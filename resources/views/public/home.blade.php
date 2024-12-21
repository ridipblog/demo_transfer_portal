{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title', 'Swagata Satirtha | Mutual Transfer Portal for Assam govt. grade III and  grade IV employees.')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')

    <div class="flex-grow flex px-4">
        <div class="hidden 2xl:flex items-end px-24 w-2/4">
            <!-- <img src="./assets/img/cmimg3.png" alt="" class="max-w-sm"> -->
            <img src="{{asset('/images/cmimg3.png')}}" alt="" class="fixed bottom-0 max-h-[50rem] h-[calc(100vh-145px)] z-[99] -left-0 xl:left-24">
        </div>
        <div class="flex-grow flex flex-col gap-12">
            <div class="hidden sm:grid">
                <div class="grid grid-cols-5 gap-">
                    <div class="flex flex-col gap-2">
                    </div>

                    <div class="flex flex-col gap-2 border-sky-600 border-b-2">
                        <p class="text-md flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.2')</p>
                        <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -mb-4">2</p>
                    </div>

                    <div class="flex flex-col gap-2">
                    </div>

                    {{-- <div class="flex flex-col gap-2 border-sky-600 border-b-2">
                        <p class="text-md flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.4')</p>
                        <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -mb-4">4</p>
                    </div> --}}

                    {{-- <div class="flex flex-col gap-2">
                    </div> --}}
                </div>
                <div class="grid grid-cols-5 -mt-0.5">
                    <div class="flex flex-col gap-2 border-sky-600 border-t-2">
                        <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -mt-4">1</p>
                        <p class="text-md flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.1')</p>
                    </div>

                    <div class="flex flex-col gap-2">
                    </div>

                    <div class="flex flex-col gap-2 border-sky-600 border-t-2">
                        <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -mt-4">3</p>
                        <p class="text-md flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.3')</p>
                    </div>
                    <div class="flex flex-col gap-2">
                    </div>
                    <div class="flex flex-col space-y-2 border-sky-600 border-t-2">
                        <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -mt-4">5</p>
                        <p class="text-md flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.5')</p>
                    </div>

                </div>
            </div>
            <div class="grid gap-2 sm:grid-cols-5 sm:hidden pl-4 pt-4">
                <div class="flex flex-col gap-2 border-sky-600 border-l-2 pl-4 sm:border-l-0 sm:border-t-2 pb-4">
                    <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -ml-9 -mt-3">1</p>
                    <p class="text-xs flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.1')</p>
                </div>
                <div class="flex flex-col gap-2 border-sky-600 border-l-2 pl-4 sm:border-l-0 sm:border-t-2 pb-4">
                    <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -ml-9 -mt-3">2</p>
                    <p class="text-xs flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.2')</p>
                </div>
                <div class="flex flex-col gap-2 border-sky-600 border-l-2 pl-4 sm:border-l-0 sm:border-t-2 pb-4">
                    <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -ml-9 -mt-3">3</p>
                    <p class="text-xs flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.3')</p>
                </div>
                {{-- <div class="flex flex-col gap-2 border-sky-600 border-l-2 pl-4 sm:border-l-0 sm:border-t-2 pb-4">
                    <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -ml-9 -mt-3">4</p>
                    <p class="text-xs flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.4')</p>
                </div> --}}
                <div class="flex flex-col gap-2 border-sky-600 border-l-2 pl-4 sm:border-l-0 sm:border-t-2 pb-4">
                    <p class="w-fit font-bold text-sm bg-sky-600 text-white rounded-full px-4 py-1.5 -ml-9 -mt-3">5</p>
                    <p class="text-xs flex-grow bg-neutral-100 rounded-xl p-4">@lang('home.steps.5')</p>
                </div>
            </div>
            <div class="grid lg:grid-cols-2 gap-6 lg:gap-12">
                <div class="flex h-fit">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-1 gap-6 flex-grow">
                        <a href="{{ route('userLogin',['lang' => app()->getLocale()]) }}" class="bg-sky-600 text-white rounded-lg">
                            <div class="grid gap-2 p-6">
                                <div class="">
                                    <i class="bi bi-shield-lock text-lg"></i>
                                </div>
                                <div class="">
                                    <p class="text-xl mb-2">@lang('home.cards.login.heading')</p>
                                    <p class="text-xs">@lang('home.cards.login.text')</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('register',['lang' => app()->getLocale()]) }}" class="border border-sky-500 border-r-4 border-b-4 rounded-lg">
                            <div class="grid gap-2 p-6">
                                <div class="">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </div>
                                <div class="">
                                    <p class="text-xl mb-2">@lang('home.cards.register.heading')</p>
                                    <p class="text-xs">@lang('home.cards.register.text')</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="flex-grow grid gap-12">
                    <div class="grid 2xl:grid-cols- gap-6">
                        <div class="bg-sky-100 p-6 rounded-lg hidden">
                            <p class="font-semibold mb-12 text-xl">@lang('home.notification')</p>
                            <ul class="list-disc list-outside pl-4 h-full overflow-auto">
                                <li class="py-2">
                                    <strong>System Maintenance:</strong> Scheduled maintenance on September 20th, 2024, from
                                    12:00 AM to 4:00 AM. The portal may be unavailable during this time.
                                </li>
                                <li class="py-2">
                                    <strong>New Features:</strong> A new feature to track transfer status in real-time has
                                    been added. Check your dashboard for more details.
                                </li>
                                <li class="py-2">
                                    <strong>Profile Update:</strong> Please ensure your contact information is up to date to
                                    avoid issues with verification.
                                </li>
                                <li class="py-2">
                                    <strong>Training Session:</strong> Join our upcoming training session on September 25th,
                                    2024, to learn about the new system functionalities.
                                </li>
                                <li class="py-2">
                                    <strong>Security Alert:</strong> Be cautious of phishing emails. Always verify the
                                    sender before clicking on links.
                                </li>
                            </ul>
                        </div>
                        <div class="bg-sky-100 p-6 rounded-lg">
                            <p class="font-semibold mb-12 text-xl">@lang('home.important_links')</p>
                            <ul class="list-disc list-outside pl-4 h-full overflow-auto">
                                <li class="py-2">
                                    <a href="{{asset('/docs/sop_new.pdf')}}" class="text-sky-600 font-semibold hover:underline">@lang('home.imp_links.sop') </a><br>@lang('home.imp_links.sop_txt')
                                </li>
                                <li class="py-2">
                                    <a href="#" class="text-sky-600 font-semibold hover:underline">@lang('home.imp_links.user_manual')</a><br>@lang('home.imp_links.user_manual_txt')
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- -------------- end dynamic content ---------------- --}}
