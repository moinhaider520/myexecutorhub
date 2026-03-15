<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Collection;

class ActivitySummaryService
{
    public function buildForCustomer(int $customerId): Collection
    {
        $logs = ActivityLog::with('actor:id,name')
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at')
            ->get();

        $stats = $logs
            ->groupBy('module')
            ->map(function (Collection $moduleLogs, string $module) {
                $latest = $moduleLogs->first();
                $oldest = $moduleLogs->last();

                return [
                    'module' => $module,
                    'created_count' => $moduleLogs->where('action', 'created')->count(),
                    'updated_count' => $moduleLogs->where('action', 'updated')->count(),
                    'deleted_count' => $moduleLogs->where('action', 'deleted')->count(),
                    'total_actions' => $moduleLogs->count(),
                    'last_action' => $latest?->action,
                    'last_activity_at' => $latest?->created_at,
                    'last_activity_by' => $latest?->actor?->name,
                    'last_description' => $latest?->description,
                    'first_activity_at' => $oldest?->created_at,
                ];
            });

        return collect(ActivityLogger::allModuleLabels())
            ->map(function (string $module) use ($stats) {
                return $stats->get($module, [
                    'module' => $module,
                    'created_count' => 0,
                    'updated_count' => 0,
                    'deleted_count' => 0,
                    'total_actions' => 0,
                    'last_action' => null,
                    'last_activity_at' => null,
                    'last_activity_by' => null,
                    'last_description' => null,
                    'first_activity_at' => null,
                ]);
            })
            ->sortByDesc(function (array $row) {
                return $row['last_activity_at']?->timestamp ?? 0;
            })
            ->values();
    }

    public function recentForCustomer(int $customerId, int $limit = 100): Collection
    {
        return ActivityLog::with('actor:id,name')
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(function (ActivityLog $log) {
                return [
                    'timestamp' => $log->created_at,
                    'module' => $log->module,
                    'action' => ucfirst($log->action),
                    'description' => $log->description,
                    'actor' => $log->actor?->name,
                ];
            });
    }
}
