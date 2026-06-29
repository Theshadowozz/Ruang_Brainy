@php
    $courses = [
        [
            'title' => 'Bahasa Inggris',
            'image' => 'englishpng.png',
            'badge' => 'Populer',
            'description' => 'Kelas percakapan, grammar, interview, hingga persiapan TOEFL/IELTS dengan latihan yang terarah.',
            'details' => ['Level basic hingga advanced', 'Kelas anak, remaja, dan dewasa', 'Belajar aktif lewat speaking practice'],
        ],
        [
            'title' => 'Bahasa Jepang',
            'image' => 'jepang.png',
            'badge' => 'JLPT Ready',
            'description' => 'Belajar hiragana, katakana, kanji, percakapan, dan persiapan JLPT bersama tutor berpengalaman.',
            'details' => ['Materi budaya dan percakapan', 'Latihan kosakata harian', 'Pendampingan level dasar'],
        ],
        [
            'title' => 'Bahasa Korea',
            'image' => 'korean.png',
            'badge' => 'TOPIK Ready',
            'description' => 'Kuasai hangeul, speaking, listening, dan persiapan TOPIK dengan metode belajar yang menyenangkan.',
            'details' => ['Latihan hangeul dari nol', 'Kelas interaktif dan fun', 'Materi budaya Korea'],
        ],
    ];

    $tutors = [
        [
            'name' => 'Adelia Delarosa S,Pd., Gr',
            'role' => 'English Tutor',
            'nickname' => 'Ms Adel',
            'image' => 'Adelia Delarosa S,Pd., Gr - English Tutor - Ms Adel.jpeg',
        ],
        [
            'name' => 'Titin Hajri, M.Ed in Diglearn',
            'role' => 'Owner Brainy Course',
            'nickname' => 'Ms Titin',
            'image' => 'Titin Hajri, M.Ed in Diglearn - Owner Brainy Course - Ms Titin.jpeg',
        ],
        [
            'name' => 'Ihya Maghfirah S.Kep',
            'role' => 'Korean Tutor',
            'nickname' => 'Ira Ssaem',
            'image' => 'Ihya Maghfirah S.Kep - Korean Tutor - Ira Ssaem.jpeg',
        ],
        [
            'name' => 'Nadia Indah Sari, S.Pd',
            'role' => 'Japanese Tutor',
            'nickname' => 'Nadia Sensei',
            'image' => 'Nadia Indah Sari, S.Pd - Japanese Tutor - Nadia Sensei.jpeg',
        ],
        [
            'name' => 'Retno Suhermen, S.s',
            'role' => 'English Tutor',
            'nickname' => 'Ms Retno',
            'image' => 'Retno Suhermen, S.s - English Tutor - Ms Retno.jpeg',
        ],
        [
            'name' => 'Annisa Nur Umatil Iqbal, S.Pd., Gr',
            'role' => 'English Tutor',
            'nickname' => 'Ms Nisa',
            'image' => 'Annisa Nur Umatil Iqbal, S.Pd., Gr - English Tutor - Ms Nisa.jpeg',
        ],
    ];

    $testimonials = [
        [
            'name' => 'Alya Putri',
            'program' => 'Alumni English Class',
            'quote' => 'Belajar di Brainy Course bikin saya lebih percaya diri saat speaking. Materinya jelas, tutornya sabar, dan kelasnya terasa hidup.',
        ],
        [
            'name' => 'Rizky Ramadhan',
            'program' => 'Alumni Japanese Class',
            'quote' => 'Dari awalnya bingung hiragana, sekarang saya sudah bisa baca teks sederhana. Cara ngajarnya runtut dan mudah diikuti.',
        ],
        [
            'name' => 'Nabila Sari',
            'program' => 'Alumni Korean Class',
            'quote' => 'Kelas Korea-nya seru banget. Saya jadi lebih paham hangeul, pelafalan, dan kosakata yang sering dipakai sehari-hari.',
        ],
    ];

    $address = 'Jl. Teuku Umar No.1 D RT/RW 003/012, Alai Parak Kopi, Kec. Padang Utara, Kota Padang, Sumatera Barat 25171';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Course - Belajar Bahasa Lebih Seru</title>
    @include('layouts.vite')
    <style>
        :root {
            --blue: #1283e8;
            --blue-dark: #0f63c7;
            --blue-soft: #43a7ef;
            --ink: #111827;
            --muted: #5f6b7a;
            --line: #dce5ef;
            --surface: #ffffff;
            --background: #f7fbff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .lp-container {
            width: min(1160px, calc(100% - 40px));
            margin-inline: auto;
        }

        .lp-header {
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid rgba(18, 131, 232, .12);
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(18px);
        }

        .lp-nav {
            display: flex;
            min-height: 72px;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .lp-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #1D4ED8;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .lp-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .lp-menu {
            display: flex;
            align-items: center;
            gap: 24px;
            color: #374151;
            font-size: 14px;
            font-weight: 700;
        }

        .lp-menu a {
            transition: color 180ms ease;
        }

        .lp-menu a:hover {
            color: var(--blue);
        }

        .lp-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lp-button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 8px;
            border: 1px solid transparent;
            padding: 0 18px;
            background: var(--blue);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 12px 24px rgba(18, 131, 232, .18);
            transition: transform 180ms ease, background 180ms ease, border-color 180ms ease;
        }

        .lp-button:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
        }

        .lp-button:disabled {
            cursor: not-allowed;
            background: #94a3b8;
            transform: none;
        }

        .lp-button.secondary {
            background: #fff;
            color: var(--blue);
            border-color: rgba(18, 131, 232, .35);
            box-shadow: none;
        }

        .lp-button.secondary:hover {
            background: #edf8ff;
        }

        .lp-hero {
            position: relative;
            overflow: hidden;
            padding: 80px 0 86px;
            background:
                linear-gradient(135deg, rgba(223, 243, 255, .96), rgba(255, 255, 255, .72) 45%, rgba(247, 251, 255, 1)),
                var(--background);
        }

        .lp-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, .95fr);
            align-items: center;
            gap: 56px;
        }

        .lp-eyebrow {
            display: inline-flex;
            width: fit-content;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(18, 131, 232, .18);
            border-radius: 999px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, .72);
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .lp-hero h1 {
            margin: 18px 0 18px;
            max-width: 620px;
            font-size: clamp(40px, 6vw, 72px);
            line-height: .98;
            letter-spacing: 0;
        }

        .lp-hero h1 span {
            color: var(--blue);
        }

        .lp-lead {
            max-width: 570px;
            margin: 0;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.75;
        }

        .lp-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .lp-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            max-width: 560px;
            margin-top: 42px;
        }

        .lp-stat {
            border: 1px solid rgba(18, 131, 232, .15);
            border-radius: 8px;
            padding: 16px;
            background: rgba(255, 255, 255, .74);
        }

        .lp-stat strong {
            display: block;
            color: var(--blue);
            font-size: 22px;
            line-height: 1;
        }

        .lp-stat span {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .lp-hero-media {
            position: relative;
            isolation: isolate;
        }

        .lp-hero-media::before {
            position: absolute;
            inset: 34px -14px -16px 38px;
            z-index: -1;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(67, 167, 239, .32), rgba(18, 131, 232, .12));
            content: "";
        }

        .lp-hero-photo {
            width: 100%;
            aspect-ratio: 4 / 3;
            border: 1px solid rgba(18, 131, 232, .18);
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 24px 70px rgba(15, 99, 199, .18);
        }

        .lp-floating-card {
            position: absolute;
            left: -22px;
            bottom: -22px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: min(270px, calc(100% - 24px));
            border: 1px solid rgba(18, 131, 232, .16);
            border-radius: 8px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 18px 42px rgba(31, 41, 55, .12);
        }

        .lp-icon {
            display: grid;
            flex: none;
            width: 44px;
            height: 44px;
            place-items: center;
            border-radius: 8px;
            background: rgba(18, 131, 232, .11);
            color: var(--blue);
        }

        .lp-floating-card strong,
        .lp-feature strong,
        .lp-contact-item strong {
            display: block;
            font-size: 15px;
        }

        .lp-floating-card span {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .lp-section {
            padding: 86px 0;
        }

        .lp-section.white {
            background: #fff;
        }

        .lp-section-head {
            max-width: 680px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .lp-section-head h2 {
            margin: 0 0 12px;
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.12;
            letter-spacing: 0;
        }

        .lp-section-head p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.7;
        }

        .lp-features {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .lp-feature,
        .lp-course,
        .lp-testimonial,
        .lp-faq details {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
        }

        .lp-feature {
            padding: 22px;
            transition: border-color 180ms ease, transform 180ms ease;
        }

        .lp-feature:hover {
            border-color: rgba(18, 131, 232, .42);
            transform: translateY(-2px);
        }

        .lp-feature p {
            margin: 12px 0 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.65;
        }

        .lp-courses {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .lp-course {
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(17, 24, 39, .04);
        }

        .lp-course-image {
            position: relative;
            min-height: 230px;
            overflow: hidden;
            background: #eaf6ff;
        }

        .lp-course-image img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            transition: transform 320ms ease;
        }

        .lp-course:hover .lp-course-image img {
            transform: scale(1.04);
        }

        .lp-course-badge {
            position: absolute;
            left: 18px;
            bottom: 18px;
            border-radius: 999px;
            padding: 7px 10px;
            background: var(--blue);
            color: #fff;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .lp-course-body {
            padding: 22px;
        }

        .lp-course-body h3,
        .lp-testimonial h3,
        .lp-tutor h3 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0;
        }

        .lp-course-body p {
            margin: 10px 0 18px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.65;
        }

        .lp-checklist {
            display: grid;
            gap: 10px;
            margin: 0 0 22px;
            padding: 0;
            list-style: none;
            color: #374151;
            font-size: 14px;
            font-weight: 700;
        }

        .lp-checklist li {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lp-check {
            display: grid;
            width: 19px;
            height: 19px;
            place-items: center;
            border-radius: 50%;
            background: rgba(18, 131, 232, .1);
            color: var(--blue);
            font-size: 12px;
        }

        .lp-band {
            background: linear-gradient(135deg, var(--blue-dark), var(--blue) 58%, var(--blue-soft));
            color: #fff;
        }

        .lp-trial {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            align-items: center;
            gap: 48px;
        }

        .lp-trial h2 {
            margin: 12px 0;
            font-size: clamp(28px, 4vw, 44px);
            line-height: 1.1;
            letter-spacing: 0;
        }

        .lp-trial p {
            max-width: 640px;
            margin: 0;
            color: rgba(255, 255, 255, .86);
            line-height: 1.7;
        }

        .lp-trial-points {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 28px;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .lp-trial-form {
            border-radius: 8px;
            padding: 24px;
            background: #fff;
            color: var(--ink);
            box-shadow: 0 24px 50px rgba(0, 37, 92, .18);
        }

        .lp-form-field {
            display: grid;
            gap: 7px;
            margin-bottom: 14px;
        }

        .lp-form-field label {
            color: #374151;
            font-size: 13px;
            font-weight: 800;
        }

        .lp-form-field input,
        .lp-form-field select {
            width: 100%;
            min-height: 44px;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 0 12px;
            color: var(--ink);
            font: inherit;
        }

        .lp-tutors {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .lp-tutor {
            text-align: center;
        }

        .lp-tutor-photo {
            width: min(190px, 72vw);
            aspect-ratio: 1;
            margin: 0 auto 18px;
            overflow: hidden;
            border: 5px solid #edf8ff;
            border-radius: 50%;
            box-shadow: 0 16px 30px rgba(17, 24, 39, .12);
        }

        .lp-tutor-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lp-tutor .role {
            margin: 8px 0 4px;
            color: var(--blue);
            font-size: 14px;
            font-weight: 900;
        }

        .lp-tutor .nickname {
            color: var(--muted);
            font-size: 14px;
            font-weight: 700;
        }

        .lp-testimonials {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .lp-testimonial {
            position: relative;
            padding: 28px;
        }

        .lp-quote-mark {
            position: absolute;
            top: 12px;
            right: 20px;
            color: rgba(18, 131, 232, .14);
            font-size: 64px;
            font-weight: 900;
            line-height: 1;
        }

        .lp-testimonial p {
            position: relative;
            z-index: 1;
            margin: 20px 0 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.75;
        }

        .lp-testimonial span {
            display: block;
            margin-top: 6px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 800;
        }

        .lp-faq {
            display: grid;
            max-width: 820px;
            margin: 0 auto;
            gap: 12px;
        }

        .lp-faq summary {
            display: flex;
            cursor: pointer;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 22px;
            font-weight: 800;
            list-style: none;
        }

        .lp-faq summary::-webkit-details-marker {
            display: none;
        }

        .lp-faq summary span {
            color: var(--blue);
            font-size: 22px;
        }

        .lp-faq details[open] summary span {
            transform: rotate(45deg);
        }

        .lp-faq details p {
            margin: 0;
            border-top: 1px solid var(--line);
            padding: 0 22px 20px;
            padding-top: 18px;
            color: var(--muted);
            line-height: 1.7;
        }

        .lp-footer {
            border-top: 1px solid var(--line);
            background: #fff;
        }

        .lp-contact {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(360px, 1.1fr);
            gap: 44px;
            padding: 72px 0 46px;
        }

        .lp-contact h2 {
            margin: 0 0 14px;
            font-size: clamp(28px, 4vw, 40px);
            letter-spacing: 0;
        }

        .lp-contact-text {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.7;
        }

        .lp-contact-list {
            display: grid;
            gap: 18px;
        }

        .lp-contact-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .lp-contact-item p {
            margin: 4px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .lp-map {
            min-height: 430px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #eef2f7;
            box-shadow: 0 18px 42px rgba(17, 24, 39, .08);
        }

        .lp-map iframe {
            width: 100%;
            height: 100%;
            min-height: 430px;
            border: 0;
        }

        .lp-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-top: 1px solid var(--line);
            padding: 22px 0;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .lp-mobile-menu {
            display: none;
        }

        @media (max-width: 980px) {
            .lp-menu {
                display: none;
            }

            .lp-hero-grid,
            .lp-trial,
            .lp-contact {
                grid-template-columns: 1fr;
            }

            .lp-hero-media {
                max-width: 620px;
            }

            .lp-features,
            .lp-courses,
            .lp-tutors,
            .lp-testimonials {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lp-trial {
                gap: 28px;
            }
        }

        @media (max-width: 680px) {
            .lp-container {
                width: min(100% - 28px, 1160px);
            }

            .lp-nav {
                min-height: 66px;
            }

            .lp-brand span {
                font-size: 18px;
            }

            .lp-actions {
                gap: 6px;
            }

            .lp-actions .lp-button {
                min-height: 40px;
                padding: 0 11px;
                font-size: 12px;
            }

            .lp-hero {
                padding: 46px 0 64px;
            }

            .lp-hero-grid {
                gap: 38px;
            }

            .lp-lead {
                font-size: 16px;
            }

            .lp-stats,
            .lp-features,
            .lp-courses,
            .lp-tutors,
            .lp-testimonials {
                grid-template-columns: 1fr;
            }

            .lp-stats {
                margin-top: 28px;
            }

            .lp-hero-actions .lp-button {
                width: 100%;
            }

            .lp-floating-card {
                position: relative;
                left: auto;
                bottom: auto;
                margin-top: 14px;
                width: 100%;
            }

            .lp-section {
                padding: 62px 0;
            }

            .lp-trial-form {
                padding: 20px;
            }

            .lp-contact {
                padding-top: 58px;
            }

            .lp-map,
            .lp-map iframe {
                min-height: 340px;
            }

            .lp-bottom {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="lp-header">
        <div class="lp-container lp-nav">
            <a href="#beranda" class="lp-brand" aria-label="Brainy Course">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy Course">
                <span>Brainy Course</span>
            </a>

            <nav class="lp-menu" aria-label="Navigasi utama">
                <a href="#beranda">Beranda</a>
                <a href="#keunggulan">Keunggulan</a>
                <a href="#kelas">Kelas</a>
                <a href="#tutor">Tutor</a>
                <a href="#alumni">Alumni</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <div class="lp-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="lp-button">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="lp-button secondary">Masuk</a>
                    <a href="{{ route('classes.index') }}" class="lp-button">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section id="beranda" class="lp-hero">
            <div class="lp-container lp-hero-grid">
                <div>
                    <div class="lp-eyebrow">Kursus Bahasa di Padang</div>
                    <h1>Belajar Lebih Seru, Masa Depan <span>Lebih Cerah</span></h1>
                    <p class="lp-lead">
                        Kuasai bahasa Inggris, Jepang, dan Korea bersama tutor profesional Brainy Course. Materinya praktis, kelasnya interaktif, dan belajarnya dibuat nyaman untuk targetmu.
                    </p>
                    <div class="lp-hero-actions">
                        <a href="#kontak" class="lp-button secondary">Konsultasi Gratis</a>
                    </div>
                    <div class="lp-stats" aria-label="Ringkasan Brainy Course">
                        <div class="lp-stat">
                            <strong>3</strong>
                            <span>Bahasa pilihan</span>
                        </div>
                        <div class="lp-stat">
                            <strong>6</strong>
                            <span>Tutor aktif</span>
                        </div>
                        <div class="lp-stat">
                            <strong>90</strong>
                            <span>Menit trial</span>
                        </div>
                    </div>
                </div>

                <div class="lp-hero-media">
                    <img src="{{ asset('images/logo_lp.png') }}" alt="Suasana belajar di Brainy Course" class="lp-hero-photo">
                    <div class="lp-floating-card">
                        <div class="lp-icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 7.5 10.75 17 6 12.25" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 3.75 19.25 6.5V12c0 4.35-2.92 6.85-7.25 8.25C7.67 18.85 4.75 16.35 4.75 12V6.5L12 3.75Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Tutor profesional</strong>
                            <span>Belajar langsung bersama tim Brainy Course</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="keunggulan" class="lp-section white">
            <div class="lp-container">
                <div class="lp-section-head">
                    <h2>Kenapa Memilih Kami?</h2>
                    <p>Sistem belajar dirancang agar siswa bisa memahami materi secara bertahap, aktif bertanya, dan berani praktik di kelas.</p>
                </div>

                <div class="lp-features">
                    <article class="lp-feature">
                        <div class="lp-icon" aria-hidden="true">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none">
                                <path d="M4 6.75 12 3.5l8 3.25-8 3.25L4 6.75Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M7 9v5.2c0 1.8 2.24 3.05 5 3.05s5-1.25 5-3.05V9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <strong>Tutor Berpengalaman</strong>
                        <p>Belajar bersama pengajar yang memahami kebutuhan siswa dari level dasar hingga lanjutan.</p>
                    </article>
                    <article class="lp-feature">
                        <div class="lp-icon" aria-hidden="true">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none">
                                <path d="M12 7v5l3.25 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" stroke="currentColor" stroke-width="1.8"/>
                            </svg>
                        </div>
                        <strong>Jadwal Fleksibel</strong>
                        <p>Pilih jadwal belajar yang sesuai dengan rutinitas sekolah, kuliah, atau pekerjaan.</p>
                    </article>
                    <article class="lp-feature">
                        <div class="lp-icon" aria-hidden="true">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none">
                                <path d="M5 5.5h14v9H5v-9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M8.5 18.5h7M12 14.5v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <strong>Materi Interaktif</strong>
                        <p>Kelas berisi praktik, diskusi, latihan soal, dan aktivitas yang membuat materi lebih mudah diingat.</p>
                    </article>
                    <article class="lp-feature">
                        <div class="lp-icon" aria-hidden="true">
                            <svg width="23" height="23" viewBox="0 0 24 24" fill="none">
                                <path d="M8.75 13.75 11 16l4.5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.5 4.5h11v15h-11v-15Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <strong>Sertifikat Belajar</strong>
                        <p>Siswa mendapatkan bukti penyelesaian program setelah mengikuti kelas dan evaluasi.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="kelas" class="lp-section">
            <div class="lp-container">
                <div class="lp-section-head">
                    <h2>Pilihan Kelas</h2>
                    <p>Pilih program bahasa yang paling sesuai dengan kebutuhanmu, lalu mulai dari level yang paling nyaman.</p>
                </div>

                <div class="lp-courses">
                    @foreach ($courses as $course)
                        <article class="lp-course">
                            <div class="lp-course-image">
                                <img src="{{ asset('images/' . rawurlencode($course['image'])) }}" alt="{{ $course['title'] }}">
                                <span class="lp-course-badge">{{ $course['badge'] }}</span>
                            </div>
                            <div class="lp-course-body">
                                <h3>{{ $course['title'] }}</h3>
                                <p>{{ $course['description'] }}</p>
                                <ul class="lp-checklist">
                                    @foreach ($course['details'] as $detail)
                                        <li><span class="lp-check">&#10003;</span>{{ $detail }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div style="display: flex; justify-content: center; margin-top: 30px;">
                    <a href="{{ route('classes.index') }}" class="lp-button secondary">Lihat Jadwal Tersedia</a>
                </div>
            </div>
        </section>

        <section id="trial" class="lp-section lp-band">
            <div class="lp-container lp-trial">
                <div>
                    <div class="lp-eyebrow" style="background: rgba(255,255,255,.16); color: #fff; border-color: rgba(255,255,255,.26);">Gratis Trial</div>
                    <h2>Coba Kelas Trial 90 Menit</h2>
                    <p>Belum yakin? Ikuti kelas trial gratis untuk merasakan langsung metode belajar Brainy Course dan menentukan program yang paling cocok.</p>
                    <div class="lp-trial-points">
                        <span>&#10003; 100% gratis</span>
                        <span>&#10003; Level check</span>
                        <span>&#10003; Konsultasi tutor</span>
                    </div>
                </div>

                <form class="lp-trial-form" action="{{ route('trial.store') }}" method="POST">
                    @csrf
                    @if (session('trial_success'))
                        <div style="margin-bottom: 14px; border: 1px solid #bbf7d0; border-radius: 8px; background: #f0fdf4; color: #166534; padding: 12px; font-size: 13px; font-weight: 800;">
                            {{ session('trial_success') }}
                        </div>
                    @endif
                    @if ($errors->getBag('trial')->any())
                        <div style="margin-bottom: 14px; border: 1px solid #fecdd3; border-radius: 8px; background: #fff1f2; color: #9f1239; padding: 12px; font-size: 13px; font-weight: 800;">
                            {{ $errors->getBag('trial')->first() }}
                        </div>
                    @endif
                    <div class="lp-form-field">
                        <label for="trial-name">Nama Lengkap</label>
                        <input id="trial-name" name="full_name" type="text" value="{{ old('full_name') }}" placeholder="Masukkan nama" required>
                    </div>
                    <div class="lp-form-field">
                        <label for="trial-nik">NIK</label>
                        <input
                            id="trial-nik"
                            name="nik"
                            type="text"
                            value="{{ old('nik') }}"
                            inputmode="numeric"
                            maxlength="16"
                            pattern="\d{16}"
                            placeholder="16 digit NIK"
                            data-nik-input
                            data-check-url="{{ route('api.nik.check') }}"
                            data-check-context="trial"
                            required
                        >
                        <p style="margin: 0; font-size: 12px; font-weight: 800; color: #64748b;" data-nik-feedback>NIK digunakan agar trial hanya bisa dipakai satu kali.</p>
                    </div>
                    <div class="lp-form-field">
                        <label for="trial-program">Minat Bahasa</label>
                        <select id="trial-program" name="program" required>
                            <option value="">Pilih Bahasa...</option>
                            <option @selected(old('program') === 'Bahasa Inggris')>Bahasa Inggris</option>
                            <option @selected(old('program') === 'Bahasa Jepang')>Bahasa Jepang</option>
                            <option @selected(old('program') === 'Bahasa Korea')>Bahasa Korea</option>
                        </select>
                    </div>
                    <button type="submit" class="lp-button" style="width: 100%;" data-nik-submit>Daftar Trial</button>
                </form>
            </div>
        </section>

        <section id="tutor" class="lp-section white">
            <div class="lp-container">
                <div class="lp-section-head">
                    <h2>Tim Pengajar Kami</h2>
                    <p>Belajar dari tutor Brainy Course yang siap mendampingi proses belajarmu dari dasar sampai makin percaya diri.</p>
                </div>

                <div class="lp-tutors">
                    @foreach ($tutors as $tutor)
                        <article class="lp-tutor">
                            <div class="lp-tutor-photo">
                                <img src="{{ asset('images/' . rawurlencode($tutor['image'])) }}" alt="{{ $tutor['nickname'] }}">
                            </div>
                            <h3>{{ $tutor['name'] }}</h3>
                            <div class="role">{{ $tutor['role'] }}</div>
                            <div class="nickname">{{ $tutor['nickname'] }}</div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="alumni" class="lp-section">
            <div class="lp-container">
                <div class="lp-section-head">
                    <h2>Kata Alumni</h2>
                    <p>Pengalaman siswa setelah belajar bersama Brainy Course.</p>
                </div>

                <div class="lp-testimonials">
                    @foreach ($testimonials as $testimonial)
                        <article class="lp-testimonial">
                            <div class="lp-quote-mark" aria-hidden="true">"</div>
                            <h3>{{ $testimonial['name'] }}</h3>
                            <span>{{ $testimonial['program'] }}</span>
                            <p>{{ $testimonial['quote'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="faq" class="lp-section white">
            <div class="lp-container">
                <div class="lp-section-head">
                    <h2>Ada Pertanyaan?</h2>
                    <p>Beberapa hal yang sering ditanyakan sebelum mulai kelas.</p>
                </div>

                <div class="lp-faq">
                    <details>
                        <summary>Apakah bisa mulai dari nol? <span>+</span></summary>
                        <p>Bisa. Tutor akan membantu menyesuaikan materi dengan kemampuan awal siswa, termasuk untuk yang belum pernah belajar bahasa tersebut.</p>
                    </details>
                    <details>
                        <summary>Bagaimana sistem jadwal kelas? <span>+</span></summary>
                        <p>Jadwal dapat dikonsultasikan dengan admin agar sesuai dengan ketersediaan kelas dan waktu belajar siswa.</p>
                    </details>
                    <details>
                        <summary>Apakah tersedia trial class? <span>+</span></summary>
                        <p>Ya, kamu bisa mengikuti trial 90 menit untuk merasakan suasana kelas dan berkonsultasi tentang program yang sesuai.</p>
                    </details>
                    <details>
                        <summary>Apakah kelasnya offline? <span>+</span></summary>
                        <p>Brainy Course berlokasi di Padang. Untuk detail format kelas yang tersedia, silakan hubungi admin melalui kontak yang tersedia.</p>
                    </details>
                </div>
            </div>
        </section>
    </main>

    <footer id="kontak" class="lp-footer">
        <div class="lp-container">
            <div class="lp-contact">
                <div>
                    <h2>Yuk Ngobrol!</h2>
                    <p class="lp-contact-text">Punya pertanyaan atau ingin konsultasi kelas yang paling cocok? Hubungi Brainy Course atau datang langsung ke lokasi kami.</p>

                    <div class="lp-contact-list">
                        <div class="lp-contact-item">
                            <div class="lp-icon" aria-hidden="true">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 21s6.5-5.75 6.5-11.25a6.5 6.5 0 0 0-13 0C5.5 15.25 12 21 12 21Z" stroke="currentColor" stroke-width="1.8"/>
                                    <path d="M12 12.25a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" stroke="currentColor" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Alamat</strong>
                                <p>{{ $address }}</p>
                            </div>
                        </div>
                        <div class="lp-contact-item">
                            <div class="lp-icon" aria-hidden="true">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M7 5.5h10a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-5l-4.5 3v-3H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Konsultasi</strong>
                                <p>Silakan hubungi admin Brainy Course untuk jadwal, biaya, dan pendaftaran kelas.</p>
                            </div>
                        </div>
                        <div class="lp-contact-item">
                            <div class="lp-icon" aria-hidden="true">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 7v5l3 1.75" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" stroke="currentColor" stroke-width="1.8"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Jam Operasional</strong>
                                <p>Senin sampai Sabtu, sesuai jadwal kelas dan konsultasi admin.</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 28px;">
                        <a href="https://maps.app.goo.gl/2aoapwBjjoDpdp7HA" target="_blank" rel="noopener noreferrer" class="lp-button secondary">Buka Google Maps</a>
                    </div>
                </div>

                <div class="lp-map" aria-label="Peta lokasi Brainy Course">
                    <iframe
                        title="Lokasi Brainy Course"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ rawurlencode($address) }}&output=embed">
                    </iframe>
                </div>
            </div>

            <div class="lp-bottom">
                <a href="#beranda" class="lp-brand">
                    <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy Course">
                    <span>Brainy Course</span>
                </a>
                <span>&copy; {{ date('Y') }} Brainy Course. All rights reserved.</span>
            </div>
        </div>
    </footer>
</body>
</html>
