@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Approver login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">Dashboardsss</p>
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
                <div class="grid grid-cols-4 gap-4">
                    <a href="/verifier/approval-all-requests"
                        class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-inboxes text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($employees) }}</p>
                                <p class="text-gray-900">Total Requests</p>
                            </div>
                        </div>
                    </a>
                    <a href="/verifier/approval-all-requests" class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                    class="text-lg bi bi-exclamation-circle text-black"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($pendingTransfers) }}</p>
                                <p class="">Pending Transfers</p>
                            </div>
                        </div>
                    </a>
                    <a href="/verifier/approval-all-requests"
                        class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-person-check text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($approvedTransfers) }}</p>
                                <p class="text-gray-900">Approved Transfers</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                        <div class="flex gap-6">
                            <div class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0"><i
                                    class="text-lg bi bi-people text-sky-600"></i></div>
                            <div class="">
                                <p class="text-3xl font-bold">{{ count($rejectedTransfers) }}</p>
                                <p class="text-gray-900">Rejected</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="mt-12 space-y-12">
                <div class="flex items-bottom justify-between">
                    <p class="text-xl">Latest Requests</p>
                    <a href="{{ route('verification.approval-all') }}" class="hover:underline text-gray-900 text-xs">View
                        all <i class="bi bi-arrow-up-right"></i></a>
                </div>
                @if (count($allTransfers) == 0)
                    <div class="flex flex-col items-center justify-center table_nfDiv">
                        <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 mb-4 object-center">
                        <p class="text-gray-500 font-bold text-lg">No Requests Found!</p>
                    </div>
                @else
                    <div class="border rounded-2xl overflow-hidden bg-white">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Reference code</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Applicant 1</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Applicant 2</th>
                                    <th class="p-4 px-6 font-medium text-sm text-gray-900">Status</th>
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
                                        {{-- {{dd($v->final_approval)}} --}}
                                        @if ($v->final_approval == 0)
                                            <div class="flex justify-center">
                                                <div
                                                    class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                    <i class="bi bi-clock"> </i>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-center">
                                                <div
                                                    class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                    <i class="bi bi-check-circle"> </i>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    {{-- <td>
                                    <div class="flex justify-center">
                                        <a href="{{ asset('/docs/jts-format.html')}}" class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1.5 rounded-md text-xs disabled:cursor-not-allowed  disabled:bg-sky-300 disabled:opacity-80 directNOC" ><i class="bi bi-file-earmark-lock"></i></a>
                                    </div>
                                </td> --}}
                                    <td class="py-4 px-6 text-xs">
                                        <div class="flex gap-1 justify-center">
                                            {{-- <button type="button" class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1.5 rounded-md text-xs directRequest"><i class="bi bi-check"></i></button> --}}
                                            <a href="/verifier/approval-profile/{{ Crypt::encryptString($v->id) }}"
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
<!-- modal -->
<div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
    id="directRequestModal">
    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
        <div class="space-y-2 mb-6">
            <p class="text-3xl font-semibold">Verify Profile</p>
        </div>
        <form action="" method="">
            <div class="grid gap-8">
                <div class="">
                    <div class="flex gap-3">
                        <input type="checkbox"
                            class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                            required>
                        <p class="text-xs text-gray-900">I approve this transfer request conditionally, pending receipt
                            of additional documents as specified.</p>
                    </div>
                </div>
                <div class="flex gap-1 justify-end">
                    <button type="button"
                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                        id="closeDirectRequestModalButton">Close</button>
                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Request</button>
                </div>
            </div>
        </form>
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
