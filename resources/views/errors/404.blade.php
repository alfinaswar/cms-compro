@extends('frontend.index')

@section('content-frontend')
    <section
        class="relative min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden py-20">
        <!-- Decorative Blobs -->
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-2xl mx-auto text-center">

                <!-- 404 Visual -->
                <div class="mb-8 relative inline-block">
                    <div class="text-[120px] md:text-[180px] font-extrabold text-white/10 leading-none select-none">
                        404
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-24 h-24 md:w-32 md:h-32 bg-brand-600 rounded-full flex items-center justify-center shadow-xl shadow-brand-500/30">
                            <i class="fa-solid fa-compass text-4xl md:text-5xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Text Content -->
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                    {{ __('Page Not Found') }}
                </h1>
                <p class="text-lg md:text-xl text-slate-300 mb-8 leading-relaxed max-w-lg mx-auto">
                    {{ __('Oops! The page you are looking for does not exist.') }} <br class="hidden md:block">
                    {{ __('It might have been moved or deleted.') }}
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('frontend.main') }}"
                        class="inline-flex items-center justify-center px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-brand-500/30 w-full sm:w-auto">
                        <i class="fa-solid fa-house mr-2"></i>
                        {{ __('Go to Homepage') }}
                    </a>

                    <a href="{{ route('frontend.contact.index') }}"
                        class="inline-flex items-center justify-center px-8 py-3.5 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white hover:bg-white/20 font-bold rounded-xl transition-all duration-200 w-full sm:w-auto">
                        <i class="fa-solid fa-headset mr-2"></i>
                        {{ __('Contact Support') }}
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="mt-12 pt-8 border-t border-white/10">
                    <p class="text-sm text-slate-400 mb-4">{{ __('Or try searching for what you need:') }}</p>
                    <form action="{{ route('frontend.news') }}" method="GET" class="max-w-md mx-auto relative">
                        <input type="text" name="search" placeholder="{{ __('Search news or solutions...') }}"
                            class="w-full pl-12 pr-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-slate-400 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 bg-brand-600 text-white text-sm font-semibold rounded-lg hover:bg-brand-700 transition-colors">
                            {{ __('Search') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
