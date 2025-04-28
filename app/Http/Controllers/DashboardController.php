<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\MaintenanceRecords;
use App\Models\Movement;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Equipment counts
        $equipmentCount = Equipment::count();
        $categoryCount = Category::count();
        $categoryEquipmentCounts = Category::withCount('equipment')
        ->orderBy('name')
        ->get();

        
        // Equipment in maintenance
        $maintenanceCount = Equipment::whereHas('movements', function($query) {
            $query->where('to_status_id', '3');
        })->count();
        
        // Recent movements in the last 7 days
        $recentMovementsCount = Movement::where('created_at', '>=', now()->subDays(7))->count();
        
        // Latest maintenance records
        $latestMaintenanceRecords = MaintenanceRecords::with('equipment')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Latest movements
        $latestMovements = Movement::with(['equipment', 'fromStatus', 'toStatus'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Equipment by status chart data
        $statusData = DB::table('equipment')
            ->join('statuses', 'equipment.status_id', '=', 'statuses.id')
            ->select('statuses.name', 'statuses.color', DB::raw('count(*) as count'))
            ->groupBy('statuses.id', 'statuses.name', 'statuses.color')
            ->get();
        
        $statusLabels = $statusData->pluck('name')->toArray();
        $statusCounts = $statusData->pluck('count')->toArray();
        $statusColors = $statusData->pluck('color')->toArray();
        
        // Equipment by category chart data
        $categoryData = DB::table('equipment')
            ->join('categories', 'equipment.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->get();
        
        $categoryLabels = $categoryData->pluck('name')->toArray();
        $categoryData = $categoryData->pluck('count')->toArray();
        
        // Movement trend data for the last 6 months
        $sixMonthsAgo = now()->subMonths(6)->startOfMonth();
        $movementTrendData = [];
        $movementTrendLabels = [];
        
        // Generate labels for the last 6 months
        for ($i = 0; $i < 6; $i++) {
            $monthDate = $sixMonthsAgo->copy()->addMonths($i);
            $movementTrendLabels[] = $monthDate->format('M Y');
        }
        
        // Get movement counts by type and month
        $entryTrendData = $this->getMovementTrendByType('entry', $sixMonthsAgo);
        $exitTrendData = $this->getMovementTrendByType('exit', $sixMonthsAgo);
        $maintenanceTrendData = $this->getMovementTrendByType('maintenance', $sixMonthsAgo);
        
        // Maintenance status data
        $maintenanceStatusData = DB::table('maintenance_records')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Ensure all statuses are represented in the data
        $allStatuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $maintenanceStatusData = array_values(array_replace(
            array_fill_keys($allStatuses, 0),
            $maintenanceStatusData
        ));
        
        return response()->view('dashboard', compact(
            'equipmentCount',
            'maintenanceCount',
            'categoryCount',
            'recentMovementsCount',
            'latestMaintenanceRecords',
            'latestMovements',
            'statusLabels',
            'statusCounts',
            'statusColors',
            'categoryLabels',
            'categoryData',
            'movementTrendLabels',
            'entryTrendData',
            'exitTrendData',
            'maintenanceTrendData',
            'maintenanceStatusData',
            'categoryEquipmentCounts' 
        ));
    }
    
    /**
     * Get movement counts by type for the last 6 months
     *
     * @param string $type Movement type
     * @param Carbon $sixMonthsAgo Start date
     * @return array
     */
    private function getMovementTrendByType($type, $sixMonthsAgo)
    {
        $results = DB::table('movements')
            ->where('type', $type)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->select(
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return (int)$item->year . '-' . str_pad((int)$item->month, 2, '0', STR_PAD_LEFT);
            });
        
        $data = [];
        
        // Fill in data for each month
        for ($i = 0; $i < 6; $i++) {
            $month = $sixMonthsAgo->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $data[] = $results->has($key) ? $results[$key]->count : 0;
        }
        
        return $data;
    }
}