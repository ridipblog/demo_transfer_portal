{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title', 'Registration')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')
    @if ($view_data['is_error'])
        <h1>Server error please try later </h1>
    @else
        <div class="flex-grow grid lg:grid-cols-2 px-4">
            <div
                class="h-full w-full bg-[url('{{ asset('/images/hero_bg2.png') }}')] bg-contain rounded-3xl bg-center bg-no-repeat hidden lg:block">
                <!-- <img src="../assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
            </div>
            <div class="max-w-sm mx-auto w-full flex flex-col justify-center">
                <h1 class="text-3xl">@lang('login_register.register_page.heading')</h1>
                <!-- <p class="mt-4 text-lg text-gray-900 font-medium">Enter your details to create a new account</p> -->
                <form id="register-form" class="mt-12">
                    <div class="grid gap-2">
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.register_page.input.name')</label>
                            <input type="text" name="full_name"
                                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <p class="registration-error capitalize pt-1" style="color:red"></p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.register_page.input.phone')</label>
                            <input type="tel" name="phone"
                                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <p class="registration-error capitalize pt-1" style="color:red"></p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('login_register.register_page.input.email')</label>
                            <input type="email" name="email"
                                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <p class="registration-error capitalize pt-1" style="color:red"></p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-semibold text-gray-800">@lang('login_register.register_page.input.pass')<span
                                    class="group ml-2 relative"><i class="bi bi-info-circle text-xs"></i><span
                                        class="w-44 p-2 rounded-md bg-black hidden group-hover:block absolute top-full right-0">
                                        <p class="italic text-xs text-white">@lang('login_register.register_page.input.pass_text')</p>
                                    </span></span></label>
                            <input type="password" name="password"
                                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <p class="registration-error capitalize pt-1" style="color:red"></p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-semibold text-gray-800">@lang('login_register.register_page.input.c_pass')<span
                                    class="group ml-2 relative"><i class="bi bi-info-circle text-xs"></i><span
                                        class="w-44 p-2 rounded-md bg-black hidden group-hover:block absolute top-full right-0">
                                        <p class="italic text-xs text-white">@lang('login_register.register_page.input.c_pass_text')</p>
                                    </span></span></label>
                            <input type="password" name="confirm_passowrd"
                                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <p class="registration-error capitalize pt-1" style="color:red"></p>
                        </div>
                        <div class="flex gap-3">
                            <input type="checkbox" name="terms_and_sop"
                                class="registration-input declaration-checkbox border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                            <p class="registration-error capitalize pt-1" style="color:red"></p>
                            <p class="text-xs text-gray-900">
                                @lang('login_register.register_page.input.check')
                                <a href="{{ asset('/docs/sop_new.pdf') }}" target="_blank"
                                    class="text-sky-600 underline">@lang('login_register.register_page.input.check_link')</a>
                            </p>
                        </div>
                        <p class="registration-error capitalize pt-1" style="color:red"></p>
                        <div class="flex justify-end gap-1 mt-8 mb-4">
                            <button type="submit"
                                class="bg-sky-500 disabled:bg-sky-300 hover:bg-sky-600 border border-transparent text-white rounded-full block px-3 py-1.5"
                                id="register" disabled>@lang('login_register.register_page.button')</button>
                            <!-- <button type="submit" class="bg-sky-500 disabled:bg-sky-300 hover:bg-sky-600 border border-transparent text-white rounded-full block px-3 py-1.5" id="register" disabled>Submit</button> -->
                        </div>
                        <p class="text-center text-xs">@lang('login_register.register_page.have_ac') <a
                                href="{{ route('userLogin', ['lang' => app()->getLocale()]) }}"
                                class="text-sky-500 hover:underline">@lang('login_register.register_page.login')</a></p>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

{{-- -------------- end dynamic content ---------------- --}}

{{-- ----------- start extra js links ----------------- --}}
@section('extra_js')
    <script type="module" src="{{ asset('js/public/registration.js') }}"></script>
    <script src="{{ asset('js/public/file_hanlde.js') }}"></script>
@endsection
{{-- ----------- end extra js links ----------------- --}}
