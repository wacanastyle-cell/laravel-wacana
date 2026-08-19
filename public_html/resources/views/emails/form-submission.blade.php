<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Wacana Style</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f4f5;margin:0;padding:0;color:#18181b}
        .container{max-width:600px;margin:0 auto;padding:24px}
        .card{background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e4e4e7}
        .header{background:#dc2626;color:#fff;padding:24px;text-align:center}
        .header h1{margin:0;font-size:20px}
        .body{padding:24px}
        .row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f4f4f5;font-size:14px}
        .row span:first-child{color:#71717a}
        .row span:last-child{font-weight:600}
        .status{display:inline-block;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:700}
        .status-new{background:#eff6ff;color:#2563eb}
        .status-processing{background:#fef3c7;color:#d97706}
        .status-accepted{background:#d1fae5;color:#059669}
        .status-rejected{background:#fee2e2;color:#dc2626}
        .status-completed{background:#e0e7ff;color:#4f46e5}
        .footer{background:#fafafa;padding:16px 24px;font-size:12px;color:#a1a1aa;text-align:center;border-top:1px solid #e4e4e7}
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>{{ $submission->form->title ?? 'Formulir Wacana Style' }}</h1>
            </div>

            <div class="body">
                <div class="row">
                    <span>No. Referensi</span>
                    <span>{{ $submission->reference_number }}</span>
                </div>

                <div class="row">
                    <span>Nama</span>
                    <span>{{ $submission->submitter_name ?? '-' }}</span>
                </div>

                <div class="row">
                    <span>Status</span>
                    <span>
                        <span class="status status-{{ $submission->status }}">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </span>
                </div>

                @if($submission->data)
                    @foreach($submission->data as $key => $value)
                        @if(is_string($value) || is_numeric($value))
                            <div class="row">
                                <span>{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                <span>{{ $value }}</span>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="footer">
                {{ $submission->form->confirmation_message ?? 'Terima kasih telah mengisi formulir Wacana Style.' }}
            </div>
        </div>
    </div>
</body>
</html>