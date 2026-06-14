<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', ($page->meta_title ?? $page->title ?? ($cms['site_name'] ?? 'ATSL')))</title>
    <meta name="description" content="@yield('meta_description', $page->meta_description ?? ($cms['site_tagline'] ?? ''))">
    <meta name="keywords" content="{{ $page->meta_keywords ?? ($cms['meta_keywords'] ?? '') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Tailwind CSS (utilities only — preflight disabled so it works alongside the custom CSS) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { corePlugins: { preflight: false }, theme: { extend: { colors: { primary: '#2563eb', 'primary-dark': '#1d4ed8', dark: '#0f172a' } } } };</script>
    <link rel="stylesheet" href="{{ asset('css/cms-blocks.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        :root {
            --cms-primary: #2563eb;
            --cms-primary-dark: #1d4ed8;
            --cms-dark: #0f172a;
            --cms-muted: #64748b;
            --cms-bg: #f8fafc;
            --cms-border: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--cms-dark);
            background: #fff;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5 { font-family: 'Poppins', sans-serif; line-height: 1.2; margin: 0 0 .5em; }
        a { color: var(--cms-primary); text-decoration: none; }
        img { max-width: 100%; height: auto; }
        .cms-container { max-width: 1180px; margin: 0 auto; padding: 0 20px; }

        /* ---------- Top bar ---------- */
        .cms-topbar {
            background: var(--cms-dark); color: #cbd5e1; font-size: 13.5px;
        }
        .cms-topbar .cms-container { display: flex; justify-content: space-between; align-items: center; height: 42px; flex-wrap: wrap; }
        .cms-topbar a { color: #cbd5e1; }
        .cms-topbar .cms-top-info span { margin-right: 22px; }
        .cms-topbar .cms-social a { margin-left: 14px; opacity: .8; }
        .cms-topbar .cms-social a:hover { opacity: 1; color: #fff; }

        /* ---------- Header / nav ---------- */
        .cms-header {
            position: sticky; top: 0; z-index: 100; background: #fff;
            box-shadow: 0 1px 0 var(--cms-border); transition: box-shadow .2s;
        }
        .cms-header.scrolled { box-shadow: 0 6px 24px rgba(15,23,42,.08); }
        .cms-header .cms-container { display: flex; align-items: center; justify-content: space-between; height: 74px; }
        .cms-logo { font-family: 'Poppins'; font-weight: 800; font-size: 24px; color: var(--cms-dark); letter-spacing: -.5px; }
        .cms-logo span { color: var(--cms-primary); }
        .cms-logo img { max-height: 46px; }

        .cms-nav > ul { display: flex; align-items: center; gap: 2px; list-style: none; margin: 0; padding: 0; }
        .cms-nav-item { position: relative; }
        .cms-nav > ul > .cms-nav-item > a {
            position: relative;
        }
        .cms-nav > ul > .cms-nav-item > a::after {
            content:''; position:absolute; left:16px; right:16px; bottom:6px; height:2px; border-radius:2px;
            background: var(--cms-primary); transform: scaleX(0); transform-origin: left; transition: transform .25s ease;
        }
        .cms-nav > ul > .cms-nav-item:hover > a::after { transform: scaleX(1); }
        .cms-nav-item > a {
            display: flex; align-items: center; gap: 6px; padding: 10px 16px; font-weight: 600;
            font-size: 15px; color: var(--cms-dark); border-radius: 8px; transition: .2s;
        }
        .cms-nav-item > a:hover { color: var(--cms-primary); }
        .cms-caret { font-size: 10px; opacity: .6; transition: transform .2s; }
        .cms-nav-item:hover > a .cms-caret { transform: rotate(180deg); }

        /* dropdowns */
        .cms-submenu {
            position: absolute; top: 100%; left: 0; min-width: 220px; background: #fff;
            border: 1px solid var(--cms-border); border-radius: 12px; box-shadow: 0 16px 40px rgba(15,23,42,.14);
            padding: 8px; list-style: none; margin: 8px 0 0; opacity: 0; visibility: hidden;
            transform: translateY(8px); transition: .2s; z-index: 50;
        }
        .cms-nav-item:hover > .cms-submenu { opacity: 1; visibility: visible; transform: translateY(0); }
        .cms-submenu .cms-nav-item > a { padding: 9px 12px; font-size: 14.5px; border-radius: 8px; justify-content: space-between; }
        .cms-submenu .cms-nav-item > a:hover { background: var(--cms-bg); }
        /* sub-sub menu flies out to the side */
        .cms-submenu .cms-submenu { top: -8px; left: 100%; margin: 0 0 0 8px; }
        .cms-submenu .cms-caret { transform: rotate(-90deg); }
        .cms-submenu .cms-nav-item:hover > a .cms-caret { transform: rotate(-90deg); }

        .cms-btn {
            display: inline-flex; align-items: center; gap: 8px; background: var(--cms-primary); color: #fff !important;
            padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 15px; transition: .2s; border: 0; cursor: pointer;
            box-shadow: 0 8px 20px rgba(37,99,235,.28);
        }
        .cms-btn:hover { background: var(--cms-primary-dark); transform: translateY(-2px); box-shadow: 0 12px 26px rgba(37,99,235,.36); }
        .cms-btn-ghost { background: transparent; color: var(--cms-dark) !important; border: 1px solid var(--cms-border); }
        .cms-btn-ghost:hover { background: var(--cms-bg); }

        .cms-burger { display: none; font-size: 24px; background: none; border: 0; cursor: pointer; color: var(--cms-dark); }

        /* ---------- Page banner ---------- */
        .cms-page-banner {
            background: linear-gradient(135deg, var(--cms-dark) 0%, #1e3a8a 100%);
            color: #fff; padding: 70px 0; text-align: center; position: relative; overflow: hidden;
        }
        .cms-page-banner.has-img { background-size: cover; background-position: center; }
        .cms-page-banner::after { content: ''; position: absolute; inset: 0; background: rgba(15,23,42,.55); }
        .cms-page-banner .cms-container { position: relative; z-index: 2; }
        .cms-page-banner h1 { font-size: 42px; color: #fff; }
        .cms-page-banner p { color: #cbd5e1; font-size: 18px; max-width: 640px; margin: 8px auto 0; }
        .cms-breadcrumb { margin-top: 14px; font-size: 14px; color: #94a3b8; }
        .cms-breadcrumb a { color: #cbd5e1; }

        /* ---------- Footer (professional) ---------- */
        .cms-footer { position: relative; background: linear-gradient(180deg,#111c33 0%, var(--cms-dark) 100%); color: #94a3b8; padding: 70px 0 0; margin-top: 70px; }
        .cms-footer::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, var(--cms-primary), #38bdf8); }
        .cms-footer-grid { display: grid; grid-template-columns: 1.6fr 1fr 1.4fr; gap: 46px; }
        .cms-footer h4 { color: #fff; font-size: 17px; margin-bottom: 22px; position: relative; padding-bottom: 12px; }
        .cms-footer h4::after { content:''; position:absolute; left:0; bottom:0; width:38px; height:3px; border-radius:3px; background: var(--cms-primary); }
        .cms-footer p { line-height: 1.7; }
        .cms-footer ul { list-style: none; padding: 0; margin: 0; }
        .cms-footer ul li { margin-bottom: 12px; }
        .cms-footer a { color: #94a3b8; transition: .2s; }
        .cms-footer ul li a { display: inline-flex; align-items: center; gap: 9px; }
        .cms-footer ul li a::before { content:'\f054'; font-family:'Font Awesome 6 Free'; font-weight:900; font-size:9px; color: var(--cms-primary); transition:.2s; }
        .cms-footer a:hover { color: #fff; }
        .cms-footer ul li a:hover { transform: translateX(4px); }
        .cms-footer .cms-social { display:flex; gap:10px; margin-top: 18px; }
        .cms-footer .cms-social a { display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center;
            background: rgba(255,255,255,.08); border-radius: 10px; }
        .cms-footer .cms-social a:hover { background: var(--cms-primary); color:#fff; transform: translateY(-3px); }
        .cms-copyright { border-top: 1px solid rgba(255,255,255,.08); margin-top: 50px; padding: 24px 0; text-align: center; font-size: 14px; }
        .cms-copyright a { color: var(--cms-primary); }

        /* ---------- ATSL Preloader ---------- */
        #cms-preloader {
            position: fixed; inset: 0; z-index: 9999; background: var(--cms-dark);
            display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: opacity .6s ease, visibility .6s ease;
        }
        #cms-preloader.hide { opacity: 0; visibility: hidden; }
        #cms-preloader span {
            font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 56px; color: #fff;
            opacity: .25; animation: cmsPulse 1.2s infinite ease-in-out;
        }
        #cms-preloader span:nth-child(1) { animation-delay: 0s; }
        #cms-preloader span:nth-child(2) { animation-delay: .15s; }
        #cms-preloader span:nth-child(3) { animation-delay: .3s; }
        #cms-preloader span:nth-child(4) { animation-delay: .45s; color: var(--cms-primary); }
        @keyframes cmsPulse { 0%,100% { opacity:.25; transform:translateY(0); } 50% { opacity:1; transform:translateY(-10px); } }

        @media (max-width: 900px) {
            .cms-footer-grid { grid-template-columns: 1fr; gap: 28px; }
            .cms-burger { display: block; }
            .cms-nav { position: fixed; inset: 0 0 0 auto; width: 300px; max-width: 85%; background: #fff; padding: 80px 18px 18px;
                box-shadow: -10px 0 40px rgba(0,0,0,.15); transform: translateX(100%); transition: .3s; overflow-y: auto; z-index: 200; }
            .cms-nav.open { transform: translateX(0); }
            .cms-nav > ul { flex-direction: column; align-items: stretch; gap: 2px; }
            .cms-nav-item > a { justify-content: space-between; }
            .cms-submenu, .cms-submenu .cms-submenu {
                position: static; opacity: 1; visibility: visible; transform: none; box-shadow: none;
                border: 0; margin: 0 0 0 14px; padding: 0; min-width: 0; display: none;
            }
            .cms-nav-item.mobile-open > .cms-submenu { display: block; }
            .cms-nav-item:hover > .cms-submenu { transform: none; }
            .cms-nav-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.4); opacity: 0; visibility: hidden; transition: .3s; z-index: 150; }
            .cms-nav-overlay.open { opacity: 1; visibility: visible; }
            .cms-header-cta { display: none; }
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- ATSL preloader --}}
    <div id="cms-preloader">
        <span>A</span><span>T</span><span>S</span><span>L</span>
    </div>

    {{-- Top bar (toggleable from Settings) --}}
    @if (($cms['show_topbar'] ?? '1') != '0')
    <div class="cms-topbar">
        <div class="cms-container">
            <div class="cms-top-info">
                @if (!empty($cms['contact_email']))<span><i class="fas fa-envelope"></i> <a href="mailto:{{ $cms['contact_email'] }}">{{ $cms['contact_email'] }}</a></span>@endif
                @if (!empty($cms['contact_phone']))<span><i class="fas fa-phone"></i> <a href="tel:{{ $cms['contact_phone'] }}">{{ $cms['contact_phone'] }}</a></span>@endif
            </div>
            <div class="cms-social">
                @if (!empty($cms['facebook_url']))<a href="{{ $cms['facebook_url'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                @if (!empty($cms['twitter_url']))<a href="{{ $cms['twitter_url'] }}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                @if (!empty($cms['linkedin_url']))<a href="{{ $cms['linkedin_url'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
            </div>
        </div>
    </div>
    @endif

    {{-- Header / dynamic menu --}}
    <header class="cms-header" id="cmsHeader">
        <div class="cms-container">
            <a href="{{ url('/') }}" class="cms-logo">
                @if (!empty($cms['site_logo']))
                    <img src="{{ asset($cms['site_logo']) }}" alt="{{ $cms['site_name'] ?? 'logo' }}">
                @else
                    {{ $cms['site_name'] ?? 'ATSL' }}<span>.</span>
                @endif
            </a>

            <nav class="cms-nav" id="cmsNav">
                <ul>
                    @if (!empty($headerMenu) && $headerMenu->rootItems->count())
                        @include('frontend.partials.menu-items', ['items' => $headerMenu->rootItems])
                    @else
                        <li class="cms-nav-item"><a href="{{ url('/') }}">Home</a></li>
                    @endif
                </ul>
            </nav>

            @if (($cms['show_header_cta'] ?? '1') != '0')
                <a href="{{ $cms['header_cta_url'] ?? '/contact' }}" class="cms-btn cms-header-cta">{{ $cms['header_cta_text'] ?? 'Get A Quote' }} <i class="fas fa-arrow-right"></i></a>
            @endif
            <button class="cms-burger" id="cmsBurger" aria-label="Menu"><i class="fas fa-bars"></i></button>
        </div>
    </header>
    <div class="cms-nav-overlay" id="cmsNavOverlay"></div>

    @yield('content')

    {{-- Footer --}}
    <footer class="cms-footer">
        <div class="cms-container">
            <div class="cms-footer-grid">
                <div>
                    <h4>{{ $cms['footer_title'] ?? ($cms['site_name'] ?? 'ATSL') }}</h4>
                    <p>{{ $cms['footer_about'] ?? ($cms['site_tagline'] ?? 'Your trusted partner for modern solutions.') }}</p>
                    @if (!empty($cms['contact_address']))<p><i class="fas fa-location-dot"></i> {{ $cms['contact_address'] }}</p>@endif
                    <div class="cms-social">
                        @if (!empty($cms['facebook_url']))<a href="{{ $cms['facebook_url'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
                        @if (!empty($cms['twitter_url']))<a href="{{ $cms['twitter_url'] }}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                        @if (!empty($cms['linkedin_url']))<a href="{{ $cms['linkedin_url'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                    </div>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        @if (!empty($footerMenu) && $footerMenu->rootItems->count())
                            @foreach ($footerMenu->rootItems as $fi)
                                <li><a href="{{ $fi->link }}" target="{{ $fi->target ?? '_self' }}">{{ $fi->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ url('/about') }}">About</a></li>
                            <li><a href="{{ url('/services') }}">Services</a></li>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4>Get In Touch</h4>
                    <ul>
                        @if (!empty($cms['contact_phone']))<li><i class="fas fa-phone"></i> <a href="tel:{{ $cms['contact_phone'] }}">{{ $cms['contact_phone'] }}</a></li>@endif
                        @if (!empty($cms['contact_email']))<li><i class="fas fa-envelope"></i> <a href="mailto:{{ $cms['contact_email'] }}">{{ $cms['contact_email'] }}</a></li>@endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="cms-copyright">
            @if (!empty($cms['footer_copyright']))
                {!! str_replace('{year}', date('Y'), $cms['footer_copyright']) !!}
            @else
                &copy; {{ date('Y') }} {{ $cms['site_name'] ?? 'ATSL' }}. All rights reserved.
            @endif
        </div>
    </footer>

    <script>
        // Hide preloader once the page is ready
        (function () {
            var pl = document.getElementById('cms-preloader');
            function hide() { if (pl) pl.classList.add('hide'); }
            window.addEventListener('load', function () { setTimeout(hide, 350); });
            setTimeout(hide, 3500); // safety fallback
        })();

        // Sticky header shadow
        var header = document.getElementById('cmsHeader');
        window.addEventListener('scroll', function () {
            header.classList.toggle('scrolled', window.scrollY > 10);
        });
        // Mobile nav toggle
        var nav = document.getElementById('cmsNav'),
            overlay = document.getElementById('cmsNavOverlay'),
            burger = document.getElementById('cmsBurger');
        function closeNav() { nav.classList.remove('open'); overlay.classList.remove('open'); }
        burger.addEventListener('click', function () { nav.classList.add('open'); overlay.classList.add('open'); });
        overlay.addEventListener('click', closeNav);
        // Mobile accordion for items with children
        nav.querySelectorAll('.has-children > a').forEach(function (a) {
            a.addEventListener('click', function (e) {
                if (window.innerWidth <= 900) { e.preventDefault(); a.parentElement.classList.toggle('mobile-open'); }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
