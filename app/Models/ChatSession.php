<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChatSession extends Model
{
    protected $fillable = [
        'phone_number',
        'current_step',
        'session_data',
        'last_activity'
    ];

    protected $casts = [
        'session_data' => 'array',
        'last_activity' => 'datetime'
    ];
    
    public static function getOrCreate($phoneNumber)
    {
        $session = self::where('phone_number', $phoneNumber)->first();
        
        if (!$session) {
            $session = self::create([
                'phone_number' => $phoneNumber,
                'current_step' => 'greeting',
                'session_data' => [],
                'last_activity' => now()
            ]);
        } else {
            // Check if session is expired (30 minutes)
            $timeout = config('whatsapp.bot.session_timeout', 1800);
            if ($session->last_activity->diffInSeconds(now()) > $timeout) {
                $session->update([
                    'current_step' => 'greeting',
                    'session_data' => [],
                    'last_activity' => now()
                ]);
            } else {
                $session->touch('last_activity');
            }
        }
        
        return $session;
    }
    
    public function updateStep($step, $data = [])
    {
        $this->update([
            'current_step' => $step,
            'session_data' => array_merge($this->session_data ?? [], $data),
            'last_activity' => now()
        ]);
    }
    
    public function setData($key, $value)
    {
        $sessionData = $this->session_data ?? [];
        $sessionData[$key] = $value;
        
        $this->update([
            'session_data' => $sessionData,
            'last_activity' => now()
        ]);
    }
    
    public function getData($key, $default = null)
    {
        return data_get($this->session_data, $key, $default);
    }
}
