@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Approver login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6 flex flex-col space-y-2">
                <div class="flex items-center justify-between">
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.heading') - {{ $request_number }}</p>
                    <div class="w-32">
                        <a href="/verifier/download-joint-transfer/{{ Crypt::encryptString($id) }}"
                            class="text-center bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-1 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                            target="_blank">Download JTS</a>
                    </div>
                </div>


                <div>
                    <p class="italic font-semibold">@lang('authority_dashboard.profile_details_jts.requested_on'): {{ $request_date }}</p>
                </div>

            </div>

            <div class="">
                <div class="text-sm font-medium text-center text-gray-900 border-b border-gray-200 mb-6">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="me-2">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 text-base font-bold tabBtn"
                                tabFor="pending">@lang('authority_dashboard.profile_details_jts.applicant_1')</button>
                        </li>
                        <li class="me-2 hidden">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-900 hover:border-gray-300 text-base font-bold tabBtn"
                                tabFor="approved">@lang('authority_dashboard.profile_details_jts.applicant_2')</button>
                        </li>
                    </ul>
                </div>
                <div class="tabItems " id="pending">
                    <div class="gap-24">
                        <!-- <div class="flex-shrink-0">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <img src="../../assets/img/profile.jpg" alt="" class="h-32 w-32 rounded-full object-cover object-center">                                                                                                                                                           </div> -->
                        <div class="grid gap-6">
                            <div
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.basic_info.heading')</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.name')</label>
                                    <p class="font-semibold">{{ $candidate1->full_name ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.gender')</label>
                                    <p class="font-semibold">{{ $candidate1->persional_details->gender ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.dob')</label>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($candidate1->persional_details->date_of_birth)->format('d-m-Y') ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.f_name')</label>
                                    <p class="font-semibold">{{ $candidate1->persional_details->father_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.m_name')</label>
                                    <p class="font-semibold">{{ $candidate1->persional_details->mother_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.caste')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->persional_details->caste->caste_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pno')</label>
                                    <p class="font-semibold">{{ $candidate1->phone ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.apno')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->persional_details->alt_phone_number ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.email')</label>
                                    <p class="font-semibold">{{ $candidate1->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pan')</label>
                                    <p class="font-semibold">{{ $candidate1->persional_details->pan_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.h_d')</label>
                                    <p class="font-semibold truncate">
                                        {{ $candidate1->persional_details->districts->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.emp_info.heading')</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dist_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->employment_details->districts->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dept_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->employment_details->departments->name ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.direc_cp')</label>
                                    <p class="font-semibold truncate w-full whitespace-normal">
                                        {{ isset($candidate1->employment_details->directorate_id) ? ($candidate1->employment_details->directorate_id === 0 ? 'Not Applicable' : $candidate1->employment_details->directorate->name ?? 'N/A') : 'Not Assign' }}
                                    </p>
                                </div>

                                <div class="col-span-2">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.office_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->employment_details->offices_finassam->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.desg_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->employment_details->post_names->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_fj')
                                    </label>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($candidate1->employment_details->first_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.time_of_service')</label>
                                    <p class="font-semibold truncate">
                                        {{ $candidate1->employment_details->time_of_service ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_cp')
                                    </label>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($candidate1->employment_details->current_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.g_pay')</label>
                                    <p class="font-semibold">{{ $candidate1->employment_details->pay_grade ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.p_bank')</label>
                                    <p class="font-semibold">{{ $candidate1->employment_details->pay_band ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                <div class="col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.prefs.heading')</p>
                                </div>
                                @php
                                    $positions = [
                                        '1' => __('user.form.prefs.1'),
                                        '2' => __('user.form.prefs.2'),
                                        '3' => __('user.form.prefs.3'),
                                        '4' => __('user.form.prefs.4'),
                                        '5' => __('user.form.prefs.5'),
                                    ];
                                @endphp
                                @foreach ($candidate1->preferences_district as $location)
                                    <div class="relative">
                                        <span
                                            class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-900">{{ $positions[$location->preference_no] }}</span>
                                        <div class="block p-2.5 pl-16 w-full">
                                            <p class="font-semibold">{{ $location->districts->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            {{-- <div
                                class="grid lg:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.ccp')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate1->additional_info->criminal_case ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.dpp')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate1->additional_info->departmental_proceedings ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.mtb')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate1->additional_info->mutual_transfer ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.no_mt')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate1->additional_info->mutual_transfer == 'yes' ? $candidate1->additional_info->no_mutual_transfer ?? 'N/A' : 'N/A' }}
                                    </p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.govt_due')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate1->additional_info->pending_govt_dues ?? 'N/A' }}</p>
                                </div>
                            </div> --}}



                            {{-- //////////////////// --}}
                            <div
                                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                                <div class="sm:col-span-2 md:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
                                </div>
                                {{-- <div>
                <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.addl_info.ccp')</label>
                <p class="font-semibold truncate">{{ strtoupper($viewData->additional_info->criminal_case ?? 'N/A') }}
                </p>
            </div>
            <div class="">
                <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.addl_info.dpp')</label>
                <p class="font-semibold truncate">
                    {{ strtoupper($viewData->additional_info->departmental_proceedings ?? 'N/A') }}</p>
            </div>
            <div class="">
                <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.addl_info.mtb')</label>
                <p class="font-semibold truncate">
                    {{ strtoupper($viewData->additional_info->mutual_transfer ?? 'N/A') }}</p>
            </div>
            <div class="">
                <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.addl_info.no_mt')</label>
                <p class="font-semibold truncate">
                    {{ $viewData->additional_info->mutual_transfer == 'yes' ? $viewData->additional_info->no_mutual_transfer ?? 'N/A' : 'N/A' }}
                </p>
            </div>
            <div class="">
                <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.addl_info.govt_due')</label>
                <p class="font-semibold truncate">
                    {{ strtoupper($viewData->additional_info->pending_govt_dues ?? 'N/A') }}</p>
            </div> --}}

                                <div class="">
                                    <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">How many
                                        times have you
                                        availed mutual transfer ?</label>

                                    <p class="font-semibold truncate">
                                        {{ $candidate1->additional_info->times_mutual_transfer ?? 'N/A' }}
                                    </p>
                                </div>
                                {{-- <div class=""></div>
            <div class="flex flex-col items-center justify-center table_nfDiv">
                <img src="/images/nfd.png" alt="" class="w-36 object-center mb-2">
                <p class="text-gray-500 font-bold text-lg text-center">No Tranfser History Found!</p>
            </div> --}}
                            </div>

                            {{-- ///////////////////// --}}




                            <div
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.docs.heading')</p>
                                </div>
                                @php
                                    $key = 1;
                                @endphp
                                @foreach ($candidate1->documents as $document)
                                    @if (
                                        $document['document_type'] != 5 ||
                                            ($document['document_type'] == 5 && $candidate1->additional_info->pending_govt_dues == 'no'))
                                        <div class="border rounded-xl bg-neutral-600">
                                            @php
                                                $name = config(
                                                    'globalVariables.registration_documtns.' .
                                                        $document['document_type'],
                                                );
                                            @endphp
                                            <div class="text-white text-center p-2 text-xs">
                                                {{ Str::upper(str_replace('_', ' ', __("user.form.docs.$key"))) }}
                                            </div>
                                            <div class="h-44 p-2 pt-0">
                                                <img src="{{ Storage::url($document['documet_location'] ?? 'N/A') }}"
                                                    alt="" class="w-full h-full object-contain object-center">
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            </div>

                            {{-- @if (count($candidate_1_doc) != 0)
                                <div
                                    class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                    <div class="lg:col-span-3">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.verifier_documents')</p>
                                    </div>
                                    @foreach ($candidate_1_doc as $d)
                                        <a href="{{ asset('storage/' . $d['document_location']) }}" target="_blank"
                                            class="border rounded-xl bg-neutral-600">
                                            <div class="text-white text-center p-2">{{ $d['remarks'] }}</div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif --}}
                            @if (count($candidate_1_doc) != 0 || $candidate1->comment != null)
                                <div
                                    class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                    <div class="lg:col-span-3">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.additional_documents')</p>
                                    </div>
                                    @foreach ($candidate_1_doc as $d)
                                        <a href="{{ asset('storage/' . $d['document_location']) }}" target="_blank"
                                            class="border rounded-xl bg-neutral-600">
                                            <div class="text-white text-center p-2">{{ $d['remarks'] }}</div>
                                        </a>
                                    @endforeach
                                    {{-- <div class="lg:col-span-3 flex flex-col">
                                        @if ($candidate1->comment != null)
                                            <p class="font-semibold mt-auto"> {{ $candidate1->comment }}</p>
                                        @endif
                                    </div> --}}
                                    <div id="comment-container" class="lg:col-span-3">
                                        <textarea name="comment" id="comment"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-300 focus:ring-opacity-50"
                                            @if (Auth::guard('user_guard')->user()->role_id != 6) disabled @endif cols="30" rows="5"
                                            placeholder="I have concerns regarding">{{ $candidate1->comment }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <!-- Verification and Noc status displayed after verified -->
                            @if ($candidate1->profile_verify_status != 0 && $candidate1->profile_verify_status != 2)
                                <!-- Verification and Noc status displayed after verified -->

                                <div
                                    class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                    <div class="lg:col-span-3">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.vnr')</p>
                                    </div>

                                    <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Verified
                                        Status</label>
                                    <p class="font-semibold">Yes</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.verifier')</label>
                                    <p class="font-semibold">{{ $verified_by != null ? $verified_by->name : 'N/A' }},
                                        {{ $verified_by != null ? $verified_by->designation : 'N/A' }},
                                        {{ $office_name != null ? $office_name : 'N/A' }},
                                        {{ $department_name != null ? $department_name : 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.verifier_remarks')</label>
                                    <p class="font-semibold">
                                        {{ $candidate1->verified_remarks != null ? $candidate1->verified_remarks : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.verifier_on')</label>
                                    <p class="font-semibold">
                                        {{ $verified_on == null ? 'N/A' : \Carbon\Carbon::parse($verified_on)->format('d-m-Y') }}
                                    </p>
                                </div>
                                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Appointing
                                    Authority</label>
                                <p class="font-semibold">{{ $candidate2->noc_generate == 1 ? 'Yes' : 'No' }}</p>
                        </div>

                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.appointing_authority')</label>
                                        <p class="font-semibold">
                                            {{ $noc_generated_by != null ? $noc_generated_by->name : 'N/A' }},
                                            {{ $noc_generated_by != null ? $noc_generated_by->designation : 'N/A' }},{{ $noc_office_name != null ? $noc_office_name : 'N/A' }},
                                            {{ $noc_department_name != null ? $noc_department_name : 'N/A' }}</p>
                                    </div> --}}
                        {{-- <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.appointing_authority_remarks')</label>
                                        <p class="font-semibold">
                                            {{ $candidate2->noc_remarks != null ? $candidate2->noc_remarks : 'N/A' }}</p>
                                    </div> --}}
                        {{-- <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.recommended_on')</label>
                                        <p class="font-semibold">
                                            {{ $noc_generated_on == null ? 'N/A' : \Carbon\Carbon::parse($noc_generated_on)->format('d-m-Y') }}
                                        </p>
                                    </div> --}}

                        @if ($approved_by != null)
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approved_by')</label>
                                <p class="font-semibold">
                                    {{ $approved_by->name }},{{ $approver_office_name != null ? $approver_office_name : 'N/A' }},
                                    {{ $approver_department_name != null ? $approver_department_name : 'N/A' }}
                                </p>
                            </div>
                        @endif
                        @if ($approved_by != null)
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approver_remarks')</label>
                                <p class="font-semibold">
                                    {{ $approver_remarks == null ? 'N/A' : $approver_remarks }}</p>
                            </div>
                        @endif
                        @if ($approved_by != null)
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.approved_on')</label>
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($approved_on)->format('d-m-Y') }}</p>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="tabItems hidden" id="approved">
            <div class="gap-24">
                <div class="grid gap-6">
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('user.form.basic_info.heading')</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.name')</label>
                            <p class="font-semibold">{{ $candidate2->full_name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.gender')</label>
                            <p class="font-semibold">{{ $candidate2->persional_details->gender ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.dob')</label>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($candidate2->persional_details->date_of_birth)->format('d-m-Y') ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.f_name')</label>
                            <p class="font-semibold">{{ $candidate2->persional_details->father_name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.m_name')</label>
                            <p class="font-semibold">{{ $candidate2->persional_details->mother_name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.caste')</label>
                            <p class="font-semibold">
                                {{ $candidate2->persional_details->caste->caste_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pno')</label>
                            <p class="font-semibold">{{ $candidate2->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.apno')</label>
                            <p class="font-semibold">
                                {{ $candidate2->persional_details->alt_phone_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.email')</label>
                            <p class="font-semibold">{{ $candidate2->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pan')</label>
                            <p class="font-semibold">{{ $candidate2->persional_details->pan_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.h_d')</label>
                            <p class="font-semibold truncate">
                                {{ $candidate2->persional_details->districts->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('user.form.emp_info.heading')</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dist_cp')</label>
                            <p class="font-semibold">
                                {{ $candidate2->employment_details->districts->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dept_cp')</label>
                            <p class="font-semibold">
                                {{ $candidate2->employment_details->departments->name ?? 'N/A' }}</p>
                        </div>
                        <div class="">
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.direc_cp')</label>
                            <p class="font-semibold truncate w-full whitespace-normal">
                                {{ isset($candidate2->employment_details->directorate_id) ? ($candidate2->employment_details->directorate_id === 0 ? 'Not Applicable' : $candidate2->employment_details->directorate->name ?? 'N/A') : 'Not Assign' }}
                            </p>
                        </div>

                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">DDO Code</label>
                        <p class="font-semibold">{{ $candidate2->employment_details->ddo_code ?? 'N/A' }}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.office_cp')</label>
                        <p class="font-semibold">
                            {{ $candidate2->employment_details->offices_finassam->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.desg_cp')</label>
                        <p class="font-semibold">
                            {{ $candidate2->employment_details->post_names->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_fj')</label>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($candidate2->employment_details->first_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.time_of_service')</label>
                        <p class="font-semibold truncate">
                            {{ $candidate2->employment_details->time_of_service ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_cp')
                        </label>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($candidate2->employment_details->current_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.g_pay')</label>
                        <p class="font-semibold">{{ $candidate2->employment_details->pay_grade ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.p_bank')</label>
                        <p class="font-semibold">{{ $candidate2->employment_details->pay_band ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                    <div class="col-span-3">
                        <p class="text-lg font-bold text-sky-700">@lang('user.form.prefs.heading')</p>
                    </div>
                    @php
                        $positions = [
                            '1' => __('user.form.prefs.1'),
                            '2' => __('user.form.prefs.2'),
                            '3' => __('user.form.prefs.3'),
                            '4' => __('user.form.prefs.4'),
                            '5' => __('user.form.prefs.5'),
                        ];
                    @endphp
                    @foreach ($candidate2->preferences_district as $location)
                        <div class="relative">
                            <span
                                class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-900">{{ $positions[$location->preference_no] }}</span>
                            <div class="block p-2.5 pl-16 w-full">
                                <p class="font-semibold">{{ $location->districts->name ?? 'N/A' }}</p>

                            </div>
                        </div>
                    @endforeach
                </div>


                <div
                    class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                    <div class="sm:col-span-2 md:col-span-3">
                        <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
                    </div>


                    <div class="">
                        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">How many
                            times have you
                            availed mutual transfer ?</label>

                        <p class="font-semibold truncate">
                            {{ $candidate2->additional_info->times_mutual_transfer ?? 'N/A' }}
                        </p>
                    </div>

                </div>

                {{-- ///////////////////// --}}
                <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                    <div class="lg:col-span-3">
                        <p class="text-lg font-bold text-sky-700">@lang('user.form.docs.heading')</p>
                    </div>

                    @php
                        $key = 1;
                    @endphp
                    @foreach ($candidate2->documents as $document)
                        @if (
                            $document['document_type'] != 5 ||
                                ($document['document_type'] == 5 && $candidate2->additional_info->pending_govt_dues == 'no'))
                            <div class="border rounded-xl bg-neutral-600">
                                @php
                                    $name = config(
                                        'globalVariables.registration_documtns.' . $document['document_type'],
                                    );
                                @endphp
                                <div class="text-white text-center p-2 text-xs">
                                    {{ Str::upper(str_replace('_', ' ', __("user.form.docs.$key"))) }}
                                </div>
                                <div class="h-44 p-2 pt-0">
                                    <img src="{{ Storage::url($document['documet_location'] ?? 'N/A') }}" alt=""
                                        class="w-full h-full object-contain object-center">
                                </div>
                            </div>
                        @endif
                        @php
                            $key++;
                        @endphp
                    @endforeach
                </div>

                @if (count($candidate_2_doc) != 0 || $candidate1->comment != null)
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.additional_documents')</p>
                        </div>
                        @foreach ($candidate_2_doc as $d)
                            <a href="{{ asset('storage/' . $d['document_location']) }}" target="_blank"
                                class="border rounded-xl bg-neutral-600">
                                <div class="text-white text-center p-2">{{ $d['remarks'] }}</div>
                            </a>
                        @endforeach

                        <div id="comment-container" class="lg:col-span-3">
                            <textarea name="comment" id="comment"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-300 focus:ring-opacity-50"
                                @if (Auth::guard('user_guard')->user()->role_id != 6) disabled @endif cols="30" rows="5"
                                placeholder="I have concerns regarding">{{ $candidate2->comment }}</textarea>
                        </div>
                    </div>
                @endif



                <!-- Verification and Noc status displayed after verified -->
                @if ($candidate2->profile_verify_status != 0 && $candidate2->profile_verify_status != 2)
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.vnr')</p>
                        </div>
                        <!--<div>                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.verifier')</label>
                            <p class="font-semibold">
                                {{ $verified_by2 != null ? $verified_by2->name : 'N/A' }},
                                {{ $verified_by2 != null ? $verified_by2->designation : 'N/A' }},
                                {{ $office_name2 != null ? $office_name2 : 'N/A' }},
                                {{ $department_name2 != null ? $department_name2 : 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.verifier_remarks')</label>
                            <p class="font-semibold">
                                {{ $candidate2->verified_remarks != null ? $candidate2->verified_remarks : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.verifier_on')</label>
                            <p class="font-semibold">
                                {{ $verified_on2 == null ? 'N/A' : \Carbon\Carbon::parse($verified_on)->format('d-m-Y') }}
                            </p>
                        </div>


                        @if ($approved_by != null)
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approved_by')</label>
                                <p class="font-semibold">
                                    {{ $approved_by->name }},{{ $approver_office_name != null ? $approver_office_name : 'N/A' }},
                                    {{ $approver_department_name != null ? $approver_department_name : 'N/A' }}
                                </p>
                            </div>
                        @endif
                        @if ($approved_by != null)
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approver_remarks')</label>
                                <p class="font-semibold">
                                    {{ $approver_remarks == null ? 'N/A' : $approver_remarks }}</p>
                            </div>
                        @endif
                        @if ($approved_by != null)
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.approved_on')</label>
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($approved_on)->format('d-m-Y') }}</p>
                            </div>

                        @endif
                    </div>
                    <!-- Verification and Noc status displayed after verified end -->
                @endif
                <!-- Verification and Noc status displayed after verified end -->
            </div>
        </div>
    </div>
    </div>
    <div class="mt-12">
        <div class="flex items-center justify-between gap-4">
            <div>
                <a href="/{{ app()->getLocale() }}/department/department-dashboard"
                    class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                        class="bi bi-arrow-left"></i> @lang('authority_dashboard.profile_details.btd')</a>
            </div>
            <div class="flex items-center justify-end gap-1">
                <button type="button" id="previous"
                    class="hidden bg-gray-800 hover:bg-gray-900 border border-transparent text-gray-100 rounded-md block px-2 py-1.5 duration-300"><i
                        class="bi bi-arrow-left"></i> @lang('authority_dashboard.profile_details.previous') </button>
                @if ($approval_status != 1)
                    <button type="button" id="block"
                        class="bg-red-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 block-btn hidden">@lang('authority_dashboard.profile_details_jts.block')</button>
                    <button type="button" id="reject"
                        class="bg-red-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn hidden">@lang('authority_dashboard.profile_details_jts.reject_transfer')</button>
                    <button type="button" id="final_approve"
                        class="hidden bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest"
                        data-id="{{ Crypt::encryptString($id) }}">@lang('authority_dashboard.profile_details_jts.approve_transfer')</button>
                @elseif($approval_status == 1)
                    @if ($jto_status == 1)
                        <a href="/jto-certificate/{{ Crypt::encryptString($id) }}"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                            data-id="">@lang('authority_dashboard.profile_details_jts.download_transfer')</a>
                    @else
                        <a href="/jto-certificate/{{ Crypt::encryptString($id) }}" id="jto-btn"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                            data-id="">@lang('authority_dashboard.profile_details_jts.generate_transfer')</a>
                    @endif
                @endif
                <button type="button" id="next"
                    class="bg-gray-800 hover:bg-gray-900 border border-transparent text-gray-100 rounded-md block px-2 py-1.5 duration-300">@lang('authority_dashboard.profile_details.next')
                    <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>

        <!-- modal -->
        <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
            id="directRequestModal">
            <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                <div class="space-y-2 mb-6">
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.approve_transfer')</p>
                </div>
                <form action="{{ url('department/final-approval-profile') }}" method="post">
                    @csrf
                    <div class="grid gap-8">
                        <input type="hidden" id="verify_profile_id" name="id"
                            value="{{ Crypt::encryptString($id) }}">
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.remarks')</label>
                            <textarea name="verifier_remarks" id="verification_remarks_id" value=""
                                class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                rows="4">Approved</textarea>
                        </div>
                        <div class="flex gap-1 justify-end">
                            <button type="button"
                                class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                id="closeDirectRequestModalButton">@lang('authority_dashboard.profile_details.close')</button>
                            <button type="button"
                                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit"
                                id="approve_btn">@lang('authority_dashboard.profile_details_jts.approve_transfer')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>



    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
        id="rejectModal">
        <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
            <div class="space-y-2 mb-6">
                <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.reject_transfer')</p>
            </div>
            <form action="{{ url('department/final-reject-profile') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <div>
                        <input type="hidden" id="candidate_reject_id" name="candidate_reject_id"
                            value="{{ Crypt::encryptString($id) }}">
                        <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details_jts.rejection_reason')</label>
                        <textarea name="reject_message"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            rows="4" required></textarea>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeRejectModalButton">@lang('authority_dashboard.profile_details.close')</button>
                        <button type="button"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit reject-btn">@lang('authority_dashboard.profile_details_jts.reject_transfer')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    {{-- block modal --}}
    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
        id="blockModal">
        <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
            <div class="space-y-2 mb-6">
                <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.block_heading')</p>
            </div>
            <form action="{{ url('/department/block-candidate') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <div class="grid">
                        <div class="flex items-center gap-2">
                            <input type="hidden" name="transfer_id" value="{{ Crypt::encryptString($id) }}">
                            <input type="checkbox" name="blocked_candidate[]"
                                value="{{ Crypt::encryptString($candidate1->id) }}"
                                class="border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5 ">
                            <p class="text-xs text-gray-900">{{ $candidate1->full_name }}</p>
                            <input type="checkbox" name="blocked_candidate[]"
                                value="{{ Crypt::encryptString($candidate2->id) }}"
                                class="border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5 ">
                            <p class="text-xs text-gray-900">{{ $candidate2->full_name }}</p>
                        </div>
                        <textarea name="reject_message" id="block_reject_message"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full mt-2"
                            rows="4" required></textarea>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeBlockModal">@lang('authority_dashboard.profile_details.close')</button>
                        <button type="button"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit final-block-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<!-- footer -->
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
        $(document).ready(function(argument) {
            $('.final-block-btn').on('click', function() {
                if ($('input[name="blocked_candidate[]"]:checked').length === 0) {
                    Swal.fire({
                        title: 'No Candidate Selected',
                        text: 'Please select at least one candidate to block.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                if ($('#block_reject_message').val() === '') {
                    Swal.fire({
                        title: 'No Remarks',
                        text: 'Remarks is required',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Block"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });


            $('#approve_btn').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Approve"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });

            $('.reject-btn').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Reject"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });


            $('.block-btn').on('click', function() {
                var id = $(this).data('id');
                $('#verify_profile_id').val(id)
                if ($('#blockModal').hasClass('hidden')) {
                    $('#blockModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });

            $('#closeBlockModal').on('click', function() {
                $('#blockModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });

            $('#jto-btn').on('click', function() {
                $(this).html("Download Transfer Order")
            });
            // Verify Modal
            $('#next').on('click', function() {
                $('#block').removeClass('hidden');
                $('#reject').removeClass('hidden');
                $('#final_approve').removeClass('hidden');
                $('#final_approve2').removeClass('hidden');
                $('#pending').addClass('hidden');
                $('#approved').removeClass('hidden');
                $('#previous').removeClass('hidden');
                $('#next').addClass('hidden');
                $('button[tabFor="pending"]').closest('li').addClass('hidden');
                $('#pending').addClass('hidden');
                $('button[tabFor="approved"]').closest('li').removeClass('hidden');
                $('#approved').removeClass('hidden');
                window.scrollTo(0, 0);
            });
            $('#previous').on('click', function() {
                $('#reject').addClass('hidden');
                $('#block').addClass('hidden');
                $('#final_approve').addClass('hidden');
                $('#approved').addClass('hidden');
                $('#previous').addClass('hidden');
                $('#next').removeClass('hidden');
                $('#pending').removeClass('hidden');
                $('button[tabFor="pending"]').closest('li').removeClass('hidden');
                $('#pending').removeClass('hidden');
                $('button[tabFor="approved"]').closest('li').addClass('hidden');
                $('#approved').addClass('hidden');
                window.scrollTo(0, 0);
            })
            $('.directRequest').on('click', function() {
                var id = $(this).data('id');
                $('#verify_profile_id').val(id)
                if ($('#directRequestModal').hasClass('hidden')) {
                    $('#directRequestModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeDirectRequestModalButton').on('click', function() {
                $('#directRequestModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });
            // NOC Modal
            $('#final_approve2').on('click', function() {
                let id = $(this).data('id');
                $('#2nd_recommend_id').val(id);
                if ($('#directNOCModal').hasClass('hidden')) {
                    $('#directNOCModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('.rejectRequestBtn').on('click', function() {
                if ($('#rejectModal').hasClass('hidden')) {
                    $('#rejectModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeRejectModalButton').on('click', function() {
                $('#rejectModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });
            $('#closeDirectNOCModalButton').on('click', function() {
                $('#directNOCModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });

            $('#jto-btn').on('click', function() {
                $(this).html("Download Transfer Order")
            });


            // Document
            $(document).on('click', '.up_doc_rmv_btn', function() {
                var up_prev_rmv = $(this);
                up_prev_rmv.closest('.up_doc_prev_con').addClass('hidden');
                up_prev_rmv.closest('.up_doc_con').find('.up_input').val(''); // Clear the file input field
            });
            $(document).on('change', '.up_input', function() {
                var up_prev = $(this);
                var up_prev_name = $(this)[0].files[0];
                if (up_prev.val() != null && up_prev.val() != "") {
                    up_prev.closest('.up_doc_con').find('.up_doc_prev_con').removeClass('hidden');
                } else {
                    up_prev.closest('.up_doc_con').find('.up_doc_prev_con').addClass('hidden');
                }
                if (up_prev_name) {
                    var fileName = up_prev_name.name;
                    up_prev.closest('.up_doc_con').find('.up_doc_name').html(fileName);
                }
            });
            $('.tabBtn').on('click', function() {
                var sw = '#' + $(this).attr('tabFor');
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
