<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Company Profile') }}</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        .font-serif { font-family: Georgia, 'Times New Roman', serif; }
    </style>
</head>
<body class="bg-[#fafaf8] text-[#1a1a1a] antialiased font-sans">
    {{-- Header --}}
    <header class="border-b border-[#e5e5e3] py-8">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="font-serif text-3xl tracking-tight text-[#1a1a1a] no-underline">Studio</a>
            <nav class="flex gap-8 items-center text-sm">
                <a href="#about" class="text-[#6b6b6b] no-underline hover:text-[#1a1a1a] transition-colors">About</a>
                <a href="#services" class="text-[#6b6b6b] no-underline hover:text-[#1a1a1a] transition-colors">Services</a>
                <a href="#clients" class="text-[#6b6b6b] no-underline hover:text-[#1a1a1a] transition-colors">Clients</a>
                <a href="#contact" class="text-[#6b6b6b] no-underline hover:text-[#1a1a1a] transition-colors">Contact</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}" class="text-[#6b6b6b] no-underline hover:text-[#1a1a1a] transition-colors">Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#6b6b6b] no-underline hover:text-[#1a1a1a] transition-colors">Login</a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="pt-32 pb-20">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
                <div class="text-xs uppercase tracking-widest text-[#2d5a27] mb-6">Digital Studio</div>
                <h1 class="font-serif text-5xl lg:text-6xl leading-tight tracking-tight mb-6">We build digital products that matter</h1>
                <p class="text-lg text-[#6b6b6b] max-w-md leading-relaxed">A small team of designers and developers crafting thoughtful software for companies who care about quality.</p>
            </div>
            <div class="bg-[#1a1a1a] aspect-[4/3] rounded-sm relative overflow-hidden">
                <div class="absolute inset-5 border border-white/10"></div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="py-24 border-t border-[#e5e5e3]">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-16">
            <div>
                <div class="text-xs uppercase tracking-widest text-[#6b6b6b]">About</div>
                <h2 class="font-serif text-3xl leading-snug mt-4">Small team, big impact</h2>
            </div>
            <div class="lg:col-span-2 flex flex-col gap-6">
                <p class="text-xl text-[#1a1a1a] leading-relaxed">We're a studio of 8 people who believe great software starts with understanding the problem, not jumping to solutions.</p>
                <p class="text-base text-[#6b6b6b] leading-relaxed">Founded in 2020, we've worked with startups and enterprises alike — always with the same approach: listen first, design with intention, build with care.</p>
                <p class="text-base text-[#6b6b6b] leading-relaxed">We don't chase trends. We build things that last.</p>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="py-16 bg-[#1a1a1a] text-white">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-10">
            <div class="text-center">
                <div class="font-serif text-5xl leading-none mb-2">47</div>
                <div class="text-xs text-white/50 uppercase tracking-wider">Projects Delivered</div>
            </div>
            <div class="text-center">
                <div class="font-serif text-5xl leading-none mb-2">12</div>
                <div class="text-xs text-white/50 uppercase tracking-wider">Countries Served</div>
            </div>
            <div class="text-center">
                <div class="font-serif text-5xl leading-none mb-2">98%</div>
                <div class="text-xs text-white/50 uppercase tracking-wider">Client Retention</div>
            </div>
            <div class="text-center">
                <div class="font-serif text-5xl leading-none mb-2">5yr</div>
                <div class="text-xs text-white/50 uppercase tracking-wider">Average Partnership</div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section id="services" class="py-24 border-t border-[#e5e5e3]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-16">
                <div>
                    <div class="text-xs uppercase tracking-widest text-[#6b6b6b]">Services</div>
                    <h2 class="font-serif text-3xl leading-snug mt-4">What we do</h2>
                </div>
                <p class="text-base text-[#6b6b6b] leading-relaxed self-end">We focus on a few things and do them well. No bloated scope, no unnecessary complexity.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-px bg-[#e5e5e3] border border-[#e5e5e3]">
                <div class="bg-[#fafaf8] p-12">
                    <div class="font-serif text-5xl text-[#e5e5e3] mb-6 leading-none">01</div>
                    <h3 class="text-lg font-medium mb-3">Product Design</h3>
                    <p class="text-sm text-[#6b6b6b] leading-relaxed">Research, wireframing, and high-fidelity design that puts users first. We think in systems, not screens.</p>
                </div>
                <div class="bg-[#fafaf8] p-12">
                    <div class="font-serif text-5xl text-[#e5e5e3] mb-6 leading-none">02</div>
                    <h3 class="text-lg font-medium mb-3">Web Development</h3>
                    <p class="text-sm text-[#6b6b6b] leading-relaxed">Fast, accessible, and maintainable web applications. Built with modern tools, designed to scale.</p>
                </div>
                <div class="bg-[#fafaf8] p-12">
                    <div class="font-serif text-5xl text-[#e5e5e3] mb-6 leading-none">03</div>
                    <h3 class="text-lg font-medium mb-3">Mobile Apps</h3>
                    <p class="text-sm text-[#6b6b6b] leading-relaxed">Native and cross-platform mobile experiences. Clean interfaces, smooth interactions, real performance.</p>
                </div>
                <div class="bg-[#fafaf8] p-12">
                    <div class="font-serif text-5xl text-[#e5e5e3] mb-6 leading-none">04</div>
                    <h3 class="text-lg font-medium mb-3">Brand Identity</h3>
                    <p class="text-sm text-[#6b6b6b] leading-relaxed">Visual identity systems that communicate clearly. Logos, typography, color — the whole language.</p>
                </div>
                <div class="bg-[#fafaf8] p-12">
                    <div class="font-serif text-5xl text-[#e5e5e3] mb-6 leading-none">05</div>
                    <h3 class="text-lg font-medium mb-3">Strategy</h3>
                    <p class="text-sm text-[#6b6b6b] leading-relaxed">Digital strategy and consulting. We help you figure out what to build before you build it.</p>
                </div>
                <div class="bg-[#fafaf8] p-12">
                    <div class="font-serif text-5xl text-[#e5e5e3] mb-6 leading-none">06</div>
                    <h3 class="text-lg font-medium mb-3">Maintenance</h3>
                    <p class="text-sm text-[#6b6b6b] leading-relaxed">Ongoing support and iteration. Software isn't done at launch — we stick around.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Clients --}}
    <section id="clients" class="py-20 border-t border-[#e5e5e3]">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
            <div>
                <div class="text-xs uppercase tracking-widest text-[#6b6b6b]">Clients</div>
                <h2 class="font-serif text-3xl leading-snug mt-4">Trusted by</h2>
            </div>
            <div class="lg:col-span-2 grid grid-cols-3 gap-8 items-center">
                <div class="h-8 bg-[#e5e5e3] rounded-sm opacity-60"></div>
                <div class="h-8 bg-[#e5e5e3] rounded-sm opacity-60"></div>
                <div class="h-8 bg-[#e5e5e3] rounded-sm opacity-60"></div>
                <div class="h-8 bg-[#e5e5e3] rounded-sm opacity-60"></div>
                <div class="h-8 bg-[#e5e5e3] rounded-sm opacity-60"></div>
                <div class="h-8 bg-[#e5e5e3] rounded-sm opacity-60"></div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="py-24 border-t border-[#e5e5e3] bg-[#f0f5ee]">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div>
                <div class="text-xs uppercase tracking-widest text-[#6b6b6b]">Contact</div>
                <h2 class="font-serif text-3xl leading-snug mt-4 mb-4">Let's work together</h2>
                <p class="text-base text-[#6b6b6b] leading-relaxed">Have a project in mind? We'd love to hear about it.</p>
            </div>
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label class="text-xs uppercase tracking-widest text-[#6b6b6b]">Email</label>
                    <a href="mailto:hello@studio.com" class="text-base text-[#1a1a1a] no-underline border-b border-[#e5e5e3] transition-colors hover:border-[#1a1a1a] w-fit pb-0.5">hello@studio.com</a>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs uppercase tracking-widest text-[#6b6b6b]">Phone</label>
                    <span class="text-base">+62 21 1234 5678</span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs uppercase tracking-widest text-[#6b6b6b]">Address</label>
                    <span class="text-base leading-relaxed">Jl. Sudirman No. 123<br>Jakarta, Indonesia</span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs uppercase tracking-widest text-[#6b6b6b]">Social</label>
                    <div class="flex gap-4 mt-1">
                        <a href="#" class="text-base text-[#1a1a1a] no-underline border-b border-[#e5e5e3] transition-colors hover:border-[#1a1a1a] pb-0.5">Instagram</a>
                        <a href="#" class="text-base text-[#1a1a1a] no-underline border-b border-[#e5e5e3] transition-colors hover:border-[#1a1a1a] pb-0.5">LinkedIn</a>
                        <a href="#" class="text-base text-[#1a1a1a] no-underline border-b border-[#e5e5e3] transition-colors hover:border-[#1a1a1a] pb-0.5">Dribbble</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-10 border-t border-[#e5e5e3]">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center max-md:flex-col max-md:gap-4 max-md:text-center">
            <p class="text-sm text-[#6b6b6b]">&copy; {{ date('Y') }} Studio. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="text-sm text-[#6b6b6b] no-underline hover:text-[#1a1a1a]">Privacy</a>
                <a href="#" class="text-sm text-[#6b6b6b] no-underline hover:text-[#1a1a1a]">Terms</a>
            </div>
        </div>
    </footer>
</body>
</html>
