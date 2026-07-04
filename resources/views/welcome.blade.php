<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: clamp(28px, 4vw, 40px); font-weight: 700; line-height: 1.2; margin-bottom: 16px; }
        .section-subtitle { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: var(--accent); margin-bottom: 12px; }
        .btn-primary { display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 4px; font-weight: 600; text-decoration: none; transition: background 0.3s; }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-outline { display: inline-block; border: 2px solid white; color: white; padding: 14px 32px; border-radius: 4px; font-weight: 600; text-decoration: none; transition: all 0.3s; }
        .btn-outline:hover { background: white; color: var(--primary); }
    </style>
</head>
<body>
    {{-- Header --}}
    <header class="bg-[#0f172a] text-white py-4">
        <div class="container flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">
                <span class="text-[#f59e0b]">Zero</span>xe
            </a>
            <nav class="hidden md:flex gap-8 text-sm font-medium">
                <a href="#" class="hover:text-[#f59e0b] transition-colors">HOME</a>
                <a href="#about" class="hover:text-[#f59e0b] transition-colors">ABOUT</a>
                <a href="#services" class="hover:text-[#f59e0b] transition-colors">SERVICES</a>
                <a href="#projects" class="hover:text-[#f59e0b] transition-colors">PROJECTS</a>
                <a href="#blog" class="hover:text-[#f59e0b] transition-colors">NEWS</a>
                <a href="#contact" class="hover:text-[#f59e0b] transition-colors">CONTACT</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}" class="hover:text-[#f59e0b] transition-colors">ADMIN</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-[#f59e0b] transition-colors">LOGIN</a>
                    @endauth
                @endif
            </nav>
            <div class="hidden lg:block text-sm">
                <span class="text-gray-400">Call anytime</span>
                <span class="font-semibold ml-2">(+123) 1234 5678</span>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="bg-[#0f172a] text-white py-20 lg:py-32">
        <div class="container grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="text-[#f59e0b] text-xs font-bold tracking-[0.2em] mb-4">OPTIMIZE YOUR BUSINESS GROWTH</div>
                <h1 class="text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-6">
                    Professional service provided by experts with specialized knowledge
                </h1>
                <p class="text-gray-400 text-lg mb-8 max-w-lg">
                    Cursus vitae congue mauris rhoncus aenean vel elit scelerisque. Mauris pellentesque pulvinar pellentesque habitant morbi tristique senectus et netus.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#contact" class="btn-primary">Get Consulting - It's Free</a>
                    <a href="#" class="btn-outline">Open Account</a>
                </div>
            </div>
            <div class="relative">
                <img src="https://placehold.co/600x400/1e293b/f59e0b?text=Consulting+Expert" alt="Consulting" class="rounded-lg shadow-2xl">
                <div class="absolute -bottom-6 -left-6 bg-[#f59e0b] text-white p-6 rounded-lg">
                    <div class="text-3xl font-bold">15+</div>
                    <div class="text-sm">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Trusted By --}}
    <section class="py-12 bg-white border-b">
        <div class="container">
            <div class="text-center mb-8">
                <span class="text-sm font-semibold text-gray-500 tracking-wider">TRUSTED BY 1,200+ POPULAR COMPANY</span>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-8 lg:gap-16 opacity-60">
                <img src="https://placehold.co/120x40/fff/333?text=Logo+1" alt="Client" class="h-8">
                <img src="https://placehold.co/120x40/fff/333?text=Logo+2" alt="Client" class="h-8">
                <img src="https://placehold.co/120x40/fff/333?text=Logo+3" alt="Client" class="h-8">
                <img src="https://placehold.co/120x40/fff/333?text=Logo+4" alt="Client" class="h-8">
                <img src="https://placehold.co/120x40/fff/333?text=Logo+5" alt="Client" class="h-8">
            </div>
        </div>
    </section>

    {{-- Experience Counter --}}
    <section class="py-16 bg-[#f8fafc]">
        <div class="container grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl lg:text-5xl font-bold text-[#0f172a] mb-2">15+</div>
                <div class="text-sm text-gray-500 uppercase tracking-wider">Years Experience</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-bold text-[#0f172a] mb-2">200+</div>
                <div class="text-sm text-gray-500 uppercase tracking-wider">Project Completed</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-bold text-[#0f172a] mb-2">50+</div>
                <div class="text-sm text-gray-500 uppercase tracking-wider">Team Members</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-bold text-[#0f172a] mb-2">98%</div>
                <div class="text-sm text-gray-500 uppercase tracking-wider">Client Satisfaction</div>
            </div>
        </div>
    </section>

    {{-- About Us --}}
    <section id="about" class="py-20">
        <div class="container grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <img src="https://placehold.co/600x500/0f172a/f59e0b?text=About+Us" alt="About" class="rounded-lg shadow-xl">
            </div>
            <div>
                <div class="section-subtitle">ABOUT US</div>
                <h2 class="section-title">The primary goal of business consulting is to help organizations.</h2>
                <p class="text-gray-500 mb-6 leading-relaxed">
                    Viverra ipsum nunc aliquet bibendum enim facilisis gravida neque. Turpis egestas pretium aenean pharetra magna ac. Sem nulla pharetra diam sit amet nisl suscipit adipiscing bibendum.
                </p>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Donec enim diam vulputate ut pharetra sit amet aliquam id. In ornare quam viverra orci sagittis eu. Non nisi est sit amet facilisis. Suscipit tellus mauris a diam maecenas.
                </p>
                <div class="bg-[#f8fafc] p-6 rounded-lg border-l-4 border-[#f59e0b]">
                    <p class="italic text-gray-600 mb-4">"Odio eu feugiat pretium nibh ipsum. Pellentesque habitant morbi tristique senectus et netus et."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://placehold.co/50x50/0f172a/fff?text=HM" alt="Founder" class="rounded-full">
                        <div>
                            <div class="font-semibold">Hendrik Morella</div>
                            <div class="text-sm text-gray-500">CEO, DIRECTOR</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Key Benefits --}}
    <section class="py-20 bg-[#0f172a] text-white">
        <div class="container grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="section-subtitle">KEY BENEFITS</div>
                <h2 class="section-title text-white">Why should choose us?</h2>
                <p class="text-gray-400 mb-8">
                    At ultrices mi tempus imperdiet nulla elit eget. Congue nisi vitae suscipit tellus mauris a diam maecenas sed. Nunc id cursus metus aliquam eleifend mi.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="text-[#f59e0b] mt-1">✓</span>
                        <span>Maecenas pharetra convallis posuere morbi leo urna</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-[#f59e0b] mt-1">✓</span>
                        <span>Nisi lacus sed viverra tellus in hac habitasse platea</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-[#f59e0b] mt-1">✓</span>
                        <span>Pretium lectus quam id leo in vitae turpis integer</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-[#f59e0b] mt-1">✓</span>
                        <span>Lacus vel facilisis volutpat est curabitur gravida arcu</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-[#f59e0b] mt-1">✓</span>
                        <span>Odio morbi quis commodo odio aenean sed adipiscing</span>
                    </li>
                </ul>
            </div>
            <div>
                <img src="https://placehold.co/600x500/1e293b/f59e0b?text=Benefits" alt="Benefits" class="rounded-lg shadow-xl">
            </div>
        </div>
    </section>

    {{-- Who We Are --}}
    <section class="py-20">
        <div class="container">
            <div class="text-center mb-16">
                <div class="section-subtitle">WHO WE ARE</div>
                <h2 class="section-title">Consultants typically have expertise in a particular industry.</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-[#f8fafc] p-8 rounded-lg">
                    <div class="w-14 h-14 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-2xl font-bold mb-6">V</div>
                    <h3 class="text-xl font-bold mb-4">VISION</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus nisl vitae magna pulvinar laoreet. Nullam ac tortor vitae purus faucibus ornare suspendisse sed nisi.
                    </p>
                </div>
                <div class="bg-[#f8fafc] p-8 rounded-lg">
                    <div class="w-14 h-14 bg-[#0f172a] rounded-lg flex items-center justify-center text-white text-2xl font-bold mb-6">M</div>
                    <h3 class="text-xl font-bold mb-4">MISSION</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Felis bibendum ut tristique et egestas quis ipsum suspendisse nec ullamcorper.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section id="services" class="py-20 bg-[#f8fafc]">
        <div class="container">
            <div class="text-center mb-16">
                <div class="section-subtitle">WHAT WE DO</div>
                <h2 class="section-title">Our Expertise & Services.</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Cursus vitae congue mauris rhoncus aenean vel elit scelerisque. Mauris pellentesque pulvinar pellentesque habitant morbi.
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-xl mb-6">📊</div>
                    <h3 class="text-lg font-bold mb-3">Business Strategy</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Develop comprehensive strategies to achieve your business goals and maximize growth potential.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#0f172a] rounded-lg flex items-center justify-center text-white text-xl mb-6">📈</div>
                    <h3 class="text-lg font-bold mb-3">Financial Consulting</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Expert financial advice to optimize your operations and improve profitability.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-xl mb-6">🎯</div>
                    <h3 class="text-lg font-bold mb-3">Market Research</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        In-depth market analysis to identify opportunities and stay ahead of competition.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#0f172a] rounded-lg flex items-center justify-center text-white text-xl mb-6">💼</div>
                    <h3 class="text-lg font-bold mb-3">Management Consulting</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Streamline your operations and improve efficiency with our management expertise.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white text-xl mb-6">🚀</div>
                    <h3 class="text-lg font-bold mb-3">Digital Transformation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Modernize your business with cutting-edge digital solutions and technologies.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-[#0f172a] rounded-lg flex items-center justify-center text-white text-xl mb-6">🤝</div>
                    <h3 class="text-lg font-bold mb-3">Partnership</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Build strategic partnerships to expand your reach and accelerate growth.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Projects --}}
    <section id="projects" class="py-20">
        <div class="container">
            <div class="text-center mb-16">
                <div class="section-subtitle">PROJECT</div>
                <h2 class="section-title">Thinking forward for your results.</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="relative group overflow-hidden rounded-lg">
                    <img src="https://placehold.co/600x400/0f172a/f59e0b?text=Project+1" alt="Project" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <div class="text-[#f59e0b] text-sm font-semibold mb-1">Business</div>
                            <div class="text-white font-bold">Strategic Planning</div>
                        </div>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-lg">
                    <img src="https://placehold.co/600x400/1e293b/f59e0b?text=Project+2" alt="Project" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <div class="text-[#f59e0b] text-sm font-semibold mb-1">Finance</div>
                            <div class="text-white font-bold">Market Analysis</div>
                        </div>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-lg">
                    <img src="https://placehold.co/600x400/334155/f59e0b?text=Project+3" alt="Project" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                        <div>
                            <div class="text-[#f59e0b] text-sm font-semibold mb-1">Digital</div>
                            <div class="text-white font-bold">Digital Transformation</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Pricing --}}
    <section class="py-20 bg-[#f8fafc]">
        <div class="container">
            <div class="text-center mb-16">
                <div class="section-subtitle">PLAN & PRICING</div>
                <h2 class="section-title">Effective & Flexible Pricing.</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Nisl pretium fusce id velit ut tortor pretium viverra. Eleifend quam adipiscing vitae proin sagittis nisl rhoncus.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <div class="text-lg font-bold mb-2">Basic</div>
                    <div class="text-4xl font-bold text-[#0f172a] mb-1">$49</div>
                    <div class="text-sm text-gray-500 mb-6">/Monthly</div>
                    <ul class="text-left space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> 5 Analytics Campaign
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> 3 User Team Member
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> 24/7 Support
                        </li>
                    </ul>
                    <a href="#" class="btn-primary w-full text-center">Choose Plan</a>
                </div>
                <div class="bg-[#0f172a] text-white p-8 rounded-lg shadow-lg text-center relative">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#f59e0b] text-white text-xs font-bold px-4 py-1 rounded-full">POPULAR</div>
                    <div class="text-lg font-bold mb-2">Premium</div>
                    <div class="text-4xl font-bold mb-1">$99</div>
                    <div class="text-sm text-gray-400 mb-6">/Monthly</div>
                    <ul class="text-left space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="text-[#f59e0b]">✓</span> 15 Analytics Campaign
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="text-[#f59e0b]">✓</span> 10 User Team Member
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="text-[#f59e0b]">✓</span> Priority Support
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="text-[#f59e0b]">✓</span> Custom Reports
                        </li>
                    </ul>
                    <a href="#" class="btn-primary w-full text-center">Choose Plan</a>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <div class="text-lg font-bold mb-2">Enterprise</div>
                    <div class="text-4xl font-bold text-[#0f172a] mb-1">$199</div>
                    <div class="text-sm text-gray-500 mb-6">/Monthly</div>
                    <ul class="text-left space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> Unlimited Campaigns
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> Unlimited Team Members
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> 24/7 Priority Support
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-[#f59e0b]">✓</span> Dedicated Manager
                        </li>
                    </ul>
                    <a href="#" class="btn-primary w-full text-center">Choose Plan</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-20 bg-[#0f172a] text-white">
        <div class="container">
            <div class="text-center mb-16">
                <div class="section-subtitle">TESTIMONIALS</div>
                <h2 class="section-title text-white">What our clients say.</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-[#1e293b] p-8 rounded-lg">
                    <div class="flex gap-1 text-[#f59e0b] mb-4">★★★★★</div>
                    <p class="text-gray-400 mb-6 italic">
                        "Excellent consulting service. They helped us increase our revenue by 40% in just 6 months. Highly recommended!"
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://placehold.co/50x50/f59e0b/0f172a?text=JD" alt="Client" class="rounded-full">
                        <div>
                            <div class="font-semibold">John Doe</div>
                            <div class="text-sm text-gray-500">CEO, Tech Corp</div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#1e293b] p-8 rounded-lg">
                    <div class="flex gap-1 text-[#f59e0b] mb-4">★★★★★</div>
                    <p class="text-gray-400 mb-6 italic">
                        "Professional team with deep industry knowledge. They transformed our business operations completely."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://placehold.co/50x50/f59e0b/0f172a?text=SM" alt="Client" class="rounded-full">
                        <div>
                            <div class="font-semibold">Sarah Miller</div>
                            <div class="text-sm text-gray-500">Director, Finance Inc</div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#1e293b] p-8 rounded-lg">
                    <div class="flex gap-1 text-[#f59e0b] mb-4">★★★★★</div>
                    <p class="text-gray-400 mb-6 italic">
                        "Their strategic insights were invaluable. We've seen consistent growth since partnering with them."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://placehold.co/50x50/f59e0b/0f172a?text=RW" alt="Client" class="rounded-full">
                        <div>
                            <div class="font-semibold">Robert Wilson</div>
                            <div class="text-sm text-gray-500">Founder, StartupXYZ</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Blog --}}
    <section id="blog" class="py-20">
        <div class="container">
            <div class="text-center mb-16">
                <div class="section-subtitle">NEWS & ARTICLE</div>
                <h2 class="section-title">Latest insights & updates.</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                    <img src="https://placehold.co/600x300/0f172a/f59e0b?text=Blog+1" alt="Blog" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">Jan 15, 2025</div>
                        <h3 class="font-bold mb-2 hover:text-[#f59e0b] transition-colors cursor-pointer">
                            How to Grow Your Business in 2025
                        </h3>
                        <p class="text-sm text-gray-500">Discover the key strategies to scale your business this year...</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                    <img src="https://placehold.co/600x300/1e293b/f59e0b?text=Blog+2" alt="Blog" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">Jan 10, 2025</div>
                        <h3 class="font-bold mb-2 hover:text-[#f59e0b] transition-colors cursor-pointer">
                            Digital Transformation Trends
                        </h3>
                        <p class="text-sm text-gray-500">Stay ahead with the latest digital transformation trends...</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                    <img src="https://placehold.co/600x300/334155/f59e0b?text=Blog+3" alt="Blog" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">Jan 5, 2025</div>
                        <h3 class="font-bold mb-2 hover:text-[#f59e0b] transition-colors cursor-pointer">
                            Financial Planning for Startups
                        </h3>
                        <p class="text-sm text-gray-500">Essential financial planning tips for new businesses...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="py-20 bg-[#f8fafc]">
        <div class="container grid lg:grid-cols-2 gap-16">
            <div>
                <div class="section-subtitle">CONTACT US</div>
                <h2 class="section-title">Get in touch with us.</h2>
                <p class="text-gray-500 mb-8">
                    Have a project in mind? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white">📍</div>
                        <div>
                            <div class="font-semibold mb-1">Our Office</div>
                            <div class="text-gray-500 text-sm">Jl. Sudirman No. 123, Jakarta, Indonesia</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0f172a] rounded-lg flex items-center justify-center text-white">📞</div>
                        <div>
                            <div class="font-semibold mb-1">Call Us</div>
                            <div class="text-gray-500 text-sm">(+123) 1234 5678</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white">✉️</div>
                        <div>
                            <div class="font-semibold mb-1">Email Us</div>
                            <div class="text-gray-500 text-sm">hello@zeroxe.com</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-sm">
                <form class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Your Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-[#f59e0b]" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Email Address</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-[#f59e0b]" placeholder="john@example.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Subject</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-[#f59e0b]" placeholder="How can we help?">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Message</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-[#f59e0b]" placeholder="Tell us about your project..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#0f172a] text-white py-16">
        <div class="container grid md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div>
                <a href="/" class="text-2xl font-bold mb-4 block">
                    <span class="text-[#f59e0b]">Zero</span>xe
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Professional consulting services to help your business grow and succeed in today's competitive market.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-[#1e293b] rounded-lg flex items-center justify-center hover:bg-[#f59e0b] transition-colors">f</a>
                    <a href="#" class="w-10 h-10 bg-[#1e293b] rounded-lg flex items-center justify-center hover:bg-[#f59e0b] transition-colors">in</a>
                    <a href="#" class="w-10 h-10 bg-[#1e293b] rounded-lg flex items-center justify-center hover:bg-[#f59e0b] transition-colors">tw</a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-6">Quick Links</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-[#f59e0b] transition-colors">About Us</a></li>
                    <li><a href="#services" class="hover:text-[#f59e0b] transition-colors">Services</a></li>
                    <li><a href="#projects" class="hover:text-[#f59e0b] transition-colors">Projects</a></li>
                    <li><a href="#blog" class="hover:text-[#f59e0b] transition-colors">News</a></li>
                    <li><a href="#contact" class="hover:text-[#f59e0b] transition-colors">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Services</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-[#f59e0b] transition-colors">Business Strategy</a></li>
                    <li><a href="#" class="hover:text-[#f59e0b] transition-colors">Financial Consulting</a></li>
                    <li><a href="#" class="hover:text-[#f59e0b] transition-colors">Market Research</a></li>
                    <li><a href="#" class="hover:text-[#f59e0b] transition-colors">Digital Transformation</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Newsletter</h4>
                <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest updates.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="flex-1 px-4 py-3 bg-[#1e293b] rounded-l-lg text-sm focus:outline-none">
                    <button type="submit" class="bg-[#f59e0b] px-6 py-3 rounded-r-lg font-semibold hover:bg-[#d97706] transition-colors">→</button>
                </form>
            </div>
        </div>
        <div class="container mt-12 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Zeroxe. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
