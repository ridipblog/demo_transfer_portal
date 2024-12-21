@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    @php
        $locale = app()->getLocale();
    @endphp
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            {{-- {{dd($user_roles_arr)}} --}}
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">@lang('user.nav_menu.dash')</p>
                    {{-- <form action="" method="">
                        <div class="flex items-center border border-gray-300 bg-white text-gray-900 text-sm rounded-full focus:ring-sky-600 focus:border-sky-600 px-2.5 py-1">
                            <i class="bi bi-search text-gray-900 pl-2"></i>
                            <div class="flex-grow">
                                <input type="text" name="" class="disabled:bg-gray-100 block p-2.5 w-full border-none focus:ring-0 focus:border-0" placeholder="Search by PAN Number...">
                            </div>
                            <div class="col-span-2 flex justify-end">
                                <button type="" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-2 py-1.5">Search</button>
                            </div>
                        </div>
                    </form> --}}
                </div>

                {{-- verification/recommendation --}}
                @if (in_array('Appointing User', $user_roles_arr))
                    {{-- {{ dd('ere') }} --}}
                    @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing User' ||
                            in_array('Appointing Authority', $user_roles_arr))
                        <div class="tabItem" id="verification_recommendation2">
                        @else
                            <div class="tabItem hidden" id="verification_recommendation2">
                    @endif
                    <div class="grid grid-cols-5 gap-4">
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                            class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $verify_recommend->count() }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-person-exclamation text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($noc_pending) }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.recommendation_pending')</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-person-check text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($noc_completed) }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.recommended')</p>
                                </div>
                            </div>
                        </a>
                    </div>
            </div>
            @endif

            {{-- transfers --}}
            @if (in_array('Approver', $user_roles_arr))
                @if (Auth::guard('user_guard')->user()->roles->role == 'Approver')
                    <div class="tabItem" id="transfers2">
                    @else
                        <div class="tabItem hidden" id="transfers2">
                @endif
                <div class="grid grid-cols-5 gap-4">
                    <a href="/{{ $locale }}/verifier/approval-all-requests"
                        class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-inboxes text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($employees) }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                            </div>
                        </div>
                    </a>
                    <a href="/{{ $locale }}/verifier/approval-all-requests"
                        class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                    class="text-lg bi bi-exclamation-circle text-black"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($pendingTransfers) }}</p>
                                <p class="">@lang('authority_dashboard.nav.pending_transfers')</p>
                            </div>
                        </div>
                    </a>
                    <a href="/{{ $locale }}/verifier/approval-all-requests"
                        class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-person-check text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($approvedTransfers) }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.approved_transfers')</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-people text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($rejectedTransfers) }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.rejected')</p>
                            </div>
                        </div>
                    </a>
                </div>
        </div>
        @endif

        {{-- verification only --}}
        @if (in_array('Verifier', $user_roles_arr) || (in_array('Appointing User', $user_roles_arr) && count($all_users) > 0))
            @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
                <div class="tabItem" id="verification_only2">
                @else
                    <div class="tabItem hidden" id="verification_only2">
            @endif
            <div class="grid grid-cols-5 gap-4">
                <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                    class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">

                    <div class="flex gap-6">
                        <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                class="text-lg bi bi-inboxes text-sky-600"></i></div>
                        <div class="">
                            <p class="text-3xl font-bold">{{ $all_users->count() }}</p>
                            <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                    class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                    <div class="flex gap-6">
                        <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                class="text-lg bi bi-exclamation-circle text-black"></i></div>
                        <div class="">
                            <p class="text-3xl font-bold">{{ $pending_users->count() }}</p>
                            <p class="">@lang('authority_dashboard.nav.pending_profiles')</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(6)]) }}"
                    class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                    <div class="flex gap-6">
                        <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                class="text-lg bi bi-person-check text-sky-600"></i></div>
                        <div class="">
                            <p class="text-3xl font-bold">{{ $verified_profiles->count() }}</p>
                            <p class="text-gray-900">@lang('authority_dashboard.nav.verified_profiles')</p>
                        </div>
                    </div>
                </a>
            </div>
    </div>
    @endif

    {{-- recommendation only --}}
    @if (in_array('Appointing Authority', $user_roles_arr))
        @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority' && count($verify_recommend) == 0)
            <div class="tabItem" id="recommendation_only2">
            @else
                <div class="tabItem hidden" id="recommendation_only2">
        @endif
        <div class="grid grid-cols-5 gap-4">
            <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                <div class="flex gap-6">
                    <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                            class="text-lg bi bi-inboxes text-sky-600"></i></div>
                    <div class="">
                        <p class="text-3xl font-bold">{{ $all_noc->count() }}</p>
                        <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                <div class="flex gap-6">
                    <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                            class="text-lg bi bi-person-exclamation text-sky-600"></i></div>
                    <div class="">
                        <p class="text-3xl font-bold">{{ count($noc_pending) }}</p>
                        <p class="text-gray-900">@lang('authority_dashboard.nav.recommendation_pending')</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString(Auth::guard('user_guard')->user()->roles->role)]) }}"
                class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                <div class="flex gap-6">
                    <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                            class="text-lg bi bi-person-check text-sky-600"></i></div>
                    <div class="">
                        <p class="text-3xl font-bold">{{ count($noc_completed) }}</p>
                        <p class="text-gray-900">@lang('authority_dashboard.nav.recommended')</p>
                    </div>
                </div>
            </a>
        </div>
        </div>
    @endif

    </div>

    {{-- view all --}}

    {{-- approver view all --}}
    <div class="mt-12 space-y-12  hidden" id="transfer_3">
        <div class="flex items-bottom justify-between">
            <p class="text-xl">@lang('authority_dashboard.latest_requests')</p>
            <a href="{{ url($locale . '/verifier/approval-all-requests') }}"
                class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </div>

    {{-- appointing authority view all --}}
    <div class="mt-12 space-y-12  hidden" id="recommendation_3">
        <div class="flex items-bottom justify-between">
            <p class="text-xl">@lang('authority_dashboard.latest_requests')</p>
            <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Appointing Authority')]) }}"
                class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </div>

    {{-- appointing user view all --}}
    <div class="mt-12 space-y-12  hidden" id="verification_recommendation_3">
        <div class="flex items-bottom justify-between">
            <p class="text-xl">@lang('authority_dashboard.latest_requests')</p>
            <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Appointing User')]) }}"
                class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </div>


    {{-- verifier view all --}}
    <div class="mt-12 space-y-12  hidden" id="verification_3">
        <div class="flex items-bottom justify-between">
            <p class="text-xl">@lang('authority_dashboard.latest_requests')</p>
            @if (in_array('Verifier', $user_roles_arr) && !in_array('Appointing User', $user_roles_arr))
                <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Verifier')]) }}"
                    class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i
                        class="bi bi-arrow-up-right"></i></a>
            @elseif(!in_array('Verifier', $user_roles_arr) && in_array('Appointing User', $user_roles_arr))
                <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Appointing User')]) }}"
                    class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i
                        class="bi bi-arrow-up-right"></i></a>
            @endif
        </div>
    </div>

    <input type="hidden" id="role_id" value="{{ Auth::guard('user_guard')->user()->roles->role }}" />
    {{--  --}}

    {{-- tabs --}}
    <div class="text-sm font-medium text-center text-gray-900 border-b border-gray-200 mb-6">
        <ul class="flex flex-wrap -mb-px">

            @if (in_array('Verifier', $user_roles_arr) || (in_array('Appointing User', $user_roles_arr) && count($all_users) > 0))
                @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
                    <li class="me-2">
                        <button class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                            tabFor="verification_only">@lang('authority_dashboard.tab.verification')</button>
                    </li>
                @else
                    <li class="me-2">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                            tabFor="verification_only">@lang('authority_dashboard.tab.verification')</button>
                    </li>
                @endif
            @endif
            @if (in_array('Appointing Authority', $user_roles_arr) && count($verify_recommend) == 0)
                @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
                    <li class="me-2">
                        <button class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                            tabFor="recommendation_only">@lang('authority_dashboard.tab.recommendation')</button>
                    </li>
                @else
                    <li class="me-2">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                            tabFor="recommendation_only">@lang('authority_dashboard.tab.recommendation')</button>
                    </li>
                @endif
            @endif


            @if (in_array('Appointing User', $user_roles_arr))
                @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing User' ||
                        in_array('Appointing Authority', $user_roles_arr))
                    <li class="me-2">
                        <button class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                            tabFor="verification_recommendation">@lang('authority_dashboard.tab.recommendation')</button>
                    </li>
                @else
                    <li class="me-2">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                            tabFor="verification_recommendation">@lang('authority_dashboard.tab.recommendation')</button>
                    </li>
                @endif
            @endif
            @if (in_array('Approver', $user_roles_arr))
                @if (Auth::guard('user_guard')->user()->roles->role == 'Approver')
                    <li class="me-2">
                        <button class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                            tabFor="transfers">@lang('authority_dashboard.tab.transfer')</button>
                    </li>
                @else
                    <li class="me-2">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                            tabFor="transfers">@lang('authority_dashboard.tab.transfer')</button>
                    </li>
                @endif
            @endif
        </ul>
    </div>

    {{-- verification/recommendation(Appointing User) --}}
    @if (in_array('Appointing User', $user_roles_arr))
        @if (count($verify_recommend) == 0)
            @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing User')
                <div class="flex flex-col items-center justify-center table_nfDiv verification_recommendation_no_data ">
                @else
                    <div
                        class="flex flex-col items-center justify-center table_nfDiv verification_recommendation_no_data hidden">
            @endif
            <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
            <p class="text-gray-500 font-bold text-lg">@lang('authority_dashboard.table.not_found')</p>
            </div>
        @else
            @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing User' || count($verify_recommend) != 0)
                <div class="border rounded-2xl overflow-hidden bg-white tabItems" id="verification_recommendation">
                @else
                    <div class="border rounded-2xl overflow-hidden bg-white hidden tabItems"
                        id="verification_recommendation">
            @endif
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col1')</th>
                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col2')</th>
                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col3')</th>
                        <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.verification_status')</th>
                        <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.recommendation_status')</th>
                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($verify_recommend as $v)
                        @if ($i == 5)
                        @break
                    @endif
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-xs text-gray-900">
                            <div class="flex items-center">
                                <img src="{{ asset('storage/' . $v->photo_path) }}"
                                    class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                <div>
                                    <p class="font-semibold">{{ $v->full_name }} </p>
                                    <p class="text-gray-900 text-xs">{{ $v->designation_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-900">
                            {{ $v->department_name }}
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91 {{ $v->phone }}</td>
                        <td class="py-4 px-6 text-xs">
                            <div class="flex justify-center">
                                @if ($v->profile_verify_status == 1)
                                    <div
                                        class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                        Verified</div>
                                @else
                                    <div
                                        class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                        Pending</div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6 text-xs">
                            <div class="flex justify-center">
                                @if ($v->noc_generate == 1)
                                    <div
                                        class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                        Recommended</div>
                                @else
                                    <div
                                        class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                        Pending</div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6 text-xs">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Appointing User'), 'tab_recommend' => Crypt::encryptString('Yes')]) }}"
                                    class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
@endif


{{-- transfers(Approver) --}}
@if (in_array('Approver', $user_roles_arr))
    {{-- {{ dd($user_roles_arr) }} --}}
    @if (count($allTransfers) == 0)
        @if (Auth::guard('user_guard')->user()->roles->role == 'Approver')
            <div class="flex flex-col items-center justify-center table_nfDiv approval_no_data ">
            @else
                <div class="flex flex-col items-center justify-center table_nfDiv approval_no_data hidden">
        @endif
        <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 mb-4 object-center">
        <p class="text-gray-500 font-bold text-lg ">@lang('authority_dashboard.table.not_found')</p>
        </div>
    @else
        @if (Auth::guard('user_guard')->user()->roles->role == 'Approver')
            <div class="border rounded-2xl overflow-hidden bg-white tabItems" id="transfers">
            @else
                <div class="border rounded-2xl overflow-hidden bg-white hidden tabItems" id="transfers">
        @endif
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.reference_code')</th>
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.applicant_1')</th>
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.applicant_2')</th>
                    @if ($dept_count != 0)
                        <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.recommendation')</th>
                    @endif
                    <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.approval')</th>
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @php
                    $i = 0;
                @endphp
                @foreach ($allTransfers as $v)
                    @if ($i == 5)
                    @break
                @endif

                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 text-xs text-gray-900">{{ $v['transfer_ref_code'] }}</td>
                    <td class="py-4 px-6 text-xs text-gray-900">{{ $v->employee_name }}</td>
                    <td class="py-4 px-6 text-xs text-gray-900">{{ $v->target_employee_name }}</td>
                    @if ($dept_count != 0)
                        <td>
                            @if ($v->{'2nd_recommend'} == 0)
                                <div class="flex justify-center">
                                    <div
                                        class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                        Pending</div>
                                </div>
                            @else
                                <div class="flex justify-center">
                                    <div
                                        class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                        Recommended</div>
                                </div>
                            @endif
                        </td>
                    @endif
                    <td>
                        @if ($v->final_approval == 0)
                            <div class="flex justify-center">
                                <div
                                    class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                    Pending</div>
                            </div>
                        @else
                            <div class="flex justify-center">
                                <div
                                    class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                    Approved</div>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-xs">
                        <div class="flex gap-1 justify-center">

                            <a href="{{ route('verification.approver.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id)]) }}"
                                class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300">@lang('authority_dashboard.table.view_details')</a>
                        </div>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    </div>
@endif
@endif


{{-- verification(Verifier) --}}
@if (in_array('Verifier', $user_roles_arr) || (in_array('Appointing User', $user_roles_arr) && count($all_users) > 0))
@if (count($all_users) == 0)
    @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
        <div class="flex flex-col items-center justify-center table_nfDiv verification_no_data ">
        @else
            <div class="flex flex-col items-center justify-center table_nfDiv verification_no_data hidden">
    @endif
    <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
    <p class="text-gray-500 font-bold text-lg">@lang('authority_dashboard.table.not_found')</p>
    </div>
@else
    @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
        <div class="border rounded-2xl overflow-hidden bg-white tabItems" id="verification_only">
        @else
            <div class="border rounded-2xl overflow-hidden bg-white tabItems hidden" id="verification_only">
    @endif
    <table class="min-w-full bg-white">
        <thead>
            <tr class="bg-gray-100">
                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col1')</th>
                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col2')</th>
                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col3')</th>
                <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.status')</th>
                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @php
                $i = 0;
            @endphp
            @foreach ($all_users as $v)
                @if ($i == 5)
                @break
            @endif
            <tr class="hover:bg-gray-50">
                <td class="py-4 px-6 text-xs text-gray-900">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $v->photo_path) }}"
                            class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                        <div>
                            <p class="font-semibold">{{ $v->full_name }} </p>
                            <p class="text-gray-900 text-xs">{{ $v->designation_name }}</p>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6 text-xs text-gray-900">
                    {{ $v->department_name }}
                </td>
                <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91 {{ $v->phone }}</td>
                <td class="py-4 px-6 text-xs">
                    @if ($v->profile_verify_status == 0)
                        <div class="flex justify-center">
                            <div
                                class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                Pending</div>
                        </div>
                    @else
                        <div class="flex justify-center">
                            <div
                                class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                Verified</div>
                        </div>
                    @endif
                </td>
                <td class="py-4 px-6 text-xs">
                    <div class="flex justify-center gap-1">
                        @if (in_array('Verifier', $user_roles_arr) && !in_array('Appointing User', $user_roles_arr))
                            <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Verifier')]) }}"
                                class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</a>
                        @elseif (!in_array('Verifier', $user_roles_arr) && in_array('Appointing User', $user_roles_arr))
                            <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Appointing User'), 'tab_recommend' => Crypt::encryptString('No')]) }}"
                                class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</a>
                        @elseif (in_array('Verifier', $user_roles_arr))
                            <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Appointing User'), 'tab_recommend' => Crypt::encryptString('No')]) }}"
                                class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</a>
                        @endif
                    </div>
                </td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </tbody>
