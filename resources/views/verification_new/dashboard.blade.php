@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">Dashboard</p>
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
                <div class="grid grid-cols-5 gap-4">
                    @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing User')
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $all_users->count() }}</p>
                                    <p class="text-gray-900">Total Requests</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                            <div class="flex gap-6">
                                <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                        class="text-lg bi bi-exclamation-circle text-black"></i></div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $pending_users->count() }}</p>
                                    <p class="">Pending Profiles</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $verified_profiles->count() }}</p>
                                    <p class="text-gray-900">Verified Profiles</p>
                                </div>
                            </div>
                        </a>
                    @elseif(Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $verified_profiles->count() }}</p>
                                    <p class="text-gray-900">Total Requests</p>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-inboxes text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $all_users->count() }}</p>
                                    <p class="text-gray-900">Total Requests</p>
                                </div>
                            </div>
                        </a>
                    @endif
                    @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-sky-500 border-sky-500 text-white rounded-2xl p-6">
                            <div class="flex gap-6">
                                <div class="h-10 w-10 bg-gray-50 flex items-center justify-center rounded-full"><i
                                        class="text-lg bi bi-exclamation-circle text-black"></i></div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $pending_users->count() }}</p>
                                    <p class="">Pending Profiles</p>
                                </div>
                            </div>
                        </a>
                    @endif
                    @if (Auth::guard('user_guard')->user()->roles->role == 'Appointing User' ||
                            Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-person-exclamation text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($noc_pending) }}</p>
                                    <p class="text-gray-900">Recommendation Pending</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ url('verifier/candidate-verify') }}"
                            class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-person-check text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ count($noc_completed) }}</p>
                                    <p class="text-gray-900">Recommended</p>
                                </div>
                            </div>
                        </a>
                    @endif
                    @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
                        <a href="#" class="bg-white border rounded-2xl p-6 border-b-4 border-r-4 border-gray-400">
                            <div class="flex gap-6">
                                <div
                                    class="h-10 w-10 bg-sky-200 flex items-center justify-center rounded-full flex-shrink-0">
                                    <i class="text-lg bi bi-person-check text-sky-600"></i>
                                </div>
                                <div class="">
                                    <p class="text-3xl font-bold">{{ $verified_profiles->count() }}</p>
                                    <p class="text-gray-900">Verified Profiles</p>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
            <div class="mt-12 space-y-12">
                <div class="flex items-bottom justify-between">
                    <p class="text-xl">Latest Requests</p>
                    <a href="{{ url('verifier/candidate-verify') }}" class="hover:underline text-gray-900 text-xs">View all
                        <i class="bi bi-arrow-up-right"></i></a>
                </div>
                @if (Auth::guard('user_guard')->user()->roles->role == 'Verifier')
                    @if (count($all_users) == 0)
                        <div class="flex flex-col items-center justify-center table_nfDiv">
                            <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                            <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p>
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
                                        <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">
                                            {{ $v->phone }}</td>
                                        <td class="py-4 px-6 text-xs">
                                            @if ($v->profile_verify_status == 0)
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
                                        <td class="py-4 px-6 text-xs">
                                            <div class="flex justify-center gap-1">
                                                {{-- <button type="button" data-id="{{$v->id}}" class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1.5 rounded-md text-xs directRequest"><i class="bi bi-check"></i></button> --}}
                                                {{-- <button type="button" data-id="{{$v->id}}" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded-md text-xs rejectRequestBtn"><i class="bi bi-x"></i></button> --}}
                                                {{-- <form action="{{ url('/verifier/candidate-profile')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$v->id}}">
                                            <button type="submit" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</button>
                                        </form> --}}
                                                <a href="/verifier/candidate-profile/{{ Crypt::encryptString($v->id) }}"
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
            @elseif(Auth::guard('user_guard')->user()->roles->role == 'Appointing Authority')
                @if (count($verified_profiles) == 0)
                    <div class="flex flex-col items-center justify-center table_nfDiv">
                        <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                        <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p>
                    </div>
                @else
                    <div class="border rounded-2xl overflow-hidden bg-white">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Name & Designation
                                    </th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Office &
                                        Department</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                                    <th class="p-4 px-6 font-medium text-sm text-gray-900">Status</th>
                                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($verified_profiles as $v)
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
                                    <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">
                                        {{ $v->phone }}</td>
                                    <td class="py-4 px-6 text-xs">
                                        @if ($v->noc_generate == 0)
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
                                    <td class="py-4 px-6 text-xs">
                                        <div class="flex justify-center gap-1">
                                            {{-- <button type="button" data-id="{{$v->id}}" class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1.5 rounded-md text-xs directRequest"><i class="bi bi-check"></i></button> --}}
                                            {{-- <button type="button" data-id="{{$v->id}}" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded-md text-xs rejectRequestBtn"><i class="bi bi-x"></i></button> --}}
                                            {{-- <form action="{{ url('/verifier/candidate-profile')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$v->id}}">
            <button type="submit" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300 view-profile-btn">@lang('authority_dashboard.table.view_details')</button>
        </form> --}}
                                            <a href="/verifier/candidate-profile/{{ Crypt::encryptString($v->id) }}"
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
        @elseif(Auth::guard('user_guard')->user()->roles->role == 'Appointing User')
            @if (count($all_users) == 0)
                <div class="flex flex-col items-center justify-center table_nfDiv">
                    <img src="{{ asset('images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                    <p class="text-gray-500 font-bold text-lg">No Applicants Found!</p>
                </div>
            @else
                {{-- for noc pending --}}
                <div class="border rounded-2xl overflow-hidden bg-white">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Name & Designation
                                </th>
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Office &
                                    Department</th>
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                                <th class="p-4 px-6 font-medium text-sm text-gray-900">Verification Status</th>
                                <th class="p-4 px-6 font-medium text-sm text-gray-900">Recommendation Status</th>
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
                                    <div class="flex justify-center">
                                        @if ($v->profile_verify_status == 1)
                                            <div
                                                class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                <i class="bi bi-check-circle"></i>
                                            </div>
                                        @else
                                            <div
                                                class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                <i class="bi bi-clock"> </i>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-xs">
                                    <div class="flex justify-center">
                                        @if ($v->noc_generate == 1)
                                            <div
                                                class="text-green-500 border border-transparent text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                <i class="bi bi-check-circle"></i>
                                            </div>
                                        @else
                                            <div
                                                class="text-yellow-500 border border-transparent text-white text-xs rounded block px-4 py-1.5 font-semibold w-fit">
                                                <i class="bi bi-clock"> </i>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-xs">
                                    <div class="flex justify-center gap-1">
                                        <a href="/verifier/candidate-profile/{{ Crypt::encryptString($v->id) }}"
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
            <p class="text-xs text-gray-900">I confirm that the information provided by the employee matches
                the official records and no discrepancies were found during the verification process.</p>
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
