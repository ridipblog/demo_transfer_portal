<div class="hidden fixed top-0 left-0 w-full h-full flex justify-center bg-black/30 p-4 z-[99] overflow-y-auto"
    id="prevModal">
    <div class="max-w-5xl w-full h-fit bg-white rounded-2xl p-6 py-10">
        <div class="space-y-2 mb-6">
            <p class="text-3xl font-semibold">@lang('user.preview.heading')</p>
        </div>
        <div class="grid gap-6">

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-semibold text-sky-500">@lang('user.form.basic_info.heading')</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.name')</label>
                    <p class="font-semibold preview_data">Rory</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.dob')</label>
                    <p class="font-semibold preview_data">13 Mar 1989</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.gender')</label>
                    <p class="font-semibold preview_data"></p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.f_name')</label>
                    <p class="font-semibold preview_data"></p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.m_name')</label>
                    <p class="font-semibold preview_data">Stephan Walters</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.caste')</label>
                    <p class="font-semibold preview_data">General</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.pno')</label>
                    <p class="font-semibold preview_data">+91 967 000 0063</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold text-gray-400">@lang('user.form.basic_info.apno')</label>
                    <p class="font-semibold preview_data"></p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.email')</label>
                    <p class="font-semibold preview_data">walters.rory217@gmail.com</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.pan')</label>
                    <p class="font-semibold preview_data">XXXXXXXXXXXXXXXX</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.basic_info.h_d')</label>
                    <p class="font-semibold preview_data">home district</p>
                </div>
            </div>

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-semibold text-sky-500">@lang('user.form.emp_info.heading')</p>
                </div>
                <div class="">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.dist_cp')</label>
                    <p class="font-semibold preview_data">Kamrup Metro</p>
                </div>
                <div class="">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.dept_cp')</label>
                    <p class="font-semibold preview_data">Health</p>
                </div>
                <div class="">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.direc_cp')</label>
                    <p class="font-semibold preview_data">Commisionalr</p>
                </div>
                {{-- <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">DDO Code <br>ডিডিঅ' ক'ড</label>
                    <p class="font-semibold preview_data">Health</p>
                </div> --}}
                <div class="sm:col-span-2">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.office_cp')</label>
                    <p class="font-semibold preview_data">XXXXXXXXXXXXXXXX</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.desg_cp')</label>
                    <p class="font-semibold preview_data">Addl. Secretary</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.doj_fj')</label>
                    <p class="font-semibold preview_data">12 Aug 2006</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.time_of_service')</label>
                    <p class="font-semibold preview_data">0 years 0 month </p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.doj_cp')</label>
                    <p class="font-semibold preview_data">12 Aug 2006</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.g_pay')</label>
                    <p class="font-semibold preview_data">XXXXXXXXXXXXXXXXXXXX</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.emp_info.p_bank')</label>
                    <p class="font-semibold preview_data">XXXXXXXXXXXXXXXX</p>
                </div>
            </div>

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-semibold text-sky-500">@lang('user.form.prefs.heading')</p>
                </div>
                <div class="relative">
                    <span
                        class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-500">@lang('user.form.prefs.1')</span>
                    <div class="block p-2.5 pl-16 w-full">
                        <p class="font-semibold preview_data">Nagaon</p>
                    </div>
                </div>
                <div class="relative">
                    <span
                        class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-500">@lang('user.form.prefs.2')</span>
                    <div class="block p-2.5 pl-16 w-full">
                        <p class="font-semibold preview_data">Cachar</p>
                    </div>
                </div>
                <div class="relative">
                    <span
                        class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-500">@lang('user.form.prefs.3')</span>
                    <div class="block p-2.5 pl-16 w-full">
                        <p class="font-semibold preview_data">Kamrup</p>
                    </div>
                </div>
                <div class="relative">
                    <span
                        class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-500">@lang('user.form.prefs.4')</span>
                    <div class="block p-2.5 pl-16 w-full">
                        <p class="font-semibold preview_data">Kamrup</p>
                    </div>
                </div>
                <div class="relative">
                    <span
                        class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-500">@lang('user.form.prefs.5')</span>
                    <div class="block p-2.5 pl-16 w-full">
                        <p class="font-semibold preview_data">Kamrup</p>
                    </div>
                </div>
            </div>

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                {{-- <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.addl_info.ccp')</label>
                    <p class="font-semibold preview_data">Yes / No</p>
                </div>
                <div>
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.addl_info.dpp')</label>
                    <p class="font-semibold preview_data">Yes / No</p>
                </div>
                <div class="">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.addl_info.mtb')</label>
                    <p class="font-semibold preview_data">Yes / No</p>
                </div>
                <div class="before-transfer-div">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.addl_info.no_mt')</label>
                    <p class="font-semibold preview_data">NA / 1 / 2</p>
                </div>
                <div class="">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">@lang('user.form.addl_info.govt_due')</label>
                    <p class="font-semibold preview_data" id="peddning-govt-due">Yes / No</p>
                </div> --}}
                <div class="">
                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-400">How many times have you
                        availed mutual transfer ?</label>
                    <p class="font-semibold preview_data" id="preview_times_mutual_transfer">1</p>
                </div>
            </div>

            <div
                class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                <div class="sm:col-span-2 md:col-span-3">
                    <p class="text-lg font-semibold text-sky-500">@lang('user.form.docs.heading')</p>
                </div>
                @php
                    $document_arr = $viewData['save_data']->documents->pluck('document_type')->toArray();
                    $image_count = -1;
                @endphp
                @foreach (config('globalVariables.registration_upload_name') ?? [] as $key => $value)
                    @php
                        if (in_array($key, $document_arr)) {
                            $image_count++;
                        }
                        $image_url = in_array($key, $document_arr)
                            ? Storage::url($viewData['save_data']->documents[$image_count]->documet_location ?? null)
                            : null;
                        $doc_extension = $image_url ? strtolower(pathinfo($image_url, PATHINFO_EXTENSION)) : null;
                    @endphp
                    <div class="border rounded-xl bg-neutral- review-document-image-div {{ $image_url ?: 'hidden' }} ">

                        <div class="text- text-center p-2 mb-1">
                            @php
                                $docKey = $key;
                            @endphp
                            {{ Str::upper(str_replace('_', ' ', __("user.form.docs.$docKey"))) }}
                        </div>
                        <div
                            class="h-44 p-2 contain-document-image {{ $doc_extension ? ($doc_extension != 'pdf' ?: 'hidden') : 'hidden' }}">
                            <img src="{{ $image_url }}" alt="NO image"
                                class="w-full h-full object-contain object-center preview_registration_document selected-document-img   ">
                        </div>
                        <div
                            class="h-44 p-2 flex items-center justify-center contain-document-pdf {{ $doc_extension ? ($doc_extension == 'pdf' ?: 'hidden') : 'hidden' }}">
                            <a href="{{ $image_url }}" class="selected-document-pdf  " target="_blank">
                                <i class="bi bi-filetype-pdf text-5xl"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="flex gap-2 justify-end">
                <button type="button"
                    class="bg-white hover:bg-gray-200 border border-transparent text-gray-600 hover:text-black rounded-full block px-4 py-1.5 transition-all duration-300"
                    id="closePrevModalButton">@lang('user.preview.button.close')</button>
                <button type="button"
                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5"
                    id="all_submit_profile">@lang('user.preview.button.submit')</button>
            </div>
        </div>
    </div>
</div>
