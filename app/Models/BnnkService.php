<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BnnkService extends Model
{
    protected $fillable = [
        'name',
        'description', 
        'contact_info',
        'schedule',
        'requirements',
        'keywords',
        'icon',
        'order_priority',
        'is_active'
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean'
    ];
    
    public static function findByKeyword($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        return self::where('is_active', true)
                   ->where(function($query) use ($keyword) {
                       $query->where('name', 'like', "%{$keyword}%")
                             ->orWhereJsonContains('keywords', $keyword);
                   })
                   ->orderBy('order_priority', 'desc')
                   ->first();
    }
    
    public function getFormattedResponse()
    {
        $response = ($this->icon ? $this->icon . ' ' : '🏢 ') . "*{$this->name}*\n\n";
        $response .= "📋 {$this->description}\n\n";
        $response .= "📞 Kontak: {$this->contact_info}\n";
        $response .= "⏰ Jadwal: {$this->schedule}\n";
        
        if ($this->requirements) {
            $response .= "📝 Syarat: {$this->requirements}";
        }
        
        return $response;
    }
    
    public static function getAllServicesMenu()
    {
        $services = self::where('is_active', true)
                       ->orderBy('order_priority', 'desc')
                       ->get();
        
        $menu = "📋 *Menu Layanan BNNK Surabaya:*\n\n";
        
        foreach ($services as $index => $service) {
            $number = $index + 1;
            $icon = $service->icon ?: '▫️';
            $menu .= "{$number}️⃣ {$icon} {$service->name}\n";
        }
        
        $menu .= "\nKetik nama layanan atau nomor untuk info detail.\n";
        $menu .= "Contoh: ketik *1* atau *rehabilitasi*";
        
        return $menu;
    }
}
