<!-- Until verification pending -->
<div class="mb-6 lg:1mb-12">
    <div class="grid gap-6">
        <div class="flex @if ($viewData->profile_verify_status == 2) justify-center @else justify-between @endif gap-12">
            @if ($viewData->profile_verify_status !== 2)
                <p class="font-bold text-xl">@lang('user.dashboard.pen_ver')</p>
            @endif
            @if ($viewData->profile_verify_status == 2 || $viewData->noc_generate == 2)
                <a href="{{ route('update.profile', ['lang' => app()->getLocale()]) }}"
                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 text-xs"><i
                        class="bi bi-pencil"> </i>@lang('user.dashboard.button.edit')</a>
            @else
            @endif
        </div>
        @if ($viewData->profile_verify_status !== 2)
            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-bold text-sky-700">@lang('user.form.basic_info.heading')</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.name')</label>
                    <p class="font-semibold truncate">{{ $viewData->full_name ?? 'N/A' }}</p>
                </div>

                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.dob')</label>
                    <p class="font-semibold truncate">
                        {{ isset($viewData->persional_details->date_of_birth) ? \Carbon\Carbon::parse($viewData->persional_details->date_of_birth)->format('d-m-Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.gender')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.f_name')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->father_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.m_name')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->mother_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.caste')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->caste->caste_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.pno')</label>
                    <p class="font-semibold truncate">{{ $viewData->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold text-gray-400">@lang('user.form.basic_info.apno')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->alt_phone_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.email')</label>
                    <p class="font-semibold truncate">{{ $viewData->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.pan')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->pan_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.basic_info.h_d')</label>
                    <p class="font-semibold truncate">{{ $viewData->persional_details->districts->name ?? 'N/A' }}</p>
                </div>
            </div>

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-bold text-sky-700">@lang('user.form.emp_info.heading')</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.dist_cp')</label>
                    <p class="font-semibold truncate">{{ $viewData->employment_details->districts->name ?? 'N/A' }}</p>
                </div>
                <div class="">
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.dept_cp')</label>
                    <p class="font-semibold truncate w-full whitespace-normal">
                        {{ $viewData->employment_details->departments->name ?? 'N/A' }}</p>
                </div>
                <div class="">
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.direc_cp')</label>
                    <p class="font-semibold truncate w-full whitespace-normal">
                        {{ isset($viewData->employment_details->directorate_id) ? ($viewData->employment_details->directorate_id === 0 ? 'Not Applicable' : $viewData->employment_details->directorate->name ?? 'N/A') : 'Not Assign' }}
                    </p>
                </div>
                {{-- <div class="">
                <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">DDO Code <br>ডিডিঅ' ক'ড</label>
                <p class="font-semibold truncate">{{ $viewData->employment_details->ddo_code ?? 'N/A' }}</p>
            </div> --}}
                <div class="">
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.office_cp')</label>
                    <p class="font-semibold truncate w-full whitespace-normal">
                        {{ $viewData->employment_details->offices_finassam->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.desg_cp')</label>
                    <p class="font-semibold truncate">{{ $viewData->employment_details->post_names->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.doj_fj')</label>
                    <p class="font-semibold truncate">
                        {{ isset($viewData->employment_details->first_date_of_joining) ? \Carbon\Carbon::parse($viewData->employment_details->first_date_of_joining)->format('d-m-Y') : 'N/A' }}
                    </p>

                </div>
                @php
            try{
                $service_date=null;
                if ($viewData->employment_details->first_date_of_joining) {
                    $input_date = $viewData->employment_details->first_date_of_joining;
                    $today = now()->format('Y-m-d');

                    $start = new DateTime($input_date);
                    $end = new DateTime($viewData->employment_details->updated_at);

                    $years = $end->format('Y') - $start->format('Y');
                    $months = $end->format('m') - $start->format('m');
                    $days = $end->format('d') - $start->format('d');


                    if ($days < 0) {
                        $months--;
                        $previousMonth = (clone $end)->modify('last day of previous month');
                        $days += $previousMonth->format('d');
                    }

                    // Adjust months if negative
                    if ($months < 0) {
                        $years--;
                        $months += 12;
                    }
                    $service_date="$years years $months months ";
                }
            }catch(Exception $err){
                $service_date="date is not calculated";
            }
            @endphp
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.time_of_service')</label>
                    <p class="font-semibold truncate">
                        {{ $service_date  ?? 'date is not calculated'}}
                    </p>

                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.doj_cp')</label>
                    <p class="font-semibold truncate">
                        {{ isset($viewData->employment_details->current_date_of_joining) ? \Carbon\Carbon::parse($viewData->employment_details->current_date_of_joining)->format('d-m-Y') : 'N/A' }}
                    </p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.g_pay')</label>
                    <p class="font-semibold truncate">{{ $viewData->employment_details->pay_grade ?? 'N/A' }}</p>
                </div>
                <div>
                    <label
                        class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">@lang('user.form.emp_info.p_bank')</label>
                    <p class="font-semibold truncate">{{ $viewData->employment_details->pay_band ?? 'N/A' }}</p>
                </div>
            </div>

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-bold text-sky-700">@lang('user.form.prefs.heading')</p>
                </div>
                @php
                    $positions[] = [];
                    for ($i = 1; $i <= 5; $i++) {
                        $positions[] = __("user.form.prefs.$i");
                    }
                @endphp
                @foreach ($viewData->preferences_district as $location)
                    <div class="relative">
                        <span
                            class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-400">{{ $positions[$location->preference_no] }}</span>
                        <div class="block p-2.5 pl-16 w-full">
                            <p class="font-semibold truncate">{{ $location->districts->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

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
                    <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-400">How many times have
                        you
                        availed mutual transfer ?</label>
                    <p class="font-semibold truncate">{{ $viewData->additional_info->times_mutual_transfer ?? 'N/A' }}
                    </p>
                </div>
                {{-- <div class=""></div>
            <div class="flex flex-col items-center justify-center table_nfDiv">
                <img src="/images/nfd.png" alt="" class="w-36 object-center mb-2">
                <p class="text-gray-500 font-bold text-lg text-center">No Tranfser History Found!</p>
            </div> --}}
            </div>
            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-bold text-sky-700">@lang('user.form.docs.heading')</p>
                </div>

                @foreach ($viewData->documents ?? [] as $document)
                    <div class="border rounded-xl ">
                        @php
                            $docKey = $document['document_type'] ?? null; // Assuming $key is zero-based, add 1 to match the doc number.
                            $name = $docKey ? __("user.form.docs.$docKey") : 'No Document Name';
                            $image_url = isset($document['documet_location'])
                                ? Storage::url($document['documet_location'] ?? 'N/A')
                                : null;
                            $doc_extension = $image_url ? strtolower(pathinfo($image_url, PATHINFO_EXTENSION)) : null;
                        @endphp
                        <div class="text- text-center p-2 text-xs">{{ Str::upper(str_replace('_', ' ', $name)) }}
                        </div>

                        <div
                            class="h-44 p-2 contain-document-image {{ $doc_extension ? ($doc_extension != 'pdf' ?: 'hidden') : 'hidden' }}">
                            {{-- {{ in_array($key, $document_arr) ? $image_count++ : '' }} --}}

                            <img src="{{ $image_url }}" alt="NO image"
                                class="w-full h-full object-contain object-center preview_registration_document selected-document-img   ">
                        </div>
                        <div
                            class="h-44 p-2 flex items-center justify-center contain-document-pdf {{ $doc_extension ? ($doc_extension == 'pdf' ?: 'hidden') : 'hidden' }}">
                            {{-- {{ in_array($key, $document_arr) ? $image_count++ : '' }} --}}
                            <a href="{{ $image_url }}" class="selected-document-pdf  " target="_blank">
                                <i class="bi bi-filetype-pdf text-5xl"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="border rounded-xl bg-neutral-600">
                <div class="h-44 p-2">
                    <img src="{{Storage::url($viewData->documents->photo)}}" alt=""
                        class="w-full h-full object-contain object-center">
                </div>
                <div class="text-white text-center p-2">Photo</div>
            </div>
            <div class="border rounded-xl bg-neutral-600">
                <div class="h-44 p-2">
                    <img src="{{Storage::url($viewData->documents->signature)}}" alt=""
                        class="w-full h-full object-contain object-center">
                </div>
                <div class="text-white text-center p-2">PAN Card</div>
            </div>
            <div class="border rounded-xl bg-neutral-600">
                <div class="h-44 p-2">
                    <img src="{{Storage::url($viewData->documents->govt_identify_card)}}" alt=""
                        class="w-full h-full object-contain object-center">
                </div>
                <div class="text-white text-center p-2">Department ID Card</div>
            </div> --}}
            </div>
        @endif
        {{-- ------------ if rejection push by authority ---------------- --}}
        @if ($viewData->profile_verify_status == 2 ? (isset($rejectedData) ? true : false) : false)
            @if ($rejectedData->commnents ? true : (count($rejectedData->authority_rejections ?? []) == 0 ? false : true))
                <x-employee-profile.rejection-infomation-component :rejectedData=$rejectedData>

                </x-employee-profile.rejection-infomation-component>
            @endif
        @endif


    </div>
</div>
<!-- Until verification pending end -->
