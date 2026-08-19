<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submisi Baru Wacana Style</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f4f5;margin:0;padding:0;color:#18181b}
        .container{max-width:600px;margin:0 auto;padding:24px}
        .card{background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e4e4e7}
        .header{background:#18181b;color:#fff;padding:24px;text-align:center}
        .header h1{margin:0;font-size:20px}
        .body{padding:24px}
        .row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f4f4f5;font-size:14px}
        .row span:first-child{color:#71717a}
        .row span:last-child{font-weight:600}
        .btn{display:inline-block;margin-top:16px;padding:10px 20px;background:#dc2626;color:#fff;border-radius:8px;text-decoration:none;font-weight:700}
        .footer{background:#fafafa;padding:16px 24px;font-size:12px;color:#a1a1aa;text-align:center;border-top:1px solid #e4e4e7}
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Submisi Baru Masuk</h1>
            </div>

            <div class="body">
                <div class="row">
                    <span>Formulir</span>
                    <span>{{ $submission->form->title ?? '-' }}</span>
                </div>

                <div class="row">
                    <span>No. Referensi</span>
                    <span>{{ $submission->reference_number }}</span>
                </div>

                <div class="row">
                    <span>Nama</span>
                    <span>{{ $submission->submitter_name ?? '-' }}</span>
                </div>

                <div class="row">
                    <span>Email</span>
                    <span>{{ $submission->submitter_email ?? '-' }}</span>
                </div>

                <div class="row">
                    <span>WhatsApp</span>
                    <span>{{ $submission->submitter_phone ?? '-' }}</span>
                </div>

                <div class="row">
                    <span>Waktu</span>
                    <span>{{ $submission->submitted_at?->format('d M Y H:i') ?? '-' }}</span>
                </div>

                <a class="btn" href="{{ url('/admin/form-submissions/' . $submission->id) }}">
                    Lihat Detail di Admin
                </a>
            </div>

            <div class="footer">
                Wacana Style Admin Notifications
            </div>
        </div>
    </div>
</body>
</html>