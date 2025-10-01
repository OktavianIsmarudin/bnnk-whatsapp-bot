<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BnnkService;
use App\Models\WhatsappLog;
use App\Models\ChatSession;
use Illuminate\Support\Facades\DB;

class CheckBotStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check BNNK WhatsApp Bot status and configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 BNNK Surabaya WhatsApp Bot Status Check');
        $this->line('');

        // Check Database Connection
        $this->checkDatabaseConnection();
        
        // Check Environment Configuration
        $this->checkEnvironmentConfig();
        
        // Check BNNK Services
        $this->checkBnnkServices();
        
        // Check Bot Statistics
        $this->checkBotStats();
        
        // Check Server Status
        $this->checkServerStatus();

        $this->line('');
        $this->info('✅ Status check completed!');
        $this->line('Bot URL: ' . url('/'));
        $this->line('Test Interface: ' . url('/test-bot.html'));
        $this->line('Admin Panel: ' . url('/admin.html'));
    }

    private function checkDatabaseConnection()
    {
        $this->line('🔍 Checking Database Connection...');
        
        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connected successfully');
            
            // Check tables
            $tables = ['bnnk_services', 'whatsapp_logs', 'chat_sessions'];
            foreach ($tables as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    $this->line("   ✓ Table '{$table}' exists");
                } else {
                    $this->error("   ✗ Table '{$table}' missing");
                }
            }
        } catch (\Exception $e) {
            $this->error('✗ Database connection failed: ' . $e->getMessage());
        }
        
        $this->line('');
    }

    private function checkEnvironmentConfig()
    {
        $this->line('⚙️ Checking Environment Configuration...');
        
        $configs = [
            'APP_NAME' => env('APP_NAME'),
            'APP_ENV' => env('APP_ENV'),
            'APP_DEBUG' => env('APP_DEBUG') ? 'true' : 'false',
            'WHATSAPP_VERIFY_TOKEN' => env('WHATSAPP_VERIFY_TOKEN') ? 'Set' : 'Not Set',
            'WHATSAPP_ACCESS_TOKEN' => env('WHATSAPP_ACCESS_TOKEN') ? 'Set' : 'Not Set',
            'WHATSAPP_PHONE_NUMBER_ID' => env('WHATSAPP_PHONE_NUMBER_ID') ? 'Set' : 'Not Set',
        ];
        
        foreach ($configs as $key => $value) {
            $status = (in_array($key, ['WHATSAPP_ACCESS_TOKEN', 'WHATSAPP_PHONE_NUMBER_ID']) && $value === 'Not Set') ? 'warn' : 'info';
            
            if ($status === 'warn') {
                $this->warn("   ⚠️ {$key}: {$value}");
            } else {
                $this->line("   ✓ {$key}: {$value}");
            }
        }
        
        $this->line('');
    }

    private function checkBnnkServices()
    {
        $this->line('🏢 Checking BNNK Services...');
        
        $services = BnnkService::where('is_active', true)->get();
        
        if ($services->count() > 0) {
            $this->info("✅ {$services->count()} BNNK services loaded:");
            
            foreach ($services as $service) {
                $keywordCount = is_array($service->keywords) ? count($service->keywords) : 0;
                $this->line("   ✓ {$service->icon} {$service->name} ({$keywordCount} keywords)");
            }
        } else {
            $this->error('✗ No BNNK services found. Run: php artisan db:seed --class=BnnkServiceSeeder');
        }
        
        $this->line('');
    }

    private function checkBotStats()
    {
        $this->line('📊 Bot Statistics...');
        
        $stats = [
            'Total Messages' => WhatsappLog::count(),
            'Messages Today' => WhatsappLog::whereDate('created_at', today())->count(),
            'Total Users' => WhatsappLog::distinct('phone_number')->count(),
            'Active Sessions' => ChatSession::where('last_activity', '>=', now()->subHour())->count(),
        ];
        
        foreach ($stats as $label => $value) {
            $this->line("   📈 {$label}: {$value}");
        }
        
        $this->line('');
    }

    private function checkServerStatus()
    {
        $this->line('🖥️ Server Status...');
        
        $this->line('   ✓ PHP Version: ' . PHP_VERSION);
        $this->line('   ✓ Laravel Version: ' . app()->version());
        $this->line('   ✓ Timezone: ' . config('app.timezone'));
        $this->line('   ✓ Server Time: ' . now()->format('Y-m-d H:i:s T'));
        
        // Check important directories
        $directories = [
            'storage/logs' => storage_path('logs'),
            'storage/app' => storage_path('app'),
            'bootstrap/cache' => base_path('bootstrap/cache'),
        ];
        
        foreach ($directories as $name => $path) {
            if (is_writable($path)) {
                $this->line("   ✓ {$name}: Writable");
            } else {
                $this->warn("   ⚠️ {$name}: Not writable");
            }
        }
        
        $this->line('');
    }
}
