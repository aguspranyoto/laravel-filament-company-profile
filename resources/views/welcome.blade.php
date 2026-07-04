<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zeroxe Consulting') }}</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #f59e0b;
            --accent-hover: #d97706;
            --text: #334155;
            --text-light: #64748b;
            --bg: #ffffff;
            --bg-light: #f8fafc;
            --radius: 8px;
            --radius-lg: 12px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }

        .container { max-width: 1200px; margin: 0 auto; padding-left: 24px; padding-right: 24px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 4vw, 40px); font-weight: 700; line-height: 1.2; margin-bottom: 16px; color: var(--primary); }
        .section-subtitle { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: var(--accent); margin-bottom: 12px; }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--accent); color: white;
            padding: 14px 32px; border-radius: var(--radius);
            font-weight: 600; text-decoration: none;
            transition: all 0.2s ease; cursor: pointer; border: none;
        }
        .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: var(--shadow-md); }
        .btn-primary:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
        .btn-primary:active { transform: translateY(0); }

        .btn-outline {
            display: inline-flex; align-items: center; justify-content: center;
            border: 2px solid white; color: white;
            padding: 14px 32px; border-radius: var(--radius);
            font-weight: 600; text-decoration: none;
            transition: all 0.2s ease; cursor: pointer; background: transparent;
        }
        .btn-outline:hover { background: white; color: var(--primary); }
        .btn-outline:focus-visible { outline: 2px solid white; outline-offset: 2px; }

        .btn-secondary {
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--primary); color: white;
            padding: 14px 32px; border-radius: var(--radius);
            font-weight: 600; text-decoration: none;
            transition: all 0.2s ease; cursor: pointer; border: none;
        }
        .btn-secondary:hover { background: var(--primary-light); transform: translateY(-1px); box-shadow: var(--shadow-md); }
        .btn-secondary:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }

        .card {
            background: white; border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .card:hover { box-shadow: var(--shadow-lg); }

        .input-field {
            width: 100%; padding: 14px 16px;
            border: 1px solid #e2e8f0; border-radius: var(--radius);
            font-size: 15px; transition: all 0.2s ease;
            background: white;
        }
        .input-field:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }
        .input-field::placeholder { color: #94a3b8; }

        .nav-link {
            position: relative; padding: 8px 0;
            transition: color 0.2s ease;
        }
        .nav-link::after {
            content: ''; position: absolute; bottom: 0; left: 0;
            width: 0; height: 2px; background: var(--accent);
            transition: width 0.2s ease;
        }
        .nav-link:hover { color: var(--accent); }
        .nav-link:hover::after { width: 100%; }

        .stat-card { text-align: center; padding: 24px; }
        .stat-number { font-size: clamp(36px, 5vw, 48px); font-weight: 700; color: var(--primary); line-height: 1; margin-bottom: 8px; }
        .stat-label { font-size: 13px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.1em; }

        .service-icon {
            width: 48px; height: 48px; border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white; margin-bottom: 20px;
            transition: transform 0.2s ease;
        }
        .card:hover .service-icon { transform: scale(1.05); }

        .pricing-card {
            background: white; border-radius: var(--radius-lg);
            padding: 32px; text-align: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease; position: relative;
        }
        .pricing-card.featured {
            background: var(--primary); color: white;
            box-shadow: var(--shadow-xl);
            transform: scale(1.02);
        }
        .pricing-card:hover { box-shadow: var(--shadow-xl); }

        .testimonial-card {
            background: var(--primary-light); border-radius: var(--radius-lg);
            padding: 32px; transition: all 0.3s ease;
        }
        .testimonial-card:hover { transform: translateY(-4px); }

        .blog-card {
            background: white; border-radius: var(--radius-lg);
            overflow: hidden; box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .blog-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .blog-card img { transition: transform 0.5s ease; }
        .blog-card:hover img { transform: scale(1.05); }

        .project-card {
            position: relative; overflow: hidden; border-radius: var(--radius-lg);
        }
        .project-card img {
            width: 100%; height: 256px; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .project-card:hover img { transform: scale(1.05); }
        .project-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            opacity: 0; transition: opacity 0.3s ease;
            display: flex; align-items: flex-end; padding: 24px;
        }
        .project-card:hover .project-overlay { opacity: 1; }

        .contact-icon {
            width: 48px; height: 48px; border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center;
            color: white; flex-shrink: 0;
        }

        .footer-link {
            color: #94a3b8; font-size: 14px; text-decoration: none;
            transition: color 0.2s ease; display: block; padding: 4px 0;
        }
        .footer-link:hover { color: var(--accent); }

        .social-link {
            width: 40px; height: 40px; border-radius: var(--radius);
            background: var(--primary-light);
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8; text-decoration: none; font-size: 14px;
            transition: all 0.2s ease;
        }
        .social-link:hover { background: var(--accent); color: white; }
        .social-link:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        .skip-link {
            position: absolute; top: -40px; left: 0;
            background: var(--accent); color: white;
            padding: 8px 16px; z-index: 100;
            transition: top 0.2s ease;
        }
        .skip-link:focus { top: 0; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeInUp 0.6s ease forwards; }

        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; position: absolute; top: 100%; left: 0; right: 0; z-index: 50; }
        .mobile-menu.open { max-height: 400px; }
    </style>
</head>
<body class="bg-white text-[#334155] antialiased">
    <a href="#main-content" class="skip-link">Skip to main content</a>

    {{-- Header --}}
    <header class="bg-[#0f172a] text-white sticky top-0 z-50 relative" role="banner">
        <div class="container flex justify-between items-center py-4">
            <a href="/" class="text-2xl font-bold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f59e0b]">
                <span class="text-[#f59e0b]">{{ Str::before($settings->company_name, ' ') }}</span>{{ Str::after($settings->company_name, ' ') }}
            </a>
            <nav class="hidden md:flex gap-8 text-sm font-medium" role="navigation" aria-label="Main navigation">
                <a href="#" class="nav-link hover:text-[#f59e0b] transition-colors">HOME</a>
                <a href="#about" class="nav-link hover:text-[#f59e0b] transition-colors">ABOUT</a>
                <a href="#services" class="nav-link hover:text-[#f59e0b] transition-colors">SERVICES</a>
                <a href="#projects" class="nav-link hover:text-[#f59e0b] transition-colors">PROJECTS</a>
                <a href="#blog" class="nav-link hover:text-[#f59e0b] transition-colors">NEWS</a>
                <a href="#contact" class="nav-link hover:text-[#f59e0b] transition-colors">CONTACT</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}" class="nav-link hover:text-[#f59e0b] transition-colors">ADMIN</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link hover:text-[#f59e0b] transition-colors">LOGIN</a>
                    @endauth
                @endif
            </nav>
            <div class="hidden lg:block text-sm">
                <span class="text-gray-400">Call anytime</span>
                <a href="tel:{{ $settings->phone }}" class="font-semibold ml-2 hover:text-[#f59e0b] transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f59e0b]">{{ $settings->phone }}</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f59e0b]" aria-label="Toggle navigation menu" aria-expanded="false">
                <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="mobile-menu" class="mobile-menu md:hidden border-t border-white/10 bg-[#0f172a] shadow-xl">
            <nav class="container flex flex-col gap-1 py-4 text-sm font-medium" role="navigation" aria-label="Mobile navigation">
                <a href="#" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">HOME</a>
                <a href="#about" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">ABOUT</a>
                <a href="#services" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">SERVICES</a>
                <a href="#projects" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">PROJECTS</a>
                <a href="#blog" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">NEWS</a>
                <a href="#contact" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">CONTACT</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">ADMIN</a>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-2 rounded hover:bg-white/10 hover:text-[#f59e0b] transition-colors">LOGIN</a>
                    @endauth
                @endif
            </nav>
            <div class="container pb-4 text-sm border-t border-white/10 pt-3">
                <span class="text-gray-400">Call anytime</span>
                <a href="tel:{{ $settings->phone }}" class="font-semibold ml-2 hover:text-[#f59e0b] transition-colors">{{ $settings->phone }}</a>
            </div>
        </div>
    </header>

    <main id="main-content">
        {{-- Hero --}}
        @if($hero)
        <section class="bg-[#0f172a] text-white py-20 lg:py-32" aria-labelledby="hero-heading">
            <div class="container grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="text-[#f59e0b] text-xs font-bold tracking-[0.2em] mb-4">{{ $hero->subtitle ?? '' }}</div>
                    <h1 id="hero-heading" class="text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-6">
                        {{ $hero->title ?? '' }}
                    </h1>
                    <div class="text-gray-400 text-lg mb-8 max-w-lg">
                        {!! $hero->content ?? '' !!}
                    </div>
                    <div class="flex flex-wrap gap-4">
                        @if($hero->getExtra('button_primary_text'))
                            <a href="{{ $hero->getExtra('button_primary_url', '#contact') }}" class="btn-primary">{{ $hero->getExtra('button_primary_text') }}</a>
                        @endif
                        @if($hero->getExtra('button_secondary_text'))
                            <a href="{{ $hero->getExtra('button_secondary_url', '#') }}" class="btn-outline">{{ $hero->getExtra('button_secondary_text') }}</a>
                        @endif
                    </div>
                </div>
                <div class="relative">
                    @if($hero->getExtra('image_url'))
                        <img src="{{ $hero->getExtra('image_url') }}" alt="{{ $hero->title ?? 'Hero image' }}" class="rounded-lg shadow-2xl" width="600" height="400" loading="eager">
                    @else
                        <img src="https://placehold.co/600x400/1e293b/f59e0b?text=Consulting+Expert" alt="Consulting expert providing professional advice" class="rounded-lg shadow-2xl" width="600" height="400" loading="eager">
                    @endif
                    @if($hero->getExtra('badge_number') || $hero->getExtra('badge_text'))
                        <div class="absolute -bottom-6 -left-6 bg-[#f59e0b] text-white p-6 rounded-lg" aria-hidden="true">
                            <div class="text-3xl font-bold">{{ $hero->getExtra('badge_number', '') }}</div>
                            <div class="text-sm">{{ $hero->getExtra('badge_text', '') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        {{-- Trusted By --}}
        @if($clientLogos->count())
        <section class="py-12 bg-white border-b" aria-label="Trusted by companies">
            <div class="container">
                <div class="text-center mb-8">
                    <span class="text-sm font-semibold text-gray-500 tracking-wider">TRUSTED BY 1,200+ POPULAR COMPANY</span>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-8 lg:gap-16 opacity-60" role="list">
                    @foreach($clientLogos as $logo)
                        @if($logo->getFirstMediaUrl('logo'))
                            @if($logo->url)
                                <a href="{{ $logo->url }}" target="_blank" rel="noopener noreferrer" role="listitem">
                                    <img src="{{ $logo->getFirstMediaUrl('logo') }}" alt="{{ $logo->name }}" class="h-8" width="120" height="40" loading="lazy">
                                </a>
                            @else
                                <img src="{{ $logo->getFirstMediaUrl('logo') }}" alt="{{ $logo->name }}" class="h-8" width="120" height="40" loading="lazy" role="listitem">
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Experience Counter --}}
        @if($counterStats->count())
        <section class="py-16 bg-[#f8fafc]" aria-label="Company statistics">
            <div class="container grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($counterStats as $stat)
                    <div class="stat-card">
                        <div class="stat-number">{{ $stat->number_value }}</div>
                        <div class="stat-label">{{ $stat->label }}</div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- About Us --}}
        @if($about)
        <section id="about" class="py-20" aria-labelledby="about-heading">
            <div class="container grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    @if($about->getExtra('image_url'))
                        <img src="{{ $about->getExtra('image_url') }}" alt="{{ $about->title ?? 'About Us' }}" class="rounded-lg shadow-xl" width="600" height="500" loading="lazy">
                    @else
                        <img src="https://placehold.co/600x500/0f172a/f59e0b?text=About+Us" alt="Our team collaborating in a modern office" class="rounded-lg shadow-xl" width="600" height="500" loading="lazy">
                    @endif
                </div>
                <div>
                    <div class="section-subtitle">ABOUT US</div>
                    <h2 id="about-heading" class="section-title">{{ $about->title ?? '' }}</h2>
                    <div class="text-gray-500 mb-8 leading-relaxed">
                        {!! $about->content ?? '' !!}
                    </div>
                    @if($about->getExtra('founder_quote'))
                        <blockquote class="bg-[#f8fafc] p-6 rounded-lg border-l-4 border-[#f59e0b]">
                            <p class="italic text-gray-600 mb-4">"{{ $about->getExtra('founder_quote') }}"</p>
                            <footer class="flex items-center gap-4">
                                @if($about->getExtra('founder_image'))
                                    <img src="{{ $about->getExtra('founder_image') }}" alt="{{ $about->getExtra('founder_name', '') }}" class="rounded-full" width="50" height="50" loading="lazy">
                                @else
                                    <img src="https://placehold.co/50x50/0f172a/fff?text={{ substr($about->getExtra('founder_name', 'HM'), 0, 2) }}" alt="{{ $about->getExtra('founder_name', '') }}" class="rounded-full" width="50" height="50" loading="lazy">
                                @endif
                                <div>
                                    <div class="font-semibold">{{ $about->getExtra('founder_name', '') }}</div>
                                    <div class="text-sm text-gray-500">{{ $about->getExtra('founder_role', '') }}</div>
                                </div>
                            </footer>
                        </blockquote>
                    @endif
                </div>
            </div>
        </section>
        @endif

        {{-- Key Benefits --}}
        @if($benefits)
        <section class="py-20 bg-[#0f172a] text-white" aria-labelledby="benefits-heading">
            <div class="container grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="section-subtitle">KEY BENEFITS</div>
                    <h2 id="benefits-heading" class="section-title text-white">{{ $benefits->title ?? '' }}</h2>
                    <div class="text-gray-400 mb-8">
                        {!! $benefits->content ?? '' !!}
                    </div>
                    @php $benefitItems = $benefits->getExtra('benefit_items', []); @endphp
                    @if(count($benefitItems))
                        <ul class="space-y-4" role="list">
                            @foreach($benefitItems as $item)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-[#f59e0b] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span>{{ is_array($item) ? ($item['text'] ?? ($item['title'] ?? '')) : $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div>
                    @if($benefits->getExtra('image_url'))
                        <img src="{{ $benefits->getExtra('image_url') }}" alt="{{ $benefits->title ?? 'Benefits' }}" class="rounded-lg shadow-xl" width="600" height="500" loading="lazy">
                    @else
                        <img src="https://placehold.co/600x500/1e293b/f59e0b?text=Benefits" alt="Key benefits of our consulting services" class="rounded-lg shadow-xl" width="600" height="500" loading="lazy">
                    @endif
                </div>
            </div>
        </section>
        @endif

        {{-- Who We Are --}}
        @if($whoWeAre)
        <section class="py-20" aria-labelledby="vision-mission-heading">
            <div class="container">
                <div class="text-center mb-16">
                    <div class="section-subtitle">WHO WE ARE</div>
                    <h2 id="vision-mission-heading" class="section-title">{{ $whoWeAre->title ?? '' }}</h2>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-[#f8fafc] p-8 rounded-lg">
                        <div class="w-14 h-14 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-2xl font-bold mb-6" aria-hidden="true">V</div>
                        <h3 class="text-xl font-bold mb-4">VISION</h3>
                        <p class="text-gray-500 leading-relaxed">
                            {{ $whoWeAre->getExtra('vision_text', '') }}
                        </p>
                    </div>
                    <div class="bg-[#f8fafc] p-8 rounded-lg">
                        <div class="w-14 h-14 bg-[#0f172a] rounded-lg flex items-center justify-center text-white text-2xl font-bold mb-6" aria-hidden="true">M</div>
                        <h3 class="text-xl font-bold mb-4">MISSION</h3>
                        <p class="text-gray-500 leading-relaxed">
                            {{ $whoWeAre->getExtra('mission_text', '') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- Services --}}
        @if($services->count())
        <section id="services" class="py-20 bg-[#f8fafc]" aria-labelledby="services-heading">
            <div class="container">
                <div class="text-center mb-16">
                    <div class="section-subtitle">WHAT WE DO</div>
                    <h2 id="services-heading" class="section-title">Our Expertise & Services.</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">
                        Cursus vitae congue mauris rhoncus aenean vel elit scelerisque. Mauris pellentesque pulvinar pellentesque habitant morbi.
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $service)
                        <article class="card p-8">
                            <div class="service-icon bg-[#f59e0b]">
                                {!! $service->icon ?? '' !!}
                            </div>
                            <h3 class="text-lg font-bold mb-3">{{ $service->title ?? '' }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ $service->description ?? '' }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Projects --}}
        @if($projects->count())
        <section id="projects" class="py-20" aria-labelledby="projects-heading">
            <div class="container">
                <div class="text-center mb-16">
                    <div class="section-subtitle">PROJECT</div>
                    <h2 id="projects-heading" class="section-title">Thinking forward for your results.</h2>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <article class="project-card">
                            @if($project->getFirstMediaUrl('project-image'))
                                <img src="{{ $project->getFirstMediaUrl('project-image') }}" alt="{{ $project->title ?? 'Project' }}" width="600" height="400" loading="lazy">
                            @else
                                <img src="https://placehold.co/600x400/0f172a/f59e0b?text={{ urlencode($project->title ?? 'Project') }}" alt="{{ $project->title ?? 'Project' }}" width="600" height="400" loading="lazy">
                            @endif
                            <div class="project-overlay">
                                <div>
                                    <div class="text-[#f59e0b] text-sm font-semibold mb-1">{{ $project->category ?? '' }}</div>
                                    <div class="text-white font-bold">{{ $project->title ?? '' }}</div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Pricing --}}
        @if($pricingPlans->count())
        <section class="py-20 bg-[#f8fafc]" aria-labelledby="pricing-heading">
            <div class="container">
                <div class="text-center mb-16">
                    <div class="section-subtitle">PLAN & PRICING</div>
                    <h2 id="pricing-heading" class="section-title">Effective & Flexible Pricing.</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">
                        Nisl pretium fusce id velit ut tortor pretium viverra. Eleifend quam adipiscing vitae proin sagittis nisl rhoncus.
                    </p>
                </div>
                <div class="grid md:grid-cols-{{ $pricingPlans->count() > 3 ? 4 : ($pricingPlans->count() > 2 ? 3 : $pricingPlans->count()) }} gap-8 items-start">
                    @foreach($pricingPlans as $plan)
                        <div class="pricing-card {{ $plan->is_popular ? 'featured' : '' }}">
                            @if($plan->badge)
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#f59e0b] text-white text-xs font-bold px-4 py-1 rounded-full">{{ $plan->badge }}</div>
                            @endif
                            <div class="text-lg font-bold mb-2">{{ $plan->name ?? '' }}</div>
                            <div class="text-4xl font-bold {{ $plan->is_popular ? '' : 'text-[#0f172a]' }} mb-1">${{ $plan->price ?? '0' }}</div>
                            <div class="text-sm {{ $plan->is_popular ? 'text-gray-400' : 'text-gray-500' }} mb-6">/{{ $plan->period ?? 'Monthly' }}</div>
                            @if(!empty($plan->features))
                                <ul class="text-left space-y-3 mb-8" role="list">
                                    @foreach($plan->features as $feature)
                                        <li class="flex items-center gap-2 text-sm {{ $plan->is_popular ? 'text-gray-300' : 'text-gray-600' }}">
                                            <svg class="w-4 h-4 text-[#f59e0b] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            {{ is_array($feature) ? ($feature['feature'] ?? '') : $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <a href="#" class="{{ $plan->is_popular ? 'btn-primary' : 'btn-secondary' }} w-full text-center">Choose Plan</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Testimonials --}}
        @if($testimonials->count())
        <section class="py-20 bg-[#0f172a] text-white" aria-labelledby="testimonials-heading">
            <div class="container">
                <div class="text-center mb-16">
                    <div class="section-subtitle">TESTIMONIALS</div>
                    <h2 id="testimonials-heading" class="section-title text-white">What our clients say.</h2>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($testimonials as $testimonial)
                        <article class="testimonial-card">
                            @if($testimonial->rating)
                                <div class="flex gap-1 text-[#f59e0b] mb-4" role="img" aria-label="{{ $testimonial->rating }} out of 5 stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                            @endif
                            <p class="text-gray-400 mb-6 italic">
                                "{{ $testimonial->quote ?? '' }}"
                            </p>
                            <footer class="flex items-center gap-4">
                                @if($testimonial->getFirstMediaUrl('avatar'))
                                    <img src="{{ $testimonial->getFirstMediaUrl('avatar') }}" alt="{{ $testimonial->name ?? '' }}" class="rounded-full" width="50" height="50" loading="lazy">
                                @else
                                    <img src="https://placehold.co/50x50/f59e0b/0f172a?text={{ substr($testimonial->name ?? 'U', 0, 2) }}" alt="{{ $testimonial->name ?? '' }}" class="rounded-full" width="50" height="50" loading="lazy">
                                @endif
                                <div>
                                    <div class="font-semibold">{{ $testimonial->name ?? '' }}</div>
                                    <div class="text-sm text-gray-500">{{ $testimonial->role ?? '' }}</div>
                                </div>
                            </footer>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Blog --}}
        @if($posts->count())
        <section id="blog" class="py-20" aria-labelledby="blog-heading">
            <div class="container">
                <div class="text-center mb-16">
                    <div class="section-subtitle">NEWS & ARTICLE</div>
                    <h2 id="blog-heading" class="section-title">Latest insights & updates.</h2>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="blog-card">
                            @if($post->getFirstMediaUrl('featured-image'))
                                <img src="{{ $post->getFirstMediaUrl('featured-image') }}" alt="{{ $post->title ?? 'Blog post' }}" class="w-full h-48 object-cover" width="600" height="300" loading="lazy">
                            @else
                                <img src="https://placehold.co/600x300/0f172a/f59e0b?text={{ urlencode($post->title ?? 'Blog') }}" alt="{{ $post->title ?? 'Blog post' }}" class="w-full h-48 object-cover" width="600" height="300" loading="lazy">
                            @endif
                            <div class="p-6">
                                @if($post->published_at)
                                    <time class="text-sm text-gray-500 mb-2 block" datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->format('M d, Y') }}</time>
                                @endif
                                <h3 class="font-bold mb-2 hover:text-[#f59e0b] transition-colors cursor-pointer">
                                    {{ $post->title ?? '' }}
                                </h3>
                                <p class="text-sm text-gray-500">{{ $post->excerpt ?? '' }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Contact --}}
        @if($contact)
        <section id="contact" class="py-20 bg-[#f8fafc]" aria-labelledby="contact-heading">
            <div class="container grid lg:grid-cols-2 gap-16">
                <div>
                    <div class="section-subtitle">CONTACT US</div>
                    <h2 id="contact-heading" class="section-title">Get in touch with us.</h2>
                    <div class="text-gray-500 mb-8">
                        {!! $contact->content ?? '' !!}
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="contact-icon bg-[#f59e0b]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-semibold mb-1">Our Office</div>
                                <div class="text-gray-500 text-sm">{{ $settings->address ?? '' }}</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="contact-icon bg-[#0f172a]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <div class="font-semibold mb-1">Call Us</div>
                                <a href="tel:{{ $settings->phone ?? '' }}" class="text-gray-500 text-sm hover:text-[#f59e0b] transition-colors">{{ $settings->phone ?? '' }}</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="contact-icon bg-[#f59e0b]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-semibold mb-1">Email Us</div>
                                <a href="mailto:{{ $settings->email ?? '' }}" class="text-gray-500 text-sm hover:text-[#f59e0b] transition-colors">{{ $settings->email ?? '' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm">
                    <form class="space-y-6" action="#" method="POST">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold mb-2">Your Name <span class="text-red-500" aria-hidden="true">*</span></label>
                                <input type="text" id="name" name="name" class="input-field" placeholder="John Doe" required autocomplete="name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold mb-2">Email Address <span class="text-red-500" aria-hidden="true">*</span></label>
                                <input type="email" id="email" name="email" class="input-field" placeholder="john@example.com" required autocomplete="email">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-semibold mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" class="input-field" placeholder="How can we help?">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold mb-2">Message <span class="text-red-500" aria-hidden="true">*</span></label>
                            <textarea id="message" name="message" rows="4" class="input-field" placeholder="Tell us about your project..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
        @endif
    </main>

    {{-- Footer --}}
    <footer class="bg-[#0f172a] text-white py-16" role="contentinfo">
        <div class="container grid md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div>
                <a href="/" class="text-2xl font-bold mb-4 block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f59e0b]">
                    <span class="text-[#f59e0b]">{{ Str::before($settings->company_name, ' ') }}</span>{{ Str::after($settings->company_name, ' ') }}
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    {{ $settings->footer_description ?? '' }}
                </p>
                <div class="flex gap-4" role="list">
                    @if($settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" class="social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">f</a>
                    @endif
                    @if($settings->linkedin_url)
                        <a href="{{ $settings->linkedin_url }}" class="social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">in</a>
                    @endif
                    @if($settings->twitter_url)
                        <a href="{{ $settings->twitter_url }}" class="social-link" aria-label="Twitter" target="_blank" rel="noopener noreferrer">tw</a>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-6">Quick Links</h4>
                <nav aria-label="Footer quick links">
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#about" class="footer-link">About Us</a></li>
                        <li><a href="#services" class="footer-link">Services</a></li>
                        <li><a href="#projects" class="footer-link">Projects</a></li>
                        <li><a href="#blog" class="footer-link">News</a></li>
                        <li><a href="#contact" class="footer-link">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div>
                <h4 class="font-bold mb-6">Services</h4>
                <nav aria-label="Footer services links">
                    <ul class="space-y-3 text-sm text-gray-400">
                        @foreach($services->take(4) as $service)
                            <li><a href="#services" class="footer-link">{{ $service->title ?? '' }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div>
                <h4 class="font-bold mb-6">Newsletter</h4>
                <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest updates.</p>
                <form class="flex" action="#" method="POST">
                    <label for="newsletter-email" class="sr-only">Email address</label>
                    <input type="email" id="newsletter-email" name="email" placeholder="Your email" class="flex-1 px-4 py-3 bg-[#1e293b] rounded-l-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#f59e0b]" required>
                    <button type="submit" class="bg-[#f59e0b] px-6 py-3 rounded-r-lg font-semibold hover:bg-[#d97706] transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f59e0b]" aria-label="Subscribe">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="container mt-12 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} {{ $settings->company_name ?? config('app.name') }}. All rights reserved.</p>
                <nav aria-label="Legal links">
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    </div>
                </nav>
            </div>
        </div>
    </footer>
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');
        btn.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('open');
            btn.setAttribute('aria-expanded', isOpen);
            iconOpen.classList.toggle('hidden', isOpen);
            iconClose.classList.toggle('hidden', !isOpen);
        });
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
