@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Approver login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2">
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.search_profiles.heading')</p>
                </div>
                <div class="flex gap-4">
                    <!-- <div class="flex w-1/4">
                                                            <div class="bg-gray-100 rounded-2xl flex-grow p-6 h-fit">
                                                                <p class="text-xl font-semibold mb-8">Filters</p>
                                                                <ul>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Basic Information</span></a></li>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Location</span></a></li>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Employment Information</span></a></li>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Preferences</span></a></li>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Documents</span></a></li>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Security</span></a></li>
                                                                    <li><a href="#" class="py-4 w-full font-medium text-gray-900 hover:text-sky-600 flex gap-3"><input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"><span>Delete account</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div> -->
                    <div class="flex-grow">
                        <div class="mb-12">
                            <div class="flex gap-2">
                                <form action="" method="" class="flex-grow">
                                    <div
                                        class="flex items-center border border-gray-300 text-gray-900 bg-white text-sm rounded-full focus:ring-sky-600 focus:border-sky-600 px-2.5 py-1">
                                        <i class="bi bi-search text-gray-900 pl-4"></i>
                                        <div class="flex-grow">
                                            <input type="text" id="pan" name=""
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
                            <!-- <div class="flex items-center gap-2">
                                                                        <i class="bi bi-sliders2"></i>
                                                                        <div class="filterDrop relative">
                                                                            <button class="bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-5 py-1.5 transition-all duration-300">District <i class="bi bi-filter ml-4 text-xs"></i></button>
                                                                            <div class="bg-white shadow-md rounded-md mt-1 overflow-hidden absolute top-full left-0 max-h-0 filterDropItems">
                                                                                <ul class="p-4 grid gap-2 w-max">
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Cachar</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Kamrup</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Kamrup Metro</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Lakhimpur</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Nagaon</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Silchar</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Tinsukia</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="filterDrop relative">
                                                                            <button class="bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-5 py-1.5 transition-all duration-300">Department <i class="bi bi-filter ml-4 text-xs"></i></button>
                                                                            <div class="bg-white shadow-md rounded-md mt-1 overflow-hidden absolute top-full left-0 max-h-0 filterDropItems">
                                                                                <ul class="p-4 grid gap-2 w-max">
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Administrative</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Agriculture</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Finance</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Health</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Housing</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Fisheries</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="filterDrop relative">
                                                                            <button class="bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-5 py-1.5 transition-all duration-300">Offices <i class="bi bi-filter ml-4 text-xs"></i></button>
                                                                            <div class="bg-white shadow-md rounded-md mt-1 overflow-hidden absolute top-full left-0 max-h-0 filterDropItems">
                                                                                <ul class="p-4 grid gap-2 w-max">
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Office of the Chief Engineer</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Office of the Superintending Engineer</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Office of the Deputy Director</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Office of the Chief Engineer</p>
                                                                                    </li>
                                                                                    <li class="flex gap-3">
                                                                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5" required>
                                                                                        <p class="text-xs text-gray-900">Office of the Superintending Engineer</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                            <div class="flex-grow flex items-end gap-2">
                                <div class="grid grid-cols-3 gap-2 flex-grow">
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.district')</label>
                                        <select name="district_select" id="district_select"
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                                            <option value="All" selected>All</option>
                                            @foreach ($district as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.department')</label>
                                        <select name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            disabled>
                                            <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                            {{-- <option value="{{$department->id}}">{{$department->name}}</option> --}}
                                        </select>
                                    </div>
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.office')</label>
                                        <select id="office_select" name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2">
                                            {{-- <option value="All" selected>All</option>
                                            @foreach ($office as $o)
                                                <option value="{{$o->id}}">{{$o->name}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold text-gray-900">@lang('authority_dashboard.search_profiles.post')</label>
                                        <select name="" id="posts"
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2">
                                            <option value="All" selected>All</option>
                                            @foreach ($posts as $o)
                                                <option value="{{ $o->id }}">{{ $o->post_name }},
                                                    {{ $o->grade_pay }}</option>
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
                                            tabFor="pending">@lang('authority_dashboard.search_profiles.pending')</button>
                                    </li>
                                    <li class="me-2">
                                        <button
                                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 tabBtn"
                                            tabFor="approved">@lang('authority_dashboard.search_profiles.approved')</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tabItems " id="pending">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('authority_dashboard.table.reference_code')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('authority_dashboard.table.applicant_1')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('authority_dashboard.table.applicant_2')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                                                    @lang('authority_dashboard.table.recommendation')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                                                    @lang('authority_dashboard.table.approval')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"
                                                    width="100px"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y">
                                            {{--  --}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tabItems hidden" id="approved">
                                <div class="border rounded-2xl overflow-hidden bg-white mt-4">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('authority_dashboard.table.reference_code')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('authority_dashboard.table.applicant_1')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">
                                                    @lang('authority_dashboard.table.applicant_2')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                                                    @lang('authority_dashboard.table.recommendation')</th>
                                                <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                                                    @lang('authority_dashboard.table.approval')</th>
                                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"
                                                    width="100px"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y">

                                            {{--  --}}

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
                            <option value="1">ABC</option>
                            <option value="2">DEF</option>
                            <option value="3">XYZ</option>
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
@endsection
@section('extra_js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @if (session('flash_message'))
        <script>
            $(document).ready(function() {
                var count = {{ session('flash_message') }};
                var message = "{{ session('message') }}";

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
        function fetch_office(district = null) {
            $.ajax({
                type: "POST",
                url: "{{ url('department/fetch-office') }}",
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
                url: "{{ url('department/fetch-candidates/approval') }}",
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
                    if (response.status == 200 && response.type == 'pending') {
                        if (response.data.length == 0) {
                            $('#pending div:first').addClass('hidden');
                            $('.table_nfDiv').remove();
                            $('#pending').append(
                                `<div class="flex flex-col items-center justify-center table_nfDiv ">
                                                    <img src="{{ asset('images/nfd.png') }}" alt="" class="max-w-xs object-center">
                                                    <p class="text-gray-500 font-bold text-lg">No data found!</p>
                                                    <p class="text-gray-500 text-sm">There is no data here, please add some.</p>
                                                </div>`
                            );
                        } else {
                            $('#pending div:first').removeClass('hidden');
                            $('.table_nfDiv').addClass('hidden');
                            let tbody = $('#pending tbody');
                            tbody.empty();
                            response.data.forEach(function(item) {
                                let second_recommend = ``;
                                if (item.second_recommend == 0) {
                                    second_recommend = `<div class="flex justify-center">
                                                        <div class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                        Pending
                                                        </div>
                                                    </div>`;
                                } else {
                                    second_recommend = `<div class="flex justify-center">
                                                        <div class="text-green-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Recommended</div>
                                                    </div>`;
                                }

                                let row = `
                                 <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 text-xs text-gray-900">${item.transfer_ref_code}</td>
                                     <td class="py-4 px-6 text-xs text-gray-900">${item.employee_name}</td>
                                     <td class="py-4 px-6 text-xs text-gray-900">${item.target_employee_name}</td>
                                     <td>
                                         ` + second_recommend + `
                                     </td>
                                     <td>
                                         <div class="flex justify-center">
                                             <div class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                 Pending
                                             </div>
                                         </div>
                                     </td>
                                     <td class="py-4 px-6 text-xs">
                                         <div class="flex gap-1 justify-center">
                                             <a href="/` + locale + `/department/approval-profile/` + item
                                    .encrypted_id + `" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300">
                                                 @lang('authority_dashboard.table.view_details')
                                             </a>
                                         </div>
                                     </td>
                                 </tr>
                             `;
                                tbody.append(row);
                            });
                        }

                    } else if (response.status == 200 && response.type == 'approved') {

                        if (response.data.length == 0) {
                            $('#approved div:first').addClass('hidden');
                            $('.table_nfDiv').remove();
                            $('#approved').append(
                                `<div class="flex flex-col items-center justify-center table_nfDiv ">
                                                    <img src="{{ asset('images/nfd.png') }}" alt="" class="max-w-xs object-center">
                                                    <p class="text-gray-500 font-bold text-lg">No data found!</p>
                                                    <p class="text-gray-500 text-sm">There is no data here, please add some.</p>
                                                </div>`
                            );
                        } else {
                            $('.table_nfDiv').addClass('hidden');
                            $('#approved div:first').removeClass('hidden');
                            let tbody = $('#approved tbody');
                            tbody.empty();
                            response.data.forEach(function(item) {
                                let second_recommend = ``;
                                if (item.second_recommend == 0) {
                                    second_recommend = `<div class="flex justify-center">
                                                        <div class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                        Pending
                                                        </div>
                                                    </div>`;
                                } else {
                                    second_recommend = `<div class="flex justify-center">
                                                        <div class="text-green-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Recommended</div>
                                                    </div>`;
                                }


                                let row = `
                                 <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 text-xs text-gray-900">${item.transfer_ref_code}</td>
                                     <td class="py-4 px-6 text-xs text-gray-900">${item.employee_name}</td>
                                     <td class="py-4 px-6 text-xs text-gray-900">${item.target_employee_name}</td>
                                     <td>
                                         ` + second_recommend + `
                                     </td>
                                     <td>
                                         <div class="flex justify-center">
                                              <div class="text-green-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">Approved</div>
                                         </div>
                                     </td>
                                     <td class="py-4 px-6 text-xs">
                                         <div class="flex gap-1 justify-center">
                                             <a href="/` + locale + `/department/approval-profile/` + item
                                    .encrypted_id + `" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300">
                                                 @lang('authority_dashboard.table.view_details')
                                             </a>
                                         </div>
                                     </td>
                                 </tr>
                             `;
                                tbody.append(row);
                            });
                        }
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

            fetch_candidate(data = 'pending', office = null, pan = null, district = null);
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
            var status = '';
            $('#filterSearch').on('click', function() {
                $('.table_nfDiv').addClass('hidden');
                var opt_val = $('#office_select').val();
                var district = $('#district_select').val();
                var post = $('#posts').val();
                var pan = $('#pan').val()
                if (opt_val == '') {
                    alert('Please select office first');
                } else {
                    fetch_candidate(data = status, office = opt_val, pan = pan, district = district, post =
                        post);
                }
            });
            $('#pan_search').on('click', function() {
                $('.table_nfDiv').addClass('hidden');
                fetch_candidate(data = status, office = null, pan = $('#pan').val(), district = null);
                $('#pan').val('');
            });
            $('.tabBtn').on('click', function() {
                var sw = '#' + $(this).attr('tabFor');
                status = $(this).attr('tabFor');
                var office_search = $('#office_select').val();
                var district_search = $('#district_select').val();
                var post_id = $('#posts').val();
                var pan_search = $('#pan').val();
                if (pan_search == '') {
                    pan_search = null
                }

                fetch_candidate(data = status, office = office_search, pan = pan_search, district =
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
