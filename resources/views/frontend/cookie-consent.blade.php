@php
    $cookieEnabled = !isset($websiteSettings) || (bool) ($websiteSettings->AktifkanCookieConsent ?? true);
    $privacyUrl = !empty($websiteSettings?->TautanKebijakanPrivasi)
        ? $websiteSettings->TautanKebijakanPrivasi
        : url(app()->getLocale() . '/kebijakan-privasi');
    $customText = $websiteSettings?->TeksCookieConsent;
@endphp

@if ($cookieEnabled)
    <div id="cookieConsent" class="fixed bottom-0 inset-x-0 z-[9999] hidden">
        <div class="container mx-auto px-4 pb-4">
            <div
                class="bg-white rounded-xl shadow-2xl border border-slate-200 p-5 md:p-6
                        flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1 flex gap-4 items-start">
                    <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-cookie-bite text-brand-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 mb-1">{{ __('Cookie Notice') }}</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            @if (!empty($customText))
                                {{ $customText }}
                            @else
                                {{ __('We use cookies to improve your browsing experience and analyze site traffic.') }}
                            @endif
                            <a href="{{ $privacyUrl }}"
                                class="text-brand-600 font-semibold hover:underline ml-1">{{ __('Privacy Policy') }}</a>
                        </p>
                    </div>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <button id="btnRejectCookies"
                        class="px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                        {{ __('Reject') }}
                    </button>
                    <button id="btnAcceptCookies"
                        class="px-5 py-2.5 bg-brand-600 text-white rounded-lg text-sm font-semibold hover:bg-brand-700 transition-colors">
                        {{ __('Accept') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const NAME = 'cookie_consent';
            const DAYS = 365;
            const get = n => (document.cookie.match('(^| )' + n + '=([^;]+)') || [])[2] || null;
            const set = (n, v) => {
                const d = new Date();
                d.setTime(d.getTime() + DAYS * 864e5);
                document.cookie = n + '=' + v + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
            };
            const banner = document.getElementById('cookieConsent');
            const consent = get(NAME);

            if (!consent) {
                setTimeout(() => {
                    if (banner) banner.classList.remove('hidden');
                }, 600);
            } else if (consent === 'accepted') {
                window.dispatchEvent(new Event('cookie-consent:accepted'));
            }

            const btnAccept = document.getElementById('btnAcceptCookies');
            if (btnAccept) {
                btnAccept.onclick = () => {
                    set(NAME, 'accepted');
                    if (banner) banner.classList.add('hidden');
                    window.dispatchEvent(new Event('cookie-consent:accepted'));
                };
            }

            const btnReject = document.getElementById('btnRejectCookies');
            if (btnReject) {
                btnReject.onclick = () => {
                    set(NAME, 'rejected');
                    if (banner) banner.classList.add('hidden');
                };
            }
        })();
    </script>
@endif

{{-- Google Analytics conditional loader (hanya jika consent disetujui atau cookie consent dimatikan di CMS) --}}
@if (!empty($websiteSettings?->IdGoogleAnalytics))
    <script>
        (function() {
            const gaId = "{{ $websiteSettings->IdGoogleAnalytics }}";
            const cookieEnabled = {{ $cookieEnabled ? 'true' : 'false' }};
            const getConsent = () => (document.cookie.match('(^| )cookie_consent=([^;]+)') || [])[2] || null;

            function initGA() {
                if (window.__gaLoaded) return;
                window.__gaLoaded = true;
                const s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=' + gaId;
                document.head.appendChild(s);

                window.dataLayer = window.dataLayer || [];
                function gtag(){ dataLayer.push(arguments); }
                gtag('js', new Date());
                gtag('config', gaId);
            }

            if (!cookieEnabled || getConsent() === 'accepted') {
                initGA();
            } else {
                window.addEventListener('cookie-consent:accepted', initGA);
            }
        })();
    </script>
@endif
