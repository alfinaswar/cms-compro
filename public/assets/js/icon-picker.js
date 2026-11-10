(function ($) {
    'use strict';

    // Katalog icon FontAwesome 6 (plus keyword ID/EN untuk pencarian)
    var ICONS = [
        // Keamanan & Verifikasi
        ['fa-solid fa-shield-halved', 'security shield aman keamanan perisai protection'],
        ['fa-solid fa-shield', 'security shield aman protection'],
        ['fa-solid fa-user-shield', 'user security admin role guard'],
        ['fa-solid fa-file-shield', 'document file security aman dokumen'],
        ['fa-solid fa-lock', 'lock security kunci tertutup gembok'],
        ['fa-solid fa-unlock-keyhole', 'unlock open buka kunci'],
        ['fa-solid fa-key', 'key kunci access akses'],
        ['fa-solid fa-fingerprint', 'fingerprint biometrik sidik jari forensic'],
        ['fa-solid fa-qrcode', 'qr barcode scan track trace'],
        ['fa-solid fa-barcode', 'barcode scan produk serial'],
        ['fa-regular fa-eye', 'eye lihat kasat mata overt view'],
        ['fa-solid fa-eye', 'eye lihat view visible'],
        ['fa-solid fa-eye-slash', 'hidden sembunyi covert'],
        ['fa-solid fa-magnifying-glass', 'search cari kaca pembesar inspect'],
        ['fa-solid fa-microscope', 'microscope lab forensik teliti'],
        ['fa-solid fa-sliders', 'sliders filter kontrol semi-covert'],
        ['fa-solid fa-certificate', 'certificate sertifikat resmi iso'],
        ['fa-solid fa-stamp', 'stamp stempel segel resmi'],
        ['fa-solid fa-passport', 'passport paspor imigrasi dokumen'],
        ['fa-solid fa-id-card', 'id card ktp kartu identitas'],
        ['fa-solid fa-credit-card', 'credit card kartu pembayaran chip'],
        ['fa-regular fa-credit-card', 'credit card payment kartu'],
        ['fa-solid fa-address-card', 'card identitas member profil'],
        ['fa-solid fa-sim-card', 'sim card chip smartcard'],
        ['fa-solid fa-microchip', 'chip microchip teknologi rfid nfc'],
        ['fa-solid fa-memory', 'memory hardware elektronik'],
        ['fa-solid fa-server', 'server infrastruktur data center'],
        ['fa-solid fa-database', 'database data penyimpanan'],
        ['fa-solid fa-cloud', 'cloud awan digital'],
        ['fa-solid fa-cloud-arrow-up', 'cloud upload backup'],
        ['fa-solid fa-network-wired', 'network jaringan sistem'],
        ['fa-solid fa-wifi', 'wifi wireless koneksi nfc'],
        ['fa-solid fa-tower-broadcast', 'signal sinyal transmisi'],
        ['fa-solid fa-satellite-dish', 'satellite komunikasi'],

        // Bisnis, Metrik & Korporat
        ['fa-solid fa-chart-line', 'chart grafik pertumbuhan naik'],
        ['fa-solid fa-chart-simple', 'chart bar statistik metrik'],
        ['fa-solid fa-chart-pie', 'chart pie persentase data'],
        ['fa-solid fa-chart-column', 'chart column laporan keuangan'],
        ['fa-solid fa-arrow-trend-up', 'trend growth naik performa'],
        ['fa-solid fa-trophy', 'trophy piala juara penghargaan'],
        ['fa-solid fa-award', 'award penghargaan prestasi'],
        ['fa-solid fa-medal', 'medal medali kualitas'],
        ['fa-solid fa-star', 'star bintang unggulan rating'],
        ['fa-regular fa-star', 'star bintang favorit'],
        ['fa-solid fa-gem', 'gem permata nilai value kualitas'],
        ['fa-regular fa-gem', 'gem permata nilai value'],
        ['fa-solid fa-crown', 'crown mahkota pemimpin leader'],
        ['fa-solid fa-thumbs-up', 'thumbs up jempol bagus setuju'],
        ['fa-regular fa-thumbs-up', 'thumbs up bagus'],
        ['fa-solid fa-handshake', 'handshake kerjasama mitra kolaborasi'],
        ['fa-regular fa-handshake', 'handshake kerjasama mitra'],
        ['fa-solid fa-briefcase', 'briefcase bisnis kerja karir kantor'],
        ['fa-solid fa-building', 'building gedung kantor perusahaan'],
        ['fa-regular fa-building', 'building gedung kantor'],
        ['fa-solid fa-industry', 'industry pabrik manufaktur produksi'],
        ['fa-solid fa-city', 'city kota korporasi'],
        ['fa-solid fa-landmark', 'landmark pemerintah institusi bank'],
        ['fa-solid fa-store', 'store toko cabang'],
        ['fa-solid fa-warehouse', 'warehouse gudang logistik'],
        ['fa-solid fa-globe', 'globe dunia global internasional'],
        ['fa-solid fa-earth-asia', 'earth asia dunia indonesia'],
        ['fa-solid fa-map-location-dot', 'map lokasi peta alamat'],
        ['fa-solid fa-location-dot', 'pin lokasi alamat kantor'],
        ['fa-solid fa-compass', 'compass arah navigasi visi'],
        ['fa-solid fa-flag', 'flag bendera target pencapaian'],

        // SDM, Komunikasi & Layanan
        ['fa-solid fa-users', 'users orang tim karyawan pelanggan'],
        ['fa-solid fa-user-group', 'team grup kolaborasi'],
        ['fa-solid fa-user-tie', 'executive direksi manajemen profesional'],
        ['fa-solid fa-user-check', 'verified user terpercaya'],
        ['fa-solid fa-user-gear', 'user setting ahli teknis'],
        ['fa-solid fa-people-group', 'community tim bersama'],
        ['fa-solid fa-headset', 'support layanan cs bantuan'],
        ['fa-solid fa-comments', 'chat diskusi komunikasi'],
        ['fa-regular fa-comments', 'chat pesan'],
        ['fa-solid fa-phone', 'phone telepon kontak'],
        ['fa-solid fa-envelope', 'email surat pesan kontak'],
        ['fa-regular fa-envelope', 'email pesan'],
        ['fa-solid fa-paper-plane', 'send kirim pesan'],

        // Operasional, Teknologi & Inovasi
        ['fa-solid fa-gears', 'gears mesin proses sistem'],
        ['fa-solid fa-gear', 'gear pengaturan konfigurasi'],
        ['fa-solid fa-wrench', 'wrench alat perbaikan'],
        ['fa-solid fa-screwdriver-wrench', 'tools teknis pemeliharaan'],
        ['fa-solid fa-print', 'print cetak percetakan dokumen'],
        ['fa-solid fa-layer-group', 'layer lapis tier tumpuk'],
        ['fa-solid fa-cubes', 'cubes modul komponen solusi'],
        ['fa-solid fa-cube', 'cube produk komponen'],
        ['fa-solid fa-box', 'box paket produk'],
        ['fa-solid fa-boxes-stacked', 'inventory logistik stok'],
        ['fa-solid fa-truck', 'truck pengiriman distribusi'],
        ['fa-solid fa-truck-fast', 'fast delivery cepat kirim'],
        ['fa-solid fa-bolt', 'bolt cepat kilat energi efisiensi'],
        ['fa-solid fa-gauge-high', 'speed kecepatan performa'],
        ['fa-solid fa-stopwatch', 'timer tepat waktu cepat'],
        ['fa-solid fa-clock', 'clock waktu jam sejarah'],
        ['fa-regular fa-clock', 'clock waktu'],
        ['fa-solid fa-calendar-check', 'schedule jadwal tahun'],
        ['fa-regular fa-calendar-days', 'calendar tanggal agenda'],
        ['fa-solid fa-infinity', 'infinity berkelanjutan seamless'],
        ['fa-solid fa-arrows-rotate', 'sync siklus proses ulang'],
        ['fa-solid fa-rocket', 'rocket peluncuran inovasi maju'],
        ['fa-solid fa-lightbulb', 'idea inovasi solusi cerdas'],
        ['fa-regular fa-lightbulb', 'idea lampu inovasi'],
        ['fa-solid fa-wand-magic-sparkles', 'sparkle kualitas desain'],
        ['fa-solid fa-palette', 'design warna cetak'],
        ['fa-solid fa-pen-nib', 'design tinta presisi'],
        ['fa-solid fa-code', 'code software developer'],
        ['fa-solid fa-laptop-code', 'laptop sistem digital'],
        ['fa-solid fa-mobile-screen-button', 'mobile hp aplikasi'],
        ['fa-solid fa-desktop', 'desktop komputer monitor'],

        // Dokumen, Keuangan & Legal
        ['fa-solid fa-file-contract', 'contract kontrak perjanjian legal'],
        ['fa-solid fa-file-invoice', 'invoice tagihan dokumen'],
        ['fa-solid fa-file-invoice-dollar', 'keuangan laporan finansial'],
        ['fa-solid fa-file-lines', 'document artikel teks laporan'],
        ['fa-regular fa-file-lines', 'document catatan'],
        ['fa-solid fa-file-pdf', 'pdf dokumen unduh'],
        ['fa-regular fa-file-pdf', 'pdf file'],
        ['fa-solid fa-file-signature', 'signature tanda tangan legal'],
        ['fa-solid fa-folder-open', 'folder arsip berkas'],
        ['fa-solid fa-book', 'book buku panduan'],
        ['fa-solid fa-scale-balanced', 'tata kelola governance hukum adil'],
        ['fa-solid fa-gavel', 'legal kepatuhan aturan'],
        ['fa-solid fa-coins', 'coins uang keuangan'],
        ['fa-solid fa-money-bill-wave', 'money uang kertas sekuriti'],
        ['fa-solid fa-wallet', 'wallet dompet pembayaran'],
        ['fa-solid fa-piggy-bank', 'saving investasi'],
        ['fa-solid fa-vault', 'vault brankas simpan aman'],
        ['fa-solid fa-percent', 'percent diskon rasio'],

        // Navigasi, UI & CSR
        ['fa-solid fa-house', 'home beranda utama menu'],
        ['fa-solid fa-bars', 'menu navigasi daftar'],
        ['fa-solid fa-circle-info', 'info informasi tentang'],
        ['fa-solid fa-circle-question', 'faq tanya bantuan'],
        ['fa-regular fa-circle-question', 'faq help tanya'],
        ['fa-solid fa-circle-check', 'check sukses terverifikasi'],
        ['fa-regular fa-circle-check', 'check valid'],
        ['fa-solid fa-check-double', 'double check terjamin'],
        ['fa-solid fa-check', 'check centang ya'],
        ['fa-solid fa-newspaper', 'news berita artikel media'],
        ['fa-regular fa-newspaper', 'news berita'],
        ['fa-solid fa-bullhorn', 'announcement pengumuman info'],
        ['fa-solid fa-bell', 'notification pengingat'],
        ['fa-solid fa-bookmark', 'bookmark tanda penting'],
        ['fa-solid fa-tag', 'tag label kategori'],
        ['fa-solid fa-tags', 'tags label'],
        ['fa-solid fa-link', 'link tautan url'],
        ['fa-solid fa-share-nodes', 'share bagi'],
        ['fa-solid fa-download', 'download unduh'],
        ['fa-solid fa-upload', 'upload unggah'],
        ['fa-solid fa-leaf', 'leaf lingkungan hijau esg'],
        ['fa-solid fa-seedling', 'tumbuh csr berkelanjutan'],
        ['fa-solid fa-recycle', 'recycle daur ulang ramah lingkungan'],
        ['fa-solid fa-heart', 'heart peduli csr sosial'],
        ['fa-regular fa-heart', 'heart suka'],
        ['fa-solid fa-hand-holding-heart', 'csr sosial peduli masyarakat'],
        ['fa-solid fa-hands-holding-circle', 'community perlindungan'],
        ['fa-solid fa-graduation-cap', 'education pelatihan sdm'],
        ['fa-solid fa-sitemap', 'struktur organisasi hierarki'],
        ['fa-solid fa-diagram-project', 'alur proses integrasi'],

        // Brand / Sosial Media
        ['fa-brands fa-whatsapp', 'whatsapp chat wa brand'],
        ['fa-brands fa-linkedin', 'linkedin sosial brand'],
        ['fa-brands fa-instagram', 'instagram ig sosial brand'],
        ['fa-brands fa-facebook', 'facebook fb sosial brand'],
        ['fa-brands fa-x-twitter', 'twitter x sosial brand'],
        ['fa-brands fa-youtube', 'youtube video brand'],
        ['fa-brands fa-tiktok', 'tiktok sosial brand'],
        ['fa-brands fa-github', 'github code brand'],
        ['fa-brands fa-google', 'google brand']
    ];

    function isFontAwesomeClass(val) {
        if (!val) return false;
        val = String(val).trim();
        if (!val || val.indexOf('/') !== -1 || /\.(png|jpe?g|svg|webp|gif|ico)(\?.*)?$/i.test(val)) {
            return false;
        }
        return /^(?:fa[srbltd]?|fa-(?:solid|regular|brands|light|thin|duotone))\s+fa-[a-z0-9-]+|^fa-[a-z0-9-]+/i.test(val);
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function refreshPreview($group) {
        var $input = $group.find('.fa-icon-picker-input');
        var $preview = $group.find('.fa-icon-picker-preview');
        var $clear = $group.find('.fa-icon-picker-clear');
        var val = $.trim($input.val() || '');
        var storageBase = $group.data('storage-base') || '/storage/';

        if (isFontAwesomeClass(val)) {
            $preview.html('<i class="' + escapeHtml(val) + '"></i>');
        } else if (val !== '' && (val.indexOf('/') !== -1 || /\.(png|jpe?g|svg|webp|gif|ico)$/i.test(val))) {
            $preview.html('<img src="' + escapeHtml(storageBase + val.replace(/^\/+/, '')) + '" alt="Icon">');
        } else {
            $preview.html('<i class="fa-regular fa-face-smile text-muted fa-icon-picker-placeholder"></i>');
        }

        if ($clear.length) {
            if (val !== '') {
                $clear.show();
            } else {
                $clear.hide();
            }
        }
    }

    window.refreshIconPickerPreview = function (inputEl) {
        var $group = $(inputEl).closest('.fa-icon-picker-group');
        if ($group.length) {
            refreshPreview($group);
        }
    };

    var $popover = null;
    var $activeGroup = null;

    function ensurePopover() {
        if ($popover) return $popover;

        $popover = $(
            '<div class="fa-icon-picker-popover" role="dialog" aria-label="Pilih Icon FontAwesome">' +
                '<div class="fa-icon-picker-search">' +
                    '<input type="text" class="form-control form-control-sm fa-icon-picker-filter" placeholder="Type to filter... (mis: shield, user, eye)">' +
                '</div>' +
                '<div class="fa-icon-picker-grid"></div>' +
                '<div class="fa-icon-picker-footer">' +
                    '<span class="fa-icon-picker-selected-label">Pilih atau ketik class FA</span>' +
                    '<button type="button" class="btn btn-link btn-sm p-0 text-muted fa-icon-picker-close">Tutup</button>' +
                '</div>' +
            '</div>'
        );

        $('body').append($popover);

        $popover.on('input', '.fa-icon-picker-filter', function () {
            renderGrid($(this).val());
        });

        $popover.on('keydown', '.fa-icon-picker-filter', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var $first = $popover.find('.fa-icon-picker-item').first();
                if ($first.length) {
                    $first.trigger('click');
                }
            } else if (e.key === 'Escape') {
                closePopover();
            }
        });

        $popover.on('click', '.fa-icon-picker-item', function () {
            if (!$activeGroup) return;
            var iconClass = $(this).data('icon');
            var $input = $activeGroup.find('.fa-icon-picker-input');
            $input.val(iconClass).trigger('input').trigger('change');
            closePopover();
        });

        $popover.on('click', '.fa-icon-picker-close', function () {
            closePopover();
        });

        return $popover;
    }

    function renderGrid(query) {
        var q = $.trim((query || '').toLowerCase());
        var currentVal = $activeGroup ? $.trim($activeGroup.find('.fa-icon-picker-input').val() || '') : '';
        var html = '';
        var count = 0;

        for (var i = 0; i < ICONS.length; i++) {
            var cls = ICONS[i][0];
            var keys = ICONS[i][1];
            if (q && cls.toLowerCase().indexOf(q) === -1 && keys.indexOf(q) === -1) {
                continue;
            }
            var isActive = currentVal === cls ? ' active' : '';
            html += '<button type="button" class="fa-icon-picker-item' + isActive + '" data-icon="' + cls + '" title="' + cls + '">' +
                '<i class="' + cls + '"></i>' +
            '</button>';
            count++;
        }

        if (count === 0) {
            html = '<div class="fa-icon-picker-empty">Tidak ditemukan. Anda tetap bisa mengetik class FA manual (mis. <code>fa-solid fa-star</code>).</div>';
        }

        $popover.find('.fa-icon-picker-grid').html(html);
        $popover.find('.fa-icon-picker-selected-label').text(currentVal || (count + ' icon tersedia'));
    }

    function positionPopover($group) {
        if (!$popover || !$group || !$group.length) return;
        var rect = $group[0].getBoundingClientRect();
        var popW = Math.min(310, window.innerWidth - 24);
        var popH = 318;
        var left = rect.left;
        if (left + popW > window.innerWidth - 12) {
            left = Math.max(12, window.innerWidth - popW - 12);
        }
        var top = rect.bottom + 4;
        if (top + popH > window.innerHeight - 12 && rect.top > popH + 8) {
            top = rect.top - popH - 4;
        }
        $popover.css({
            width: popW + 'px',
            left: left + 'px',
            top: top + 'px'
        });
    }

    function openPopover($group) {
        ensurePopover();
        $activeGroup = $group;
        $popover.find('.fa-icon-picker-filter').val('');
        renderGrid('');
        $popover.addClass('is-open');
        positionPopover($group);
        setTimeout(function () {
            $popover.find('.fa-icon-picker-filter').trigger('focus');
        }, 10);
    }

    function closePopover() {
        if ($popover) {
            $popover.removeClass('is-open');
        }
        $activeGroup = null;
    }

    $(document).on('click', '.fa-icon-picker-toggle, .fa-icon-picker-preview', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $group = $(this).closest('.fa-icon-picker-group');
        if ($popover && $popover.hasClass('is-open') && $activeGroup && $activeGroup[0] === $group[0]) {
            closePopover();
        } else {
            openPopover($group);
        }
    });

    $(document).on('focus', '.fa-icon-picker-input', function () {
        var $group = $(this).closest('.fa-icon-picker-group');
        if (!$popover || !$popover.hasClass('is-open') || !$activeGroup || $activeGroup[0] !== $group[0]) {
            ensurePopover();
            $activeGroup = $group;
            $popover.find('.fa-icon-picker-filter').val('');
            renderGrid('');
            $popover.addClass('is-open');
            positionPopover($group);
        }
    });

    $(document).on('click', '.fa-icon-picker-clear', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $group = $(this).closest('.fa-icon-picker-group');
        var $input = $group.find('.fa-icon-picker-input');
        $input.val('').trigger('input').trigger('change');
        if ($popover && $popover.hasClass('is-open') && $activeGroup && $activeGroup[0] === $group[0]) {
            renderGrid($popover.find('.fa-icon-picker-filter').val());
        }
    });

    $(document).on('input change', '.fa-icon-picker-input', function () {
        var $group = $(this).closest('.fa-icon-picker-group');
        refreshPreview($group);
        if ($popover && $popover.hasClass('is-open') && $activeGroup && $activeGroup[0] === $group[0]) {
            renderGrid($popover.find('.fa-icon-picker-filter').val());
        }
    });

    $(document).on('reset', 'form', function () {
        var $form = $(this);
        setTimeout(function () {
            $form.find('.fa-icon-picker-group').each(function () {
                refreshPreview($(this));
            });
        }, 0);
    });

    $(document).on('click', function (e) {
        if (!$popover || !$popover.hasClass('is-open')) return;
        if ($(e.target).closest('.fa-icon-picker-popover, .fa-icon-picker-group').length === 0) {
            closePopover();
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $popover && $popover.hasClass('is-open')) {
            closePopover();
        }
    });

    $(window).on('resize scroll', function () {
        if ($popover && $popover.hasClass('is-open') && $activeGroup) {
            if (!document.body.contains($activeGroup[0])) {
                closePopover();
            } else {
                positionPopover($activeGroup);
            }
        }
    });
})(jQuery);
