@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Approver login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6 flex flex-col space-y-2">
                <div>
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.heading') - {{ $request_number }}</p>
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
                        <!-- <div class="flex-shrink-0">
                                                                                                                                                                                                                                                                <img src="../../assets/img/profile.jpg" alt="" class="h-32 w-32 rounded-full object-cover object-center">
                                                                                                                                                                                                                                                            </div> -->
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
                                <!-- <div class="">
                                                                                                                                                                                                                                                                        <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">DDO Code</label>
                                                                                                                                                                                                                                                                        <p class="font-semibold">{{ $candidate1->employment_details->ddo_code ?? 'N/A' }}</p>
                                                                                                                                                                                                                                                                    </div> -->
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
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_fj')</label>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($candidate1->employment_details->first_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
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
                            <div
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
                            </div>

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
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.new_verifier_documents')</p>
                                    </div>
                                    @foreach ($candidate_1_doc as $d)
                                        <a href="{{ asset('storage/' . $d['document_location']) }}" target="_blank"
                                            class="border rounded-xl bg-neutral-600">
                                            <div class="text-white text-center p-2">{{ $d['remarks'] }}</div>
                                        </a>
                                    @endforeach
                                    <div class="lg:col-span-3 flex flex-col">
                                        @if ($candidate1->comment != null)
                                            <p class="font-semibold mt-auto"> {{ $candidate1->comment }}</p>
                                        @endif
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
                                    <!--<div>
                                                                                                                                                                                                                                                                                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Verified Status</label>
                                                                                                                                                                                                                                                                                <p class="font-semibold">Yes</p>
                                                                                                                                                                                                                                                                            </div> -->
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
                                    <!-- <div>
                                                                                                                                                                                                                                                                                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Appointing Authority</label>
                                                                                                                                                                                                                                                                                <p class="font-semibold">{{ $candidate2->noc_generate == 1 ? 'Yes' : 'No' }}</p>
                                                                                                                                                                                                                                                                            </div> -->
                                    <div>

                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.appointing_authority')</label>
                                        <p class="font-semibold">
                                            {{ $noc_generated_by != null ? $noc_generated_by->name : 'N/A' }},
                                            {{ $noc_generated_by != null ? $noc_generated_by->designation : 'N/A' }},{{ $noc_office_name != null ? $noc_office_name : 'N/A' }},
                                            {{ $noc_department_name != null ? $noc_department_name : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.appointing_authority_remarks')</label>
                                        <p class="font-semibold">
                                            {{ $candidate1->noc_remarks != null ? $candidate1->noc_remarks : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.recommended_on')</label>
                                        <p class="font-semibold">
                                            {{ $noc_generated_on == null ? 'N/A' : \Carbon\Carbon::parse($noc_generated_on)->format('d-m-Y') }}
                                        </p>
                                    </div>



                                    @if ($ar != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.department_hod')</label>
                                            <p class="font-semibold">
                                                {{ $ar->name }},{{ $sr_office_name != null ? $sr_office_name : 'N/A' }},
                                                {{ $sr_department_name != null ? $sr_department_name : 'N/A' }}</p>
                                        </div>
                                    @endif
                                    @if ($ar != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.remarks_hod')</label>
                                            <p class="font-semibold">{{ $srr == null ? 'N/A' : $srr }}</p>
                                        </div>
                                    @endif
                                    @if ($ar != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.hod_recommended_on')</label>
                                            <p class="font-semibold">
                                                {{ \Carbon\Carbon::parse($second_recommended_on)->format('d-m-Y') }}</p>
                                        </div>
                                    @endif

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

                <div class="tabItems hidden" id="approved">
                    <div class="gap-24">
                        <!-- <div class="flex-shrink-0">
                                                                                                                                                                                                                                                                        <img src="../../assets/img/profile.jpg" alt="" class="h-32 w-32 rounded-full object-cover object-center">
                                                                                                                                                                                                                                                                    </div> -->
                        <div class="grid gap-6">
                            <div
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
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
                                        {{ $candidate2->employment_details->districts->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dept_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate2->employment_details->departments->name ?? 'N/A' }}</p>
                                </div>
                                <!-- <div class="">
                                                                                                                                                                                                                                                                                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">DDO Code</label>
                                                                                                                                                                                                                                                                                <p class="font-semibold">{{ $candidate2->employment_details->ddo_code ?? 'N/A' }}</p>
                                                                                                                                                                                                                                                                            </div> -->
                                <div class="col-span-2">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.office_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate2->employment_details->offices_finassam->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.desg_cp')</label>
                                    <p class="font-semibold">
                                        {{ $candidate2->employment_details->post_names->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_fj')</label>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($candidate2->employment_details->first_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_cp')
                                    </label>
                                    <p class="font-semibold">
                                        {{ \Carbon\Carbon::parse($candidate2->employment_details->first_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.g_pay')</label>
                                    <p class="font-semibold">{{ $candidate2->employment_details->pay_grade ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.p_bank')</label>
                                    <p class="font-semibold">{{ $candidate2->employment_details->pay_band ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
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
                                class="grid lg:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.ccp')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate2->additional_info->criminal_case ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.dpp')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate2->additional_info->departmental_proceedings ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.mtb')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate2->additional_info->mutual_transfer ?? 'N/A' }}</p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.no_mt')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate2->additional_info->mutual_transfer == 'yes' ? $candidate2->additional_info->no_mutual_transfer ?? 'N/A' : 'N/A' }}
                                    </p>
                                </div>
                                <div class="">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.govt_due')</label>
                                    <p class="font-semibold uppercase">
                                        {{ $candidate2->additional_info->pending_govt_dues ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
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

                            {{-- @if (count($candidate_2_doc) != 0)
                                <div
                                    class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                    <div class="lg:col-span-3">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.verifier_documents')</p>
                                    </div>
                                    @foreach ($candidate_2_doc as $d)
                                        <a href="{{ asset('storage/' . $d['document_location']) }}" target="_blank"
                                            class="border rounded-xl bg-neutral-600">
                                            <div class="text-white text-center p-2">{{ $d['remarks'] }}</div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif --}}

                            @if (count($candidate_2_doc) != 0 || $candidate2->comment != null)
                                <div
                                    class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                    <div class="lg:col-span-3">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.new_verifier_documents')</p>
                                    </div>
                                    @foreach ($candidate_2_doc as $d)
                                        <a href="{{ asset('storage/' . $d['document_location']) }}" target="_blank"
                                            class="border rounded-xl bg-neutral-600">
                                            <div class="text-white text-center p-2">{{ $d['remarks'] }}</div>
                                        </a>
                                    @endforeach
                                    <div class="lg:col-span-3 flex flex-col">
                                        @if ($candidate2->comment != null)
                                            <p class="font-semibold mt-auto"> {{ $candidate2->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif


                            <!-- Verification and Noc status displayed after verified -->
                            @if ($candidate2->profile_verify_status != 0 && $candidate2->profile_verify_status != 2)
                                <!-- Verification and Noc status displayed after verified -->
                                <div
                                    class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                    <div class="lg:col-span-3">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.vnr')</p>
                                    </div>
                                    <!--<div>
                                                                                                                                                                                                                                                                                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Verified Status</label>
                                                                                                                                                                                                                                                                                <p class="font-semibold">Yes</p>
                                                                                                                                                                                                                                                                            </div> -->
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
                                            {{ $candidate2->verified_remarks != null ? $candidate2->verified_remarks : 'N/A' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.verifier_on')</label>
                                        <p class="font-semibold">
                                            {{ $verified_on == null ? 'N/A' : \Carbon\Carbon::parse($verified_on)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                    <!-- <div>
                                                                                                                                                                                                                                                                                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Appointing Authority</label>
                                                                                                                                                                                                                                                                                <p class="font-semibold">{{ $candidate2->noc_generate == 1 ? 'Yes' : 'No' }}</p>
                                                                                                                                                                                                                                                                            </div> -->
                                    <div>

                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.appointing_authority')</label>
                                        <p class="font-semibold">
                                            {{ $noc_generated_by != null ? $noc_generated_by->name : 'N/A' }},
                                            {{ $noc_generated_by != null ? $noc_generated_by->designation : 'N/A' }},{{ $noc_office_name != null ? $noc_office_name : 'N/A' }},
                                            {{ $noc_department_name != null ? $noc_department_name : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.appointing_authority_remarks')</label>
                                        <p class="font-semibold">
                                            {{ $candidate2->noc_remarks != null ? $candidate2->noc_remarks : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.recommended_on')</label>
                                        <p class="font-semibold">
                                            {{ $noc_generated_on == null ? 'N/A' : \Carbon\Carbon::parse($noc_generated_on)->format('d-m-Y') }}
                                        </p>
                                    </div>



                                    @if ($ar != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.department_hod')</label>
                                            <p class="font-semibold">
                                                {{ $ar->name }},{{ $sr_office_name != null ? $sr_office_name : 'N/A' }},
                                                {{ $sr_department_name != null ? $sr_department_name : 'N/A' }}</p>
                                        </div>
                                    @endif
                                    @if ($ar != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.remarks_hod')</label>
                                            <p class="font-semibold">{{ $srr == null ? 'N/A' : $srr }}</p>
                                        </div>
                                    @endif
                                    @if ($ar != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.hod_recommended_on')</label>
                                            <p class="font-semibold">
                                                {{ \Carbon\Carbon::parse($second_recommended_on)->format('d-m-Y') }}</p>
                                        </div>
                                    @endif

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
                        <a href="/{{ app()->getLocale() }}/verifier/verifier-dashboard"
                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                class="bi bi-arrow-left"></i> @lang('authority_dashboard.profile_details.btd')</a>
                    </div>

                    <div class="flex items-center justify-end gap-1">
                        <button type="button" id="previous"
                            class="hidden bg-gray-800 hover:bg-gray-900 border border-transparent text-gray-100 rounded-md block px-2 py-1.5 duration-300"><i
                                class="bi bi-arrow-left"></i> @lang('authority_dashboard.profile_details.previous')</button>
                        @if ($approval_status != 1 && $second_recommend_status != 1)
                            @if ($dept_count != 0)
                                <button type="button" id="reject2"
                                    class="bg-red-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRecBtn hidden">@lang('authority_dashboard.profile_details_jts.rts')</button>
                                <button type="button" id="final_approve2"
                                    class="hidden bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 "
                                    data-id="{{ Crypt::encryptString($id) }}">@lang('authority_dashboard.profile_details_jts.rt')</button>
                            @elseif($second_recommend_status == 1)
                                {{--  --}}
                            @else
                                <button type="button" id="reject"
                                    class="bg-red-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn hidden">@lang('authority_dashboard.profile_details_jts.reject_transfer')</button>
                                <button type="button" id="final_approve"
                                    class="hidden bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest"
                                    data-id="{{ Crypt::encryptString($id) }}">@lang('authority_dashboard.profile_details_jts.approve_transfer')</button>
                            @endif
                        @elseif($approval_status == 1)
                            @if ($jto_status == 0)
                                <a href="/jto-certificate/{{ Crypt::encryptString($id) }}" id="jto-btn"
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                                    data-id="">@lang('authority_dashboard.profile_details_jts.generate_transfer')</a>
                            @else
                                <a href="/jto-certificate/{{ Crypt::encryptString($id) }}"
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300"
                                    data-id="">@lang('authority_dashboard.profile_details_jts.download_transfer')</a>
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
                        <form action="{{ url('verifier/final-approval-profile') }}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <input type="hidden" id="verify_profile_id" name="id"
                                    value="{{ Crypt::encryptString($id) }}">
                                <!--<div class="flex gap-3">-->
                                <!--    <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>-->
                                <!--    <p class="text-xs text-gray-900">I have thoroughly verified the employee's profile, and I confirm that all provided details, including personal, employment, and contact information, are accurate to the best of my knowledge.</p>-->
                                <!--</div>-->
                                <!--<div class="flex gap-3">-->
                                <!--    <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>-->
                                <!--    <p class="text-xs text-gray-900">I confirm that the information provided by the employee matches the official records and no discrepancies were found during the verification process.</p>-->
                                <!--</div>-->
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.remarks')</label>
                                    <textarea name="verifier_remarks" id="verification_remarks_id" value=""
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                        rows="4"></textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeDirectRequestModalButton">@lang('authority_dashboard.profile_details.close')</button>
                                    <button type="submit"
                                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">@lang('authority_dashboard.profile_details.submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                {{-- 2nd recommend --}}
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
                    id="directNOCModal">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">@lang('authority_dashboard.tab.recommendation')</p>
                        </div>
                        <form action="{{ url('verifier/approval-second-recommend') }}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <input type="hidden" name="2nd_recommend_id" id="2nd_recommend_id" value="" />
                                {{-- <div class="">
                                    <div class="flex gap-3">
                                        
                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                        <p class="text-xs text-gray-900">I confirm that all profiles have been successfully generated and are ready for review.</p>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="flex gap-3">
                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                        <p class="text-xs text-gray-900">I acknowledge that all required documents are in order and approve the NOC generation.</p>
                                    </div>
                                </div> --}}
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.remarks')</label>
                                    <textarea name="2nd_recommend_remarks"
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                        rows="4">I Recommend</textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeDirectNOCModalButton">Close</button>
                                    <button type="button" id="recommend_btn"
                                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">@lang('authority_dashboard.profile_details.ir')
                                    </button>
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
                <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.rt')</p>
            </div>
            <form action="{{ url('verifier/final-reject-profile') }}" method="post">
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
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit reject-transfer-btn">@lang('authority_dashboard.profile_details.submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- recommendation reject modal --}}
    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
        id="rejectModal2">
        <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
            <div class="space-y-2 mb-6">
                <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details_jts.rsr')</p>
            </div>
            <form action="{{ url('verifier/second-recommendation-reject-profile') }}" method="post">
                @csrf
                <div class="grid gap-8">
                    <div>
                        <input type="hidden" id="candidate_reject_id" name="candidate_reject_id"
                            value="{{ Crypt::encryptString($id) }}">
                        <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details_jts.rejection_reason')</label>
                        <textarea name="reject_message"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                            rows="4" required>I do not Recommend</textarea>
                    </div>
                    <div class="flex gap-1 justify-end">
                        <button type="button"
                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                            id="closeRejectModalButton2">@lang('authority_dashboard.profile_details.close')</button>
                        <button type="button"
                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit 2nd_reject">@lang('authority_dashboard.profile_details.rejection_recommendation')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- footer -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function(argument) {

            $('#recommend_btn').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Recommend"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });

            $('.2nd_reject').on('click', function() {
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


            $('.reject-transfer-btn').on('click', function() {
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



            $('.rejectRecBtn').on('click', function() {
                if ($('#rejectModal2').hasClass('hidden')) {
                    $('#rejectModal2').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeRejectModalButton2').on('click', function() {
                $('#rejectModal2').addClass('hidden');
                $('body').css('overflow', 'visible');
            });

            // Verify Modal
            $('#next').on('click', function() {
                $('#reject').removeClass('hidden');
                $('#reject2').removeClass('hidden');
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
                $('#reject2').addClass('hidden');
                $('#final_approve').addClass('hidden');
                $('#final_approve2').addClass('hidden');
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
