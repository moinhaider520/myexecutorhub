<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; color: #111; }
        .header { border-bottom: 1px solid #ddd; margin-bottom: 24px; padding-bottom: 12px; }
        .muted { color: #666; }
        .content { white-space: pre-line; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Bereavement Notification</h2>
        <div class="muted">Case reference: {{ $deceasedCase->case_reference }}</div>
        <div class="muted">Organisation: {{ $organization->organisation_name }}</div>
        <div class="muted">Generated: {{ now()->format('Y-m-d') }}</div>
    </div>

    <div class="content">{{ $notification->body_rendered }}</div>
</body>
</html>
