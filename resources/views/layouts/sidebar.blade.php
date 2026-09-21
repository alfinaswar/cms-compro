            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('') }}assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $websiteSettings->NamaPerusahaan ?? '-' }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- --- Informasi Publik --- -->
                        <li class="nav-header">Informasi Publik</li>

                        <!-- Berita & Solusi -->
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'berita' || request()->segment(1) == 'halaman-solusi' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(1) == 'berita' || request()->segment(1) == 'halaman-solusi' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Berita & Solusi
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('berita.index') }}" class="nav-link {{ request()->segment(1) == 'berita' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Blog / Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('halaman-solusi.index') }}" class="nav-link {{ request()->segment(1) == 'halaman-solusi' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Halaman Solusi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Jenis Laporan / Investor -->
                        <li class="nav-item">
                            <a href="{{ route('jenis-laporan.index') }}" class="nav-link {{ request()->segment(1) == 'jenis-laporan' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Jenis Laporan Keuangan</p>
                            </a>
                        </li>

                        <!-- Kontak Masuk -->
                        <li class="nav-item">
                            <a href="{{ route('contact.list') }}" class="nav-link {{ request()->segment(1) == 'contact' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Contact Masuk</p>
                            </a>
                        </li>

                        <!-- --- Karir & SDM --- -->
                        <li class="nav-header">SDM & Karir</li>
                        <li class="nav-item">
                            <a href="{{ route('karir.index') }}" class="nav-link {{ request()->segment(1) == 'karir-dan-rekrutmen' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Karir & Rekrutmen</p>
                            </a>
                        </li>

                        <!-- Akun & Roles -->
                        <li class="nav-header">Manajemen Akun</li>
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'manajemen-akun' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(1) == 'manajemen-akun' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Manajemen Akun
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->segment(2) == 'users' ? 'active' : '' }}">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->segment(2) == 'roles' ? 'active' : '' }}">
                                        <i class="fas fa-user-shield nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- --- Master Data --- -->
                        <li class="nav-header">Data Master</li>
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'data-master' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(1) == 'data-master' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Data Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('kategori-berita.index') }}" class="nav-link {{ request()->segment(2) == 'kategori-berita' ? 'active' : '' }}">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Kategori Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('master-kantor.index') }}" class="nav-link {{ request()->segment(2) == 'master-kantor' ? 'active' : '' }}">
                                        <i class="fas fa-building nav-icon"></i>
                                        <p>Master Kantor</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- --- Website & Konten --- -->
                        <li class="nav-header">Pengaturan & Konten Website</li>
                        <li class="nav-item has-treeview {{ request()->segment(2) == 'pengaturan-website' || request()->segment(2) == 'pages' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(2) == 'pengaturan-website' || request()->segment(2) == 'pages' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Pengaturan Website
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pengaturan-website.edit') }}" class="nav-link {{ request()->segment(2) == 'pengaturan-website' ? 'active' : '' }}">
                                        <i class="fas fa-cog nav-icon"></i>
                                        <p>Pengaturan Website</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'landing-page' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(1) == 'landing-page' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Landing Page
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('hero-slider.index') }}" class="nav-link {{ request()->segment(2) == 'hero' ? 'active' : '' }}">
                                        <i class="fas fa-image nav-icon"></i>
                                        <p>Hero</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengaturan-key-figure.index') }}" class="nav-link {{ request()->segment(2) == 'key-figures' ? 'active' : '' }}">
                                        <i class="fas fa-chart-bar nav-icon"></i>
                                        <p>Key Figures</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('why-choose-us.index') }}" class="nav-link {{ request()->segment(2) == 'why-choose-us' ? 'active' : '' }}">
                                        <i class="fas fa-star nav-icon"></i>
                                        <p>Why Choose Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ request()->segment(2) == 'logo-sertifikasi' ? 'active' : '' }}">
                                        <i class="fas fa-certificate nav-icon"></i>
                                        <p>Logo Sertifikasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('client-logo.index') }}" class="nav-link {{ request()->segment(4) == 'halaman-solusi' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Logo Klien</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('about-us.index') }}" class="nav-link {{ request()->segment(2) == 'about-us' ? 'active' : '' }}">
                                        <i class="fas fa-info-circle nav-icon"></i>
                                        <p>About Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('struktur-organisasi.index') }}" class="nav-link {{ request()->segment(1) == 'struktur-organisasi' ? 'active' : '' }}">
                                        <i class="fas fa-sitemap nav-icon"></i>
                                        <p>Struktur Organisasi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{ request()->segment(1) == 'menu' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->segment(1) == 'menu' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>
                                    Menu
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('menu.index') }}" class="nav-link {{ request()->segment(1) == 'menu' && request()->segment(2) == null ? 'active' : '' }}">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Menu List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- --- Other --- -->
                        <li class="nav-header">Lainnya</li>
                        <li class="nav-item">
                            <a href="{{ route('log.index') }}" class="nav-link {{ request()->segment(2) == 'activity-log' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Log Aktifitas</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
