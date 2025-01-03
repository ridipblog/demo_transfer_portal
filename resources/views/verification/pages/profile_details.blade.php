@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    {{-- {{ dd('hehe') }} --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-6 mb-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details.heading')</p>
                </div>

                @if ($candidate->profile_verify_status == 0)
                    <div class="bg-yellow-100 p-6 text-yellow-600 rounded-3xl">
                        <div class="flex gap-4">
                            <i class="bi bi-exclamation-triangle mt-0.5"></i>
                            <div class="">
                                <p class="text-xl font-semibold mb-1">
                                    @lang('authority_dashboard.profile_details.verification_progress')</p>
                                <p class="text-sm">@lang('authority_dashboard.profile_details.verification_under_review')</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="mb-2 grid grid-cols-4">
                @if ($rej == 0)
                    <div class="border border-sky-500 rounded-3xl border-b-4 border-r-4 p-2 flex items-center">
                        <span class="p-2 bg-green-600 text-white rounded-full"><i class="bi bi-archive"></i></span>
                        <span class="text-lg font-semibold pl-2">Fresh Profile</span>
                    </div>
                @else
                    <div class="border border-sky-500 rounded-3xl border-b-4 border-r-4 p-2 flex items-center">
                        <span class="p-2 bg-green-600 text-white rounded-full"><i class="bi bi-archive-fill"></i></span>
                        <span class="text-lg font-semibold pl-2">Resubmitted Profile</span>
                    </div>
                    <div class="col-span-3 flex items-center justify-end">

                        {{-- {{ dd(Crypt::encryptString($candidate->id)) }} --}}
                        <a href=" {{ route('resubmitted.profile', ['id' => Crypt::encryptString($candidate->id)]) }}"
                            class="hover:underline text-gray-900 text-xs">
                            @lang('authority_dashboard.profile_details.view_resubmission')
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                @endif
            </div>

            <div class="gap-24">
                <div class="grid gap-6 ">

                    <div
                        class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6 relative">
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
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.pan')</label>
                            <p class="font-semibold">{{ $candidate->persional_details->pan_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.basic_info.h_d')</label>
                            <p class="font-semibold truncate">{{ $candidate->persional_details->districts->name ?? 'N/A' }}
                            </p>
                        </div>
                        @if ($candidate->profile_verify_status == 0)
                            <div class="lg:col-span-3 flex gap-2 justify-end">
                                <input id="certifyCheckbox1" type="checkbox"
                                    class="w-5 h-5 border border-sky-500 rounded-md focus:ring focus:ring-sky-500 focus:ring-offset-2 cursor-pointer"
                                    checked>
                                {{-- <input id="certifyCheckbox1" type="checkbox"
                                    class="w-5 h-5 border border-sky-500 rounded-md focus:ring focus:ring-sky-500 focus:ring-offset-2 cursor-pointer"
                                    checked> --}}

                                <div class="text-right">
                                    <p class="text-xs text-gray-900">The furnished details of the employee is correct</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div
                        class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6 relative">
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

                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.direc_cp')</label>
                            <p class="font-semibold truncate w-full whitespace-normal">
                                {{ isset($candidate->employment_details->directorate_id) ? ($candidate->employment_details->directorate_id === 0 ? 'Not Applicable' : $candidate->employment_details->directorate->name ?? 'N/A') : 'Not Assign' }}
                            </p>
                        </div>

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
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('user.form.emp_info.time_of_service')</label>
                            <p class="font-semibold truncate">
                                {{ $candidate->employment_details->time_of_service ?? 'N/A' }}
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
                        @if ($candidate->profile_verify_status == 0)
                            <div class="lg:col-span-3 flex gap-2 justify-end">
                                <input id="certifyCheckbox2" type="checkbox"
                                    class="w-5 h-5 border border-sky-500 rounded-md focus:ring focus:ring-sky-500 focus:ring-offset-2 cursor-pointer"
                                    checked>
                                <div class="text-right">
                                    <p class="text-xs text-gray-900">The furnished details of the employee is correct</p>
                                </div>
                            </div>
                        @endif
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
                        class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                        <div class="sm:col-span-2 md:col-span-3">
                            <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
                        </div>


                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">How many
                                times have you
                                availed mutual transfer ?</label>

                            <p class="font-semibold truncate">
                                {{ $candidate->additional_info->times_mutual_transfer ?? 'N/A' }}
                            </p>
                        </div>

                    </div>

                    {{-- ///////////////////// --}}
                    <div class="border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="grid lg:grid-cols-3 gap-4 remarks-doc-div relative">
                            <div class="lg:col-span-3">
                                <p class="text-lg font-bold text-sky-700">@lang('user.form.docs.heading')</p>
                                <p class="text-xs font-bold text-sky-700">If any document is found to be invalid, verifying
                                    officers can provide remarks by selecting the "<span
                                        class="text-red-600">Remarks</span>"
                                    option on document.</p>
                            </div>
                            {{-- <input id="certifyCheckbox3" type="checkbox"
                                class="absolute top-2 right-2 w-5 h-5 bg-sky-200 border-2 border-sky-500 rounded-full focus:ring focus:ring-sky-500 focus:ring-offset-2 cursor-pointer">
                            <div class="absolute top-8 right-2 text-right">
                                <p class="text-xs text-gray-900">The furnished documents of the employee is correct</p>
                            </div> --}}
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($candidate->documents as $document)
                                <div class="border rounded-xl bg-neutral-60">
                                    @php
                                        $name = config(
                                            'globalVariables.registration_documtns.' . $document['document_type'],
                                        );
                                        $docKey = $document['document_type'] ?? null; // Assuming $key is zero-based, add 1 to match the doc number.
                                        $name = $docKey ? __("user.form.docs.$docKey") : 'No Document Name';
                                        $image_url = isset($document['documet_location'])
                                            ? Storage::url($document['documet_location'] ?? 'N/A')
                                            : null;
                                        $doc_extension = $image_url
                                            ? strtolower(pathinfo($image_url, PATHINFO_EXTENSION))
                                            : null;
                                    @endphp
                                    <div class="flex items-center justify-between px-2">
                                        <p class="m-0 p-2 px-8"></p>
                                        <p class="m-0 p-2 text-xs text-center">
                                            {{ $key }}
                                            {{ Str::upper(str_replace('_', ' ', __("user.form.docs.$key"))) }}
                                        </p>
                                        <div class="">
                                            <input type="hidden" class="get-key">
                                            <button type="button" value="{{ $document['document_type'] }}"
                                                class="border border-red-600 hover:bg-red-600 text-red-600 hover:text-white rounded p-0.5 text-[.65rem] px-2 btn-remarks-doc">
                                                {{-- <i class="bi bi-x-lg"></i> --}}
                                                Remarks
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="h-44 p-2 pt-0 {{ $doc_extension ? ($doc_extension != 'pdf' ?: 'hidden') : 'hidden' }}">
                                        <img src="{{ $image_url }}"
                                            class="w-full h-full object-contain object-center">
                                    </div>
                                    <a href="{{ $image_url }}" target="__blank"
                                        class="h-44 p-2 pt-0 flex flex-col justify-end {{ $doc_extension ? ($doc_extension == 'pdf' ?: 'hidden') : 'hidden' }}">
                                        <span class="block mb-auto text-xs text-sky-500">View
                                            File
                                        </span>
                                        <i class="bi bi-file-pdf mx-auto mb-12 text-4xl"></i>
                                    </a>
                                </div>
                                @php
                                    $key++;
                                @endphp
                            @endforeach
                            <div class="mt-6 lg:col-span-3 doc-remarks-label hidden">
                                <p class="text-xs font-bold text-sky-700">Invalid document remarks</p>
                            </div>
                            @if ($candidate->profile_verify_status == 0)
                                <div class="lg:col-span-3 flex gap-2 justify-end">
                                    <input id="certifyCheckbox3" type="checkbox"
                                        class="w-5 h-5 border border-sky-500 rounded-md focus:ring focus:ring-sky-500 focus:ring-offset-2 cursor-pointer"
                                        checked>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-900">The furnished details of the employee is correct
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <form class="remarks-document-div w-full" id="reject-on-verify" action="/ridip" method="post">

                        </form>
                    </div>

                    {{-- previous documents --}}
                    {{-- @if (count($docs2) != 0)
                        <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                            <div class="lg:col-span-3">
                                <p class="text-lg font-bold text-sky-700">
                                    @lang('authority_dashboard.profile_details.previous_documents')
                                </p>
                            </div>
                            @php
                                $key = 1;
                            @endphp
                            @foreach ($docs2 as $docArray)
                                @foreach ($docArray as $document)
                                    @if ($document->document_type != 5 || ($document->document_type == 5 && $candidate->additional_info->pending_govt_dues == 'no'))
                                        <div class="border rounded-xl bg-neutral-600">

                                            @php
                                                $name = config(
                                                    'globalVariables.registration_documtns.' . $document->document_type,
                                                );
                                            @endphp
                                            <div class="text-white text-center p-2 text-xs">
                                                {{ Str::upper(str_replace('_', ' ', __("user.form.docs.$document->document_type"))) }}
                                            </div>
                                            <div class="h-44 p-2 pt-0">
                                                <img src="{{ Storage::url($document->documet_location ?? 'N/A') }}"
                                                    alt="Document {{ $document->document_type }}"
                                                    class="w-full h-full object-contain object-center">
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            @endforeach
                        </div>
                    @endif --}}



                    {{-- Additional documents and comments --}}
                    @if ($user_role == 'Appointing Authority' || 'Verifier' || 'Appointing User')
                        @if (count($docs) != 0 || $candidate->comment != null)
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
                                <div class="lg:col-span-3 flex flex-col">
                                    @if ($candidate->comment != null)
                                        <p class="font-semibold mt-auto"> {{ $candidate->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif



                    @if ($user_role != 'Appointing Authority' || 'Approver')
                        @if ($candidate->profile_verify_status != 1)
                            <form
                                class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6 doc-section"
                                id="form_doc_append" enctype="multipart/form-data">
                                <div class="lg:col-span-3">
                                    <div class="h-full flex items-top">
                                        <p class="text-lg font-bold text-sky-700">
                                            @lang('authority_dashboard.profile_details.additional_documents')
                                        </p>
                                        <div class="ml-auto">
                                            <button type="button" id="add-more"
                                                class="ml-auto bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-2 py-0.5">
                                                <i class="bi bi-plus-lg text-lg pr-1"></i>
                                                {{-- @lang('authority_dashboard.profile_details.add_more') --}}
                                                Add Document
                                            </button>
                                            <div class="text-right text-[0.65rem] font-bold text-gray-400">(if applicable)
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="comment-container" class="lg:col-span-3">
                                    <textarea name="comment" id="comment"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-300 focus:ring-opacity-50"
                                        @if ($user_role != 'Verifier') disabled @endif cols="30" rows="5"
                                        placeholder="I have concerns regarding">{{ $candidate->comment }}</textarea>
                                </div>
                                <input type="hidden" name="verifier_remarks" id="verifier_remarks" value="" />
                                <input type="hidden" name="employee_id" id="candidate_verify_id" value="" />
                                <input type="hidden" name="forms_number" id="forms_number" value="" />
                                <!-- Dynamic divs will be appended here -->
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
                                    {{ $verifier_office1 }},
                                    {{ $department_name != null ? $department_name : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.verifier_remarks')</label>
                                <p class="font-semibold">
                                    {{ $candidate->verified_remarks != null ? $candidate->verified_remarks : 'N/A' }}
                                </p>
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

                            @if ($candidate->noc_generate == 1)


                                @if ($approval_status == 1)
                                    @if ($approved_by != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approved_by')</label>
                                            <p class="font-semibold">
                                                {{ $approved_by->name != null ? $approved_by->name : 'N/A' }},
                                                {{ $approved_by->designation != null ? $approved_by->designation : 'N/A' }},
                                                {{ $approver_officer1 }},
                                                {{ $approver_department_name != null ? $approver_department_name : 'N/A' }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($approved_by != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.updated_texts.approver_remarks')</label>
                                            <p class="font-semibold">
                                                {{ $approver_remarks == null ? 'N/A' : $approver_remarks }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($approved_by != null)
                                        <div>
                                            <label
                                                class="block mb-1 text-xs md:text-sm font-black text-gray-900">@lang('authority_dashboard.profile_details.approved_on')</label>
                                            <p class="font-semibold">
                                                {{ \Carbon\Carbon::parse($approved_on)->format('d-m-Y') }}
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            @endif




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
                        @if ($candidate->profile_verify_status != 1 && Auth::guard('user_guard')->user()->role_id == 6)
                            {{-- @if ($candidate->profile_verify_status != 1) --}}
                            <button type="button"
                                class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">@lang('authority_dashboard.profile_details.reject')</button>
                            <button type="button" id="certifyButton"
                                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest">@lang('authority_dashboard.profile_details.certify')</button>
                        @else
                            @if ($user_role == 'Appointing Authority' || $user_role == 'Appointing User')
                                @if ($candidate->noc_generate != 1 && $candidate->profile_verify_status == 1)
                                    {{-- {{ dd(Session::has('allow_recommend')) }} --}}
                                    {{-- @if (Session::has('allow_recommend')) --}}
                                    <button type="button"
                                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directNOC">@lang('authority_dashboard.profile_details.ir')</button>
                                    <button type="button"
                                        class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn2">@lang('authority_dashboard.profile_details.idr')</button>
                                    {{-- @endif --}}
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
                    <div class="max-w-xl w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">@lang('authority_dashboard.profile_details.verify_profile')</p>
                        </div>
                        <div action="/verifier/verify-candidates" method="">
                            <div class="grid gap-8">
                                <input type="hidden" id="cd_id" value="{{ Crypt::encryptString($candidate->id) }}">
                                <div class="flex flex-col gap-3">
                                    <input type="hidden" id="verify_comment" name="comment" value="">
                                    <div class="flex items-center gap-2">
                                        {{-- @if (count($conditions) != 0)
                                            @foreach ($conditions as $cc)
                                                <input type="checkbox" name="verification[]" value="general"
                                                    class="border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                                                    required>
                                                <p class="text-xs text-gray-900">{{ $cc->conditions }}</p>
                                            @endforeach
                                        @endif --}}
                                        <input type="checkbox" name="verification[]" value="general"
                                            class="border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                                            required>
                                        <p class="text-xs text-gray-900">@lang('authority_dashboard.profile_details.vrmsg')</p>
                                    </div>
                                    @if (count($cond) != 0)
                                        @foreach ($cond as $c)
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" name="verification[]" value="{{ $c->id }}"
                                                    class="border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5 additional_conditions"
                                                    required>
                                                <p class="text-xs text-gray-900">{{ $c->conditions }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div>
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.remarks')</label>
                                    <textarea name="verifier_remarks" id="verification_remarks_id" value=""
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                        rows="4">Verified</textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeDirectRequestModalButton">@lang('authority_dashboard.profile_details.close')</button>
                                    <button type="submit"
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
                        <form action="{{ url('verifier/reject-candidates') }}" method="post" id="reject_new">
                            @csrf
                            <div class="grid gap-8">
                                <div>
                                    <input type="hidden" id="reject_comment" name="comment" value="">
                                    <input type="hidden" id="candidate_reject_id" name="candidate_reject_id"
                                        value="{{ $candidate->id }}">
                                    <label
                                        class="block mb-1 text-xs md:text-sm font-bold text-gray-800">@lang('authority_dashboard.profile_details.verify_reject_heading')</label>
                                    <textarea name="reject_message"
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full reject_msg"
                                        rows="4" required></textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button"
                                        class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                        id="closeRejectModalButton">@lang('authority_dashboard.profile_details.close')</button>
                                    <button type="button" id="reject_noc_btn" value="{{ $candidate->id }}"
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
                var count = {
                    {
                        session('flash_message')
                    }
                };
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

            function checkAllCheckboxes() {
                const checkbox1 = document.getElementById('certifyCheckbox1');
                const checkbox2 = document.getElementById('certifyCheckbox2');
                const checkbox3 = document.getElementById('certifyCheckbox3');
                const button = document.getElementById('certifyButton');
                button.disabled = !(checkbox1.checked && checkbox2.checked && checkbox3.checked);
            }

            document.getElementById('certifyCheckbox1').addEventListener('change', checkAllCheckboxes);
            document.getElementById('certifyCheckbox2').addEventListener('change', checkAllCheckboxes);
            document.getElementById('certifyCheckbox3').addEventListener('change', checkAllCheckboxes);



            $('.btn-remarks-doc').on('click', function() {
                // Show the remarks label
                const myGlobalVariable = @json(config('globalVariables.registration_documtns'));
                let name = myGlobalVariable[$(this).val()].replaceAll('_', ' ');
                var k = $(this).val();
                if ($('.doc-remarks .send-key').filter(function() {
                        return $(this).val() === k;
                    }).length > 0) {
                    return;
                }
                var append_data = `
            <div class="doc-remarks">
                <label for="message"
                    class="block mb-2 text-xs font-semibold text-gray-900 dark:text-white" data-id="${$(this).val()}">Remarks for ${name}</label>
                    <input class="send-key" type="hidden" value="${$(this).val()}" name="">
                <textarea id="message" rows="2"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Write here..."></textarea>
                <!-- Cross button to remove the div -->
                <button type="button" class="remove-remarks-btn text-red-600 hover:text-red-800 mt-2 text-sm">
                    &times; Remove
                </button>
            </div>`;
                $('.remarks-document-div').append(append_data);
            });
            // $(document).on('click', '.remove-remarks-btn', function() {
            //     let doc_index = $(this).closest('.doc-remarks').index();
            //     console.log($doc_index);
            // });
            $(document).on('click', '.remove-remarks-btn', function() {
                $(this).closest('.doc-remarks').remove();
                if ($('.doc-remarks').length === 0) {
                    $('.doc-remarks-label').addClass('hidden');
                }
            });

            // $('#reject_noc_btn').on('click', function(e) {
            //     console.log($(this).val());
            //     e.preventDefault();
            //     $('#reject-on-verify').append(
            //         `<input type="hidden" value=${$(this).val()} name="candidate_id">`);
            //     var comment = $('#comment').val();

            //     let form = $('#form_doc_append')[0];
            //     let formData = new FormData(form);
            //     // Append each FormData item as hidden inputs to the modal form
            //     for (let [key, value] of formData.entries()) {
            //         // console.log(value);
            //         if (key === 'remarks_documents') {
            //             $('#reject_new').append('<input type="hidden" name="' + key + '" value="' + value
            //                 .name + '">');
            //         } else {
            //             $('#reject_new').append('<input type="hidden" name="' + key + '" value="' + value +
            //                 '">');
            //         }
            //     }
            //     // Show a confirmation modal using SweetAlert
            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: 'You won\'t be able to revert this.',
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: "#3085d6",
            //         cancelButtonColor: "#d33",
            //         confirmButtonText: "Yes, Reject"
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $('#reject_new').submit();
            //         }
            //     });
            // });

            $('#reject_noc_btn').on('click', function(e) {
                e.preventDefault();

                let form = $('#form_doc_append')[0];

                // Check if all dynamically added file inputs have corresponding textareas filled
                let isValid = true;

                // Loop through each dynamically added div with class 'sub-form-div'
                $('.sub-form-div').each(function() {
                    let fileInput = $(this).find('input[type="file"]');
                    let textarea = $(this).find('textarea');

                    // Check if file is selected and textarea is filled
                    if (fileInput.val() === '' || textarea.val().trim() === '') {
                        isValid = false;

                        // Highlight the missing field(s)
                        if (fileInput.val() === '') {
                            fileInput.addClass('border-red-500');
                        } else {
                            fileInput.removeClass('border-red-500');
                        }

                        if (textarea.val().trim() === '') {
                            textarea.addClass('border-red-500');
                        } else {
                            textarea.removeClass('border-red-500');
                        }
                    } else {
                        // Remove error highlights if valid
                        fileInput.removeClass('border-red-500');
                        textarea.removeClass('border-red-500');
                    }
                });

                if (!isValid) {
                    alert(
                        'Please ensure that all additional documents have their corresponding fields completed.'
                    );
                    return;
                }

                // If all inputs are valid, proceed with form submission
                let formData = new FormData(form);




                // let form = $('#form_doc_append')[0];
                // let formData = new FormData(form);
                formData.append('candidate_id', $(this).val());
                formData.append('comment', $('#comment').val());

                var allRemarks = [];
                $('.doc-remarks').each(function() {
                    var docKey = $(this).find('label').data('id');
                    var remarkText = $(this).find('textarea').val();
                    if (remarkText.trim() !== '') {
                        allRemarks.push({
                            document: docKey,
                            remark: remarkText
                        });
                    }
                });
                // $('.all_remarks').html('');
                $('#reject_new').append(
                    '<input type="hidden" name="allRemarks" value="' +
                    JSON.stringify(allRemarks).replace(/'/g, '&#39;') +
                    '">'
                );
                var reject_msg = $('.reject_msg').val();
                // Confirm append
                formData.append('allRemarks', JSON.stringify(allRemarks));
                formData.append('reject_message', reject_msg);

                // console.log(formData);
                // alert('ee')
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Reject',
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: $('#reject_new').attr('action'),
                            type: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            processData: false,
                            contentType: false,
                            success: function(response) {

                                var locale = window.App?.locale;
                                Swal.fire('Rejected!',
                                    'The candidate has been rejected.', 'success');

                                window.location.href =
                                    `/en/verifier/verifier-dashboard`;
                            },
                            error: function(response) {
                                Swal.fire('Error!',
                                    'An error occurred while rejecting.', 'error');

                            },
                        });
                    }
                });
            });





            // $('#reject_noc_btn').on('click', function() {
            //     var comment = $('#comment').val();
            //     $('#reject_comment').val(comment);

            //     var allRemarks = [];
            //     $('.doc-remarks').each(function() {
            //         // Get the document name/key and clean it
            //         var docKey = $(this).find('label').text().replace(/^Remarks for\s*[\n\r]*\s*/,
            //             '').trim();

            //         // Get the remark text entered by the user
            //         var remarkText = $(this).find('textarea').val();

            //         // Store the data in an object and push it to the allRemarks array
            //         if (remarkText.trim() !== '') {
            //             allRemarks.push({
            //                 document: docKey,
            //                 remark: remarkText
            //             });
            //         }
            //     });

            //     // Append remarks array to FormData
            //     let form = $('#form_doc_append')[0];
            //     let formData = new FormData(form);
            //     formData.append('allRemarks', JSON.stringify(allRemarks));

            //     $('.doc-remarks input[type="file"]').each(function(index) {
            //         let file = this.files[0];
            //         if (file) {
            //             formData.append(`remarks_documents[${index}]`, file);
            //         }
            //     });

            //     // Append the number of sub-forms
            //     let docsLength = $('.sub-form-div').length;
            //     formData.append('forms_number', docsLength);

            //     // Debug FormData
            //     for (let [key, value] of formData.entries()) {
            //         console.log(key, value);
            //     }

            //     // Show confirmation modal
            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: 'You won\'t be able to revert this.',
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, Reject'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             // Submit the form via AJAX
            //             $.ajax({
            //                 url: $('#reject_new').attr('action'),
            //                 method: 'POST',
            //                 data: formData,
            //                 headers: {
            //                     'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 processData: false,
            //                 contentType: false,
            //                 success: function(response) {
            //                     console.log('Form submitted successfully:', response);
            //                 },
            //                 error: function(error) {
            //                     console.error('Error submitting form:', error);
            //                 }
            //             });
            //         }
            //     });
            // });


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
                console.log("dd");
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

                });
                $('#add_docs').val(data);
            });
            $('#closeDirectRequestModalButton').on('click', function() {
                $('#directRequestModal').addClass('hidden');
                $('body').css('overflow', 'visible');
                $('#add_docs').val('');
            });


            $('.rejectRequestBtn').on('click', function() {
                // Show the modal if it's hidden
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
                var content = `
        <div class="border rounded-xl bg-neutral- p-4 flex flex-col gap-2 doc-upload sub-form-div">
            <div class="flex items-start gap-2">
                <input type="file" name="remarks_documents[]" class="w-10/12 p-1 border border-gray-200 rounded-xl bg-neutral-100" value="">
                <button class="ml-auto p- text-gray-300 hover:text-red-400 doc-close">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>
            
            <span class="file_error text-red-500"></span>
            <label class="block mb-0 text-xs md:text-sm font-bold text">Document For:</label>
            <textarea name="remarks_text[]" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="1" required></textarea>
            <span class="remakrs_error text-red-500"></span>
        </div>`;


                if ($('#comment').length > 0) {
                    $(content).insertBefore('#comment-container');
                } else {
                    $('.doc-section').append(content);
                }
            });

            $(document).on('click', '.doc-close', function() {
                var $docSection = $(this).closest('.doc-section');
                var $docUpload = $(this).closest('.doc-upload');
                $docUpload.remove();
            });
            $('#verify_submit').on('click', function() {
                var comment = $('#comment').val();
                $('#verify_comment').val(comment);

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this.',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Verify"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Check if the main checkbox is selected
                        let mainCheckbox = $('input[type="checkbox"]').eq(0).prop('checked');
                        if (!mainCheckbox) {
                            alert('Please ensure the main checkbox is selected before proceeding.');
                            return false;
                        }

                        // Check if additional conditions are available
                        let additionalConditions = $('.additional_conditions');
                        if (additionalConditions.length > 0) {
                            let allChecked = true;

                            // Verify all additional checkboxes are checked
                            additionalConditions.each(function() {
                                if (!$(this).prop('checked')) {
                                    allChecked = false;
                                }
                            });

                            if (!allChecked) {
                                alert(
                                    'Please ensure all additional conditions are checked before proceeding.'
                                );
                                return false;
                            }
                        }

                        // Proceed with form submission if all validations pass
                        let remarks = $('#verification_remarks_id').val();
                        let id = $('#cd_id').val();
                        $('#verifier_remarks').val(remarks);
                        $('#candidate_verify_id').val(id);

                        let docsLength = $('.sub-form-div').length;
                        let form = $('#form_doc_append')[0];
                        $('#forms_number').val(docsLength);

                        let formData = new FormData(form);
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
                                if (response.res_data.status == 200) {
                                    // Swal.fire('Rejected!',
                                    // 'The candidate has been rejected.', 'success');
                                    window.location.reload();
                                } else {
                                    for (var i = 0; i < response.res_data.message
                                        .length; i++) {
                                        $('.file_error').text(response.res_data.message[
                                            0].document);
                                        $('.remakrs_error').text(response.res_data
                                            .message[0].text);
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
