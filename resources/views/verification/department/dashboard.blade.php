@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Department Dashboard')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">@lang('user.nav_menu.dash')</p>

                </div>
                @php
                    $locale = app()->getLocale();
                @endphp
                <div class="grid grid-cols-4 gap-4">
                    <a href="/{{ $locale }}/department/approval-all-requests"
                        class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-inboxes text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($employees) }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.total_request')</p>
                            </div>
                        </div>
                    </a>
                    <a href="/{{ $locale }}/department/approval-all-requests"
                        class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                    class="text-lg bi bi-exclamation-circle text-black"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($pendingTransfers) }}</p>
                                <p class="">@lang('authority_dashboard.nav.pending_transfers')</p>
                            </div>
                        </div>
                    </a>
                    <a href="/{{ $locale }}/department/approval-all-requests"
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

                    <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-people text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ $count_users }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.registered_profiles')</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-people text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ $verified_profiles }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.verified_profiles')</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-people text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ $pending_profiles }}</p>
                                <p class="text-gray-900">@lang('authority_dashboard.nav.pending_profiles')</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="mt-12 space-y-12">
                <div class="flex items-bottom justify-between">
                    <p class="text-xl">@lang('authority_dashboard.latest_requests')</p>
                    <a href="/{{ $locale }}/department/approval-all-requests"
                        class="hover:underline text-gray-900 text-xs">@lang('authority_dashboard.nav.view_all') <i
                            class="bi bi-arrow-up-right"></i></a>
                </div>
                @if (count($allTransfers) == 0)
                    <div class="flex flex-col items-center justify-center table_nfDiv">
                        <img src="{{ asset('images/nfd.png') }}" alt="" class="max-w-xs object-center">
                        <p class="text-gray-500 font-bold text-lg">@lang('authority_dashboard.table.not_found')</p>
                    </div>
                @else
                    <div class="border rounded-2xl overflow-hidden bg-white">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.reference_code')</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.applicant_1')</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.applicant_2')</th>
                                    <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.approval')</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900 text-center">
                                        @lang('authority_dashboard.table.noc_col')</th>
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
                                    <td class="py-4 px-6 text-xs text-gray-900">{{ $v->transfer_ref_code }}</td>
                                    <td class="py-4 px-6 text-xs text-gray-900">{{ $v->employee_name }}</td>
                                    <td class="py-4 px-6 text-xs text-gray-900">{{ $v->target_employee_name }}</td>
                                    <td>
                                        @if ($v->final_approval == 0 || $v->final_approval == 2)
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
                                    <td>
                                        @if ($v->final_approval == 1)
                                            @if ($v->jto_generate_status == 0)
                                                <a href="/jto-certificate/{{ Crypt::encryptString($v->id) }}"
                                                    id="jto-btn"
                                                    class="text-center bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-1 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                                                    data-id="">@lang('authority_dashboard.profile_details_jts.generate_transfer')</a>
                                            @else
                                                <a href="/jto-certificate/{{ Crypt::encryptString($v->id) }}"
                                                    class="text-center bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-1 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                                                    data-id="">@lang('authority_dashboard.profile_details_jts.download_transfer')</a>
                                            @endif
                                        @else
                                            <div class="flex justify-center">
                                                <div
                                                    class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                    Pending</div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-xs">
                                        <div class="flex gap-1 justify-center">
                                            <a href="{{ route('verification.department.candidate_profile', ['lang' => $locale, 'id' => Crypt::encryptString($v->id)]) }}"
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
        </div>
    </div>
</div>
</div>

<!-- footer -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
            if ($('#directRequestModal').hasClass('hidden')) {
                $('#directRequestModal').removeClass('hidden');
                $('body').css('overflow', 'hidden');
            }
        });
        $('#closeDirectRequestModalButton').on('click', function() {
            $('#directRequestModal').addClass('hidden');
            $('body').css('overflow', 'visible');
        });
    });
</script>
@endsection

</body>
