<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 15);

        $users = User::withCount('snapshots')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $dailyLoginStats = $this->getDailyLoginStats();
        $monthlyLoginStats = $this->getMonthlyLoginStats();

        return view('admin.dashboard', ['users' => $users, 'dailyLoginStats' => $dailyLoginStats, 'monthlyLoginStats' => $monthlyLoginStats]);
    }

    /**
     * Get login stats for the last 7 days.
     *
     * @return array
     */
    private function getDailyLoginStats(): array
    {
        $labels = [];
        $data = [];
        $today = Carbon::today();

        $loginsByDay = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $labels[] = $date->format('D, M j'); // e.g., Mon, Jun 1
            $loginsByDay[$date->toDateString()] = 0; // Initialize with 0
        }

        $dailyCounts = LoginLog::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as logins')
        )
            ->where('created_at', '>=', $today->copy()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('logins', 'date');

        foreach ($dailyCounts as $date => $count) {
            if (isset($loginsByDay[$date])) {
                $loginsByDay[$date] = $count;
            }
        }

        // Ensure data array matches the order of labels by re-iterating through $labels
        foreach ($labels as $labelFormattedDate) {
            // Find the original date string key from $loginsByDay that matches the formatted label
            $originalDateKey = '';
            foreach ($loginsByDay->keys() as $dateStr) {
                if (Carbon::parse($dateStr)->format('D, M j') === $labelFormattedDate) {
                    $originalDateKey = $dateStr;
                    break;
                }
            }
            $data[] = $loginsByDay[$originalDateKey] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get login stats for the last 12 months.
     *
     * @return array
     */
    private function getMonthlyLoginStats(): array
    {
        $labels = [];
        $data = [];
        $currentMonth = Carbon::today()->startOfMonth();

        $loginsByMonth = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);
            $labels[] = $month->format('M Y'); // e.g., Jun 2025
            $loginsByMonth[$month->format('Y-m')] = 0; // Initialize with 0
        }

        $monthlyCounts = LoginLog::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_year"), // MySQL specific
            DB::raw('count(*) as logins')
        )
            ->where('created_at', '>=', $currentMonth->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month_year')
            ->orderBy('month_year', 'asc')
            ->get()
            ->pluck('logins', 'month_year');

        foreach ($monthlyCounts as $monthYear => $count) {
            if (isset($loginsByMonth[$monthYear])) {
                $loginsByMonth[$monthYear] = $count;
            }
        }

        // Ensure data array matches the order of labels
        foreach ($labels as $labelFormattedMonthYear) {
            $originalMonthYearKey = '';
            foreach ($loginsByMonth->keys() as $ymStr) {
                if (Carbon::parse($ymStr . "-01")->format('M Y') === $labelFormattedMonthYear) {
                    $originalMonthYearKey = $ymStr;
                    break;
                }
            }
            $data[] = $loginsByMonth[$originalMonthYearKey] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
