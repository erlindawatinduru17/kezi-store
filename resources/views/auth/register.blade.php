<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Kez iStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ICON Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            /* Latar belakang gambar sama seperti halaman Login */
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

        /* Kontainer utama */
        .container {
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 420px;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            padding: 35px;
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
            background: linear-gradient(90deg, #22c55e, #16a34a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            font-size: 15px;
            color: #64748b;
            margin-bottom: 25px;
        }

        h2 {
            text-align: center;
            color: #1e293b;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 15px;
            position: relative;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 14px 16px 14px 42px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 15px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
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

        /* Ikon lihat sandi */
        .toggle {
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

        .toggle:hover {
            color: #22c55e;
        }

        /* Pesan error */
        .error {
            background: #fef2f2;
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #fecaca;
        }

        /* Tombol Daftar */
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(90deg, #16a34a, #15803d);
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.4);
            transform: translateY(-2px);
        }

        /* Tautan ke halaman Login */
        .link {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #64748b;
        }

        .link a {
            color: #22c55e;
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
            transition: color 0.2s;
        }

        .link a:hover {
            color: #16a34a;
            text-decoration: underline;
        }

        /* Responsif untuk HP */
        @media (max-width: 480px) {
            .card {
                padding: 25px 20px;
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
        <h2>Daftar Akun Baru</h2>

        <!-- Tampilkan pesan error jika ada -->
        @if($errors->any())
            <div class="error">
                <i class="fa fa-exclamation-circle me-1"></i>
                @foreach($errors->all() as $err)
                    {{ $err }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.proses') }}" method="POST">
        @csrf

            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
            </div>

            <div class="input-group">
                <i class="fa fa-at"></i>
                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
            </div>

            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Buat Password" required>
                <span class="toggle" onclick="togglePass()">
                    <i class="fa fa-eye" id="eyeIcon"></i>
                </span>
            </div>

            <div class="input-group">
                <i class="fa fa-shield-alt"></i>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
                <span class="toggle" onclick="toggleConfirmPass()">
                    <i class="fa fa-eye" id="eyeIconConfirm"></i>
                </span>
            </div>

            <div class="input-group">
                <i class="fa fa-user-tag"></i>
                <select name="jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="admin" {{ old('jabatan') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('jabatan') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>

            <button type="submit" class="btn">
                <i class="fa fa-user-plus me-1"></i> Daftar Sekarang
            </button>
        </form>

        <div class="link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>
</div>

<!-- ✅ Script untuk fungsi lihat sandi -->
<script>
function togglePass() {
    const pass = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pass.type === 'password') {
        pass.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        pass.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function toggleConfirmPass() {
    const pass = document.getElementById('password_confirmation');
    const icon = document.getElementById('eyeIconConfirm');
    if (pass.type === 'password') {
        pass.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        pass.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>