@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    @php
        $locale = app()->getLocale();
    @endphp
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">Dashboard</p>
                </div>
                @if (Auth::guard('user_guard')->user()->role_id == 6)
                    <div class="grid grid-cols-5 gap-4">
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Verifier')]) }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($all_users) }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Verifier')]) }}"
                            class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                            <div class="flex gap-6">
                                <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                        class="text-lg bi bi-exclamation-circle text-black"></i></div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($pending_users) }}</p>
                                    <p class="">@lang('authority_dashboard.nav.pending_profiles')</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Verifier')]) }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($verified_profiles) }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.verified_profiles')</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Verifier')]) }}"
                            class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                            <div class="flex gap-6">
                                <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                        class="text-lg bi bi-arrow-clockwise text-black"></i></div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($pending_users) }}</p>
                                    <p class="">@lang('authority_dashboard.nav.resubmitted')</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-5 gap-4">
                        <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($all_noc) }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                            <div class="flex gap-6">
                                <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                        class="text-lg bi bi-exclamation-circle text-black"></i></div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($noc_pending) }}</p>
                                    <p class="">@lang('authority_dashboard.nav.recommendation_pending')</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($noc_completed) }}</p>
                                    <p class="text-gray-900">@lang('authority_dashboard.nav.recommended')</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>




            @if (Auth::guard('user_guard')->user()->role_id == 6)
                <div class="mt-12 space-y-12">
                    <div class="flex items-bottom justify-between">
                        <p class="text-xl">Latest Requests</p>
                        <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Verifier')]) }}"
                            class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i
                                class="bi bi-arrow-up-right"></i></a>
                    </div>
                    @if (count($all_users) == 0)
                        <div class="flex flex-col items-center justify-center table_nfDiv recommendation_no_data ">
                            <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                            <p class="text-gray-500 font-bold text-lg">@lang('authority_dashboard.table.not_found')</p>
                        </div>
                    @else
                        <div class="border rounded-2xl overflow-hidden bg-white">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Name & Designation
                                        </th>
                                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Office & Department
                                        </th>
                                        <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                                        <th class="p-4 px-6 font-medium text-sm text-gray-900">Status</th>
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
                                        <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91
                                            {{ $v->phone }}</td>
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
                                                <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Verifier')]) }}"
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
            </div>
        @else
            <div class="mt-12 space-y-12">
                <div class="flex items-bottom justify-between">
                    <p class="text-xl">Latest Requests</p>
                    <a href="{{ route('verifier.candidate_verify', ['lang' => $locale, 'type' => Crypt::encryptString('Appointing Authority')]) }}"
                        class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i
                            class="bi bi-arrow-up-right"></i></a>
                </div>
                @if (count($all_noc) == 0)
                    <div class="flex flex-col items-center justify-center table_nfDiv recommendation_no_data ">
                        <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                        <p class="text-gray-500 font-bold text-lg">@lang('authority_dashboard.table.not_found')</p>
                    </div>
                @else
                    <div class="border rounded-2xl overflow-hidden bg-white tabItems" id="recommendation_only">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col1')
                                    </th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col2')
                                    </th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col3')
                                    </th>
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
                                    <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91
                                        {{ $v->phone }}</td>
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
                                            <a href="{{ route('candidate.profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id), 'type' => Crypt::encryptString('Appointing Authority')]) }}"
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
        </div>
    @endif
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
    });
</script>
@endsection

</body>

</html>
