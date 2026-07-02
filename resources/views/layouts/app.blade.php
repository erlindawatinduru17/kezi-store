<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kez iStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font & Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #eef2f7;
        }

        /* ============= NAVBAR ============= */
        .navbar {
            position: fixed;
            left: 260px;
            right: 0;
            top: 0;
            height: 60px;
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            transition: left 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            z-index: 999;
        }

        .navbar.mini {
            left: 70px;
        }

        .toggle-btn {
            font-size: 20px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            transition: 0.2s;
        }

        .toggle-btn:hover {
            background: #f1f5f9;
        }

        /* ============= KONTEN UTAMA ============= */
        .content {
            margin-left: 260px;
            margin-top: 60px;
            min-height: calc(100vh - 60px);
            transition: all 0.3s ease;
            padding: 20px;
        }

        .content.mini {
            margin-left: 70px;
        }

        /* ============= MENU PROFIL ============= */
        .profile-menu {
            position: relative;
        }

        .profile-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .profile-btn:hover {
            background: #f1f5f9;
        }

        .profile-btn img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            min-width: 170px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .profile-dropdown a,
        .profile-dropdown button {
            display: block;
            padding: 12px 15px;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            text-decoration: none;
            color: #333333;
        }

        .profile-dropdown a:hover,
        .profile-dropdown button:hover {
            background: #f1f5f9;
        }

        /* ============= RESPONSIF UNTUK HP ============= */
        @media (max-width: 768px) {
            .navbar {
                left: 0 !important;
            }
            .content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('components.sidebar')

        <div class="navbar" id="navbar">
            <!-- Tombol Hamburger -->
            <div class="toggle-btn" onclick="ubahStatusSidebar()">
                <i class="fa-solid fa-bars"></i>
            </div>

            <div class="profile-menu">
                <button class="profile-btn" onclick="tampilkanProfil()">
                    <img src="{{ Auth::user()->foto_url ?? asset('images/default-user.png') }}">
                    <span>{{ Auth::user()->nama }}</span>
                </button>
                <div id="menuProfil" class="profile-dropdown">
                    <a href="{{ route('profile.index') }}"><i class="fa fa-user"></i> Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="color:red;">
                            <i class="fa fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="content" id="kontenUtama">
            @yield('content')
        </div>
    </div>

    <script>
        // FUNGSI UTAMA: BUKA / MODE MINI (IKON SAJA)
        function ubahStatusSidebar() {
            const sidebar = document.getElementById('sidebar');
            const navbar = document.getElementById('navbar');
            const konten = document.getElementById('kontenUtama');

            if (window.innerWidth <= 768) {
                // Untuk HP: sembunyikan penuh
                sidebar.classList.toggle('buka');
            } else {
                // Untuk Desktop: mode ikon saja
                sidebar.classList.toggle('mini');
                navbar.classList.toggle('mini');
                konten.classList.toggle('mini');
            }
        }

        // Tutup sidebar jika klik di luar area saat di HP
        window.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const tombol = document.querySelector('.toggle-btn');
            if (!sidebar.contains(e.target) && !tombol.contains(e.target) && window.innerWidth <= 768) {
                sidebar.classList.remove('buka');
            }
        });

        // Fungsi menu profil
        function tampilkanProfil() {
            const menu = document.getElementById('menuProfil');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        window.onclick = function(e) {
            if (!e.target.closest('.profile-menu')) {
                document.getElementById('menuProfil').style.display = 'none';
            }
        };

        // Fungsi buka/tutup dropdown menu + putar ikon panah
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                this.nextElementSibling.classList.toggle('show');
                const icon = this.querySelector('i:last-child');
                if (icon) {
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                }
            });
        });

        // Tandai menu yang sedang aktif
        document.querySelectorAll('.menu a').forEach(link => {
            if (window.location.href.includes(link.getAttribute('href'))) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>