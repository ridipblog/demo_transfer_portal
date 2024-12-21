@php
    isset($viewData['pan_request_data']) ? ($pan_request_data = true) : ($pan_request_data = false);
    $employment_data = $viewData['save_data']->employment_details ?? null;
    $offices = $viewData['offices'];
    $posts = $viewData['posts'];
    $is_pan_found = $viewData['is_pan_found'];
@endphp
@if ($employment_data)
    <div
        class="grid lg:grid-cols-3 gap-2 lg:gap-2 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-5 lg:p-10 overflow-hidden">
        <div class="lg:col-span-3">
            <p class="text-lg font-semibold text-sky-500">@lang('user.form.emp_info.heading')</p>
        </div>
        <div>
            @php
                // $pan_district = strtolower(trim($viewData['pan_request_data']['profile']['district'] ?? null));
                // $pan_department = strtolower(trim($viewData['pan_request_data']['ddo']['department'] ?? null));
                // $pan_office = strtolower(trim($viewData['pan_request_data']['ddo']['office_name'] ?? null));
                // // $pan_office = strtolower(trim('Guwahati West-Palashbari Division, Irrigation'));
                // $pan_post = strtolower($viewData['pan_request_data']['profile']['designation'] ?? null);
                // $pan_ddo = strtolower(trim($viewData['pan_request_data']['ddo']['ddo'] ?? null));
                // // $pan_ddo=strtolower(trim('AKM/IRR/002-DIv '));
                // // $pan_post = strtolower(trim('Junior Assistant'));
            @endphp
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.dist_cp')</label>
            <select name="district" id="select_district"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                <option value="" selected disabled>—
                    Select —</option>
                @foreach ($viewData['districts'] as $district)
                    {{-- <option value="{{ $district->id }}" {{ $is_pan_found ? ($pan_district == strtolower(trim($district->name)) ? 'selected' : '') : ($employment_data->district_id == $district->id ? 'selected ' : '') }}>
                {{ $district->name }}</option> --}}
                    <option value="{{ $district->id }}"
                        {{ $employment_data->district_id == $district->id ? 'selected ' : '' }}>
                        {{ $district->name }}</option>
                    {{-- <option value="{{$district->id}}" {{trim($district_name)===trim($district->name) ? "selected" :''}}>{{$district->name}}</option> --}}
                @endforeach
            </select>
            <p class="registration-error"></p>
        </div>
        <div class="overflow-hidden relative">
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">
                @lang('user.form.emp_info.dept_cp')
            </label>
            <select name="depertment" id="select_depert"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2"
                style="width: 100% !important;">
                <option value="" selected disabled>— Select —</option>
                @foreach ($viewData['depertments'] as $depertment)
                    <option value="{{ $depertment->id }}"
                        {{ $employment_data->depertment_id == $depertment->id ? 'selected ' : '' }}>
                        {{ $depertment->name }}
                    </option>
                @endforeach
            </select>
            <p class="registration-error"></p>
        </div>
        <div class="lg:col-span-2 overflow-hidden relative">
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.office_cp')</label>
            <select name="office" id="select_office"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full select2"
                style="width: 100% !important;">
                <option value="" selected disabled>— Select —</option>
                @foreach ($offices as $office)
                    <option value="{{ $office->office_id }}"
                        {{ $employment_data->office_id == $office->office_id ? 'selected' : '' }}>
                        {{ $office->office_fin_assam->name }}</option>
                @endforeach
            </select>
            <p class="registration-error"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.desg_cp')</label>
            <select name="designation" id="select_degis"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                <option value="" selected disabled>— Select —
                </option>
                @foreach ($posts as $post)
                    {{-- <option value="{{ $post->post_names->id }}" {{ $is_pan_found ? ($pan_post == strtolower(trim($post->post_names->name)) ? 'selected' : '') : ($employment_data->designation_id == $post->post_names->id ? 'selected ' : '') }}>
                {{ $post->post_names->name }}</option> --}}
                    <option value="{{ $post->post_names->id }}"
                        {{ $employment_data->designation_id == $post->post_names->id ? 'selected ' : '' }}>
                        {{ $post->post_names->name }}</option>
                @endforeach
            </select>
            <p class="registration-error"></p>
        </div>
        <div>
            {{-- {{$viewData['pan_request_data']['profile']['date_of_joining']}} --}}
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.doj_fj')</label>
            {{-- <input type="date" name="date_of_joining" id="date_of_join_id" value="{{ $is_pan_found ? $viewData['pan_request_data']['profile']['date_of_joining'] ?? '' : $employment_data->first_date_of_joining ?? '' }}" class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"> --}}
            <input type="date" name="date_of_joining" id="date_of_join_id"
                value="{{ $employment_data->first_date_of_joining ?? '' }}"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.doj_cp')</label>
            <input type="date" name="current_posting_date" id="date_of_join_current_id"
                value="{{ $employment_data->current_date_of_joining ?? '' }}"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.g_pay')</label>
            {{-- <input type="text" value="{{ $is_pan_found ? $viewData['pan_request_data']['profile']['grade_pay'] ?? '' : $employment_data->pay_grade ?? '' }}" id="review_pay_grade" name="pay_grade" class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full read-only:pointer-events-none" readonly> --}}
            <input type="text" value="{{ $employment_data->pay_grade ?? '' }}" id="review_pay_grade"
                name="pay_grade"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full read-only:pointer-events-none"
                readonly>
            <p class="registration-error"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.emp_info.p_bank')</label>
            {{-- <input type="text" name="pay_band" value="{{ $is_pan_found ? $viewData['pan_request_data']['profile']['pay_band'] ?? '' : $employment_data->pay_band ?? '' }}" class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full read-only:pointer-events-none" id="review_pay_band"> --}}
            {{-- <input type="text" name="pay_band" value="{{ $employment_data->pay_band ?? '' }}"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full read-only:pointer-events-none"
                id="review_pay_band"> --}}

            <select name="pay_band" id="review_pay_band"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                <option value="" selected disabled>— Select —
                </option>
                @foreach (config('globalVariables.pay_band_list') ?? [] as $key => $value)
                    <option value="{{ $value }}" {{$employment_data->pay_band ? ($employment_data->pay_band==$value ? 'selected' : '') : ''}}>{{ $value }}</option>
                @endforeach
            </select>
            <p class="registration-error"></p>
        </div>
    </div>
@else
    <div class="bg-yellow-100 p-6 text-yellow-600 mb-24 rounded-3xl">
        <div class="flex gap-4">
            <i class="bi bi-exclamation-triangle"></i>
            <div class="">
                <p class="text-xl font-semibold mb-1">@lang('user.form.emp_info.messages.title')</p>
                <p>@lang('user.form.emp_info.messages.text')</p>
            </div>
        </div>
    </div>
@endif
