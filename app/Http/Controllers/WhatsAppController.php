<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\BnnkService;
use App\Models\WhatsappLog;
use App\Models\ChatSession;

class WhatsAppController extends Controller
{
    /**
     * Handle WhatsApp webhook verification and incoming messages
     */
    public function webhook(Request $request)
    {
        // Log all incoming requests for debugging
        Log::info('Webhook request received:', [
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'query' => $request->query->all(),
            'body' => $request->all()
        ]);

        // Webhook verification for WhatsApp
        if ($request->has('hub_verify_token') && $request->has('hub_challenge')) {
            Log::info('Webhook verification attempt:', [
                'received_token' => $request->hub_verify_token,
                'expected_token' => config('whatsapp.verify_token'),
                'challenge' => $request->hub_challenge
            ]);
            
            if ($request->hub_verify_token === config('whatsapp.verify_token')) {
                Log::info('WhatsApp webhook verified successfully');
                return response($request->hub_challenge, 200, ['Content-Type' => 'text/plain']);
            } else {
                Log::error('WhatsApp webhook verification failed', [
                    'received' => $request->hub_verify_token,
                    'expected' => config('whatsapp.verify_token')
                ]);
                return response('Verification failed', 403);
            }
        }

        // Handle incoming messages
        try {
            $body = $request->all();
            Log::info('WhatsApp webhook received:', $body);

            if (isset($body['entry'][0]['changes'][0]['value']['messages'])) {
                $messages = $body['entry'][0]['changes'][0]['value']['messages'];
                
                foreach ($messages as $message) {
                    $this->processMessage($message, $body['entry'][0]['changes'][0]['value']);
                }
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('WhatsApp webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Process incoming WhatsApp message
     */
    private function processMessage($message, $value)
    {
        $from = $message['from'];
        $messageId = $message['id'];
        $timestamp = $message['timestamp'];
        
        // Get contact info
        $contactName = null;
        if (isset($value['contacts'])) {
            foreach ($value['contacts'] as $contact) {
                if ($contact['wa_id'] === $from) {
                    $contactName = $contact['profile']['name'] ?? null;
                    break;
                }
            }
        }

        // Handle different message types
        $messageText = '';
        $messageType = 'text';

        if (isset($message['text'])) {
            $messageText = $message['text']['body'];
            $messageType = 'text';
        } elseif (isset($message['interactive'])) {
            // Handle interactive messages (buttons, lists)
            if ($message['interactive']['type'] === 'button_reply') {
                $messageText = $message['interactive']['button_reply']['id'];
            } elseif ($message['interactive']['type'] === 'list_reply') {
                $messageText = $message['interactive']['list_reply']['id'];
            }
            $messageType = 'interactive';
        }

        if ($messageText) {
            // Get or create chat session
            $session = ChatSession::getOrCreate($from);
            
            // Generate response based on message and session
            $response = $this->generateResponse($messageText, $session, $contactName);
            
            // Send response
            if ($response) {
                $this->sendMessage($from, $response);
                
                // Log conversation
                WhatsappLog::logConversation(
                    $from, 
                    $messageText, 
                    $response, 
                    $contactName,
                    ['message_id' => $messageId, 'timestamp' => $timestamp]
                );
            }
        }
    }

    /**
     * Generate bot response based on message content and session
     */
    private function generateResponse($message, $session, $contactName = null)
    {
        $message = strtolower(trim($message));
        $greeting = $contactName ? "Halo {$contactName}! 👋" : "Halo! 👋";
        
        // Handle menu requests
        if (in_array($message, ['menu', 'layanan', 'info', 'help', 'bantuan', 'mulai', 'start'])) {
            $session->updateStep('showing_menu');
            return $this->getMenuResponse();
        }
        
        // Handle service number selection (1, 2, 3, etc.)
        if (is_numeric($message)) {
            return $this->handleServiceNumberSelection($message, $session);
        }
        
        // Handle greeting messages
        if (in_array($message, ['halo', 'hai', 'hello', 'hi', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'])) {
            $session->updateStep('greeted');
            return "{$greeting}\n\n" . config('whatsapp.bot.welcome_message');
        }
        
        // Handle contact/information requests
        if (strpos($message, 'kontak') !== false || strpos($message, 'alamat') !== false || strpos($message, 'lokasi') !== false) {
            return $this->getBnnkContactInfo();
        }
        
        // Handle reporting requests
        if (strpos($message, 'lapor') !== false || strpos($message, 'aduan') !== false || strpos($message, 'report') !== false) {
            return $this->getReportingInfo();
        }
        
        // Search for service by keyword
        $service = BnnkService::findByKeyword($message);
        if ($service) {
            $session->updateStep('service_selected', ['service_id' => $service->id]);
            return $service->getFormattedResponse() . "\n\n" . $this->getBackToMenuOption();
        }
        
        // Default response
        return config('whatsapp.bot.default_response');
    }

    /**
     * Handle service selection by number
     */
    private function handleServiceNumberSelection($number, $session)
    {
        $services = BnnkService::where('is_active', true)
                              ->orderBy('order_priority', 'desc')
                              ->get();
        
        $index = intval($number) - 1;
        
        if (isset($services[$index])) {
            $service = $services[$index];
            $session->updateStep('service_selected', ['service_id' => $service->id]);
            return $service->getFormattedResponse() . "\n\n" . $this->getBackToMenuOption();
        }
        
        return "Maaf, nomor layanan tidak valid. " . $this->getMenuResponse();
    }

    /**
     * Get menu response
     */
    private function getMenuResponse()
    {
        return BnnkService::getAllServicesMenu();
    }

    /**
     * Get BNNK contact information
     */
    private function getBnnkContactInfo()
    {
        $bnnk = config('whatsapp.bnnk');
        
        return "📍 *Kontak BNNK Surabaya*\n\n" .
               "🏢 {$bnnk['name']}\n" .
               "📍 {$bnnk['address']}\n" .
               "📞 {$bnnk['phone']}\n" .
               "📧 {$bnnk['email']}\n" .
               "🌐 {$bnnk['website']}\n" .
               "⏰ {$bnnk['office_hours']}\n\n" .
               $this->getBackToMenuOption();
    }

    /**
     * Get reporting information
     */
    private function getReportingInfo()
    {
        return "📢 *Pelaporan Tindak Pidana Narkoba*\n\n" .
               "Untuk melaporkan tindak pidana narkoba:\n\n" .
               "🔹 *Hotline BNN:* 184 (24 jam)\n" .
               "🔹 *SMS Center:* 0811-888-184\n" .
               "🔹 *WhatsApp:* 0811-234-5678\n" .
               "🔹 *Email:* bnnksby@bnn.go.id\n\n" .
               "⚠️ *Kerahasiaan identitas pelapor dijamin*\n" .
               "💰 Tersedia reward untuk informasi yang valid\n\n" .
               $this->getBackToMenuOption();
    }

    /**
     * Get back to menu option
     */
    private function getBackToMenuOption()
    {
        return "Ketik *menu* untuk kembali ke menu utama.";
    }

    /**
     * Send message to WhatsApp user
     */
    private function sendMessage($to, $message)
    {
        try {
            $url = config('whatsapp.graph_api_url') . '/' . config('whatsapp.phone_number_id') . '/messages';
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('whatsapp.access_token'),
                'Content-Type' => 'application/json'
            ])->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'text' => [
                    'preview_url' => false,
                    'body' => $message
                ]
            ]);

            Log::info('WhatsApp send message response:', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp message: ' . $e->getMessage());
            return false;
        }
    }
}
