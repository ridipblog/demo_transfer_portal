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
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.search_profiles.heading')</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex-grow">
                        <div class="mb-12">
                            <div class="flex gap-2">
                                <form action="" method="" class="flex-grow">
                                    <div
                                        class="flex items-center border border-gray-300 text-gray-900 bg-white text-sm rounded-full focus:ring-sky-600 focus:border-sky-600 px-2.5 py-1">
                                        <i class="bi bi-search text-gray-900 pl-4"></i>
                                        <div class="flex-grow">
                                            <input type="text" id="pan" value="" name=""
                                                class="disabled:bg-gray-100 block p-2.5 w-full border-none focus:ring-0 focus:border-0"
                                                placeholder="Search by Name or PAN...">
                                        </div>
                                        {{-- <div class="col-span-2 flex justify-end">
                                            <button type="button" id="pan_search" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-2 py-1.5">Search</button>
                                        </div> --}}
                                    </div>
                                </form>
                                <!-- <button class="bg-gray-50 hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-2xl block px-5 py-1.5 transition-all duration-300" id="filterModalButton"><i class="bi bi-sliders2"></i></button> -->
                            </div>
                        </div>
                        <div class="flex gap-56 items-center justify-between mb-6">
                            <div class="flex-grow flex items-end gap-2">
                                <div class="grid grid-cols-3 gap-2 flex-grow">
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.district')</label>
                                        @if (count($district) == 0)
                                            <select name="" id="district_select"
                                                class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                                disabled>
                                                <option value="" selected>{{ Session::get('district_name') }}</option>
                                            </select>
                                        @else
                                            <select name="" id="district_select"
                                                class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                                                <option value="All" selected>All</option>
                                                @foreach ($district as $o)
                                                    <option value="{{ $o->id }}">{{ $o->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.department')</label>
                                        <select name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            disabled>
                                            <option value="" selected>{{ Session::get('department_name') }}</option>
                                        </select>
                                    </div>


                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.office')</label>
                                        <select id="office_select" name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2">
                                        </select>
                                    </div>



                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.post')</label>
                                        <select name="" id="posts"
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2">
                                            <option value="All" selected>All</option>
                                            @foreach ($posts as $o)
                                                <option value="{{ $o->id }}">{{ $o->post_name }}, {{ $o->grade_pay }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="flex">
                                        <div class="mt-auto flex items-center pb-3 pl-1">
                                            <input id="default-checkbox" type="checkbox" value=""
                                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Re-submitted</label>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-4 py-1.5"
                                    id="filterSearch"><i class="bi bi-filter"></i></button>
                            </div>
                        </div>
                        <div class="">
                            <div class="text-sm font-medium text-center text-gray-900 border-b border-gray-200 mb-6">
                                <ul class="flex flex-wrap -mb-px">

                                    @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                                                tabFor="pending"> @lang('authority_dashboard.nav.recommendation_pending')</button>
                                        </li>
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                                                tabFor="verified">@lang('authority_dashboard.search_profiles.recommended_profiles')</button>
                                        </li>
                                    @elseif(Auth::guard('user_guard')->user()->roles->role == 'Appointing User')
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                                                tabFor="pending_verify">@lang('authority_dashboard.search_profiles.pending_verification')</button>
                                        </li>
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                                                tabFor="pending">@lang('authority_dashboard.nav.recommendation_pending')</button>
                                        </li>
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                                                tabFor="verified">@lang('authority_dashboard.search_profiles.recommended_profiles')</button>
                                        </li>
                                    @else
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 text-blue-600 border-blue-600 rounded-t-lg tabBtn"
                                                tabFor="pending">@lang('user.profile_status.status.pending')</button>
                                        </li>
                                        <li class="me-2">
                                            <button
                                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                                                tabFor="verified">@lang('user.profile_status.status.verified')</button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="tabItems hidden" id="pending_verify_div">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4 hide-div">
                                    <table class="min-w-full bg-white ">
                                        <thead>
                                            <tr class="bg-gray-100 tb">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col1')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col2')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col3')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.status')
                                                </th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y" id="divide-y-pending_verified">
                                            {{-- populate --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tabItems hidden" id="pending">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4 hide-div">
                                    <table class="min-w-full bg-white ">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col1')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col2')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col3')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.status')
                                                </th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"
                                                    width="100px"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y">
                                            {{-- populate --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tabItems hidden" id="verified">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4 hide-div">
                                    <table class="min-w-full bg-white ">
                                        <thead>
                                            <tr class="bg-gray-100 tb">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col1')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col2')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('user.search_profile.table_col3')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900">@lang('authority_dashboard.table.status')
                                                </th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y" id="divide-y-verified">
                                            {{-- populate --}}
                                        </tbody>
                                    </table>
                                </div>
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
                <p class="text-3xl font-semibold">@lang('authority_dashboard.table.status')</p>
            </div>
            <form action="{{ url('verifier/verify-candidates') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <input type="hidden" id="candidate_verify_id" name="candidate_verify_id" value="">
                    <div class="flex gap-3">
                        <input type="checkbox"
                            class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                            required>
                        <p class="text-xs text-gray-900">I have thoroughly verified the employee's details, and I confirm
                            that all details provided, including personal, employment, and contact information, are correct
                            and matches the official records.</p>
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

    @if (session('flash_message'))
        <script>
            $(document).ready(function() {
                var count = {{ session('flash_message') }};
                var message = "{{ session::get('message') }}";

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
    <script type="module" src="{{ asset('js/verification/login.js') }}"></script>
    <script>
        function fetch_office(district = null) {
            $.ajax({
                type: "POST",
                url: "{{ url('verifier/fetch-office') }}",
                data: {
                    'district': district
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(response) {

                    if (response.status === 200) {
                        let officeSelect = $('#office_select');
                        officeSelect.empty();

                        officeSelect.append('<option value="All" selected>All</option>');
                        console.log(response);
                        $.each(response.data, function(index, office) {
                            officeSelect.append('<option value="' + office.office_fin_assam.id + '">' +
                                office.office_fin_assam.name + '</option>');
                        });

                        officeSelect.trigger('change');
                    } else {
                        console.log('Error: ' + response.message);
                    }
                }
            });
        }

        function fetch_candidate(data = null, office = null, pan = null, district = null, post = null) {
            $.ajax({
                type: "POST",
                url: "{{ url('verifier/fetch-candidates') }}",
                data: {
                    'status': data,
                    'office': office,
                    'pan_search': pan,
                    'district': district,
                    'post': post
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(response) {
                    var locale = @json(app()->getLocale());
                    $('.divide-y').empty();
                    $('#divide-y-verified').empty();
                    $('#divide-y-pending_verified').empty();
                    if (response.status == 200) {
                        if (response.type == 'pending') {
                            $('#pending').removeClass('hidden');
                            $('#pending_verify_div').addClass('hidden');
                            $('#verified').addClass('hidden');
                            if (response.data.length == 0) {
                                // $('#pending div:first').remove();
                                $('#pending .hide-div').addClass('hidden');
                                $('.table_nfDiv').remove();
                                // $('.table_nfDiv').removeClass('hidden');
                                $('#pending').append(
                                    `<div class="flex flex-col items-center justify-center table_nfDiv ">
                                                    <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                                                    <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p></div>`
                                );
                            } else {
                                console.log(response)
                                $('#pending .hide-div').removeClass('hidden');
                                $('.table_nfDiv').addClass('hidden');
                                // $('#pending div:first').removeClass('hidden');
                                $('.table_nfDiv').remove();
                                $.each(response.data, function(indexInArray, valueOfElement) {
                                    $('.divide-y').append(`<tr class="hover:bg-gray-50">
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        <div class="flex items-center">
                                                            <img src="{{ asset('storage') }}/${valueOfElement.documents[0].documet_location}" class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                                            <div>
                                                                <p class="font-semibold">` + valueOfElement.full_name + `</p>
                                                                <p class="text-gray-900 text-xs">` + valueOfElement
                                        .employment_details.post_names.name + `</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        ` + valueOfElement.employment_details.departments.name + `
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">` +
                                        valueOfElement.phone + `</td>
                                                    <td>
                                                        <div class="flex justify-center">
                                                            <div class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Pending</div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs" >
                                                        <div class="flex gap-1 justify-start">
                                                            <a href="/` + locale + `/verifier/candidate-profile/` +
                                        valueOfElement.encrypted_id + `/` + response
                                        .encrypted_role + `/` + response.rec + `" class="hover:bg-gray-200 border border-transparent text-gray-900 text-xs hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">
                                                                    @lang('authority_dashboard.table.view_details')
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>`);
                                });
                            }
                        } else if (response.type == 'verified') {
                            $('#pending').addClass('hidden');
                            $('#pending_verify_div').addClass('hidden');
                            $('#verified').removeClass('hidden');
                            var totalTh = $('.tb th').length;
                            var th_data = ``;

                            if (response.user_role == 'Appointing Authority') {
                                th_data =
                                    `<th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>`;
                            }

                            if (totalTh == 5) {
                                $('.tb').append(th_data);
                            }

                            $('#divide-y-verified').empty();
                            if (response.data.length == 0) {
                                // $('#verified div:first').remove();
                                $('#verified .hide-div').addClass('hidden');
                                $('.table_nfDiv').remove();
                                $('#verified').append(
                                    `<div class="flex flex-col items-center justify-center table_nfDiv ">
                                                    <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                                                    <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p></div>`
                                );
                            } else {
                                // $('#verified div:first').removeClass('hidden');
                                // $('.table_nfDiv').addClass('hidden');
                                $('#verified .hide-div').removeClass('hidden');
                                $('.table_nfDiv').remove();
                                $.each(response.data, function(indexInArray, valueOfElement) {
                                    //   console.log(response.encrypted_role)
                                    var status_bar = ``;
                                    if (response.user_role == 'Verifier') {
                                        status_bar = `<div class="flex justify-center">
                                                                    <div class="text-green-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Verified</div>
                                                                    
                                                                    </div>`;
                                    } else {
                                        status_bar = `<div class="flex justify-center">
                                                                    <div class="text-green-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Recommended</div>
                                                            </div>`;
                                    }
                                    var append_noc = ``;
                                    if (valueOfElement.noc_generate == 0) {
                                        if (response.user_role == 'Appointing Authority') {
                                            // 'tab_recommend' => Crypt::encryptString('Yes')
                                            status_bar = `<div class="flex justify-center">
                                                                    <div class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">Recommended</div>
                                                                    <a href="/` + locale +
                                                `/verifier/candidate-profile/` + valueOfElement
                                                .encrypted_id + `/` + response.encrypted_role + `/` +
                                                response.rec + `" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">
                                                                    @lang('authority_dashboard.table.view_details')
                                                                    </div>`;
                                        }
                                        noc_doc = ``;
                                    } else {
                                        if (response.user_role == 'Appointing Authority') {

                                            status_bar = `<div class="flex justify-center">
                                                                    <div class="text-green-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Recommended</div>
                                                                    
                                                                    </div>`;
                                        }
                                        noc_doc = '';

                                    }

                                    $('#divide-y-verified').append(`<tr class="hover:bg-gray-50">
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        <div class="flex items-center">
                                                            <img src="{{ asset('storage') }}/${valueOfElement.documents[0].documet_location}" class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                                            <div>
                                                                <p class="font-semibold">` + valueOfElement.full_name + `</p>
                                                                <p class="text-gray-900 text-xs">` + valueOfElement
                                        .employment_details.post_names.name + `</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        ` + valueOfElement.employment_details.departments.name + `
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">` +
                                        valueOfElement.phone + `</td>
                                                    <td>
                                                        ` + status_bar + `
                                                    </td>
                                                    <td>
                                                        <div class="flex justify-center">
                                                            <a href="/` + locale + `/verifier/candidate-profile/` +
                                        valueOfElement.encrypted_id + `/` + response
                                        .encrypted_role + `" class="hover:bg-gray-200 border border-transparent text-xs text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">
                                                                    @lang('authority_dashboard.table.view_details')
                                                        </div>
                                                    </td>
                                                        ` + append_noc + `  
                                                </tr>`);
                                });
                            }
                        } else if (response.type == 'pending_verify') {
                            $('#pending').addClass('hidden');
                            $('#pending_verify_div').removeClass('hidden');
                            $('#verified').addClass('hidden');
                            if (response.data.length == 0) {
                                $('#pending_verify_div .hide-div').addClass('hidden');
                                // $('#pending_verify_div div:first').remove();
                                $('.table_nfDiv').remove();
                                $('#pending_verify_div').append(
                                    `<div class="flex flex-col items-center justify-center table_nfDiv">
                                                    <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                                                    <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p>                                                                                                    </div>`
                                );
                            } else {
                                // $('.table_nfDiv').addClass('hidden');
                                // $('#pending_verify_div div:first').removeClass('hidden');
                                $('#pending_verify_div .hide-div').removeClass('hidden');
                                $('.table_nfDiv').remove();
                                $.each(response.data, function(indexInArray, valueOfElement) {
                                    $('#divide-y-pending_verified').append(`<tr class="hover:bg-gray-50">
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        <div class="flex items-center">
                                                            <img src="{{ asset('storage') }}/${valueOfElement.documents[0].documet_location}" class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                                            <div>
                                                                <p class="font-semibold">` + valueOfElement.full_name + `</p>
                                                                <p class="text-gray-900 text-xs">` + valueOfElement
                                        .employment_details.post_names.name + `</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900">
                                                        ` + valueOfElement.employment_details.departments.name + `
                                                    </td>
                                                    <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">` +
                                        valueOfElement.phone + `</td>
                                                    <td>
                                                        <div class="flex justify-center">
                                                            <div class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Pending</div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-6 text-xs" >
                                                        <div class="flex gap-1 justify-start"> 
                                                            <a href="/` + locale + `/verifier/candidate-profile/` +
                                        valueOfElement.encrypted_id + `/` + response
                                        .encrypted_role + `" class="hover:bg-gray-200 border text-xs border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">
                                                                    @lang('authority_dashboard.table.view_details')
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>`);
                                });

                                // <button type="button" data-id="`+ valueOfElement.id +`" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded-md text-xs rejectRequestBtn"><i class="bi bi-x"></i></button> 
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
            $('#district_select').on('change', function() {
                var district = $(this).val();
                fetch_office(district);
            });
            fetch_office();
            fetch_candidate();
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
                $('.table_nfDiv').addClass('hidden');
                var opt_val = $('#office_select').val();
                var district = $('#district_select').val();
                var post = $('#posts').val();
                var pan = $('#pan').val();
                if (opt_val == '') {
                    alert('Please select office first');
                } else {
                    fetch_candidate(data = status, office = opt_val, pan = pan, district = district, post =
                        post);
                }
            });

            $('#pan_search').on('click', function() {
                $('.table_nfDiv').addClass('hidden');
                fetch_candidate(data = status, office = null, pan = $('#pan').val());

            });

            // tabs
            $('.tabBtn').on('click', function() {
                var office_search = $('#office_select').val();
                var district_search = $('#district_select').val();
                var post_id = $('#posts').val();

                status = $(this).attr('tabFor');
                var sw = '#' + $(this).attr('tabFor');

                var pan_search = $('#pan').val();
                if (pan_search == '') {
                    pan_search = null
                }
                fetch_candidate(status, office = office_search, pan = pan_search, district =
                    district_search, post = post_id);

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
