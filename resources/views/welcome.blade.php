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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body: 'Inter', system-ui, sans-serif;
            --black: #09090b;
            --white: #fafafa;
            --gray: #71717a;
            --border: #e4e4e7;
            --accent: #2d5a27;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--white);
            color: var(--black);
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 clamp(20px, 4vw, 48px);
        }

        /* Header */
        header {
            padding: 28px 0;
            border-bottom: 1px solid var(--border);
        }
        header .container {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }
        .logo {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 500;
            color: var(--black);
            text-decoration: none;
            letter-spacing: -0.01em;
        }
        nav { display: flex; gap: 28px; }
        nav a {
            font-size: 13px;
            font-weight: 400;
            color: var(--gray);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: color 0.2s;
        }
        nav a:hover { color: var(--black); }

        /* Hero - Asymmetric */
        .hero {
            padding: clamp(60px, 10vw, 140px) 0 clamp(60px, 8vw, 100px);
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(40px, 6vw, 80px);
            align-items: end;
        }
        .hero-left {}
        .hero-tag {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--accent);
            margin-bottom: 24px;
        }
        .hero h1 {
            font-family: var(--font-heading);
            font-size: clamp(42px, 5.5vw, 72px);
            font-weight: 400;
            line-height: 1.08;
            letter-spacing: -0.025em;
            max-width: 600px;
        }
        .hero h1 em {
            font-style: italic;
            color: var(--accent);
        }
        .hero-right {
            padding-bottom: 12px;
        }
        .hero-desc {
            font-size: 16px;
            line-height: 1.7;
            color: var(--gray);
            max-width: 400px;
        }
        .hero-desc strong {
            color: var(--black);
            font-weight: 500;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
        }

        /* About - Two Column */
        .about {
            padding: clamp(60px, 8vw, 100px) 0;
        }
        .about-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: clamp(40px, 6vw, 80px);
        }
        .section-number {
            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 400;
            color: var(--gray);
            margin-bottom: 8px;
        }
        .section-title {
            font-family: var(--font-heading);
            font-size: clamp(28px, 3vw, 36px);
            font-weight: 400;
            line-height: 1.15;
            letter-spacing: -0.02em;
        }
        .about-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .about-content p {
            font-size: 15px;
            line-height: 1.75;
            color: var(--gray);
        }
        .about-content p:first-child {
            font-size: 17px;
            color: var(--black);
            line-height: 1.65;
        }

        /* Stats - Inline */
        .stats {
            padding: clamp(40px, 5vw, 60px) 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-family: var(--font-heading);
            font-size: clamp(36px, 4vw, 52px);
            font-weight: 400;
            line-height: 1;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray);
        }

        /* Services - Asymmetric Grid */
        .services {
            padding: clamp(60px, 8vw, 100px) 0;
        }
        .services-header {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: clamp(40px, 6vw, 80px);
            margin-bottom: clamp(48px, 6vw, 80px);
        }
        .services-desc {
            font-size: 15px;
            line-height: 1.75;
            color: var(--gray);
            max-width: 480px;
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
        }
        .service-card {
            background: var(--white);
            padding: clamp(32px, 4vw, 48px);
            position: relative;
        }
        .service-num {
            font-family: var(--font-heading);
            font-size: 11px;
            font-weight: 400;
            color: var(--gray);
            margin-bottom: 20px;
        }
        .service-card h3 {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }
        .service-card p {
            font-size: 13px;
            line-height: 1.7;
            color: var(--gray);
        }

        /* Clients */
        .clients {
            padding: clamp(60px, 8vw, 100px) 0;
            border-top: 1px solid var(--border);
        }
        .clients-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: clamp(40px, 6vw, 80px);
            align-items: start;
        }
        .client-logos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            align-items: center;
        }
        .client-logo {
            height: 28px;
            background: var(--border);
            border-radius: 2px;
        }

        /* Contact */
        .contact {
            padding: clamp(60px, 8vw, 100px) 0;
            border-top: 1px solid var(--border);
            background: #f4f4f5;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(40px, 6vw, 80px);
        }
        .contact-left {}
        .contact-right {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }
        .contact-item {}
        .contact-label {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray);
            margin-bottom: 6px;
        }
        .contact-value {
            font-size: 15px;
            line-height: 1.6;
        }
        .contact-value a {
            color: var(--black);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            transition: border-color 0.2s;
        }
        .contact-value a:hover {
            border-color: var(--black);
        }
        .contact-social {
            display: flex;
            gap: 20px;
            margin-top: 6px;
        }
        .contact-social a {
            font-size: 14px;
            color: var(--gray);
            text-decoration: none;
            transition: color 0.2s;
        }
        .contact-social a:hover { color: var(--black); }

        /* Footer */
        footer {
            padding: 32px 0;
            border-top: 1px solid var(--border);
        }
        footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        footer p {
            font-size: 12px;
            color: var(--gray);
        }
        footer-links {
            display: flex;
            gap: 20px;
        }
        footer-links a {
            font-size: 12px;
            color: var(--gray);
            text-decoration: none;
        }
        footer-links a:hover { color: var(--black); }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-grid,
            .about-grid,
            .services-header,
            .clients-grid,
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
            .client-logos {
                grid-template-columns: repeat(2, 1fr);
            }
            nav { gap: 20px; }
            footer .container {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a href="/" class="logo">Studio.</a>
            <nav>
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#clients">Clients</a>
                <a href="#contact">Contact</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}">Admin</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-left">
                    <div class="hero-tag">Digital Studio — Est. 2020</div>
                    <h1>We craft digital experiences that <em>endure</em></h1>
                </div>
                <div class="hero-right">
                    <p class="hero-desc">A design-led studio building software for companies who believe quality is a competitive advantage. <strong>Eight people. Zero bloat.</strong></p>
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <section class="about" id="about">
        <div class="container">
            <div class="about-grid">
                <div>
                    <div class="section-number">01</div>
                    <h2 class="section-title">About the studio</h2>
                </div>
                <div class="about-content">
                    <p>We start with the problem, not the solution. Every project begins with understanding — who uses this, why does it matter, what does success look like.</p>
                    <p>Founded in Jakarta in 2020, we've grown from two founders to a team of eight. We work with startups finding product-market fit and enterprises modernizing their digital presence. Same rigor, different scale.</p>
                    <p>We don't do assembly-line work. Every project gets our full attention, and we stay involved after launch. Software is a living thing — it needs care.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">47</div>
                    <div class="stat-label">Projects</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Countries</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">98%</div>
                    <div class="stat-label">Retention</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">5yr</div>
                    <div class="stat-label">Avg. Partnership</div>
                </div>
            </div>
        </div>
    </section>

    <section class="services" id="services">
        <div class="container">
            <div class="services-header">
                <div>
                    <div class="section-number">02</div>
                    <h2 class="section-title">What we do</h2>
                </div>
                <p class="services-desc">Six capabilities, no distractions. We'd rather be excellent at a few things than mediocre at everything.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-num">— 01</div>
                    <h3>Product Design</h3>
                    <p>Research, wireframes, and high-fidelity interfaces. We design systems, not just screens.</p>
                </div>
                <div class="service-card">
                    <div class="service-num">— 02</div>
                    <h3>Web Development</h3>
                    <p>Fast, accessible applications. Modern stack, clean code, built to scale.</p>
                </div>
                <div class="service-card">
                    <div class="service-num">— 03</div>
                    <h3>Mobile Apps</h3>
                    <p>Native and cross-platform. Smooth interactions, real performance, no compromises.</p>
                </div>
                <div class="service-card">
                    <div class="service-num">— 04</div>
                    <h3>Brand Identity</h3>
                    <p>Visual systems that communicate clearly. Logo, typography, color — the full language.</p>
                </div>
                <div class="service-card">
                    <div class="service-num">— 05</div>
                    <h3>Strategy</h3>
                    <p>Digital consulting. We help you figure out what to build before you build it.</p>
                </div>
                <div class="service-card">
                    <div class="service-num">— 06</div>
                    <h3>Maintenance</h3>
                    <p>Ongoing support and iteration. We don't disappear after launch.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="clients" id="clients">
        <div class="container">
            <div class="clients-grid">
                <div>
                    <div class="section-number">03</div>
                    <h2 class="section-title">Selected clients</h2>
                </div>
                <div class="client-logos">
                    <div class="client-logo"></div>
                    <div class="client-logo"></div>
                    <div class="client-logo"></div>
                    <div class="client-logo"></div>
                    <div class="client-logo"></div>
                    <div class="client-logo"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-left">
                    <div class="section-number">04</div>
                    <h2 class="section-title">Get in touch</h2>
                    <p style="margin-top: 16px; font-size: 15px; color: var(--gray); line-height: 1.75;">Have a project in mind? We'd like to hear about it.</p>
                </div>
                <div class="contact-right">
                    <div class="contact-item">
                        <div class="contact-label">Email</div>
                        <div class="contact-value"><a href="mailto:hello@studio.id">hello@studio.id</a></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">Phone</div>
                        <div class="contact-value">+62 21 5785 4000</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">Location</div>
                        <div class="contact-value">Jl. Sudirman Kav. 52-53<br>Jakarta 12190, Indonesia</div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-label">Socials</div>
                        <div class="contact-social">
                            <a href="#">Instagram</a>
                            <a href="#">LinkedIn</a>
                            <a href="#">Dribbble</a>
                            <a href="#">GitHub</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Studio. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
            </div>
        </div>
    </footer>
</body>
</html>
