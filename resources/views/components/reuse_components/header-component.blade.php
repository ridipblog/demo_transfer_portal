<nav class="bg-white sticky top-0 z-50 mb-4">
    <div class="bg-sky-600 px-4">
        <div
            class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center lg:px-4 py-1 text-[0.625rem] lg:text-xs text-white gap-2">
            <div class="flex flex-col sm:flex-row gap-1 lg:gap-4">
                <div class="flex gap-1"><i class="bi bi-telephone"> </i>+91 970 722 9761 / 970 621 6022 / 763 690 0806 / 967 803 7963 (From 10AM to 5PM)</div>
                <div class="flex gap-1"><i class="bi bi-at"> </i>help.swagatasatirtha@gmail.com</div>
            </div>
            <div class="ml-auto">
                <form action="{{ route('chanage.lang') }}" method="POST">
                    @csrf
                    <div class="flex gap-1 lg:gap-2">
                        <button type="submit" name="lang" value="en"
                            class=" border-b {{ app()->getLocale() == 'en' ? '' : 'border-transparent' }}">English</button>
                        <button type="submit" name="lang" value="as"
                            class=" border-b {{ app()->getLocale() == 'as' ? '' : 'border-transparent' }}">অসমীয়া</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="max-w-7xl w-full mx-auto flex justify-between items-center py-3 px-4">
        <div class="font-black flex gap-2 items-center">
            <img src="{{ asset('images/logo.svg') }}" alt="" class="h-8 md:h-12">
            <p class="leading-4 text-2xl text-sky-600 mt-1">@lang('home.site_name')<br><small
                    class="text-xs font-medium text-black">@lang('home.site_tag')</small></p>
        </div>
        {{-- @if (!request()->routeIs('depertmentLogin'))
            <div class="flex items-center gap-4 text-gray-900 text-xs md:text-base">
                <a href="{{ route('home',['lang' => app()->getLocale()]) }}" class="{{request()->routeIs('home') ? 'border-b-2 border-sky-600 text-sky-600 pb-2' : 'hover:text-sky-600 hover:border-sky-600 pb-2'}}">@lang('home.nav_menu.home')</a>
                <a href="{{ route('about',['lang' => app()->getLocale()]) }}" class="transition-all duration-150 {{request()->routeIs('about') ? 'border-b-2 border-sky-600 text-sky-600 pb-2' : 'hover:text-sky-600 hover:border-sky-600 pb-2'}}">@lang('home.nav_menu.about')</a>
                <a href="{{ route('faq',['lang' => app()->getLocale()]) }}" class=" {{request()->routeIs('faq') ? 'border-b-2 border-sky-600 text-sky-600 pb-2' : 'hover:text-sky-600 hover:border-sky-600 pb-2'}} transition-all duration-150">@lang('home.nav_menu.faq')</a>
                <form action="{{ route('chanage.lang')}}" method="POST">
                    @csrf
                    <select name="lang" onchange="this.form.submit()" class="text-xs p-1.5 pr-6 rounded-lg">
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                        <option value="as" {{ app()->getLocale() == 'as' ? 'selected' : '' }}>অসমীয়া</option>
                        <!-- Add more languages as needed -->
                    </select>
                </form>
            </div>
        @endif --}}
    </div>
    <div class="bg-sky-600">
        <div class="max-w-7xl mx-auto px-4 py-1 flex gap-4 justify-between">
            <div class="flex items-center gap-4 text-white text-xs md:text-base">
                <a href="{{ route('home', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ request()->routeIs('home') ? 'border-white' : 'border-transparent hover:border-white' }}">
                    @lang('home.nav_menu.home')
                </a>
                |
                <a href="{{ route('about', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ request()->routeIs('about') ? 'border-white' : 'border-transparent hover:border-white' }}">
                    @lang('home.nav_menu.about')
                </a>
                |
                <a href="{{ route('faq', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ request()->routeIs('faq') ? 'border-white' : 'border-transparent hover:border-white' }}">
                    @lang('home.nav_menu.faq')
                </a>
            </div>
            <div class="flex items-center gap-4 text-white text-xs md:text-base">
                <a href="{{ route('verification-login', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ request()->routeIs('verification-login') ? 'border-white' : 'border-transparent hover:border-white' }}">
                    Authority Login
                </a>
            </div>
        </div>
    </div>
</nav>
