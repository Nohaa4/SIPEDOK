<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIPEDOK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Nunito Sans', sans-serif;
            overflow-x: hidden;
            background: #06445f;
        }

        /* BACKGROUND FULL SCREEN */

        .login-container {
            width: 100%;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 52% 48%;
            position: relative;
            overflow: hidden;
            background: linear-gradient(
                120deg,
                #06435f 0%,
                #07536d 35%,
                #087e83 70%,
                #159e9b 100%
            );
        }

        /* ANIMASI BACKGROUND */

        .background-decoration {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(70, 210, 190, 0.13);
            animation: floatCircle 13s ease-in-out infinite alternate;
        }

        .circle-one {
            width: 470px;
            height: 470px;
            top: -300px;
            left: -100px;
        }

        .circle-two {
            width: 300px;
            height: 300px;
            right: -130px;
            bottom: -180px;
            background: rgba(100, 230, 190, 0.15);
            animation-delay: 2s;
        }

        .circle-three {
            width: 170px;
            height: 170px;
            left: 40%;
            bottom: 12%;
            background: rgba(255, 255, 255, 0.06);
            animation-delay: 4s;
        }

        .background-wave {
            position: absolute;
            width: 120%;
            height: 310px;
            left: -10%;
            bottom: -245px;
            border-radius: 50%;
            background: linear-gradient(
                90deg,
                #087b91,
                #20b7a2,
                #57d99b
            );
            transform: rotate(-7deg);
            animation: waveMove 14s ease-in-out infinite alternate;
        }

        .background-wave-two {
            position: absolute;
            width: 115%;
            height: 250px;
            left: -5%;
            bottom: -220px;
            border-radius: 50%;
            background: rgba(91, 220, 174, 0.22);
            transform: rotate(5deg);
            animation: waveMoveTwo 16s ease-in-out infinite alternate;
        }

        @keyframes floatCircle {
            from {
                transform: translate(0, 0);
            }
            to {
                transform: translate(25px, 30px);
            }
        }

        @keyframes waveMove {
            from {
                transform: translateX(-15px) rotate(-7deg);
            }
            to {
                transform: translateX(25px) rotate(-4deg);
            }
        }

        @keyframes waveMoveTwo {
            from {
                transform: translateX(15px) rotate(5deg);
            }
            to {
                transform: translateX(-20px) rotate(2deg);
            }
        }

        /* PANEL KIRI */

        .left-panel {
            grid-column: 1;
            min-height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 45px 55px 45px 8%;
            color: #fff;
            z-index: 1;
        }

        .left-content {
            width: 100%;
            max-width: 490px;
            position: relative;
            z-index: 2;
            animation: contentFloat 6s ease-in-out infinite;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .brand-logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-divider {
            width: 2px;
            height: 68px;
            background: rgba(255, 255, 255, 0.85);
        }

        .brand-name {
            font-size: 37px;
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: 1px;
            color: #fff;
        }

        .brand-description {
            font-size: 14px;
            line-height: 1.5;
            margin-top: 6px;
            color: #e3f4f7;
        }

        .accent-line {
            width: 80px;
            height: 4px;
            border-radius: 20px;
            background: linear-gradient(90deg, #20c7b0, #67d994);
            margin: 23px 0;
        }

        .left-content h2 {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.35;
            margin-bottom: 13px;
            max-width: 450px;
        }

        .highlight {
            color: #6ce0bd;
        }

        .description {
            font-size: 14px;
            line-height: 1.75;
            color: #e0f0f5;
            margin-bottom: 23px;
            max-width: 440px;
        }

        /* DAFTAR FITUR */

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 13px;
            font-weight: 700;
            color: #f4fbfc;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.12);
            flex-shrink: 0;
        }

        .feature-icon svg {
            width: 21px;
            height: 21px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .captcha-code {
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: #123653;
        }

        /* ANIMASI KONTEN KIRI */

        @keyframes contentFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-7px);
            }
        }

        /* PANEL KANAN */

        .right-panel {
            grid-column: 2;
            min-height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 35px 8% 35px 15px;
            background: transparent;
            z-index: 3;
        }

        /* KARTU LOGIN */

        .login-card {
            width: 100%;
            max-width: 430px;
            position: relative;
            z-index: 4;
            padding: 35px 32px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 18px 55px rgba(0, 35, 55, 0.22);
        }

        /* LOGO LOGIN */

        .login-brand {
            display: flex;
            justify-content: center;
            margin-bottom: 14px;
        }

        .brand-bubble {
            width: 100%;
            max-width: 330px;
            min-height: 75px;
            padding: 9px 18px;
            border-radius: 60px;
            background: linear-gradient(100deg, #d5f5f0, #c0eaff);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 13px;
        }

        .login-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .login-brand-divider {
            width: 2px;
            height: 43px;
            background: #17627f;
        }

        .login-brand-name {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 1px;
            color: #07516c;
            line-height: 1.1;
        }

        .login-slogan {
            text-align: center;
            color: #08718c;
            font-size: 13px;
            font-weight: 700;
            font-style: italic;
            margin-bottom: 27px;
        }

        /* ALERT */

        .alert {
            padding: 11px 13px;
            margin-bottom: 16px;
            border-radius: 10px;
            font-size: 13px;
        }

        .alert-danger {
            background: #fff0f0;
            color: #b42318;
            border: 1px solid #ffd2d2;
        }

        .alert-success {
            background: #eaf8f0;
            color: #18794e;
            border: 1px solid #c7ead5;
        }

        /* FORM */

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 800;
            color: #10516f;
        }

        .input-box {
            width: 100%;
            height: 49px;
            border: 1.5px solid #d2e5f5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            background: #fff;
            transition: 0.2s;
        }

        .input-box:focus-within {
            border-color: #1597a7;
            box-shadow: 0 0 0 3px rgba(21, 151, 167, 0.10);
        }

        .input-icon {
            width: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #075b7e;
            flex-shrink: 0;
        }

        .input-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-family: inherit;
            font-size: 13px;
            color: #174761;
            padding-right: 12px;
        }

        .input-box input::placeholder {
            color: #8ca2b9;
        }

        .password-toggle {
            border: none;
            background: transparent;
            color: #28607d;
            padding: 0 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        /* CAPTCHA */

        .captcha-row {
            display: grid;
            grid-template-columns: 1fr 48px;
            gap: 9px;
            margin-bottom: 9px;
        }

        .captcha-display {
            height: 49px;
            border: 1.5px solid #d5e5f4;
            border-radius: 12px;
            background: repeating-linear-gradient(
                135deg,
                #ffffff,
                #ffffff 12px,
                #f1faff 13px,
                #f1faff 15px
            );
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 4px;
            user-select: none;
        }

        .captcha-display span:nth-child(1) {
            color: #d94355;
            transform: rotate(-5deg);
        }

        .captcha-display span:nth-child(2) {
            color: #2765d8;
            transform: rotate(5deg);
        }

        .captcha-display span:nth-child(3) {
            color: #23996f;
            transform: rotate(-4deg);
        }

        .captcha-refresh {
            border: 1.5px solid #d4e5f5;
            border-radius: 12px;
            background: #e9f4ff;
            color: #0875c5;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }

        .captcha-refresh:hover {
            background: #d9edff;
        }

        .captcha-refresh svg {
            width: 23px;
            height: 23px;
        }

        /* INPUT CAPTCHA - TEKS HITAM, TEBAL, DAN KAPITAL */

        .captcha-input {
            width: 100%;
            height: 42px;
            border: 1.5px solid #d5e5f4;
            border-radius: 11px;
            outline: none;
            text-align: center;
            font-family: 'Nunito Sans', sans-serif;
            font-size: 15px;
            font-weight: 900;
            color: #000000;
            background: #fff;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .captcha-input:focus {
            border-color: #1597a7;
            box-shadow: 0 0 0 3px rgba(21, 151, 167, 0.10);
        }

        .captcha-input::placeholder {
            color: #8ca2b9;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: normal;
            text-transform: none;
        }

        /* TOMBOL MASUK */

        .btn-login {
            width: 100%;
            height: 49px;
            margin-top: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(
                100deg,
                #07516c,
                #078c94,
                #38c796
            );
            color: #fff;
            font-family: inherit;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: 0.2s;
        }

        .btn-login:hover {
            filter: brightness(1.07);
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(8, 115, 131, 0.20);
        }

        .btn-login svg {
            width: 21px;
            height: 21px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* INFORMASI HAK AKSES */

        .login-divider {
            border: none;
            border-top: 1px solid #dce9f4;
            margin: 20px 0 15px;
        }

        .access-info {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            text-align: center;
            color: #14577c;
            font-size: 11px;
            font-weight: 700;
        }

        .access-info svg {
            width: 18px;
            height: 18px;
            stroke: #0874c5;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .login-container {
                grid-template-columns: 50% 50%;
            }

            .left-panel {
                padding: 40px 35px;
            }

            .right-panel {
                padding: 25px 25px 25px 10px;
            }

            .brand-logo {
                width: 78px;
                height: 78px;
            }

            .brand-name {
                font-size: 33px;
            }

            .left-content h2 {
                font-size: 25px;
            }

            .description {
                font-size: 13px;
            }

            .login-card {
                max-width: 390px;
                padding: 28px 25px;
            }
        }

        @media (max-width: 800px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .left-panel {
                min-height: auto;
                padding: 40px 28px;
            }

            .left-content {
                max-width: 520px;
            }

            .right-panel {
                grid-column: 1;
                min-height: 600px;
                padding: 35px 18px;
            }

            .background-wave,
            .background-wave-two {
                bottom: -230px;
            }

            .login-card {
                max-width: 420px;
            }
        }

        @media (max-width: 480px) {
            .left-panel {
                padding: 30px 22px;
            }

            .right-panel {
                padding: 25px 15px;
            }

            .brand {
                gap: 12px;
            }

            .brand-logo {
                width: 65px;
                height: 65px;
            }

            .brand-divider {
                height: 55px;
            }

            .brand-name {
                font-size: 27px;
            }

            .brand-description {
                font-size: 11px;
            }

            .left-content h2 {
                font-size: 23px;
            }

            .description {
                font-size: 12px;
            }

            .feature-item {
                font-size: 12px;
            }

            .feature-icon {
                width: 38px;
                height: 38px;
            }

            .login-card {
                padding: 24px 18px;
            }

            .brand-bubble {
                min-height: 68px;
                padding: 8px 13px;
                gap: 10px;
            }

            .login-logo {
                width: 50px;
                height: 50px;
            }

            .login-brand-name {
                font-size: 29px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .left-content,
            .bg-circle,
            .background-wave,
            .background-wave-two {
                animation: none;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <!-- BACKGROUND ANIMASI -->

    <div class="background-decoration">
        <div class="bg-circle circle-one"></div>
        <div class="bg-circle circle-two"></div>
        <div class="bg-circle circle-three"></div>
        <div class="background-wave"></div>
        <div class="background-wave-two"></div>
    </div>


    <!-- PANEL KIRI -->

    <section class="left-panel">

        <div class="left-content">

            <div class="brand">

                <img
                    src="<?= base_url('assets/sipedok/img/logo-sipedok.png') ?>"
                    alt="Logo SIPEDOK"
                    class="brand-logo"
                >

                <div class="brand-divider"></div>

                <div>
                    <h1 class="brand-name">SIPEDOK</h1>

                    <p class="brand-description">
                        Sistem Informasi<br>
                        Pelaporan Dokumen Pegawai
                    </p>
                </div>

            </div>

            <div class="accent-line"></div>

            <h2>
                Kelola pelaporan dokumen
                dengan <span class="highlight">lebih mudah.</span>
            </h2>

            <p class="description">
                SIPEDOK merupakan Sistem Informasi
                Pelaporan Dokumen Pegawai yang membantu
                pengelolaan, pemantauan, dan pelaporan
                dokumen IA / SK secara terintegrasi.
            </p>

            <div class="feature-list">

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path d="M8 8h8M8 12h8M8 16h4"/>
                        </svg>
                    </div>
                    <span>Pengelolaan dokumen secara terstruktur</span>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="14" rx="2"/>
                            <path d="M8 21h8M12 18v3"/>
                            <path d="m7 13 3-3 2 2 4-5"/>
                        </svg>
                    </div>
                    <span>Monitoring pelaporan dokumen</span>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>
                    <span>Penyajian laporan yang akurat</span>
                </div>

            </div>

        </div>

    </section>


    <!-- PANEL KANAN / FORM LOGIN -->

    <section class="right-panel">

        <div class="login-card">

            <div class="login-brand">

                <div class="brand-bubble">

                    <img
                        src="<?= base_url('assets/sipedok/img/logo-sipedok.png') ?>"
                        alt="Logo SIPEDOK"
                        class="login-logo"
                    >

                    <div class="login-brand-divider"></div>

                    <h2 class="login-brand-name">SIPEDOK</h2>

                </div>

            </div>

            <p class="login-slogan">
                Transparan &bull; Terintegrasi &bull; Andal
            </p>


            <!-- NOTIFIKASI -->

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>


            <!-- FORM LOGIN -->

            <form action="<?= base_url('login') ?>" method="POST">

                <?= csrf_field() ?>

                <div class="form-group">

                    <label for="nip">NIP</label>

                    <div class="input-box">

                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 21v-2a8 8 0 0 1 16 0v2z"/>
                            </svg>
                        </div>

                        <input
                            type="text"
                            id="nip"
                            name="nip"
                            placeholder="Masukkan NIP"
                            value="<?= esc(old('nip') ?? '') ?>"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label for="password">PASSWORD</label>

                    <div class="input-box">

                        <div class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="10" width="18" height="12" rx="2"/>
                                <path d="M7 10V7a5 5 0 0 1 10 0v3"/>
                            </svg>
                        </div>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password"
                        >
                            <svg
                                id="eyeIcon"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>

                    </div>

                </div>


                <div class="form-group">

                    <label for="captcha">KODE KEAMANAN</label>

                    <div class="captcha-row">

                        <div class="captcha-display" id="captchaDisplay">
                            <?php foreach (str_split($captcha) as $character) : ?>
                                <span><?= esc($character) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <button
                            type="button"
                            class="captcha-refresh"
                            onclick="refreshCaptcha()"
                            aria-label="Perbarui kode keamanan"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M20 7v5h-5"/>
                                <path d="M4 17v-5h5"/>
                                <path d="M5.6 9a7 7 0 0 1 11.8-2L20 12"/>
                                <path d="M4 12l2.6 5a7 7 0 0 0 11.8-2"/>
                            </svg>
                        </button>

                    </div>

                    <input
                        type="text"
                        class="captcha-input"
                        id="captcha"
                        name="captcha"
                        placeholder="Masukkan 3 karakter di atas"
                        maxlength="3"
                        autocomplete="off"
                        autocapitalize="characters"
                        oninput="this.value = this.value.toUpperCase()"
                        required
                    >

                </div>


                <button type="submit" class="btn-login">

                    <svg viewBox="0 0 24 24">
                        <path d="M10 17l5-5-5-5"/>
                        <path d="M15 12H3"/>
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                    </svg>

                    <span>Masuk</span>

                </button>

            </form>


            <hr class="login-divider">

            <div class="access-info">

                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>

                <span>
                    Gunakan akun sesuai dengan hak akses Anda
                </span>

            </div>

        </div>

    </section>

</div>


<script>

    // Tampilkan dan sembunyikan password

    function togglePassword() {

        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {

            password.type = 'text';

            eyeIcon.innerHTML = `
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                <path d="M3 3l18 18"/>
            `;

        } else {

            password.type = 'password';

            eyeIcon.innerHTML = `
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                <circle cx="12" cy="12" r="3"/>
            `;

        }

    }


    // Refresh CAPTCHA

    function refreshCaptcha() {

        fetch("<?= base_url('login/captcha') ?>")
            .then(response => {

                if (!response.ok) {
                    throw new Error('Gagal mengambil CAPTCHA');
                }

                return response.json();

            })
            .then(data => {

                const display = document.getElementById('captchaDisplay');

                display.innerHTML = '';

                data.captcha.split('').forEach(character => {

                    const span = document.createElement('span');

                    span.textContent = character;

                    display.appendChild(span);

                });

                document.getElementById('captcha').value = '';

            })
            .catch(error => {

                console.error(error);

                alert('Kode keamanan gagal diperbarui. Silakan muat ulang halaman.');

            });

    }

</script>

</body>
</html>