@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12 mb-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details.heading')</p>
                </div>
                @if ($candidate->profile_verify_status == 0)
                    <div class="bg-yellow-100 p-6 text-yellow-600 mb-24 rounded-3xl">
                        <div class="flex gap-4">
                            <i class="bi bi-exclamation-triangle mt-0.5"></i>
                            <div class="">
                                <p class="text-xl font-semibold mb-1">@lang('authority_dashboard.profile_details.verification_progress')</p>
                                <p class="text-sm">@lang('authority_dashboard.profile_details.verification_under_review')</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="gap-24">
                <!-- <div class="flex-shrink-0">
                                                                                                                                                                                                                                                                        <img src="../../assets/img/profile.jpg" alt="" class="h-32 w-32 rounded-full object-cover object-center">
                                                                                                                                                                                                                                                                    </div> -->
                <div class="grid gap-6">
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('user.form.basic_info.heading')</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.name')</label>
                            <p class="font-semibold">{{ $candidate->full_name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.gender')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->gender ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.dob')</label>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($candidate->persional_details->date_of_birth)->format('d-m-Y') ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.f_name')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->father_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.m_name')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->mother_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.caste')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->caste->caste_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pno')</label>
                            <p class="font-semibold">{{ $candidate->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.apno')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->alt_phone_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.email')</label>
                            <p class="font-semibold">{{ $candidate->email ?? 'N/A' }}</p>
                        </div>
                        {{-- <div>
                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Govt. ID Type</label>
                <p class="font-semibold">Aadhar Card</p>
            </div> --}}
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pan')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->pan_number ?? 'N/A' }}</p>
                        </div>
                        {{-- <div>
                <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Password</label>
                <p class="font-semibold">XXXXXXXXXXXXXXXX</p>
            </div> --}}
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('user.form.emp_info.heading')</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dist_cp')</label>
                            <p class="font-semibold">{{ $candidate->employment_details->districts->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.dept_cp')</label>
                            <p class="font-semibold">{{ $candidate->employment_details->departments->name ?? 'N/A' }}</p>
                        </div>
                        <!-- <div class="">
                                                                                                                                                                                                                                                                    <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">DDO Code</label>
                                                                                                                                                                                                                                                                    <p class="font-semibold">{{ $candidate->employment_details->ddo_code ?? 'N/A' }}</p>
                                                                                                                                                                                                                                                                </div> -->
                        <div class="col-span-2">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.office_cp')</label>
                            <p class="font-semibold">{{ $candidate->employment_details->offices_finassam->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.desg_cp')</label>
                            <p class="font-semibold">{{ $candidate->employment_details->post_names->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_fj')
                            </label>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($candidate->employment_details->first_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.doj_cp')
                            </label>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($candidate->employment_details->current_date_of_joining)->format('d-m-Y') ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.g_pay')</label>
                            <p class="font-semibold">{{ $candidate->employment_details->pay_grade ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.p_bank')</label>
                            <p class="font-semibold">{{ $candidate->employment_details->pay_band ?? 'N/A' }}</p>
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
                        @foreach ($candidate->preferences_district as $location)
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
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.ccp')</label>
                            <p class="font-semibold uppercase">{{ $candidate->additional_info->criminal_case ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.dpp')</label>
                            <p class="font-semibold uppercase">
                                {{ $candidate->additional_info->departmental_proceedings ?? 'N/A' }}</p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.mtb')</label>
                            <p class="font-semibold uppercase">{{ $candidate->additional_info->mutual_transfer ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.no_mt')</label>
                            <p class="font-semibold uppercase">
                                {{ $candidate->additional_info->mutual_transfer == 'yes' ? $candidate->additional_info->no_mutual_transfer ?? 'N/A' : 'N/A' }}
                            </p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.addl_info.govt_due')</label>
                            <p class="font-semibold uppercase">
                                {{ $candidate->additional_info->pending_govt_dues ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('user.form.docs.heading')</p>
                        </div>

                        @php
                            $key = 1;
                        @endphp
                        @foreach ($candidate->documents as $document)
                            @if (
                                $document['document_type'] != 5 ||
                                    ($document['document_type'] == 5 && $candidate->additional_info->pending_govt_dues == 'no'))
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

                    {{--  --}}
                    @if ($user_role == 'Appointing Authority' || 'Verifier')
                        @if (count($docs) != 0)
                            <div
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.verifier_documents')</p>
                                </div>
                                @foreach ($docs as $d)
                                    <a href="{{ asset('storage/' . $d->document_location) }}" target="_blank"
                                        class="border rounded-xl bg-neutral-600">
                                        <div class="text-white text-center p-2">{{ $d->remarks }}</div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endif

                    @if ($user_role != 'Appointing Authority' || 'Approver')
                        @if ($candidate->profile_verify_status != 1)
                            <form
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6 doc-section"
                                id="form_doc_append" enctype="multipart/form-data">
                                <div class="lg:col-span-3">
                                    <div class="h-full flex items-end">
                                        <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.additional_documents')</p>
                                        <div class="ml-auto">
                                            <button type="button" id="add-more"
                                                class="ml-auto bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-2 py-0.5"><i
                                                    class="bi bi-plus-lg text-lg pr-1"></i>@lang('authority_dashboard.profile_details.add_more')</button>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="verifier_remarks" id="verifier_remarks" value="" />
                                <input type="hidden" name="employee_id" id="candidate_verify_id" value="" />
                                <input type="hidden" name="forms_number" id="forms_number" value="" />
                            </form>
                        @endif
                    @endif

                    @if ($candidate->profile_verify_status != 0 && $candidate->profile_verify_status != 2)
                        <!-- Verification and Noc status displayed after verified -->
                        <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                            <div class="lg:col-span-3">
                                <p class="text-lg font-bold text-sky-700">@lang('authority_dashboard.profile_details.vnr')</p>
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
                                    {{ $candidate->verified_remarks != null ? $candidate->verified_remarks : 'N/A' }}</p>
                            </div>
                            @if ($candidate->verified_on != null)
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.verifier_on')</label>
                                    <p class="font-semibold">
                                        {{ $candidate->verified_on != null ? \Carbon\Carbon::parse($candidate->verified_on)->format('d-m-Y') : 'N/A' }}
                                    </p>
                                </div>
                            @endif
                            @if ($noc_generated_by != null)
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.appointing_authority')</label>
                                    <p class="font-semibold">
                                        {{ $noc_generated_by != null ? $noc_generated_by->name : 'N/A' }},
                                        {{ $noc_generated_by != null ? $noc_generated_by->designation : 'N/A' }}
                                        {{ $noc_office_name != null ? $noc_office_name : 'N/A' }},
                                        {{ $noc_department_name != null ? $noc_department_name : 'N/A' }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.appointing_authority_remarks')</label>
                                    <p class="font-semibold">
                                        {{ $candidate->noc_remarks != null ? $candidate->noc_remarks : 'N/A' }}</p>
                                </div>
                                @if ($candidate->noc_generated_on != null)
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.recommended_on')</label>
                                        <p class="font-semibold">
                                            {{ $candidate->noc_generated_on != null ? \Carbon\Carbon::parse($candidate->noc_generated_on)->format('d-m-Y') : 'N/A' }}
                                        </p>
                                    </div>
                                @endif
                            @endif


                            @if ($sr != null)
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.department_hod')</label>
                                    <p class="font-semibold">
                                        {{ $sr->name != null ? $sr->name : 'N/A' }},
                                        {{ $sr->designation != null ? $sr->designation : 'N/A' }}
                                        {{ $sr_office_name != null ? $sr_office_name : 'N/A' }},
                                        {{ $sr_department_name != null ? $sr_department_name : 'N/A' }}</p>
                                </div>
                            @endif
                            @if ($sr != null)
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.remarks_hod')</label>
                                    <p class="font-semibold">{{ $srr == null ? 'N/A' : $srr }}</p>
                                </div>
                            @endif
                            @if ($sr != null)
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
                                        {{ $approved_by->name != null ? $approved_by->name : 'N/A' }},
                                        {{ $approved_by->designation != null ? $approved_by->designation : 'N/A' }}
                                        {{ $approver_office_name != null ? $approver_office_name : 'N/A' }},
                                        {{ $approver_department_name != null ? $approver_department_name : 'N/A' }}
                                    </p>
                                </div>
                            @endif
                            @if ($approved_by != null)
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approver_remarks')</label>
                                    <p class="font-semibold">{{ $approver_remarks == null ? 'N/A' : $approver_remarks }}
                                    </p>
                                </div>
                            @endif
                            @if ($approved_by != null)
                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.approved_on')</label>
                                    <p class="font-semibold">{{ \Carbon\Carbon::parse($approved_on)->format('d-m-Y') }}
                                    </p>
                                </div>
                            @endif

                            {{-- @if ($candidate->profile_verify_status == 1)
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Recommended</label>
                            <p class="font-semibold">{{$candidate->noc_generate == 1 ? 'Yes' : 'No'}}</p>
                        </div>
                        @endif
                        @if ($candidate->noc_generate == 1)
                        <form action="{{ url('verifier/noc-print') }}" method="post" style="display: inline; margin: 0; padding: 0;">
                            @csrf
                                <input type="hidden" name="noc_print_candidate" id="noc_print_candidate" value={{$candidate->id}}>
                                <div style="display: inline-block;"> <!-- Wrapper div -->
                                    <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">NOC</label>
                                <button type="submit" class="hover:bg-gray-200 border border-transparent text-gray-600 hover:text-black rounded-md block px-2 py-1.5 duration-300">
                                    <i class="bi bi-file-earmark-lock"></i>
                                    </button>
                                </div>
                            </form>
                        @endif --}}
                        </div>
                        <!-- Verification and Noc status displayed after verified end -->
                    @endif
                </div>
            </div>
            <div class="mt-12">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <a href="/{{ app()->getLocale() }}/verifier/verifier-dashboard"
                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                class="bi bi-arrow-left"></i>@lang('authority_dashboard.profile_details.btd')</a>
                    </div>
                    <div class="flex items-center gap-1">
                        @if ($candidate->profile_verify_status != 1 && !Session::has('allow_recommend'))
                            {{-- @if ($candidate->profile_verify_status != 1) --}}
                            <button type="button"
                                class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">@lang('authority_dashboard.profile_details.reject')</button>
                            <button type="button"
                                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest">@lang('authority_dashboard.profile_details.certify')</button>
                        @else
                            @if ($user_role == 'Appointing Authority' || $user_role == 'Appointing User')
                                @if ($candidate->noc_generate != 1 && $candidate->profile_verify_status == 1)
                                    {{-- {{ dd(Session::has('allow_recommend')) }} --}}
                                    @if (Session::has('allow_recommend'))
                                        <button type="button"
                                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directNOC">@lang('authority_dashboard.profile_details.ir')</button>
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn2">@lang('authority_dashboard.profile_details.idr')</button>
                                    @endif

                                @endif
                            @elseif($user_role == 'Verifier')
                                @if ($candidate->profile_verify_status != 1)
                                    <button type="button"
                                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest">@lang('authority_dashboard.profile_details.certify')</button>
                                @endif
                            @elseif($user_role == 'Approver')
                                <button type="button"
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directNOC">@lang('authority_dashboard.profile_details.ir')</button>
                                <button type="button"
                                    class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn2">@lang('authority_dashboard.profile_details.idr')</button>
                                <a href="#"
                                    class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300">@lang('authority_dashboard.profile_details.next')<i
                                        class="bi bi-arrow-right"></i></a>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- modal -->
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
                    id="directRequestModal">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details.verify_profile')</p>
                        </div>
                        <div action="/verifier/verify-candidates" method="">
                            <div class="grid gap-8">
                                <input type="hidden" id="cd_id" value="{{ Crypt::encryptString($candidate->id) }}">
                                <div class="flex gap-3">
                                    <input type="checkbox"
                                        class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                                        required>
                                    <p class="text-xs text-gray-900">@lang('authority_dashboard.profile_details.vrmsg')</p>
                                </div>
                                {{-- <div class="flex gap-3">
                                    <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                    <p class="text-xs text-gray-900">I confirm that the information provided by the employee matches the official records and no discrepancies were found during the verification process.</p>
                                </div> --}}
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
                                    <button type="button"
                                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit"
                                        id="verify_submit">@lang('authority_dashboard.profile_details.submit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- reject modal -->
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
                    id="rejectModal">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details.reject')</p>
                        </div>
                        <form action="{{ url('verifier/reject-candidates') }}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <div>
                                    <input type="hidden" id="candidate_reject_id" name="candidate_reject_id"
                                        value="{{ $candidate->id }}">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.verify_reject_heading')</label>
                                    <textarea name="reject_message"
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                        rows="4" required></textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeRejectModalButton">@lang('authority_dashboard.profile_details.close')</button>
                                    <button type="button" id="reject_noc_btn"
                                        class="bg-red-500 hover:bg-red-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">@lang('authority_dashboard.profile_details.reject_verify_btn')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- reject recommendationmodel --}}
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
                    id="rejectModal2">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details.reject')</p>
                        </div>
                        <form action="{{ url('verifier/reject-candidates') }}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <div>
                                    <input type="hidden" id="candidate_reject_id" name="candidate_reject_id"
                                        value="{{ $candidate->id }}">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.verify_reject_heading')</label>
                                    <textarea name="reject_message"
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                        rows="4" required>@lang('authority_dashboard.profile_details.idr')</textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeRejectModalButton2">@lang('authority_dashboard.profile_details.close')</button>
                                    <button type="button" id="reject_noc_btn2"
                                        class="bg-red-500 hover:bg-red-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">@lang('authority_dashboard.profile_details.reject_recommendation_btn')</button>
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
                            <p class="text-3xl font-semibold">@lang('authority_dashboard.tab.recommendation')</p>
                        </div>
                        <form action="{{ url('verifier/noc-update') }}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <input type="hidden" name="direct_noc_id" id="direct_noc_id"
                                    value="{{ $candidate->id }}" />

                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.remarks')</label>
                                    <textarea name="noc_remarks"
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                        rows="4">@lang('authority_dashboard.profile_details.ir')</textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeDirectNOCModalButton">@lang('authority_dashboard.profile_details.close')</button>
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
    <!-- footer -->


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

    {{-- <script>
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

    <script>
        $(document).ready(function(argument) {

            $('#reject_noc_btn').on('click', function() {
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

            $('#reject_noc_btn2').on('click', function() {
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
                        // Submit the form
                        $(this).closest('form').submit();
                    }
                });
            });



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
                var data = [];
                $('.doc-upload').each(function() {
                    var fileInput = $(this).find('input[type="file"]').val();
                    var textarea = $(this).find('textarea').val();
                    if (fileInput == '') {
                        return data;
                    }
                    // data.push({
                    //     file: fileInput,
                    //     text: textarea
                    // });
                });
                $('#add_docs').val(data);
            });
            $('#closeDirectRequestModalButton').on('click', function() {
                $('#directRequestModal').addClass('hidden');
                $('body').css('overflow', 'visible');
                $('#add_docs').val('');
            });
            $('.rejectRequestBtn').on('click', function() {
                if ($('#rejectModal').hasClass('hidden')) {
                    $('#rejectModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });

            $('.rejectRequestBtn2').on('click', function() {
                if ($('#rejectModal2').hasClass('hidden')) {
                    $('#rejectModal2').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeRejectModalButton2').on('click', function() {
                $('#rejectModal2').addClass('hidden');
                $('body').css('overflow', 'visible');
            });

            $('#closeRejectModalButton').on('click', function() {
                $('#rejectModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });
            $('.directNOC').on('click', function() {

                if ($('#directNOCModal').hasClass('hidden')) {
                    $('#directNOCModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeDirectNOCModalButton').on('click', function() {
                $('#directNOCModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });
            $('#add-more').click(function() {
                var content = `<div class="border rounded-xl bg-neutral-600 p-2 px-2.5 flex flex-col gap-2 doc-upload sub-form-div">
                            <div class="flex">
                                <p class="text-white text-center">Document Name</p>
                                <button class="ml-auto p-2 text-gray-300 hover:text-red-400 doc-close">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </button>
                            </div>
                                <input type="file" name="remarks_documents[]" class="border rounded-xl bg-neutral-600" value="">
                                <span class="file_error text-red-500"></span>
                                <label class="block mb-0 text-xs md:text-sm font-bold text-white">Document For:</label>
                                <textarea name="remarks_text[]" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="1" required></textarea>
                                <span class="remakrs_error text-red-500"></span>
                        </div>`;
                $('.doc-section').append(content);
            });
            $(document).on('click', '.doc-close', function() {
                var $docSection = $(this).closest('.doc-section');
                var $docUpload = $(this).closest('.doc-upload');
                $docUpload.remove();
            });
            $('#verify_submit').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Verify"
                }).then((result) => {
                    console.log();
                    if (result.isConfirmed) {
                        let checkbox1 = $('input[type="checkbox"]').eq(0).prop('checked');
                        // let checkbox2 = $('input[type="checkbox"]').eq(1).prop('checked');
                        if (!checkbox1) {
                            alert('Please ensure the checkbox is selected before proceeding.');
                            return false;
                        }
                        let remarks = $('#verification_remarks_id').val();
                        let id = $('#cd_id').val()
                        $('#verifier_remarks').val(remarks);
                        $('#candidate_verify_id').val(id);
                        let docsLength = $('.sub-form-div').length;
                        let form = $('#form_doc_append')[0];
                        $('#forms_number').val(docsLength);
                        let formData = new FormData(form);
                        // formData.forEach((value, key) => {
                        //     console.log(key + ": " + value);  
                        // });

                        console.log("Ok");
                        $.ajax({
                            type: "POST",
                            url: "/verifier/verify-candidates",
                            data: formData,
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log(response)
                                if (response.res_data.status == 200) {
                                    window.location.reload();
                                    // window.location.href = '/verifier/verifier-dashboard';
                                } else {
                                    for (var i = 0; i < response.res_data.message
                                        .length; i++) {
                                        $('.file_error').text(response.res_data.message[
                                            0].document)
                                        $('.remakrs_error').text(response.res_data
                                            .message[0].text)
                                    }
                                }
                            }
                        });
                    }
                });
            });
            // Document
            $(document).on('click', '.up_doc_rmv_btn', function() {
                var up_prev_rmv = $(this);
                up_prev_rmv.closest('.up_doc_prev_con').addClass('hidden');
                up_prev_rmv.closest('.up_doc_con').find('.up_input').val('');
            });

            $(document).on('change', '.up_input', function() {
                var up_prev = $(this);
                var up_prev_name = $(this)[0].files[0];
                // Check if a file is selected
                if (up_prev.val() != null && up_prev.val() != "") {
                    up_prev.closest('.up_doc_con').find('.up_doc_prev_con').removeClass('hidden');
                } else {
                    up_prev.closest('.up_doc_con').find('.up_doc_prev_con').addClass('hidden');
                }
                // If a file is selected, update the specific file name field
                if (up_prev_name) {
                    var fileName = up_prev_name.name;
                    up_prev.closest('.up_doc_con').find('.up_doc_name').html(
                        fileName); // Target the correct .up_doc_name element
                }
            });
        });
    </script>


@endsection

</body>

</html>
