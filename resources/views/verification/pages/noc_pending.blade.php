@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <!-- Messages -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2">
                    <p class="text-3xl font-semibold">All Profiles</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex-grow">
                        <div class="mb-12">
                            <div class="flex gap-2">
                                {{-- <form action="" method="" class="flex-grow">
                                    <div class="flex items-center border border-gray-300 text-gray-900 bg-white text-sm rounded-full focus:ring-sky-600 focus:border-sky-600 px-2.5 py-1">
                                        <i class="bi bi-search text-gray-900 pl-4"></i>
                                        <div class="flex-grow">
                                            <input type="text" id="pan" value="" name="" class="disabled:bg-gray-100 block p-2.5 w-full border-none focus:ring-0 focus:border-0" placeholder="Search by PAN Number...">
                                        </div>
                                        <div class="col-span-2 flex justify-end">
                                            <button type="button" id="pan_search" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-2 py-1.5">Search</button>
                                        </div>
                                    </div>
                                </form> --}}
                                <!-- <button class="bg-gray-50 hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-2xl block px-5 py-1.5 transition-all duration-300" id="filterModalButton"><i class="bi bi-sliders2"></i></button> -->
                            </div>
                        </div>
                        <div class="flex gap-56 items-center justify-between mb-6">
                            <div class="flex-grow flex items-end gap-2">
                                <div class="grid grid-cols-3 gap-2 flex-grow">
                                    <div class="">
                                        <label class="block mb-1 text-xs font-semibold text-gray-900">District</label>
                                        <select name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            disabled>
                                            <option value="" selected>{{ Session::get('district_name') }}</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label class="block mb-1 text-xs font-semibold text-gray-900">Department</label>
                                        <select name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            disabled>
                                            <option value="" selected>{{ Session::get('department_name') }}</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label class="block mb-1 text-xs font-semibold text-gray-900">Office</label>
                                        <select id="office_select" name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2">
                                            <option value="All" selected>All</option>
                                            @foreach ($office as $o)
                                                <option value="{{ $o->id }}">{{ $o->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-4 py-1.5"
                                    id="filterSearch"><i class="bi bi-filter"></i></button>
                            </div>
                            <!-- <div class="flex gap-2 items-center text-xs">
                                            <p class="text-gray-900 whitespace-nowrap">Sort by:</p>
                                            <select name="" class="disabled:bg-gray-100 border-0 bg-gray-50 text-gray-900 text-xs rounded-md focus:ring-0 focus:border-0 block p-1.5 w-full pr-8 font-bold">
                                                <option value="1" selected>Relevence</option>
                                                <option value="2">Latest</option>
                                            </select>
                                        </div> -->
                        </div>
                        <div class="">
                            <div class="text-sm font-medium text-center text-gray-900 border-b border-gray-200 mb-6">
                                <ul class="flex flex-wrap -mb-px">
                                    <li class="me-2">
                                        <button
                                            class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                                            tabFor="pending">Pending</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tabItems " id="pending">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4">
                                    <table class="min-w-full bg-white ">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Name &
                                                    Designation</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Office &
                                                    Department</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900">Status</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y">
                                            {{-- populate --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="tabItems hidden" id="verified">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4">
                                    <table class="min-w-full bg-white ">
                                        <thead>
                                            <tr class="bg-gray-100 tb">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Name & Designation</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Office & Department</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900">Status</th>
                                        
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y" id="divide-y-verified">
                        
                                        </tbody>
                                    </table>
                                </div> --}}
                        </div>
                    </div>
                </div>
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
            <form action="{{ url('verifier/verify-candidates') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <input type="hidden" id="candidate_verify_id" name="candidate_verify_id" value="">
                    <div class="flex gap-3">
                        <input type="checkbox"
                            class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                            required>
                        <p class="text-xs text-gray-900">I have thoroughly verified the employee's profile, and I confirm
                            that all provided details, including personal, employment, and contact information, are accurate
                            to the best of my knowledge.</p>
                    </div>
                    <div class="flex gap-3">
                        <input type="checkbox"
                            class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                            required>
                        <p class="text-xs text-gray-900">I confirm that the information provided by the employee matches the
                            official records and no discrepancies were found during the verification process.</p>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeDirectRequestModalButton">Close</button>
                        <button type="submit"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- reject modal -->
    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
        id="rejectModal">
        <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
            <div class="space-y-2 mb-6">
                <p class="text-3xl font-semibold">Reject Profile</p>
            </div>
            <form action="{{ url('/verifier/reject-candidates') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <div>
                        <input type="hidden" id="candidate_reject_id" name="candidate_reject_id" value="">
                        <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">Rejection Reason</label>
                        <textarea name="reject_message"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            rows="4" required></textarea>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeRejectModalButton">Close</button>
                        <button type="submit"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- NOC modal -->
    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
        id="directNOCModal">
        <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
            <div class="space-y-2 mb-6">
                <p class="text-3xl font-semibold">Generate NOC</p>
            </div>
            <form action="{{ url('verifier/noc-update') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <div class="">
                        <input type="hidden" name="direct_noc_id" id="direct_noc_id" value="" />
                        <div class="flex gap-3">
                            <input type="checkbox"
                                class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                                required>
                            <p class="text-xs text-gray-900">I confirm that all profiles have been successfully generated
                                and are ready for review.</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex gap-3">
                            <input type="checkbox"
                                class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                                required>
                            <p class="text-xs text-gray-900">I acknowledge that all required documents are in order and
                                approve the NOC generation.</p>
                        </div>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeDirectNOCModalButton">Close</button>
                        <button type="submit"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Generate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- filter modal -->
    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
        id="filterModal">
        <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
            <div class="space-y-2 mb-6">
                <p class="text-3xl font-semibold">Filters</p>
            </div>
            <form action="" method="">
                <div class="grid gap-4">
                    <div>
                        <label class="block mb-1 text-xs font-semibold text-gray-900">District</label>
                        <select name=""
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <option value="" selected>All</option>
                            <option value="1">Kamrup</option>
                            <option value="2">Kamrup Metro</option>
                            <option value="3">Nagaon</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-semibold text-gray-900">Department</label>
                        <select name=""
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <option value="" selected>All</option>
                            <option value="1">Irrigation</option>
                            <option value="2">Health</option>
                            <option value="3">Finance</option>
                        </select>
                    </div>
                    <div class="">
                        <label class="block mb-1 text-xs font-semibold text-gray-900">Office</label>
                        <select name=""
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                            <option value="" selected>All</option>
                            @foreach ($office as $o)
                                <option value="{{ $o->id }}">{{ $o->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeFilterModalButton">Close</button>
                        <button type="submit"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- footer -->

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>     --}}
@endsection
{{-- --------------------- dynamic js link ------------------ --}}
@section('extra_js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- <script type="module" src="{{ asset('js/verification/login.js') }}"></script> --}}

    {{-- @if (session('flash_message'))
    <script>
        $(document).ready(function() {
            var count = {{ session('flash_message') }};
            var message = "{{ session::get('message') }}";
            console.log(message)
            if(count == 1){
                showSuccessPopup(message);
            }
            if(count == 2){
                console.log('error')
                showErrorPopup(message);
            }
            setTimeout(function() {
                hidePopup()
            }, 1550); 
        });
    </script>
    @endif --}}

    {{-- 
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
 </script> --}}
    <script type="module" src="{{ asset('js/verification/login.js') }}"></script>
    <script>
        function fetch_candidate(data = null, office = null, pan = null) {
            $.ajax({
                type: "POST",
                url: "{{ url('verifier/fetch-noc-pending-candidates') }}",
                data: {
                    'status': data,
                    'office': office,
                    'pan_search': pan
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(response) {
                    $('#verified').addClass('hidden');
                    console.log(response)
                    $('.divide-y').empty();
                    $('#divide-y-verified').empty();
                    if (response.status == 200) {
                        if (response.type == 'pending') {
                            if (response.data.length == 0) {
                                $('#pending div:first').addClass('hidden');
                                // $('.table_nfDiv').removeClass('hidden');
                                $('#pending').append(
                                    `<div class="flex flex-col items-center justify-center table_nfDiv ">
                                                    <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                                                    <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p>                                                                                                    </div>`
                                );
                            } else {
                                $('#pending div:first').removeClass('hidden');
                                // $('.table_nfDiv').addClass('hidden');
                                $.each(response.data, function(indexInArray, valueOfElement) {
                                    $('.divide-y').append(`<tr class="hover:bg-gray-50">
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        <div class="flex items-center">
                                                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fHByb2ZpbGUlMjBwaWN0dXJlfGVufDB8fDB8fHwy" class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                                            <div>
                                                                <p class="font-semibold">` + valueOfElement.full_name + `</p>
                                                                <p class="text-gray-900 text-xs">` + valueOfElement
                                        .employee_post + `</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        ` + valueOfElement.department_name + `
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">` +
                                        valueOfElement.phone + `</td>
                                                    <td>
                                                        <div class="flex justify-center">
                                                            <div class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit"><i class="bi bi-clock"> </i></div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs" >
                                                        <div class="flex gap-1 justify-start">
                                                        
                                                            <button type="button" data-id="` + valueOfElement.id + `" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded-md text-xs rejectRequestBtn"><i class="bi bi-x"></i></button>
                                                            <a href="/verifier/candidate-profile/` + valueOfElement
                                        .encrypted_id + `" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">
                                                                    @lang('authority_dashboard.table.view_details')
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>`);
                                });
                            }
                        } else {
                            if (response.data.length == 0) {
                                $('.divide-y').append(
                                    `<tr>
                                                <td colspan="5">
                                                    <div class="flex flex-col items-center justify-center table_nfDiv">
                                                        <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                                                        <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p>                                                                                                            </div>
                                                </td>
                                            </tr>`
                                );
                            }
                        }
                    } else {
                        console.log(response);
                        $('.divide-y').append(`<tr class="hover:bg-gray-50">
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        <p>Failed to load users</p>
                                                    </td>
                                                </tr>`);
                    }
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            fetch_candidate(data = 'pending', office = null, pan = null);
            $(document).on('click', '.directRequest', function() {
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
            $('#filterModalButton').on('click', function() {
                if ($('#filterModal').hasClass('hidden')) {
                    $('#filterModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeFilterModalButton').on('click', function() {
                $('#filterModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });
            $('.tabBtn').on('click', function() {
                $('.filterDropItems').removeClass('max-h-[99rem]');
                $('.filterDropItems').addClass('max-h-0');
                $(this).find('.filterDropItems').toggleClass('max-h-0 max-h-[99rem]');
            });
            // NOC Modal
            $(document).on('click', '.directNOC', function() {
                var id = $(this).data('id');
                $('#direct_noc_id').val(id);
                if ($('#directNOCModal').hasClass('hidden')) {
                    $('#directNOCModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeDirectNOCModalButton').on('click', function() {
                $('#directNOCModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });

            // Reject Modal
            $(document).on('click', '.rejectRequestBtn', function() {
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

            var status = '';
            $('#filterSearch').on('click', function() {
                var opt_val = $('#office_select').val();
                if (opt_val == '') {
                    alert('Please select office first');
                } else {
                    fetch_candidate(data = 'pending', office = opt_val);
                }
            });

            $('#pan_search').on('click', function() {
                fetch_candidate(data = 'pending', office = null, pan = $('#pan').val());
                $('#pan').val('');
            });

            // tabs
            $('.tabBtn').on('click', function() {
                $('#office_select').val('');
                status = $(this).attr('tabFor');
                var sw = '#' + $(this).attr('tabFor');
                fetch_candidate(status);

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
