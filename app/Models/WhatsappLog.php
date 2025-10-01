<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    protected $fillable = [
        'phone_number',
        'contact_name',
        'message_in',
        'message_out',
        'message_type',
        'metadata',
        'sent_at',
        'status',
        'whatsapp_message_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'sent_at' => 'datetime'
    ];
    
    public static function logConversation($phoneNumber, $messageIn, $messageOut, $contactName = null, $metadata = [])
    {
        return self::create([
            'phone_number' => $phoneNumber,
            'contact_name' => $contactName,
            'message_in' => $messageIn,
            'message_out' => $messageOut,
            'message_type' => 'text',
            'metadata' => $metadata,
            'sent_at' => now(),
            'status' => 'sent'
        ]);
    }
    
    public static function getConversationHistory($phoneNumber, $limit = 10)
    {
        return self::where('phone_number', $phoneNumber)
                   ->orderBy('created_at', 'desc')
                   ->limit($limit)
                   ->get()
                   ->reverse();
    }
}
