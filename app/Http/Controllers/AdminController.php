<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappLog;
use App\Models\ChatSession;
use App\Models\BnnkService;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard with statistics
     */
    public function dashboard()
    {
        $stats = [
            'total_messages' => WhatsappLog::count(),
            'messages_today' => WhatsappLog::whereDate('created_at', today())->count(),
            'active_sessions' => ChatSession::where('last_activity', '>=', now()->subHours(1))->count(),
            'total_users' => WhatsappLog::distinct('phone_number')->count(),
            'popular_services' => $this->getPopularServices()
        ];

        return response()->json($stats);
    }

    /**
     * Get conversation logs
     */
    public function logs(Request $request)
    {
        $query = WhatsappLog::with(['chatSession'])
                           ->orderBy('created_at', 'desc');

        if ($request->has('phone')) {
            $query->where('phone_number', 'like', '%' . $request->phone . '%');
        }

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(50);

        return response()->json($logs);
    }

    /**
     * Get analytics data
     */
    public function analytics()
    {
        $data = [
            'messages_by_date' => $this->getMessagesByDate(),
            'service_requests' => $this->getServiceRequests(),
            'response_times' => $this->getResponseTimes(),
            'user_engagement' => $this->getUserEngagement()
        ];

        return response()->json($data);
    }

    /**
     * Get popular services based on keyword searches
     */
    private function getPopularServices()
    {
        return WhatsappLog::selectRaw('COUNT(*) as count')
                         ->whereNotNull('message_in')
                         ->groupBy('message_in')
                         ->orderBy('count', 'desc')
                         ->limit(10)
                         ->get();
    }

    /**
     * Get messages count by date (last 30 days)
     */
    private function getMessagesByDate()
    {
        return WhatsappLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                         ->where('created_at', '>=', now()->subDays(30))
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get();
    }

    /**
     * Get service requests statistics
     */
    private function getServiceRequests()
    {
        $services = BnnkService::all();
        $requests = [];

        foreach ($services as $service) {
            $count = 0;
            foreach ($service->keywords as $keyword) {
                $count += WhatsappLog::where('message_in', 'like', "%{$keyword}%")->count();
            }
            $requests[] = [
                'service' => $service->name,
                'count' => $count
            ];
        }

        return collect($requests)->sortByDesc('count')->values();
    }

    /**
     * Get average response times (mock data for now)
     */
    private function getResponseTimes()
    {
        return [
            'average' => '2.3 seconds',
            'fastest' => '0.8 seconds',
            'slowest' => '5.1 seconds'
        ];
    }

    /**
     * Get user engagement statistics
     */
    private function getUserEngagement()
    {
        return [
            'new_users_today' => WhatsappLog::whereDate('created_at', today())
                                          ->distinct('phone_number')
                                          ->count(),
            'returning_users' => WhatsappLog::selectRaw('phone_number, COUNT(*) as count')
                                          ->groupBy('phone_number')
                                          ->having('count', '>', 1)
                                          ->count(),
            'average_messages_per_user' => round(
                WhatsappLog::count() / WhatsappLog::distinct('phone_number')->count(), 2
            )
        ];
    }
}
