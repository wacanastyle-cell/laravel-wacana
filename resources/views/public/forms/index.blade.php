@php
    $siteName = $siteSettings['site_name'] ?? 'Wacana Style';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir | {{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        *{box-sizing:border-box}
        body{
            width:100%;min-height:100%;margin:0;padding:0;overflow-x:hidden;
            background:#08080a;color:#f4f4f5;font-family:Inter,Arial,sans-serif;
        }
        h1,h2,h3,h4{font-family:Montserrat,Arial,sans-serif}
        a{color:inherit;text-decoration:none}
        img{max-width:100%}
        ::-webkit-scrollbar{width:6px}
        ::-webkit-scrollbar-track{background:#0d0d0f}
        ::-webkit-scrollbar-thumb{background:#dc2626;border-radius:10px}
        .container{width:min(1200px,calc(100% - 32px));margin:auto;padding:96px 0}
        .forms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }
        .form-card {
            background: #09090b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 24px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .form-card:hover {
            border-color: #dc2626;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.1);
            transform: translateY(-4px);
        }
        .form-card h3 {
            margin: 0 0 12px 0;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
        }
        .form-card p {
            margin: 0 0 16px 0;
            color: #a1a1a6;
            font-size: 14px;
            line-height: 1.6;
        }
        .form-card-link {
            display: inline-block;
            background: #dc2626;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .form-card-link:hover {
            background: #b91c1c;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a1a1a6;
        }
        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #52525b;
        }
        h1 {
            font-size: 36px;
            font-weight: 700;
            margin: 0 0 16px 0;
        }
        .subtitle {
            color: #a1a1a6;
            font-size: 16px;
            margin-bottom: 24px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 48px 0;
            }
            h1 {
                font-size: 28px;
            }
            .forms-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('partials.header-nav')

    <div class="container">
        <h1>Formulir</h1>
        <p class="subtitle">Pilih formulir yang ingin Anda isi</p>

        @if($forms->count() > 0)
            <div class="forms-grid">
                @foreach($forms as $form)
                    <div class="form-card">
                        <h3>{{ $form->title }}</h3>
                        <p>{{ $form->description ?? 'Silakan isi formulir ini.' }}</p>
                        <a href="{{ route('public.form.show', $form->slug) }}" class="form-card-link">
                            Buka Formulir <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>Tidak ada formulir tersedia</h3>
                <p>Mohon maaf, saat ini tidak ada formulir yang tersedia untuk diisi.</p>
            </div>
        @endif
    </div>

    @include('partials.footer')
</body>
</html>
