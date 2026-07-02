<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Kez iStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            /* Latar belakang gambar */
            background: url("images/gambar.jpeg") center center / cover no-repeat fixed;
            background-color: #0f172a;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Lapisan gelap transparan agar tulisan jelas */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.75), rgba(30, 41, 59, 0.65));
            z-index: 1;
        }

        /* Kontainer utama berada di atas lapisan gelap */
        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .brand {
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            font-size: 15px;
            color: #64748b;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px 14px 42px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 15px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            background: #ffffff;
        }

        /* Ikon di dalam input */
        .input-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            pointer-events: none;
        }

        .password-wrapper .toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            font-size: 18px;
            pointer-events: auto;
            transition: color 0.2s;
        }

        .password-wrapper .toggle:hover {
            color: #2563eb;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(90deg, #1d4ed8, #1e40af);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
            transform: translateY(-2px);
        }

        .error {
            background: #fef2f2;
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 18px;
            font-size: 14px;
            border: 1px solid #fecaca;
        }

        .link {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #64748b;
        }

        .link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
            transition: color 0.2s;
        }

        .link a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Responsif untuk HP */
        @media (max-width: 480px) {
            .card {
                padding: 30px 25px;
            }
            .brand {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <!-- BRAND -->
        <div class="brand">Kez iStore</div>
        <div class="subtitle">Sistem Penjualan Modern & Terpercaya</div>
        <h2>Masuk ke Akun</h2>

        @if(session('error'))
            <div class="error">
                <i class="fa fa-exclamation-circle me-1"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.proses') }}" method="POST">
        @csrf

            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>

            <div class="input-group password-wrapper">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Masukkan Password" required>

                <!-- ICON MATA -->
                <span class="toggle" onclick="togglePass()">
                    <i class="fa fa-eye" id="eyeIcon"></i>
                </span>
            </div>

            <button type="submit" class="btn">
                <i class="fa fa-sign-in-alt me-1"></i> Masuk Sekarang
            </button>
        </form>

        <div class="link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar di sini</a>
        </div>

    </div>
</div>

<script>
function togglePass() {
    let input = document.getElementById('password');
    let icon = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>