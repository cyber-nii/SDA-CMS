<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Seventh-day Adventist Church Management System — streamline member records, finance, and ministry operations.">
    <title>SDA Church Management System</title>

    <!-- Fonts: Inter for body, Playfair Display for headings -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Minimal keyframes for hero animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fadeUp 0.6s ease both;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="font-sans antialiased bg-neutral-50 text-slate-900 relative">

    <!-- Decorative background -->
    <div class="fixed inset-0 z-0 pointer-events-none" aria-hidden="true">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_50%_at_50%_-10%,rgba(46,95,59,0.08)_0%,transparent_70%),radial-gradient(ellipse_60%_40%_at_100%_100%,rgba(227,168,43,0.06)_0%,transparent_60%)]"></div>
        <div class="absolute inset-0 opacity-[0.025]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E&quot;);"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col">

        <!-- ── Navigation ─────────────────────────────────── -->
        <nav class="py-6">
            <div class="w-full max-w-6xl mx-auto px-6">
                <div class="flex items-center justify-between">

                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2.5 hover:opacity-90 transition-opacity">
                        <img src="/images/logo.png" class="w-9 h-9 object-contain shrink-0" alt="SDA Church CMS logo">
                        <div class="font-sans font-bold text-base text-slate-900 tracking-tight leading-tight">
                            SDA Church CMS
                            <span class="block font-normal text-[0.7rem] text-slate-500 tracking-wide uppercase">Management Portal</span>
                        </div>
                    </a>

                    <!-- Nav actions -->
                    <div class="flex items-center gap-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-slate-900 hover:bg-slate-100 transition-colors">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                    </svg>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-slate-900 hover:bg-slate-100 transition-colors">Sign In</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white rounded-xl bg-gradient-to-br from-primary to-primary-500 shadow-md shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all">
                                        Get Started
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>

                </div>
            </div>
        </nav>

        <!-- ── Hero ───────────────────────────────────────── -->
        <main class="flex-1 flex flex-col justify-center items-center text-center py-20 lg:py-28">
            <div class="w-full max-w-6xl mx-auto px-6 flex flex-col items-center">

                <!-- Eyebrow label -->
                <div class="animate-fade-up inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 border border-primary/20 rounded-full text-xs font-semibold text-primary tracking-wider uppercase mb-8">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    Official Church Administration System
                </div>

                <!-- Main heading -->
                <h1 class="animate-fade-up delay-100 font-serif text-[clamp(2.8rem,7vw,5.5rem)] font-extrabold leading-[1.08] tracking-tight text-slate-900 mb-7 max-w-4xl">
                    Serving the community,<br>
                    <span class="bg-gradient-to-r from-secondary via-[#c9a84c] to-secondary-200 bg-clip-text text-transparent">one record at a time.</span>
                </h1>

                <!-- Sub-description -->
                <p class="animate-fade-up delay-200 text-lg leading-relaxed text-slate-500 max-w-2xl mb-11">
                    A secure and simple portal for managing members, finances, baptisms, and departmental activities across the Seventh-day Adventist community.
                </p>

                <!-- CTA buttons -->
                <div class="animate-fade-up delay-300 flex items-center justify-center gap-4 flex-wrap">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 text-[0.95rem] font-semibold text-white rounded-xl bg-gradient-to-br from-primary to-primary-500 shadow-lg shadow-primary/40 hover:shadow-xl hover:shadow-primary/50 hover:-translate-y-0.5 transition-all">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                </svg>
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 text-[0.95rem] font-semibold text-white rounded-xl bg-gradient-to-br from-primary to-primary-500 shadow-lg shadow-primary/40 hover:shadow-xl hover:shadow-primary/50 hover:-translate-y-0.5 transition-all">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                    <polyline points="10 17 15 12 10 7"/>
                                    <line x1="15" y1="12" x2="3" y2="12"/>
                                </svg>
                                Sign In to Portal
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-[0.95rem] font-semibold text-slate-900 rounded-xl bg-white border border-slate-200 shadow-sm hover:border-primary-300 hover:shadow-md hover:-translate-y-0.5 transition-all">
                                    Create an Account
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div class="w-full h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent mt-16 max-w-3xl animate-fade-up delay-300"></div>

                <!-- Feature Cards -->
                <div class="w-full max-w-4xl mt-14 animate-fade-up delay-300">
                    <p class="text-center text-[0.7rem] font-bold tracking-[0.12em] uppercase text-slate-400 mb-8">What's inside the portal</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                        <a href="{{ auth()->check() ? route('members.index') : route('login') }}" class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col gap-3 hover:-translate-y-1 hover:border-primary-300 hover:shadow-xl hover:shadow-primary/10 transition-all cursor-pointer text-left group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-primary/10 text-primary group-hover:bg-primary/20 transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 tracking-tight">Membership</div>
                                <div class="text-xs text-slate-500 leading-relaxed mt-1">Register, view and manage all church members and departments.</div>
                            </div>
                        </a>

                        <a href="{{ auth()->check() ? route('finance.index') : route('login') }}" class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col gap-3 hover:-translate-y-1 hover:border-primary-300 hover:shadow-xl hover:shadow-primary/10 transition-all cursor-pointer text-left group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 6v6l4 2"/>
                                    <path d="M9 12h.01M12 9h.01M15 12h.01"/>
                                    <line x1="12" y1="8" x2="12" y2="16"/>
                                    <line x1="8" y1="12" x2="16" y2="12"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 tracking-tight">Finance</div>
                                <div class="text-xs text-slate-500 leading-relaxed mt-1">Track tithes, offerings, donations, and expenditures with full reports.</div>
                            </div>
                        </a>

                        <a href="{{ auth()->check() ? route('documents.index') : route('login') }}" class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col gap-3 hover:-translate-y-1 hover:border-primary-300 hover:shadow-xl hover:shadow-primary/10 transition-all cursor-pointer text-left group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 tracking-tight">Documents</div>
                                <div class="text-xs text-slate-500 leading-relaxed mt-1">Store and retrieve important church documents and records securely.</div>
                            </div>
                        </a>

                        <a href="{{ auth()->check() ? route('baptisms.index') : route('login') }}" class="bg-white border border-slate-100 rounded-2xl p-5 flex flex-col gap-3 hover:-translate-y-1 hover:border-primary-300 hover:shadow-xl hover:shadow-primary/10 transition-all cursor-pointer text-left group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-secondary/10 text-secondary-600 group-hover:bg-secondary/20 transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 tracking-tight">Baptisms</div>
                                <div class="text-xs text-slate-500 leading-relaxed mt-1">Log and track baptism records and member transfers.</div>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
        </main>

        <!-- ── Deep Dive Features ─────────────────────────── -->
        <section class="py-20 bg-white border-t border-slate-100">
            <div class="w-full max-w-6xl mx-auto px-6">
                <!-- Block 1: Membership -->
                <div class="flex flex-col md:flex-row items-center gap-12 mb-24">
                    <div class="w-full md:w-1/2">
                        <div class="bg-primary/5 rounded-3xl p-8 border border-primary/10 aspect-video flex items-center justify-center relative overflow-hidden group hover:border-primary/20 transition-colors cursor-default">
                            <svg class="w-32 h-32 text-primary/30 group-hover:scale-105 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"/>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary-700 text-xs font-bold uppercase tracking-widest">
                            Membership
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-serif leading-tight">Comprehensive Member Records</h2>
                        <p class="text-slate-600 text-lg leading-relaxed">
                            Maintain an up-to-date, centralized database of all church members. Track family relationships, baptismal dates, spiritual gifts, and contact information with ease. Stop relying on scattered spreadsheets and physical books.
                        </p>
                        <ul class="space-y-4 pt-2">
                            <li class="flex items-start gap-3 text-slate-700">
                                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Family linking & household management</strong> to easily view related members.</span>
                            </li>
                            <li class="flex items-start gap-3 text-slate-700">
                                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Transfer requests & baptism logging</strong> integrated directly into profiles.</span>
                            </li>
                            <li class="flex items-start gap-3 text-slate-700">
                                <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Custom demographic reports</strong> to gain insights into your congregation.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Block 2: Finance -->
                <div class="flex flex-col md:flex-row-reverse items-center gap-12">
                    <div class="w-full md:w-1/2">
                        <div class="bg-secondary/10 rounded-3xl p-8 border border-secondary/20 aspect-video flex items-center justify-center relative overflow-hidden group hover:border-secondary/30 transition-colors cursor-default">
                            <svg class="w-32 h-32 text-secondary-800/40 group-hover:scale-105 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-secondary/10 text-secondary-800 text-xs font-bold uppercase tracking-widest">
                            Treasury
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-serif leading-tight">Transparent Financial Tracking</h2>
                        <p class="text-slate-600 text-lg leading-relaxed">
                            Empower your treasury team with tools built for Adventist financial structures. Accurately record tithes, offerings, and specific department funds, ensuring accountability and easy auditing.
                        </p>
                        <ul class="space-y-4 pt-2">
                            <li class="flex items-start gap-3 text-slate-700">
                                <svg class="w-5 h-5 text-secondary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Digital offering envelopes</strong> with intuitive batch entry workflows.</span>
                            </li>
                            <li class="flex items-start gap-3 text-slate-700">
                                <svg class="w-5 h-5 text-secondary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Departmental budget tracking</strong> for Youth, Sabbath School, and more.</span>
                            </li>
                            <li class="flex items-start gap-3 text-slate-700">
                                <svg class="w-5 h-5 text-secondary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Automated financial reporting</strong> to present to the church board.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Security & Privacy ─────────────────────────── -->
        <section class="py-24 bg-neutral-50 border-y border-neutral-200">
            <div class="w-full max-w-6xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 font-serif mb-6">Enterprise-Grade Security</h2>
                    <p class="text-slate-600 text-lg leading-relaxed">Church records contain sensitive personal information. We've built the SDA CMS with privacy and security as foundational principles.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-2xl border border-neutral-200 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all">
                        <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Role-Based Access</h3>
                        <p class="text-slate-600 leading-relaxed text-sm">Ensure users only see what they need. Clerks access membership, treasurers access finances, and pastors have overview access.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-2xl border border-neutral-200 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all">
                        <div class="w-14 h-14 bg-secondary/10 text-secondary-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Cloud Backups</h3>
                        <p class="text-slate-600 leading-relaxed text-sm">Never lose a physical record book again. Your data is continuously backed up to secure, redundant cloud servers to prevent data loss.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-2xl border border-neutral-200 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all">
                        <div class="w-14 h-14 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Data Privacy</h3>
                        <p class="text-slate-600 leading-relaxed text-sm">Built to comply with modern data protection standards, ensuring your members' personal information remains strictly confidential.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Departments ────────────────────────────────── -->
        <section class="py-16 bg-white border-b border-neutral-100">
            <div class="w-full max-w-5xl mx-auto px-6 text-center">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Supporting Core Ministries</p>
                <div class="flex flex-wrap justify-center gap-4 md:gap-6 opacity-80">
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 font-medium">Sabbath School</span>
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 font-medium">Pathfinders & Adventurers</span>
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 font-medium">Youth Ministries (AYM)</span>
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 font-medium">Women's Ministries</span>
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-200 bg-slate-50 text-slate-700 font-medium">Deacons & Deaconesses</span>
                </div>
            </div>
        </section>

        <!-- ── Bottom CTA ─────────────────────────────────── -->
        <section class="py-24 bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 relative overflow-hidden">
            <!-- Decorative overlay -->
            <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at 100% 100%, #ffffff 0%, transparent 60%), radial-gradient(circle at 0% 0%, #ffffff 0%, transparent 60%);"></div>
            
            <div class="w-full max-w-4xl mx-auto px-6 text-center relative z-10">
                <h2 class="text-3xl md:text-5xl font-bold text-white font-serif mb-6 leading-tight">Ready to streamline your administration?</h2>
                <p class="text-primary-100/90 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed">
                    Join other SDA churches transitioning from paper records to a secure, modern management portal built specifically for Adventist congregations.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-5">
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center gap-2 bg-secondary text-secondary-950 font-bold px-8 py-4 rounded-xl hover:bg-secondary-400 transition-colors shadow-lg shadow-secondary/20 text-lg">
                        Create an Account
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    @endif
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center gap-2 bg-primary-800/50 text-white border border-primary-600/50 font-semibold px-8 py-4 rounded-xl hover:bg-primary-800 transition-colors text-lg">
                        Sign In
                    </a>
                </div>
            </div>
        </section>

        <!-- ── Footer ─────────────────────────────────────── -->
        <footer class="border-t border-slate-200 bg-white py-8 mt-auto">
            <div class="w-full max-w-6xl mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-slate-500">&copy; {{ date('Y') }} SDA Church Management System. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>
