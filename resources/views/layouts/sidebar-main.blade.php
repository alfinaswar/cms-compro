<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-white">
        <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
            alt="{{ $websiteSettings->NamaPerusahaan ?? 'Logo' }}" width="230px">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ $websiteSettings->NamaPerusahaan ?? '-' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- ============================================ --}}
                {{-- NAVIGASI UTAMA --}}
                {{-- ============================================ --}}
                <li class="nav-header text-uppercase" style="font-size: 11px; letter-spacing: 1px; color: #6c757d;">
                    <i class="fas fa-compass mr-1"></i> Navigasi Utama
                </li>

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard Overview</p>
                    </a>
                </li>

                {{-- ============================================ --}}
                {{-- KOMUNIKASI & TRANSAKSI --}}
                {{-- ============================================ --}}
                <li class="nav-header text-uppercase" style="font-size: 11px; letter-spacing: 1px; color: #6c757d;">
                    <i class="fas fa-comments mr-1"></i> Komunikasi & Transaksi
                </li>

                <li class="nav-item has-treeview {{ request()->segment(1) == 'contact' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->segment(1) == 'contact' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>
                            Kontak & RFQ
                            <span class="badge badge-info right">12</span>
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('contact.list') }}"
                                class="nav-link {{ request()->segment(2) == 'list' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kotak Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('notification-email.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan Form Kontak</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ============================================ --}}
                {{-- PUBLIKASI & BERITA --}}
                {{-- ============================================ --}}
                <li class="nav-header text-uppercase" style="font-size: 11px; letter-spacing: 1px; color: #6c757d;">
                    <i class="fas fa-bullhorn mr-1"></i> Publikasi & Berita
                </li>

                <li class="nav-item has-treeview {{ request()->segment(1) == 'berita' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->segment(1) == 'berita' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            News & Artikel
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('berita.index') }}"
                                class="nav-link {{ request()->segment(2) == 'berita' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Semua Artikel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('berita.create') }}"
                                class="nav-link {{ request()->segment(2) == 'create' && request()->segment(1) == 'berita' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Artikel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori-berita.index') }}"
                                class="nav-link {{ request()->segment(2) == 'kategori-berita' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ============================================ --}}
                {{-- MANAJEMEN PORTAL & WEB --}}
                {{-- ============================================ --}}
                <li class="nav-header text-uppercase" style="font-size: 11px; letter-spacing: 1px; color: #6c757d;">
                    <i class="fas fa-globe mr-1"></i> Manajemen Portal & Web
                </li>

                {{-- Manajemen Konten --}}
                @php
                    // Cek apakah salah satu submenu Manajemen Konten sedang active (biar parent juga open)
                    $menuKontenActive =
                        in_array(request()->segment(1), ['about-us', 'halaman-solusi', 'jenis-laporan']) ||
                        request()->segment(2) == 'homepage';
                @endphp
                <li class="nav-item has-treeview {{ $menuKontenActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $menuKontenActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Manajemen Konten
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('homepage.index') }}"
                                class="nav-link {{ request()->segment(2) == 'homepage' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Homepage</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('about-us.index') }}"
                                class="nav-link {{ request()->segment(1) == 'about-us' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tentang Kami</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('halaman-solusi.index') }}"
                                class="nav-link {{ request()->segment(1) == 'halaman-solusi' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Solusi (Produk & Layanan)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jenis-laporan.index') }}"
                                class="nav-link {{ request()->segment(1) == 'jenis-laporan' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Investor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kebijakan Privasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Syarat & Ketentuan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Kelola Halaman --}}
                @php
                    // Jika nanti ada submenu yang bisa active di "Kelola Halaman", cek di sini
                    $menuHalamanActive = false;
                @endphp
                <li class="nav-item has-treeview {{ $menuHalamanActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $menuHalamanActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Kelola Halaman
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('custom-pages.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Semua Halaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Halaman</p>
                            </a>
                        </li>
                    </ul>
                </li>


                {{-- Menu & Navigasi --}}
                <li class="nav-item has-treeview {{ request()->segment(1) == 'menu' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->segment(1) == 'menu' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menu & Navigasi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('menu.index') }}"
                                class="nav-link {{ request()->segment(1) == 'menu' && !request()->segment(2) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Karir & Rekrutmen --}}
                <li class="nav-item">
                    <a href="{{ route('karir.index') }}"
                        class="nav-link {{ request()->segment(1) == 'karir' || request()->segment(1) == 'karir-dan-rekrutmen' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Karir & Rekrutmen</p>
                    </a>
                </li>

                {{-- ============================================ --}}
                {{-- SISTEM & PENGATURAN --}}
                {{-- ============================================ --}}
                <li class="nav-header text-uppercase" style="font-size: 11px; letter-spacing: 1px; color: #6c757d;">
                    <i class="fas fa-cogs mr-1"></i> Sistem & Pengaturan
                </li>

                {{-- Manajemen Akun --}}
                <li
                    class="nav-item has-treeview {{ in_array(request()->segment(1), ['users', 'roles', 'permissions']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(request()->segment(1), ['users', 'roles', 'permissions']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Manajemen Akun
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                                class="nav-link {{ request()->segment(1) == 'users' ? 'active' : '' }}">
                                <i class="fas fa-user nav-icon"></i>
                                <p>User (Pengguna)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ request()->segment(1) == 'roles' ? 'active' : '' }}">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>Role & Kapabilitas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}"
                                class="nav-link {{ request()->segment(1) == 'permissions' ? 'active' : '' }}">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Setting Sistem --}}
                <li
                    class="nav-item has-treeview {{ in_array(request()->segment(2), ['pengaturan-website', 'master-kantor']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(request()->segment(2), ['pengaturan-website', 'master-kantor']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            Setting Sistem
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('pengaturan-website.edit') }}"
                                class="nav-link {{ request()->segment(2) == 'pengaturan-website' ? 'active' : '' }}">
                                <i class="fas fa-globe nav-icon"></i>
                                <p>Pengaturan Website</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('master-kantor.index') }}"
                                class="nav-link {{ request()->segment(2) == 'master-kantor' ? 'active' : '' }}">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Informasi Kantor</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Log Aktivitas --}}
                <li class="nav-item">
                    <a href="{{ route('log.index') }}"
                        class="nav-link {{ request()->segment(2) == 'activity-log' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Log Aktivitas</p>
                    </a>
                </li>

                {{-- ============================================ --}}
                {{-- LANDING PAGE (Komponen Halaman Depan) --}}
                {{-- ============================================ --}}
                <li class="nav-header text-uppercase" style="font-size: 11px; letter-spacing: 1px; color: #6c757d;">
                    <i class="fas fa-palette mr-1"></i> Landing Page
                </li>

                <li
                    class="nav-item has-treeview {{ in_array(request()->segment(2), ['hero', 'key-figures', 'why-choose-us', 'logo-sertifikasi', 'client-logo', 'struktur-organisasi']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(request()->segment(2), ['hero', 'key-figures', 'why-choose-us', 'logo-sertifikasi', 'client-logo', 'struktur-organisasi']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Komponen Landing Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="{{ route('hero-slider.index') }}"
                                class="nav-link {{ request()->segment(2) == 'hero' ? 'active' : '' }}">
                                <i class="fas fa-image nav-icon"></i>
                                <p>Hero Slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pengaturan-key-figure.index') }}"
                                class="nav-link {{ request()->segment(2) == 'key-figures' ? 'active' : '' }}">
                                <i class="fas fa-chart-bar nav-icon"></i>
                                <p>Key Figures</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('why-choose-us.index') }}"
                                class="nav-link {{ request()->segment(2) == 'why-choose-us' ? 'active' : '' }}">
                                <i class="fas fa-star nav-icon"></i>
                                <p>Why Choose Us</p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->segment(2) == 'logo-sertifikasi' ? 'active' : '' }}">
                                <i class="fas fa-certificate nav-icon"></i>
                                <p>Logo Sertifikasi</p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="{{ route('client-logo.index') }}"
                                class="nav-link {{ request()->segment(2) == 'client-logo' ? 'active' : '' }}">
                                <i class="fas fa-handshake nav-icon"></i>
                                <p>Logo Klien</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('struktur-organisasi.index') }}"
                                class="nav-link {{ request()->segment(1) == 'struktur-organisasi' ? 'active' : '' }}">
                                <i class="fas fa-sitemap nav-icon"></i>
                                <p>Struktur Organisasi</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
