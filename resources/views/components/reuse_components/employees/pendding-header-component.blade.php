<nav class="bg-white sticky top-0 z-50">
    <div class="bg-sky-600 px-4">
        <div
            class="max-w-7xl mx-auto flex justify-between items-center lg:px-4 py-1 text-[0.625rem] lg:text-xs text-white gap-2">
            <div class="flex gap-1 lg:gap-4">
                <div class="flex gap-1"><i class="bi bi-telephone"> </i>+91 970 722 9761</div>
                <div class="flex gap-1"><i class="bi bi-at"> </i>helpdesk.swagatasatirtha@gmail.com</div>
            </div>
            <div class="">
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
            <img src="{{ asset('/images/logo.svg') }}" alt="" class="h-8 md:h-12">
            <p class="leading-4 text-2xl text-sky-600 mt-1">@lang('user.site_name')<br><small
                    class="text-xs font-medium text-black">@lang('user.site_tag')</small></p>
        </div>
        {{-- <div class="hidden lg:flex items-center gap-4 text-gray-900 text-xs md:text-base">
            <a href="{{ route('employees.dashboard', ['lang' => app()->getLocale()]) }}"
                class="border-b-2 pb-2 {{ Route::currentRouteName() === 'employees.dashboard' ? 'text-sky-600 border-sky-600' : 'border-transparent hover:text-sky-600 hover:border-sky-600' }}">@lang('user.nav_menu.dash')</a>
            <a href="{{ route('search.profile', ['lang' => app()->getLocale()]) }}"
                class=" border-b-2 transition-all duration-150 {{ Route::currentRouteName() === 'search.profile' ? 'text-sky-600 border-sky-600' : 'border-transparent hover:text-sky-600 hover:border-sky-600' }}  pb-2">@lang('user.nav_menu.apl')</a>
            <!-- <a href="#" class="border-transparent border-b-2 transition-all duration-150 hover:text-sky-600 hover:border-sky-600 pb-2">My Requests</a> -->
        </div> --}}
        <div class="flex items-center gap-4 text-gray-900">
            <div class="flex justify-end">
                <a href="{{ route('user.logout') }}" class="py-1.5 text-sm px-3 text-white bg-red-600 rounded"><i
                        class="bi bi-box-arrow-right"></i> <span class="hidden lg:block">@lang('user.nav_menu.logout')</span></a>
            </div>
            {{-- <form action="{{ route('chanage.lang')}}" method="POST">
                @csrf
                <select name="lang" onchange="this.form.submit()" class="text-xs p-1.5 pr-6 rounded-lg">
                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                    <option value="as" {{ app()->getLocale() == 'as' ? 'selected' : '' }}>অসমীয়া</option>
                    <!-- Add more languages as needed -->
                </select>
            </form> --}}
        </div>
    </div>
    <div class="bg-sky-600">
        <div class="max-w-7xl mx-auto px-4 py-1">
            <div class="flex items-center justify-center gap-4 text-white text-xs md:text-base">
                <a href="{{ route('employees.dashboard', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ Route::currentRouteName() === 'employees.dashboard' ? 'border-white' : 'border-transparent hover:border-white' }}">
                    @lang('user.nav_menu.dash')
                </a>
                |
                <a href="{{ route('search.profile', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ Route::currentRouteName() === 'search.profile' ? 'border-white' : 'border-transparent hover:border-white' }}">
                    @lang('user.nav_menu.apl')
                </a>
                |
                <a href="{{ route('transfer.history', ['lang' => app()->getLocale()]) }}"
                    class="transition-all duration-150 border-b-2 pb- {{ Route::currentRouteName() === 'transfer.history' ? 'border-white' : 'border-transparent hover:border-white' }}">
                    @lang('user.nav_menu.t_history')
                </a>
            </div>
        </div>
    </div>
    <p class="px-4 py-0.5 text-xs font-semibold text-gray-500 text-right">( This website works best on Google Chrome for a smooth experience. )</p>
</nav>

