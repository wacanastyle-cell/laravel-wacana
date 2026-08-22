<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('storage/icon-logo/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/icon-logo/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/icon-logo/icon.png') }}">
    <meta name="google-site-verification" content="_cpKGNoFoejJEVqCD380wXY_Ds3HG6OUtEH5PAOLbI4" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Wacana Style adalah komunitas motor Tegal dan sekitarnya untuk touring, kopdar, ride out, berbagi cerita, dan membangun persaudaraan tanpa memandang jenis motor.">
    <meta name="theme-color" content="#09090b">
    <title>Wacana Style – Komunitas Motor Tegal &amp; Sekitarnya</title>
    <link rel="canonical" href="https://wacanastyle.my.id/">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Wacana Style – Komunitas Motor Tegal &amp; Sekitarnya">
    <meta property="og:description" content="Komunitas motor Tegal dan sekitarnya untuk touring, kopdar, ride out, dan membangun persaudaraan sesama pengendara.">
    <meta property="og:url" content="https://wacanastyle.my.id/">
    <meta property="og:site_name" content="Wacana Style">
    <meta property="og:image" content="https://wacanastyle.my.id/storage/icon-logo/logo.png">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Wacana Style – Komunitas Motor Tegal &amp; Sekitarnya">
    <meta name="twitter:description" content="Komunitas motor Tegal dan sekitarnya untuk touring, kopdar, ride out, dan membangun persaudaraan.">
    <meta name="twitter:image" content="https://wacanastyle.my.id/storage/icon-logo/logo.png">

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M9QS5P68');
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        :root{
            --bg:#08080a;
            --bg2:#0d0d10;
            --card:#121216;
            --card2:#18181c;
            --line:rgba(255,255,255,.09);
            --text:#f4f4f5;
            --muted:#a1a1aa;
            --red:#ef0000;
            --red2:#dc2626;
            --red3:#991b1b;
            --green:#22c55e;
            --blue:#3b82f6;
            --container:1200px;
        }

        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{
            width:100%;
            min-height:100%;
            margin:0;
            padding:0;
            overflow-x:hidden;
            background:var(--bg);
            color:var(--text);
            font-family:Inter,Arial,sans-serif;
        }
        body.modal-open{overflow:hidden}
        h1,h2,h3,h4,.font-sporty{
            font-family:Montserrat,Arial,sans-serif;
        }
        a{color:inherit;text-decoration:none}
        img{max-width:100%}
        button,input,select{font:inherit}
        button,a{-webkit-tap-highlight-color:transparent}
        ::selection{background:var(--red);color:#fff}
        ::-webkit-scrollbar{width:6px}
        ::-webkit-scrollbar-track{background:#0d0d0f}
        ::-webkit-scrollbar-thumb{background:#dc2626;border-radius:10px}
        ::-webkit-scrollbar-thumb:hover{background:#991b1b}

        .container{
            width:min(var(--container),calc(100% - 32px));
            margin-inline:auto;
        }
        .section{padding:96px 0;position:relative}
        .section-dark{background:#09090b}
        .section-alt{background:#0d0d10}
        .section-head{max-width:760px;margin:0 auto 42px;text-align:center}
        .eyebrow{
            display:inline-flex;
            align-items:center;
            gap:8px;
            color:#fca5a5;
            font-size:11px;
            font-weight:800;
            letter-spacing:.2em;
            text-transform:uppercase;
            margin-bottom:14px;
        }
        .eyebrow::before{
            content:"";
            width:24px;height:2px;background:var(--red);
        }
        .section-title{
            margin:0;
            font-size:clamp(30px,5vw,54px);
            line-height:1.02;
            letter-spacing:-.04em;
            font-weight:900;
        }
        .section-desc{
            color:var(--muted);
            line-height:1.8;
            margin:16px auto 0;
            max-width:680px;
        }

        /* HERO */
        .hero{
            position:relative;
            min-height:100svh;
            display:flex;
            align-items:center;
            overflow:hidden;
            isolation:isolate;
            background:#050507;
        }
        .video-background-container{
            position:absolute;
            inset:0;
            overflow:hidden;
            z-index:0;
            pointer-events:none;
            background:#050507;
        }
        .video-background-container::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at 70% 40%,rgba(239,0,0,.12),transparent 35%),
                linear-gradient(90deg,rgba(0,0,0,.92) 0%,rgba(0,0,0,.58) 46%,rgba(0,0,0,.55) 100%),
                linear-gradient(0deg,rgba(0,0,0,.8),transparent 50%,rgba(0,0,0,.45));
            z-index:1;
        }
        .video-background-container::after{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(0,0,0,.15);
            z-index:2;
        }
        .video-foreground{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            min-width:100%;
            min-height:100%;
            display:block;
            border:0;
            pointer-events:none;
            z-index:0;
            object-fit:cover;
            object-position:center center;
            background:#050507;
        }
        .hero-fallback{
            position:absolute;
            transition:opacity .35s ease;
            inset:0;
            background:
                radial-gradient(circle at 75% 50%,rgba(220,38,38,.22),transparent 28%),
                linear-gradient(135deg,#070707 0%,#141416 55%,#09090b 100%);
            z-index:-1;
        }
        .hero-content{
            position:relative;
            z-index:5;
            width:min(var(--container),calc(100% - 32px));
            margin:auto;
            padding:130px 0 90px;
        }
        .hero-kicker{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:8px 13px;
            border:1px solid rgba(255,255,255,.14);
            background:rgba(0,0,0,.32);
            backdrop-filter:blur(10px);
            border-radius:999px;
            color:#e4e4e7;
            font-size:11px;
            font-weight:800;
            letter-spacing:.16em;
            text-transform:uppercase;
        }
        .hero-kicker span{
            width:7px;height:7px;border-radius:50%;
            background:#ef4444;
            box-shadow:0 0 16px #ef4444;
        }
        .hero-title{
            max-width:850px;
            margin:24px 0 18px;
            font-size:clamp(48px,8vw,94px);
            line-height:.92;
            letter-spacing:-.025em;
            font-weight:700;
        }
        .hero-title .accent{
            color:#ef4444;
            text-shadow:0 0 35px rgba(239,0,0,.25);
        }
        .hero-subtitle{
            max-width:650px;
            color:#d4d4d8;
            font-size:clamp(15px,2vw,19px);
            line-height:1.7;
            margin:0 0 30px;
        }
        .hero-actions{display:flex;flex-wrap:wrap;gap:12px}
        .btn{
            min-height:48px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            border-radius:10px;
            padding:0 20px;
            border:1px solid transparent;
            cursor:pointer;
            font-family:Montserrat,sans-serif;
            font-size:12px;
            font-weight:800;
            letter-spacing:.05em;
            text-transform:uppercase;
            transition:.25s ease;
        }
        .btn-red{
            color:#fff;
            background:linear-gradient(135deg,#ef0000,#b90000);
            box-shadow:0 12px 30px rgba(239,0,0,.18);
        }
        .btn-red:hover{transform:translateY(-2px);box-shadow:0 16px 35px rgba(239,0,0,.3)}
        .btn-outline{
            color:#fff;
            background:rgba(255,255,255,.06);
            border-color:rgba(255,255,255,.15);
            backdrop-filter:blur(8px);
        }
        .btn-outline:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.25)}
        .hero-stats{
            display:flex;
            flex-wrap:wrap;
            gap:28px;
            margin-top:52px;
        }
        .hero-stat strong{
            display:block;
            font-family:Montserrat,sans-serif;
            font-size:22px;
            font-weight:900;
        }
        .hero-stat span{
            display:block;
            margin-top:4px;
            color:#a1a1aa;
            font-size:10px;
            letter-spacing:.14em;
            text-transform:uppercase;
        }
        .scroll-hint{
            position:absolute;
            left:50%;
            bottom:24px;
            transform:translateX(-50%);
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:8px;
            color:#a1a1aa;
            font-size:9px;
            letter-spacing:.2em;
            text-transform:uppercase;
        }
        .scroll-hint i{animation:bounce 1.8s infinite}
        @keyframes bounce{
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(6px)}
        }

        /* NAV */
        .top-nav{
            position:absolute;
            top:0;left:0;right:0;
            z-index:20;
            padding:18px 0;
        }
        .nav-inner{
            width:min(var(--container),calc(100% - 32px));
            margin:auto;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
        }
        .brand{
            display:flex;
            align-items:center;
            gap:11px;
            font-family:Montserrat,sans-serif;
            font-weight:900;
            letter-spacing:-.03em;
        }
        .brand-mark{
            width:38px;height:38px;
            border-radius:10px;
            display:grid;place-items:center;
            background:linear-gradient(135deg,#ef0000,#8b0000);
            box-shadow:0 8px 25px rgba(239,0,0,.25);
        }
        .brand small{
            display:block;
            color:#a1a1aa;
            font-size:8px;
            font-weight:600;
            letter-spacing:.17em;
        }
        .nav-links{
            display:flex;
            align-items:center;
            gap:24px;
        }
        .nav-links a{
            color:#d4d4d8;
            font-size:11px;
            font-weight:700;
            transition:.2s;
        }
        .nav-links a:hover{color:#fff}
        .menu-btn{
            width:42px;height:42px;
            border-radius:10px;
            border:1px solid rgba(255,255,255,.13);
            background:rgba(0,0,0,.35);
            color:#fff;
            cursor:pointer;
            display:grid;place-items:center;
        }

        /* ABOUT */
        .about-grid{
            display:grid;
            grid-template-columns:1.05fr .95fr;
            gap:60px;
            align-items:center;
        }
        .about-copy p{
            color:#a1a1aa;
            line-height:1.9;
            margin:0 0 16px;
        }
        .feature-list{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:12px;
            margin-top:26px;
        }
        .feature{
            padding:18px;
            background:rgba(255,255,255,.03);
            border:1px solid var(--line);
            border-radius:14px;
        }
        .feature i{color:#ef4444;font-size:18px}
        .feature strong{display:block;margin-top:12px;font-size:13px}
        .feature span{display:block;color:#71717a;font-size:11px;line-height:1.6;margin-top:5px}
        .about-card{
            min-height:430px;
            position:relative;
            overflow:hidden;
            border:1px solid var(--line);
            border-radius:24px;
            background:
                radial-gradient(circle at 65% 30%,rgba(239,0,0,.2),transparent 30%),
                linear-gradient(145deg,#1b1b20,#0a0a0c);
        }
        .about-card::before{
            content:"";
            position:absolute;
            inset:20px;
            border:1px solid rgba(255,255,255,.08);
            border-radius:18px;
            z-index:1;
            pointer-events:none;
        }
        .about-card .big-logo{
            position:absolute;
            inset:0;
            display:grid;
            place-items:center;
            font-family:Montserrat,sans-serif;
            font-size:clamp(70px,11vw,130px);
            font-weight:900;
            color:rgba(255,255,255,.035);
            letter-spacing:-.08em;
        }
        .about-card .big-logo img{
            position:relative;
            z-index:2;
            display:block;
            width:min(78%,430px);
            max-width:78%;
            max-height:300px;
            height:auto;
            object-fit:contain;
            opacity:1;
            filter:drop-shadow(0 20px 35px rgba(0,0,0,.45));
        }
        .about-card-info{
            position:absolute;
            left:30px;right:30px;bottom:30px;
            padding:20px;
            border:1px solid rgba(255,255,255,.1);
            background:rgba(0,0,0,.42);
            backdrop-filter:blur(12px);
            border-radius:16px;
            z-index:3;
        }
        .about-card-info strong{font-family:Montserrat;font-size:22px}
        .about-card-info span{display:block;color:#a1a1aa;font-size:12px;margin-top:5px}

        /* MAP */
        .tech-grid{
            background-image:
                linear-gradient(to right,rgba(30,58,138,.15) 1px,transparent 1px),
                linear-gradient(to bottom,rgba(30,58,138,.15) 1px,transparent 1px);
            background-size:40px 40px;
        }
        .map-shell{
            position:relative;
            min-height:560px;
            overflow:hidden;
            border:1px solid rgba(255,255,255,.1);
            border-radius:24px;
            background:
                radial-gradient(circle at 50% 45%,rgba(37,99,235,.13),transparent 34%),
                #080b12;
        }
        .map-viewport{
            position:absolute;
            inset:0;
            perspective:1200px;
            overflow:hidden;
        }
        .map-3d-wrapper{
            position:absolute;
            width:100%;
            height:100%;
            transform-style:preserve-3d;
            transform:rotateX(32deg) rotateZ(-2deg) scale(.9);
        }
        .map-plane{
            position:absolute;
            inset:8% 8%;
            transform-style:preserve-3d;
            border:1px solid rgba(96,165,250,.22);
            background:
                linear-gradient(rgba(59,130,246,.08) 1px,transparent 1px),
                linear-gradient(90deg,rgba(59,130,246,.08) 1px,transparent 1px);
            background-size:35px 35px;
            box-shadow:0 40px 80px rgba(0,0,0,.65);
        }
        .road{
            position:absolute;
            height:3px;
            transform-origin:left center;
            background:rgba(161,161,170,.3);
            box-shadow:0 0 10px rgba(255,255,255,.06);
        }
        .road.r1{width:78%;top:30%;left:10%;transform:rotate(18deg)}
        .road.r2{width:70%;top:55%;left:16%;transform:rotate(-12deg)}
        .road.r3{width:55%;top:72%;left:20%;transform:rotate(28deg)}
        .road.r4{width:62%;top:43%;left:24%;transform:rotate(75deg)}
        .connection{
            position:absolute;
            height:2px;
            transform-origin:left center;
            background:repeating-linear-gradient(90deg,#ef4444 0 7px,transparent 7px 14px);
            animation:dash 16s linear infinite;
            filter:drop-shadow(0 0 5px rgba(239,68,68,.5));
        }
        .connection.c1{width:30%;top:42%;left:29%;transform:rotate(12deg)}
        .connection.c2{width:28%;top:53%;left:44%;transform:rotate(-15deg)}
        .connection.c3{width:26%;top:63%;left:52%;transform:rotate(17deg)}
        @keyframes dash{to{background-position:1000px 0}}
        .map-point{
            position:absolute;
            transform:translate(-50%,-50%);
            z-index:5;
            text-align:center;
        }
        .map-point .pin{
            width:18px;height:18px;
            margin:auto;
            border-radius:50%;
            border:4px solid rgba(255,255,255,.9);
            box-shadow:0 0 0 7px rgba(239,68,68,.16),0 0 24px rgba(239,68,68,.7);
            background:#ef4444;
            animation:pinpulse 2s infinite;
        }
        .map-point.blue .pin{background:#3b82f6;box-shadow:0 0 0 7px rgba(59,130,246,.15),0 0 24px rgba(59,130,246,.6)}
        .map-point.green .pin{background:#22c55e;box-shadow:0 0 0 7px rgba(34,197,94,.15),0 0 24px rgba(34,197,94,.6)}
        .map-point.purple .pin{background:#a855f7;box-shadow:0 0 0 7px rgba(168,85,247,.15),0 0 24px rgba(168,85,247,.6)}
        .map-point.cyan .pin{background:#06b6d4;box-shadow:0 0 0 7px rgba(6,182,212,.15),0 0 24px rgba(6,182,212,.6)}
        @keyframes pinpulse{
            0%,100%{transform:scale(1)}
            50%{transform:scale(1.15)}
        }
        .map-point label{
            display:block;
            margin-top:9px;
            padding:5px 8px;
            white-space:nowrap;
            border-radius:7px;
            color:#e4e4e7;
            background:rgba(9,9,11,.78);
            border:1px solid rgba(255,255,255,.1);
            font-size:9px;
            font-weight:800;
            letter-spacing:.05em;
        }
        .p-brebes{left:20%;top:31%}
        .p-tegal{left:38%;top:39%}
        .p-slawi{left:45%;top:53%}
        .p-pemalang{left:63%;top:48%}
        .p-pemalangkidul{left:72%;top:68%}
        .p-kota{left:31%;top:54%}
        .map-overlay{
            position:absolute;
            left:24px;top:24px;
            z-index:10;
            max-width:300px;
            padding:18px;
            border-radius:15px;
            background:rgba(8,11,18,.75);
            border:1px solid rgba(255,255,255,.11);
            backdrop-filter:blur(14px);
        }
        .map-overlay strong{font-family:Montserrat;font-size:15px}
        .map-overlay p{margin:7px 0 0;color:#71717a;font-size:11px;line-height:1.6}
        .map-legend{
            position:absolute;
            right:24px;bottom:24px;
            z-index:10;
            padding:13px 15px;
            border-radius:12px;
            background:rgba(8,11,18,.78);
            border:1px solid rgba(255,255,255,.1);
            backdrop-filter:blur(12px);
        }
        .legend-row{display:flex;align-items:center;gap:7px;color:#a1a1aa;font-size:9px;margin:5px 0}
        .legend-dot{width:7px;height:7px;border-radius:50%}

        /* GALLERY */
        .gallery-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            grid-auto-rows:210px;
            gap:16px;
        }
        .g-item{
            position:relative;
            overflow:hidden;
            border-radius:14px;
            border:1px solid rgba(255,255,255,.06);
            background:#16161a;
            cursor:pointer;
            transition:transform .4s ease,border-color .4s ease,box-shadow .4s ease;
        }
        .g-item:hover{
            border-color:rgba(220,38,38,.6);
            box-shadow:0 10px 35px rgba(220,38,38,.18);
            transform:translateY(-3px);
        }
        .g-item img{
            width:100%;height:100%;
            object-fit:cover;display:block;
            transition:transform .7s cubic-bezier(.2,.8,.2,1);
        }
        .g-item:hover img{transform:scale(1.08)}
        .g-item .g-overlay{
            position:absolute;inset:0;
            background:linear-gradient(to top,rgba(0,0,0,.88),rgba(0,0,0,.05) 60%);
            opacity:0;
            transition:opacity .4s;
            display:flex;
            flex-direction:column;
            justify-content:flex-end;
            padding:14px;
        }
        .g-item:hover .g-overlay{opacity:1}
        .g-tag{font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:#fca5a5;font-weight:700;margin-bottom:4px}
        .g-caption{font-size:13px;color:#fff;font-weight:700;font-family:Montserrat}
        .g-zoom{
            position:absolute;top:12px;right:12px;
            width:30px;height:30px;border-radius:50%;
            background:rgba(220,38,38,.9);color:#fff;
            display:flex;align-items:center;justify-content:center;
            font-size:11px;opacity:0;transform:scale(.6);
            transition:.35s;z-index:2;
        }
        .g-item:hover .g-zoom{opacity:1;transform:scale(1)}
        .g-item--featured{grid-row:span 2;grid-column:span 2}
        .g-item--wide{grid-column:span 2}

        /* MEMBERSHIP */
        .member-wrap{
            position:relative;
            overflow:hidden;
            border:1px solid rgba(239,0,0,.2);
            border-radius:26px;
            padding:60px;
            background:
                radial-gradient(circle at 80% 20%,rgba(239,0,0,.17),transparent 30%),
                linear-gradient(135deg,#170708,#0c0c0f 55%,#09090b);
        }
        .member-wrap::after{
            content:"WACANA";
            position:absolute;
            right:-10px;bottom:-65px;
            font-family:Montserrat;
            font-weight:900;
            font-size:170px;
            letter-spacing:-.09em;
            color:rgba(255,255,255,.025);
            pointer-events:none;
        }
        .member-content{position:relative;z-index:2;max-width:700px}
        .member-content h2{font-size:clamp(34px,5vw,64px);line-height:1;letter-spacing:-.05em;margin:0 0 18px}
        .member-content p{color:#a1a1aa;line-height:1.8;max-width:650px}
        .member-badges{display:flex;flex-wrap:wrap;gap:8px;margin:24px 0}
        .badge{
            padding:8px 11px;
            border-radius:999px;
            border:1px solid rgba(255,255,255,.1);
            background:rgba(255,255,255,.04);
            color:#d4d4d8;
            font-size:10px;
            font-weight:700;
        }

        /* FORM */
        .form-grid{
            display:flex;
            justify-content:center;
            align-items:flex-start;
            width:100%;
        }
        .form-card{
            width:min(760px,100%);
        }
        .glass-card{
            background:rgba(30,41,59,.55);
            backdrop-filter:blur(12px);
            border:1px solid rgba(255,255,255,.1);
            border-radius:20px;
            padding:28px;
        }
        .form-card h3,.order-card h3{margin:0;font-size:22px}
        .form-card>p,.order-card>p{color:#71717a;font-size:12px;line-height:1.7;margin:8px 0 24px}
        .field{margin-bottom:15px}
        .field label{
            display:block;
            margin-bottom:7px;
            color:#d4d4d8;
            font-size:10px;
            font-weight:800;
            letter-spacing:.1em;
            text-transform:uppercase;
        }
        .field input,.field select{
            width:100%;
            height:46px;
            border:1px solid rgba(255,255,255,.1);
            border-radius:10px;
            outline:none;
            background:#09090b;
            color:#fff;
            padding:0 13px;
            transition:.2s;
        }
        .field input:focus,.field select:focus{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1)}
        .form-status{
            margin-top:12px;
            padding:12px;
            border-radius:10px;
            font-size:11px;
            line-height:1.6;
        }
        .status-success{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#86efac}
        .status-error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#fca5a5}
        .hidden{display:none!important}

        /* RIDER LIST */
        .riders-list{
            margin-top:20px;
            display:grid;
            gap:8px;
        }
        .rider{
            display:flex;
            align-items:center;
            gap:11px;
            padding:10px;
            border:1px solid rgba(255,255,255,.07);
            background:rgba(0,0,0,.22);
            border-radius:10px;
        }
        .rider-avatar{
            flex:0 0 34px;width:34px;height:34px;border-radius:50%;
            display:grid;place-items:center;
            background:#dc2626;color:#fff;
            font-size:11px;font-weight:900;
        }
        .rider-name{font-size:11px;font-weight:800}
        .rider-meta{font-size:9px;color:#71717a;margin-top:3px}

        /* JACKET */
        .order-card{
            position:relative;
            overflow:hidden;
            min-height:100%;
            background:
                radial-gradient(circle at 80% 20%,rgba(239,0,0,.15),transparent 34%),
                rgba(30,41,59,.55);
        }
        .jacket-preview{
            height:230px;
            margin:-8px -8px 22px;
            border-radius:16px;
            display:grid;
            place-items:center;
            overflow:hidden;
            background:linear-gradient(145deg,#18181b,#09090b);
            border:1px solid rgba(255,255,255,.08);
        }
        .jacket-preview i{font-size:100px;color:#27272a;filter:drop-shadow(0 20px 25px rgba(0,0,0,.5))}
        .price{
            display:flex;align-items:end;justify-content:space-between;
            gap:10px;margin:15px 0 20px;
        }
        .price strong{font-family:Montserrat;font-size:27px}
        .price span{color:#71717a;font-size:10px}
        .size-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:7px;margin:12px 0 18px}
        .size-btn{
            height:38px;border:1px solid rgba(255,255,255,.1);
            border-radius:8px;background:#09090b;color:#a1a1aa;
            cursor:pointer;font-size:10px;font-weight:800;
        }
        .size-btn.active{border-color:#ef0000;background:rgba(239,0,0,.12);color:#fff}
        .qty-row{display:flex;align-items:center;gap:8px;margin-bottom:18px}
        .qty-btn{
            width:38px;height:38px;border:1px solid rgba(255,255,255,.1);
            border-radius:8px;background:#09090b;color:#fff;cursor:pointer;
        }
        .qty-value{flex:1;text-align:center;font-weight:800}

        /* FAQ */
        .faq-list{max-width:850px;margin:auto;display:grid;gap:9px}
        .faq-item{
            overflow:hidden;
            border:1px solid rgba(255,255,255,.08);
            border-radius:12px;
            background:#111114;
        }
        .faq-question{
            width:100%;
            min-height:58px;
            display:flex;align-items:center;justify-content:space-between;gap:20px;
            padding:0 17px;
            color:#fff;
            background:transparent;
            border:0;
            cursor:pointer;
            text-align:left;
            font-size:12px;
            font-weight:800;
        }
        .faq-question i{color:#71717a;transition:.25s}
        .faq-question.open i{transform:rotate(180deg);color:#ef4444}
        .faq-answer{
            display:none;
            padding:0 17px 17px;
            color:#a1a1aa;
            font-size:11px;
            line-height:1.8;
        }
        .faq-answer.open{display:block}

        /* LIGHTBOX */
        .lightbox{
            position:fixed;inset:0;
            background:rgba(8,8,10,.96);
            backdrop-filter:blur(6px);
            z-index:9999;
            display:none;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            padding:20px;
        }
        .lightbox.open{display:flex}
        .lightbox img{
            max-width:92vw;max-height:78vh;
            object-fit:contain;border-radius:10px;
            box-shadow:0 20px 60px rgba(0,0,0,.7);
            animation:lbIn .3s ease;
        }
        @keyframes lbIn{from{opacity:0;transform:scale(.94)}to{opacity:1;transform:scale(1)}}
        .lb-caption{margin-top:16px;color:#d4d4d8;font-size:13px;text-align:center}
        .lb-counter{position:absolute;top:18px;right:22px;color:#71717a;font-size:13px;font-weight:600;letter-spacing:.1em}
        .lb-btn{
            position:absolute;top:50%;transform:translateY(-50%);
            width:46px;height:46px;border-radius:50%;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);
            color:#fff;display:flex;align-items:center;justify-content:center;
            font-size:18px;cursor:pointer;z-index:2;
        }
        .lb-btn:hover{background:#dc2626;border-color:#dc2626}
        .lb-prev{left:16px}.lb-next{right:16px}
        .lb-close{
            position:absolute;top:16px;left:20px;
            width:40px;height:40px;border-radius:50%;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);
            color:#fff;display:flex;align-items:center;justify-content:center;
            cursor:pointer;
        }

        /* MODALS */
        .modal{
            position:fixed;inset:0;
            z-index:10000;
            display:none;
            align-items:center;justify-content:center;
            padding:20px;
            background:rgba(8,8,10,.88);
            backdrop-filter:blur(8px);
        }
        .modal.open{display:flex}
        .modal-card{
            position:relative;
            width:min(560px,100%);
            max-height:90vh;
            overflow:auto;
            border-radius:20px;
            border:1px solid rgba(255,255,255,.1);
            background:#111114;
            padding:28px;
            box-shadow:0 30px 90px rgba(0,0,0,.6);
            animation:modalIn .25s ease;
        }
        @keyframes modalIn{from{opacity:0;transform:translateY(15px) scale(.98)}to{opacity:1;transform:none}}
        .modal-close{
            position:absolute;top:12px;right:12px;
            width:36px;height:36px;border-radius:50%;
            border:1px solid rgba(255,255,255,.1);
            background:#18181b;color:#fff;cursor:pointer;
        }
        .modal-card h3{margin:0 35px 8px 0;font-size:22px}
        .modal-card p{color:#a1a1aa;font-size:12px;line-height:1.7}
        .receipt{
            margin-top:18px;padding:16px;border-radius:12px;
            background:#09090b;border:1px solid rgba(255,255,255,.08);
        }
        .receipt-row{display:flex;justify-content:space-between;gap:15px;padding:7px 0;font-size:11px}
        .receipt-row span:first-child{color:#71717a}
        .receipt-row span:last-child{font-weight:700;text-align:right}

        /* REVEAL */
        .reveal{opacity:0;transform:translateY(18px);transition:opacity .6s ease,transform .6s ease}
        .reveal.revealed{opacity:1;transform:translateY(0)}
        @media(prefers-reduced-motion:reduce){
            html{scroll-behavior:auto}
            .reveal{opacity:1;transform:none;transition:none}
            *,*::before,*::after{animation:none!important;transition:none!important}
        }

        /* FOOTER */
        footer{
            padding:45px 0 25px;
            border-top:1px solid rgba(255,255,255,.07);
            background:#070709;
        }
        .footer-grid{
            display:grid;grid-template-columns:1.3fr 1fr 1fr;
            gap:40px;
        }
        .footer-brand p{max-width:400px;color:#71717a;font-size:11px;line-height:1.8}
        .footer-title{font-family:Montserrat;font-size:11px;font-weight:800;margin-bottom:13px}
        .footer-links{display:grid;gap:8px}
        .footer-links a{color:#71717a;font-size:11px}
        .footer-links a:hover{color:#fff}
        .copyright{
            margin-top:35px;padding-top:20px;
            border-top:1px solid rgba(255,255,255,.06);
            color:#52525b;font-size:10px;
            display:flex;justify-content:space-between;gap:15px;flex-wrap:wrap;
        }

        @media(max-width:900px){
            .nav-links{display:none}
            .about-grid,.form-grid{grid-template-columns:1fr}
            .gallery-grid{grid-template-columns:repeat(2,1fr);grid-auto-rows:180px}
            .footer-grid{grid-template-columns:1fr 1fr}
            .member-wrap{padding:40px 28px}
        }
        @media(max-width:640px){
            .section{padding:70px 0}
            .hero-content{padding-top:120px}
            .hero-title{font-size:clamp(44px,14vw,70px)}
            .hero-stats{gap:18px}
            .feature-list{grid-template-columns:1fr}
            .about-card{min-height:330px}
            .map-shell{min-height:480px}
            .map-plane{inset:12% 2%}
            .map-overlay{left:13px;top:13px;max-width:245px}
            .map-legend{right:13px;bottom:13px}
            .gallery-grid{gap:9px;grid-auto-rows:145px}
            .g-item--featured{grid-row:span 2;grid-column:span 2}
            .g-item--wide{grid-column:span 2}
            .member-wrap{padding:32px 20px}
            .member-wrap::after{font-size:100px;bottom:-35px}
            .glass-card{padding:20px}
            .footer-grid{grid-template-columns:1fr}
            .hero-actions .btn{width:100%}
            .video-foreground{
                width:100%;
                height:100%;
                transform:none;
                object-fit:cover;
            }
        }
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HES7NBTQ10"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag("js", new Date());
      gtag("config", "G-HES7NBTQ10");
    </script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NGCRSJB2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9QS5P68"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

@include('partials.header-nav')

<main class="landing-content">

    <!-- HERO -->
    <section id="home" class="hero">
        <div class="hero-fallback"></div>

        <div class="video-background-container">
            <!--
                Ganti file berikut dengan video kamu:
                public/video/hero.mp4
            -->
            <video class="video-foreground" autoplay muted loop playsinline preload="auto" poster="{{ asset('images/foto-1.jpg') }}" aria-hidden="true">
                <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
            </video>
        </div>

        <div class="hero-content">
            <div class="hero-kicker">
                <span></span>
                Komunitas Motor Jawa Tengah
            </div>

            <h1 class="hero-title">
                SATU ASPAL.<br>
                SATU <span class="accent">KELUARGA.</span>
            </h1>

            <p class="hero-subtitle">
                Wacana Style adalah ruang untuk berkumpul, touring, kopdar,
                berbagi cerita, dan membangun persaudaraan tanpa memandang jenis motor.
            </p>

            <div class="hero-actions">
                <a href="#join" class="btn btn-red">
                    <i class="fa-solid fa-user-plus"></i>
                    Gabung Sekarang
                </a>
                <a href="#gallery" class="btn btn-outline">
                    <i class="fa-solid fa-images"></i>
                    Lihat Galeri
                </a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>JATENG</strong>
                    <span>Wilayah Komunitas</span>
                </div>
                <div class="hero-stat">
                    <strong>TOURING</strong>
                    <span>Satu Jalan</span>
                </div>
                <div class="hero-stat">
                    <strong>KOPDAR</strong>
                    <span>Tanpa Batas</span>
                </div>
            </div>
        </div>

        <a class="scroll-hint" href="#about">
            Scroll
            <i class="fa-solid fa-chevron-down"></i>
        </a>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section section-dark">
        <div class="container">
            <div class="about-grid">
                <div class="about-copy reveal">
                    <div class="eyebrow">Tentang Kami</div>
                    <h2 class="section-title">Bukan Sekadar<br><span style="color:#ef4444">Komunitas Motor.</span></h2>
                    <p style="margin-top:22px">
                        Wacana Style dibangun sebagai tempat berkumpulnya para rider
                        yang ingin menikmati perjalanan, memperluas pertemanan,
                        dan menjaga rasa kekeluargaan.
                    </p>
                    <p>
                        Di sini tidak ada adu gaya. Yang ada adalah satu tujuan:
                        <strong style="color:#fff">satu aspal, satu cerita, satu keluarga.</strong>
                    </p>

                    <div class="feature-list">
                        <div class="feature">
                            <i class="fa-solid fa-road"></i>
                            <strong>Touring</strong>
                            <span>Menjelajah jalan dan tempat baru bersama.</span>
                        </div>
                        <div class="feature">
                            <i class="fa-solid fa-mug-hot"></i>
                            <strong>Kopdar</strong>
                            <span>Ngobrol santai, berbagi pengalaman, dan silaturahmi.</span>
                        </div>
                        <div class="feature">
                            <i class="fa-solid fa-people-group"></i>
                            <strong>Solidaritas</strong>
                            <span>Saling membantu ketika berada di jalan.</span>
                        </div>
                        <div class="feature">
                            <i class="fa-solid fa-heart"></i>
                            <strong>Kekeluargaan</strong>
                            <span>Jaga nama baik komunitas dan sesama member.</span>
                        </div>
                    </div>
                </div>

                <div class="about-card reveal">
                   <div class="big-logo">
    <img src="{{ asset('images/foto-2.jpg') }}" alt="Wacana Style">
               </div>
                    <div class="about-card-info">
                        <strong>WACANA STYLE</strong>
                        <span>Ride Together • Grow Together • Stay Family</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAP -->
    <section id="map" class="section section-alt tech-grid">
        <div class="container">
            <div class="section-head reveal">
                <div class="eyebrow">Jaringan Komunitas</div>
                <h2 class="section-title">WACANA STYLE <span style="color:#ef4444">JAWA TENGAH</span></h2>
                <p class="section-desc">
                    Titik wilayah komunitas dan koneksi antar rider.
                    Visual ini dapat kamu kembangkan lagi menjadi peta interaktif MapLibre/Google Maps.
                </p>
            </div>

            <div class="map-shell reveal">
                <div class="map-viewport">
                    <div class="map-3d-wrapper">
                        <div class="map-plane">
                            <div class="road r1"></div>
                            <div class="road r2"></div>
                            <div class="road r3"></div>
                            <div class="road r4"></div>

                            <div class="connection c1"></div>
                            <div class="connection c2"></div>
                            <div class="connection c3"></div>

                            <div class="map-point green p-brebes">
                                <div class="pin"></div><label>BREBES</label>
                            </div>
                            <div class="map-point blue p-tegal">
                                <div class="pin"></div><label>KAB. TEGAL</label>
                            </div>
                            <div class="map-point cyan p-kota">
                                <div class="pin"></div><label>KOTA TEGAL</label>
                            </div>
                            <div class="map-point purple p-slawi">
                                <div class="pin"></div><label>SLAWI</label>
                            </div>
                            <div class="map-point p-pemalang">
                                <div class="pin"></div><label>PEMALANG</label>
                            </div>
                            <div class="map-point cyan p-pemalangkidul">
                                <div class="pin"></div><label>PEMALANG KIDUL</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="map-overlay">
                    <strong><i class="fa-solid fa-location-dot" style="color:#ef4444"></i> Wacana Network</strong>
                    <p>
                        Hubungkan rider, wilayah, dan agenda komunitas dalam satu jaringan.
                    </p>
                </div>

                <div class="map-legend">
                    <div class="legend-row"><span class="legend-dot" style="background:#22c55e"></span> Wilayah komunitas</div>
                    <div class="legend-row"><span class="legend-dot" style="background:#3b82f6"></span> Titik regional</div>
                    <div class="legend-row"><span class="legend-dot" style="background:#ef4444"></span> Jalur koneksi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="section section-dark">
        <div class="container">
            <div class="section-head reveal">
                <div class="eyebrow">Dokumentasi</div>
                <h2 class="section-title">CERITA DI <span style="color:#ef4444">JALAN</span></h2>
                <p class="section-desc">
                    Setiap perjalanan punya cerita. Klik foto untuk melihat dokumentasi lebih besar.
                </p>
            </div>

            <div class="gallery-grid reveal">
                <div class="g-item g-item--featured" onclick="openLightbox(0)">
                    <img src="{{ asset('images/foto-1.jpg') }}" alt="Touring Dieng" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Touring</span><span class="g-caption">Touring Dieng</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(1)">
                    <img src="{{ asset('images/foto-2.jpg') }}" alt="Touring Senja" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Touring</span><span class="g-caption">Touring Senja</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(2)">
                    <img src="{{ asset('images/foto-3.jpg') }}" alt="Ngopi Bareng" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Roling</span><span class="g-caption">Ngopi Bareng</span></div>
                </div>

                <div class="g-item g-item--wide" onclick="openLightbox(3)">
                    <img src="{{ asset('images/foto-4.jpg') }}" alt="Barisan Motor" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Ride</span><span class="g-caption">Barisan Motor</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(4)">
                    <img src="{{ asset('images/foto-5.jpg') }}" alt="Warung Bude" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Kopdar</span><span class="g-caption">Kopdar Minguan</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(5)">
                    <img src="{{ asset('images/foto-6.jpg') }}" alt="Ngopi Bude CW" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Kopdar</span><span class="g-caption">Ngopi Bude CW</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(6)">
                    <img src="{{ asset('images/foto-7.jpg') }}" alt="Night ride" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Night ride </span><span class="g-caption">Night ride</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(7)">
                    <img src="{{ asset('images/foto-8.jpg') }}" alt="Night ride V1" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Event</span><span class="g-caption">Night ride V1</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(8)">
                    <img src="{{ asset('images/foto-9.jpg') }}" alt="Agenda Bulanan" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Night ride</span><span class="g-caption">Agenda Bulanan</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(9)">
                    <img src="{{ asset('images/foto-10.jpg') }}" alt="Satu Aspal" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Moment</span><span class="g-caption">Satu Aspal</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(10)">
                    <img src="{{ asset('images/foto-11.jpg') }}" alt="Kopdar Malam CW" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Kopdar</span><span class="g-caption">Kopdar Malam</span></div>
                </div>

                <div class="g-item" onclick="openLightbox(11)">
                    <img src="{{ asset('images/foto-12.jpg') }}" alt="Touring To Dieng" loading="lazy">
                    <div class="g-zoom"><i class="fa-solid fa-expand"></i></div>
                    <div class="g-overlay"><span class="g-tag">Moment</span><span class="g-caption">Touring Dieng</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- MEMBER CTA -->
    <section id="member" class="section section-alt">
        <div class="container">
            <div class="member-wrap reveal">
                <div class="member-content">
                    <div class="eyebrow">Open Member</div>
                    <h2>Motor Boleh Beda.<br><span style="color:#ef4444">Solidaritas Tetap Sama.</span></h2>
                    <p>
                        Mau motor matic, bebek, sport, trail, atau jenis lainnya —
                        selama punya semangat berkendara dan menjaga kebersamaan,
                        kamu punya tempat di Wacana Style.
                    </p>
                    <div class="member-badges">
                        <span class="badge">#SatuAspal</span>
                        <span class="badge">#SatuKeluarga</span>
                        <span class="badge">#WacanaStyle</span>
                        <span class="badge">#RideTogether</span>
                    </div>
                    <a href="#join" class="btn btn-red">
                        <i class="fa-solid fa-motorcycle"></i>
                        Saya Mau Gabung
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- JOIN FORM -->
    <section id="join" class="section section-dark">
        <div class="container">
            <div class="section-head reveal">
                <div class="eyebrow">Pendaftaran</div>
                <h2 class="section-title">GABUNG <span style="color:#ef4444">WACANA STYLE</span></h2>
                <p class="section-desc">
                    Isi data singkat di bawah. Setelah dikirim, data Anda akan diverifikasi oleh admin.
                </p>
            </div>

            <div class="form-grid">
                <div class="glass-card form-card reveal">
                    <h3>Form Calon Member</h3>
                    <p>Data ini digunakan untuk memudahkan admin menghubungi kamu.</p>

                    <form id="joinForm">
                        @csrf
                        <div class="field">
                            <label for="riderName">Nama Lengkap</label>
                            <input id="riderName" type="text" placeholder="Contoh: Ahmad" required autocomplete="name">
                        </div>

                        <div class="field">
                            <label for="riderContact">Nomor WhatsApp</label>
                            <input id="riderContact" type="tel" placeholder="08xxxxxxxxxx" required autocomplete="tel">
                        </div>

                        <div class="field">
                            <label for="scooterModel">Jenis / Tipe Motor</label>
                            <input id="scooterModel" type="text" placeholder="Contoh: Vario 160" required>
                        </div>

                        <div class="field">
                            <label for="riderDomisili">Domisili</label>
                            <input id="riderDomisili" type="text" placeholder="Contoh: Slawi" required autocomplete="address-level2">
                        </div>

                        <button id="submitBtn" type="submit" class="btn btn-red" style="width:100%">
                            <i id="btnIcon" class="fa-solid fa-paper-plane"></i>
                            <span id="submitText">Kirim Pendaftaran</span>
                        </button>

                        <div id="joinSuccess" class="form-status status-success hidden">
                            <i class="fa-solid fa-circle-check"></i>
                            Pendaftaran berhasil dikirim. Data Anda sedang menunggu verifikasi admin.
                        </div>
                        <div id="joinError" class="form-status status-error hidden">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span id="joinErrorMessage">Mohon isi semua data terlebih dahulu.</span>
                        </div>
                    </form>

                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:25px">
                            <strong style="font-family:Montserrat;font-size:12px">Pendaftar Terbaru</strong>
                            <span style="font-size:9px;color:#52525b">LIVE PREVIEW</span>
                        </div>
                        <div id="ridersList" class="riders-list">
                            <div class="rider">
                                <div class="rider-avatar">W</div>
                                <div>
                                    <div class="rider-name">Wacana Rider</div>
                                    <div class="rider-meta">Satu aspal • Satu keluarga</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="section section-alt">
        <div class="container">
            <div class="section-head reveal">
                <div class="eyebrow">Pertanyaan</div>
                <h2 class="section-title">FAQ <span style="color:#ef4444">WACANA STYLE</span></h2>
                <p class="section-desc">Beberapa pertanyaan yang sering ditanyakan calon member.</p>
            </div>

            <div class="faq-list reveal">
                @forelse($faqs as $faq)
                    <div class="faq-item">
                        <button class="faq-question" type="button" onclick="toggleFaq(this)">
                            {{ $faq->question }}
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="faq-answer">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @empty
                    <div class="faq-item">
                        <button class="faq-question" type="button" onclick="toggleFaq(this)">
                            Belum ada FAQ tersedia
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="faq-answer">
                            Silakan cek kembali nanti.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


</main>

@include('partials.footer')

<!-- LIGHTBOX -->
<div id="lightbox" class="lightbox" role="dialog" aria-modal="true" aria-label="Galeri">
    <button class="lb-close" type="button" onclick="closeLightbox()" aria-label="Tutup">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div id="lbCounter" class="lb-counter">1 / 12</div>
    <button class="lb-btn lb-prev" type="button" onclick="changePhoto(-1)" aria-label="Sebelumnya">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <img id="lbImage" src="" alt="">
    <div id="lbCaption" class="lb-caption"></div>
    <button class="lb-btn lb-next" type="button" onclick="changePhoto(1)" aria-label="Berikutnya">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>


<!-- STATUS MODAL -->
<div id="statusModal" class="modal" role="dialog" aria-modal="true">
    <div class="modal-card" style="text-align:center">
        <button class="modal-close" type="button" onclick="closeStatusModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div id="statusIcon" style="width:64px;height:64px;border-radius:50%;display:grid;place-items:center;margin:0 auto 16px;background:rgba(34,197,94,.1);color:#4ade80;font-size:28px">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <h3 id="statusTitle" style="margin-right:0">Berhasil</h3>
        <p id="statusMessage">Data sudah diproses.</p>
        <button class="btn btn-red" type="button" onclick="closeStatusModal()" style="margin-top:10px">
            Tutup
        </button>
    </div>
</div>

<script>
    /* ==========================================================
       DATA GALLERY
       ========================================================== */
    const galleryPhotos = [
        {src:"{{ asset('images/foto-1.jpg') }}",caption:"Touring Dieng"},
        {src:"{{ asset('images/foto-2.jpg') }}",caption:"Touring Senja"},
        {src:"{{ asset('images/foto-3.jpg') }}",caption:"Ngopi Bareng"},
        {src:"{{ asset('images/foto-4.jpg') }}",caption:"Barisan Motor"},
        {src:"{{ asset('images/foto-5.jpg') }}",caption:"Warung Bude"},
        {src:"{{ asset('images/foto-6.jpg') }}",caption:"Ngopi Bude CW"},
        {src:"{{ asset('images/foto-7.jpg') }}",caption:"Night ride"},
        {src:"{{ asset('images/foto-8.jpg') }}",caption:"Night ride V1"},
        {src:"{{ asset('images/foto-9.jpg') }}",caption:"Agenda Bulanan"},
        {src:"{{ asset('images/foto-10.jpg') }}",caption:"Satu Aspal"},
        {src:"{{ asset('images/foto-11.jpg') }}",caption:"Kopdar Malam CW"},
        {src:"{{ asset('images/foto-12.jpg') }}",caption:"Touring To Dieng"}
    ];

    let lbIndex = 0;

    function openLightbox(index){
        lbIndex = index;
        updateLightbox();
        document.getElementById('lightbox').classList.add('open');
        document.body.classList.add('modal-open');
    }

    function closeLightbox(){
        document.getElementById('lightbox').classList.remove('open');
        document.body.classList.remove('modal-open');
    }

    function changePhoto(dir){
        lbIndex = (lbIndex + dir + galleryPhotos.length) % galleryPhotos.length;
        updateLightbox();
    }

    function updateLightbox(){
        const photo = galleryPhotos[lbIndex];
        document.getElementById('lbImage').src = photo.src;
        document.getElementById('lbImage').alt = photo.caption;
        document.getElementById('lbCaption').textContent = photo.caption;
        document.getElementById('lbCounter').textContent = (lbIndex + 1) + ' / ' + galleryPhotos.length;
    }

    /* ==========================================================
       FAQ
       ========================================================== */
    function toggleFaq(button){
        const item = button.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const isOpen = answer.classList.contains('open');

        document.querySelectorAll('.faq-answer.open').forEach(el => el.classList.remove('open'));
        document.querySelectorAll('.faq-question.open').forEach(el => el.classList.remove('open'));

        if(!isOpen){
            answer.classList.add('open');
            button.classList.add('open');
        }
    }

    /* ==========================================================
       SCROLL REVEAL
       ========================================================== */
    (function(){
        const revealEls = document.querySelectorAll('.reveal');

        if(!('IntersectionObserver' in window)){
            revealEls.forEach(el => el.classList.add('revealed'));
            return;
        }

        const observer = new IntersectionObserver((entries)=>{
            entries.forEach((entry)=>{
                if(entry.isIntersecting){
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        },{threshold:.12,rootMargin:'0px 0px -35px 0px'});

        revealEls.forEach(el => observer.observe(el));
    })();

    /* ==========================================================
       MEMBER FORM
       ========================================================== */
    document.getElementById('joinForm').addEventListener('submit',function(event){
        event.preventDefault();

        const nameInput = document.getElementById('riderName');
        const contactInput = document.getElementById('riderContact');
        const scooterInput = document.getElementById('scooterModel');
        const domisiliInput = document.getElementById('riderDomisili');

        const name = nameInput.value.trim();
        const contact = contactInput.value.trim();
        const scooter = scooterInput.value.trim();
        const domisili = domisiliInput.value.trim();

        const success = document.getElementById('joinSuccess');
        const error = document.getElementById('joinError');
        const button = document.getElementById('submitBtn');
        const icon = document.getElementById('btnIcon');
        const text = document.getElementById('submitText');

        success.classList.add('hidden');
        error.classList.add('hidden');

        if(!name || !contact || !scooter || !domisili){
            error.classList.remove('hidden');
            return;
        }

        button.disabled = true;
        icon.className = 'fa-solid fa-circle-notch fa-spin';
        text.textContent = 'Menyimpan...';

        const csrfToken = document.querySelector('input[name="_token"]').value;

        fetch('{{ route("public.member.join") }}',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                name: name,
                whatsapp: contact,
                motor_type: scooter,
                city: domisili
            })
        })
        .then(function(response){
            if(!response.ok){
                return response.json().then(function(data){
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
                    throw new Error(firstError || data.message || 'Terjadi kesalahan server.');
                });
            }
            return response.json();
        })
        .then(function(data){
            success.classList.remove('hidden');

                const list = document.getElementById('ridersList');
                const riderDiv = document.createElement('div');
                riderDiv.className = 'rider';

                const initial = name.charAt(0).toUpperCase();
                const masked = contact.length > 4 ? contact.substring(0,4) + '-xxxx-xxxx' : contact;

                riderDiv.innerHTML =
                    '<div class="rider-avatar">' + escapeHtml(initial) + '</div>' +
                    '<div>' +
                        '<div class="rider-name">' + escapeHtml(name) + '</div>' +
                        '<div class="rider-meta">' + escapeHtml(scooter) + ' • ' + escapeHtml(domisili) + ' • ' + escapeHtml(masked) + '</div>' +
                    '</div>';

                list.insertBefore(riderDiv,list.firstChild);

                nameInput.value = '';
                contactInput.value = '';
                scooterInput.value = '';
                domisiliInput.value = '';

                button.disabled = false;
                icon.className = 'fa-solid fa-paper-plane';
                text.textContent = 'Kirim Pendaftaran';
        })
        .catch(function(err){
            button.disabled = false;
            icon.className = 'fa-solid fa-paper-plane';
            text.textContent = 'Kirim Pendaftaran';

            document.getElementById('joinErrorMessage').textContent = err.message;
            error.classList.remove('hidden');
        });
    });

    function escapeHtml(value){
        return String(value).replace(/[&<>"']/g,function(char){
            return {
                '&':'&amp;',
                '<':'&lt;',
                '>':'&gt;',
                '"':'&quot;',
                "'":'&#039;'
            }[char];
        });
    }

    /* ==========================================================
       JACKET PRICE
       ========================================================== */
    const BASE_PRICE = 180000;
    let selectedSize = 'S';
    let selectedExtra = 0;
    let jacketQty = 1;

    function rupiah(number){
        return new Intl.NumberFormat('id-ID',{
            style:'currency',
            currency:'IDR',
            maximumFractionDigits:0
        }).format(number);
    }

    document.querySelectorAll('.size-btn').forEach(function(btn){
        btn.addEventListener('click',function(){
            document.querySelectorAll('.size-btn').forEach(el => el.classList.remove('active'));
            btn.classList.add('active');

            selectedSize = btn.dataset.size;
            selectedExtra = parseInt(btn.dataset.extra || '0',10);

            updateJacketPrice();
        });
    });

    function adjustQty(delta){
        jacketQty += delta;
        if(jacketQty < 1) jacketQty = 1;
        if(jacketQty > 100) jacketQty = 100;
        document.getElementById('qtyValue').textContent = jacketQty + ' pcs';
        updateJacketPrice();
    }

    function updateJacketPrice(){
        const priceDisplay = document.getElementById('priceDisplay');
        const modalUnitPrice = document.getElementById('modalUnitPrice');
        const modalQty = document.getElementById('modalQty');
        const modalTotal = document.getElementById('modalTotal');

        if(!priceDisplay && !modalUnitPrice && !modalQty && !modalTotal){
            return;
        }

        const unit = BASE_PRICE + selectedExtra;
        const total = unit * jacketQty;

        if(priceDisplay) priceDisplay.textContent = rupiah(unit);
        if(modalUnitPrice) modalUnitPrice.textContent = rupiah(unit);
        if(modalQty) modalQty.textContent = jacketQty + ' pcs';
        if(modalTotal) modalTotal.textContent = rupiah(total);
    }

    /* ==========================================================
       STATUS MODAL
       ========================================================== */
    function showStatus(success,title,message){
        const icon = document.getElementById('statusIcon');

        icon.style.background = success ? 'rgba(34,197,94,.1)' : 'rgba(239,68,68,.1)';
        icon.style.color = success ? '#4ade80' : '#f87171';
        icon.innerHTML = success
            ? '<i class="fa-solid fa-circle-check"></i>'
            : '<i class="fa-solid fa-circle-exclamation"></i>';

        document.getElementById('statusTitle').textContent = title;
        document.getElementById('statusMessage').textContent = message;
        document.getElementById('statusModal').classList.add('open');
        document.body.classList.add('modal-open');
    }

    function closeStatusModal(){
        document.getElementById('statusModal').classList.remove('open');
        document.body.classList.remove('modal-open');
    }

    /* ==========================================================
       MODAL BACKDROP + KEYBOARD
       ========================================================== */
    document.getElementById('lightbox').addEventListener('click',function(e){
        if(e.target === this) closeLightbox();
    });

    document.getElementById('statusModal').addEventListener('click',function(e){
        if(e.target === this) closeStatusModal();
    });

    document.addEventListener('keydown',function(e){
        if(e.key === 'Escape'){
            closeLightbox();
            closeStatusModal();
        }

        const lb = document.getElementById('lightbox');
        if(lb.classList.contains('open')){
            if(e.key === 'ArrowLeft') changePhoto(-1);
            if(e.key === 'ArrowRight') changePhoto(1);
        }
    });

    /* ==========================================================
       VIDEO FALLBACK
       ========================================================== */
    const heroVideo = document.querySelector('.video-foreground');
    if(heroVideo){
        const videoContainer = document.querySelector('.video-background-container');
        const fallback = document.querySelector('.hero-fallback');

        heroVideo.addEventListener('loadeddata',function(){
            if(fallback) fallback.style.opacity = '0';
        });

        heroVideo.addEventListener('canplay',function(){
            heroVideo.play().catch(function(){});
        });

        heroVideo.addEventListener('error',function(){
            if(fallback) fallback.style.opacity = '1';
            if(videoContainer) videoContainer.style.display = 'none';
        });

        heroVideo.play().catch(function(){});
    }

    updateJacketPrice();
</script>

</body>
</html>