</table>
</div>
@endif
@endif



{{-- recommendation(Appointing authority) --}}
@if (in_array('Appointing Authority', $user_roles_arr) && count($verify_recommend) == 0)
@if (count($all_noc) == 0)
@if (Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
    <div class="flex flex-col items-center justify-center table_nfDiv recommendation_no_data ">
    @else
        <div class="flex flex-col items-center justify-center table_nfDiv recommendation_no_data hidden">
@endif
<img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
<p class="text-gray-500 font-bold text-lg">@lang('authority_dashboard.table.not_found')</p>
</div>
@else
@if (Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
    <div class="border rounded-2xl overflow-hidden bg-white tabItems" id="recommendation_only">
    @else
        <div class="border rounded-2xl overflow-hidden bg-white tabItems hidden" id="recommendation_only">
@endif
<table class="min-w-full bg-white">
    <thead>
        <tr class="bg-gray-100">
            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col1')</th>
            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col2')</th>
            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col3')</th>
            <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.status')</th>
            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>
        </tr>
    </thead>
    <tbody class="divide-y">
        @php
            $i = 0;
        @endphp
        @foreach ($all_noc as $v)
            @if ($i == 5)
            @break
        @endif
        <tr class="hover:bg-gray-50">
            <td class="py-4 px-6 text-xs text-gray-900">
                <div class="flex items-center">
                    <img src="{{ asset('storage/' . $v->photo_path) }}"
                        class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                    <div>
                        <p class="font-semibold">{{ $v->full_name }} </p>
                        <p class="text-gray-900 text-xs">{{ $v->designation_name }}</p>
                    </div>
                </div>
            </td>
            <td class="py-4 px-6 text-xs text-gray-900">
                {{ $v->department_name }}
            </td>
            <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91 {{ $v->phone }}</td>
            <td class="py-4 px-6 text-xs">
                @if ($v->noc_generate == 0)
                    <div class="flex justify-center">
                        <div
                            class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                            Pending</div>
                    </div>
                @else
                    <div class="flex justify-center">
                        <div
                            class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                            Recommended</div>
                    </div>
                @endif
            </td>
            <td class="py-4 px-6 text-xs">
                <div class="flex justify-center gap-1">
                    <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Appointing Authority'), 'tab_recommend' => Crypt::encryptString('Yes')]) }}"
                        class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</a>
                </div>
            </td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
</tbody>
</table>
</div>
@endif
@endif
</div>
</div>
</div>
</div>



@endsection
{{-- --------------------- dynamic js link ------------------ --}}
@section('extra_js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="module" src="{{ asset('js/verification/login.js') }}"></script>

@if (session('flash_message'))
<script>
    $(document).ready(function() {
        var count = {{ session('flash_message') }};
        var message = "{{ session('message') }}";
        console.log(message)
        if (count == 1) {
            showSuccessPopup(message);
        }
        if (count == 2) {
            console.log('error')
            showErrorPopup(message);
        }
        setTimeout(function() {
            hidePopup()
        }, 1550);
    });
</script>
@endif

<script>
    function storeInSession(candidateId, userType) {
        sessionStorage.setItem('candidateId', candidateId);
        sessionStorage.setItem('userType', userType);

        console.log('Data stored in sessionStorage:', {
            candidateId,
            userType
        });
    }
</script>

<script>
    function showSuccessPopup(message = null) {
        $('.popup').removeClass('hidden');
        $('.popup-success').removeClass('hidden');
        $('.popup-error').addClass('hidden');
        $('.popup-success .text-gray-900').text(message);
    }
    // Function to show the error popup
    function showErrorPopup(message = null) {
        $('.popup').removeClass('hidden');
        $('.popup-error').removeClass('hidden');
        $('.popup-success').addClass('hidden');
        $('.error-msg').text(message);
    }
    // Function to hide the popup
    function hidePopup() {
        $('.popup').addClass('hidden');
        $('.popup-success').addClass('hidden');
        $('.popup-error').addClass('hidden');
    }
</script>

<script>
    $(document).ready(function(argument) {

        //////////
        const role = $('#role_id').val();
        if (role === 'Appointing User') {
            $('#verification_recommendation_3').removeClass('hidden')
        } else if (role === 'Appointing Authority') {
            $('#recommendation_3').removeClass('hidden')
        } else if (role === 'Verifier') {
            $('#verification_3').removeClass('hidden')
        } else if (role === 'Approver') {
            $('#transfer_3').removeClass('hidden')
        }
        ////////////////

        $('#createRequest').on('click', function() {
            if ($('#requestModal').hasClass('hidden')) {
                $('#requestModal').removeClass('hidden');
            }
        });
        $('#closeModalButton').on('click', function() {
            $('#requestModal').addClass('hidden');
        });
        $('.directRequest').on('click', function() {
            var id = $(this).data('id');
            $('#candidate_verify_id').val(id);
            if ($('#directRequestModal').hasClass('hidden')) {
                $('#directRequestModal').removeClass('hidden');
                $('body').css('overflow', 'hidden');
            }
        });
        $('#closeDirectRequestModalButton').on('click', function() {
            $('#directRequestModal').addClass('hidden');
            $('body').css('overflow', 'visible');
        });
        $('.rejectRequestBtn').on('click', function() {
            $('#candidate_reject_id').val();
            var id = $(this).data('id');
            $('#candidate_reject_id').val(id);
            if ($('#rejectModal').hasClass('hidden')) {
                $('#rejectModal').removeClass('hidden');
                $('body').css('overflow', 'hidden');
            }
        });
        $('#closeRejectModalButton').on('click', function() {
            $('#rejectModal').addClass('hidden');
            $('body').css('overflow', 'visible');
        });


        $('.tabBtn').on('click', function() {
            $('.filterDropItems').removeClass('max-h-[99rem]');
            $('.filterDropItems').addClass('max-h-0');
            $(this).find('.filterDropItems').toggleClass('max-h-0 max-h-[99rem]');
            var target = '';
            var view_all_target = '';
            var tabTarget = $(this).attr('tabFor');

            if (tabTarget === 'transfers') {
                target = 'transfers2';
                view_all_target = 'transfer_3';
            } else if (tabTarget === 'verification_recommendation') {
                target = 'verification_recommendation2';
                view_all_target = 'verification_recommendation_3';
            } else if (tabTarget === 'verification_only') {
                target = 'verification_only2';
                view_all_target = 'verification_3';
            } else if (tabTarget === 'recommendation_only') {
                target = 'recommendation_only2';
                view_all_target = 'recommendation_3';
            }

            var trinaryTabTarget = view_all_target;
            var secondaryTabTarget = target;

            // var secondaryTabTarget = tabTarget === 'transfers' ? 'transfers2' : 'verification_recommendation2';
            // Update the styling of active and inactive tab buttons
            $('.tabBtn').removeClass('text-blue-600 border-blue-600 rounded-t-lg');
            $('.tabBtn').addClass(
                'border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300');
            $(this).removeClass(
                'border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300');
            $(this).addClass('text-blue-600 border-blue-600 rounded-t-lg');

            // Hide all main and secondary tabs, then show the selected ones
            $('.tabItem').addClass('hidden');
            $('#' + tabTarget).removeClass('hidden');
            $('#' + secondaryTabTarget).removeClass('hidden');

            if (trinaryTabTarget === 'verification_recommendation_3') {
                if ($('#' + trinaryTabTarget).hasClass('hidden')) {
                    $('#' + trinaryTabTarget).removeClass('hidden');
                }
                $('#recommendation_3').addClass('hidden');
                $('#verification_3').addClass('hidden');
                $('#transfer_3').addClass('hidden')

                $('.verification_recommendation_no_data').removeClass('hidden');
                $('.verification_no_data').addClass('hidden');
                $('.recommendation_no_data').addClass('hidden');
                $('.approval_no_data').addClass('hidden');
            } else if (trinaryTabTarget === 'recommendation_3') {
                if ($('#' + trinaryTabTarget).hasClass('hidden')) {
                    $('#' + trinaryTabTarget).removeClass('hidden');
                }
                $('#verification_recommendation_3').addClass('hidden');
                $('#verification_3').addClass('hidden');
                $('#transfer_3').addClass('hidden')

                $('.verification_recommendation_no_data').addClass('hidden');
                $('.verification_no_data').addClass('hidden');
                $('.recommendation_no_data').removeClass('hidden');
                $('.approval_no_data').addClass('hidden');
            } else if (trinaryTabTarget === 'verification_3') {
                if ($('#' + trinaryTabTarget).hasClass('hidden')) {
                    $('#' + trinaryTabTarget).removeClass('hidden');
                }
                $('#verification_recommendation_3').addClass('hidden');
                $('#recommendation_3').addClass('hidden');
                $('#transfer_3').addClass('hidden')

                $('.verification_recommendation_no_data').addClass('hidden');
                $('.verification_no_data').removeClass('hidden');
                $('.recommendation_no_data').addClass('hidden');
                $('.approval_no_data').addClass('hidden');
            } else if (trinaryTabTarget === 'transfer_3') {
                if ($('#' + trinaryTabTarget).hasClass('hidden')) {
                    $('#' + trinaryTabTarget).removeClass('hidden');
                }
                $('#verification_recommendation_3').addClass('hidden');
                $('#recommendation_3').addClass('hidden');
                $('#verification_3').addClass('hidden')
                $('.verification_recommendation_no_data').addClass('hidden');
                $('.verification_no_data').addClass('hidden');
                $('.recommendation_no_data').addClass('hidden');
                $('.approval_no_data').removeClass('hidden');
            }
        });


        $('.tabBtn').on('click', function() {
            var sw = '#' + $(this).attr('tabFor');
            status = $(this).attr('tabFor');
            $('.tabBtn').removeClass('text-blue-600 border-blue-600 rounded-t-lg');
            $('.tabBtn').addClass(
                'border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300');
            $(this).removeClass(
                'border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300');
            $(this).addClass('text-blue-600 border-blue-600 rounded-t-lg');
            $('.tabItems').addClass('hidden');
            $(sw).removeClass('hidden')
        });


    });
</script>
@endsection

</body>

</html>
