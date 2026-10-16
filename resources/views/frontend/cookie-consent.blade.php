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
                        {{ __('We use cookies to improve your browsing experience and analyze site traffic.') }}
                        <a href="{{ url(app()->getLocale() . '/kebijakan-privasi') }}"
                            class="text-brand-600 font-semibold hover:underline">{{ __('Privacy Policy') }}</a>
                    </p>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <button id="btnRejectCookies"
                    class="px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    {{ __('Reject') }}
                </button>
                <button id="btnAcceptCookies"
                    class="px-5 py-2.5 bg-brand-600 text-white rounded-lg text-sm font-semibold hover:bg-brand-700">
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
            setTimeout(() => banner.classList.remove('hidden'), 600);
        } else if (consent === 'accepted') {
            window.dispatchEvent(new Event('cookie-consent:accepted'));
        }

        document.getElementById('btnAcceptCookies').onclick = () => {
            set(NAME, 'accepted');
            banner.classList.add('hidden');
            window.dispatchEvent(new Event('cookie-consent:accepted'));
        };

        document.getElementById('btnRejectCookies').onclick = () => {
            set(NAME, 'rejected');
            banner.classList.add('hidden');
        };
    })();
</script>
