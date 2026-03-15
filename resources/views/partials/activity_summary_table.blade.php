<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Activity Summary</h4>
                @if (!empty($activitySummaryHeading))
                    <span>{{ $activitySummaryHeading }}</span>
                @else
                    <span>Overview of actions across customer modules</span>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="table table-striped table-hover" id="{{ $tableId ?? 'activity-summary-table' }}">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Deleted</th>
                                <th>Total Actions</th>
                                <th>Latest Action</th>
                                <th>Last Activity</th>
                                <th>Last Updated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activitySummary as $row)
                                <tr>
                                    <td>
                                        <strong>{{ $row['module'] }}</strong>
                                        @if ($row['last_description'])
                                            <br>
                                            <small class="text-muted">{{ $row['last_description'] }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $row['created_count'] }}</td>
                                    <td>{{ $row['updated_count'] }}</td>
                                    <td>{{ $row['deleted_count'] }}</td>
                                    <td>{{ $row['total_actions'] }}</td>
                                    <td>{{ $row['last_action'] ? ucfirst($row['last_action']) : 'N/A' }}</td>
                                    <td>
                                        @if ($row['last_activity_at'])
                                            {{ $row['last_activity_at']->format('d M Y, H:i') }}
                                        @else
                                            <span class="text-muted">No activity yet</span>
                                        @endif
                                    </td>
                                    <td>{{ $row['last_activity_by'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .activity-badge {
        display: inline-block;
        min-width: 84px;
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-align: center;
    }

    .activity-badge-created {
        background-color: #e8f7ee;
        color: #146c43;
    }

    .activity-badge-updated {
        background-color: #fff4db;
        color: #9a6700;
    }

    .activity-badge-deleted {
        background-color: #fdeaea;
        color: #b42318;
    }
</style>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Recent Activity</h4>
                <span>Chronological activity log for this customer context</span>
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <table class="table table-striped table-hover" id="{{ $recentTableId ?? 'recent-activity-table' }}">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Performed By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentActivity as $activity)
                                <tr>
                                    <td>{{ $activity['timestamp']->format('d M Y, H:i') }}</td>
                                    <td>{{ $activity['module'] }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match (strtolower($activity['action'])) {
                                                'created' => 'activity-badge activity-badge-created',
                                                'updated' => 'activity-badge activity-badge-updated',
                                                'deleted' => 'activity-badge activity-badge-deleted',
                                                default => 'activity-badge',
                                            };
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $activity['action'] }}</span>
                                    </td>
                                    <td>{{ $activity['description'] ?? 'N/A' }}</td>
                                    <td>{{ $activity['actor'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
