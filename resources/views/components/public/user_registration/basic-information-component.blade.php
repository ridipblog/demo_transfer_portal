@php
    isset($viewData['pan_request_data']) ? ($pan_request_data = true) : ($pan_request_data = false);
    $persioanl_data = $viewData['save_data']->persional_details ?? null;
    $is_pan_found=$viewData['is_pan_found'];
@endphp

@if ($persioanl_data)
    <div class="grid lg:grid-cols-3 gap-2 lg:gap-2 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-5 lg:p-10">
        <div class="lg:col-span-3">
            <p class="text-lg font-semibold text-sky-500">@lang('user.form.basic_info.heading')</p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.name')</label>
            <input type="text" name="full_name"
                value="{{ $viewData['save_data']->full_name ?? 'N/A' }}"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>

            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.dob')</label>
            <input type="date" name="date_of_birth"
                value="{{ $persioanl_data->date_of_birth ?? '' }}"
                class="clear-input-error registration-input preview-input  border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                >
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.gender')</label>
            <select name="gender"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                <option value="" {{ $persioanl_data->gender ?? 'selected' }} disabled>— Select —</option>
                <option value="male" {{ $persioanl_data->gender == 'male' ? 'selected' : '' }}>Male
                </option>
                <option value="female" {{ $persioanl_data->gender == 'female' ? 'selected' : '' }}>
                    Female
                </option>
            </select>
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.f_name')</label>
            <input type="text" name="father_name" value="{{ $persioanl_data->father_name ?? '' }}"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.m_name')</label>
            <input type="text" name="mother_name" value="{{ $persioanl_data->mother_name ?? '' }}"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.caste')</label>
            <select id="caste_type" name="category"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                <option value="" {{ $persioanl_data->category_id ?? 'selected' }} disabled>— Select —</option>
                @foreach ($viewData['caste'] as $caste)
                    <option value="{{ $caste->id }}"
                        {{ $persioanl_data->category_id == $caste->id ? 'selected' : '' }}>
                        {{ $caste->caste_name }}</option>
                @endforeach
            </select>
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.pno')</label>
            <input type="tel" name="phone" value="{{ $viewData['save_data']->phone ?? '' }}"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                disabled>
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold text-gray-800">@lang('user.form.basic_info.apno')</label>
            <input type="tel" name="alternative_number" value="{{ $persioanl_data->alt_phone_number ?? '' }}"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.email')</label>
            <input type="email" name="email" value="{{ $viewData['save_data']->email ?? '' }}"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.pan')</label>
            <input type="text" name="pan_number" readonly
                value="{{ $is_pan_found ?( $viewData['search_pan_number'] ?? '') : ($persioanl_data->pan_number ?? '')}}"
                class="clear-input-error registration-input preview-input border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full uppercase"
                id="idNum">
            {{-- <input type="text" name="pan_number"
                value="{{ $viewData['pan_request_data']['profile']['pan'] ?? ($persioanl_data->pan_number ?? '')}}"
                class="clear-input-error registration-input preview-input border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                id="idNum" readonly> --}}
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.h_d')</label>
            <select id="home_district" name="home_district"
                class="clear-input-error registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                <option value="" {{ $persioanl_data->home_district_id ?? 'selected' }} disabled>— Select —</option>
                @foreach ($viewData['districts'] as $district)
                    <option value="{{ $district->id ?? '' }}"
                        {{ $persioanl_data->home_district_id == $district->id ? 'selected' : '' }}>
                        {{ $district->name }}</option>
                @endforeach
            </select>
            <p class="registration-error capitalize pt-1" style="color:red"></p>
        </div>
        {{-- <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.basic_info.heading')</label>
            <input type="text" name="pan_number"
                value="{{ $viewData['pan_request_data']['profile']['pan'] ?? ($persioanl_data->pan_number ?? '') }}"
                class="registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                id="idNum" disabled>
            <p class="registration-error"></p>
        </div> --}}
        {{-- <div>
        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-500">Govt. ID Type</label>
        <select name="govt_identy_type"
            class="registration-input preview-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
            id="idType">
            <option value="" {{ $update_data ?: 'selected' }} disabled>— Select —</option>
            @foreach ($viewData['govt_ID_type'] as $id_type)
                <option value="{{ $id_type->id }}"
                    {{ $update_data ? ($viewData['persional_details']->govt_identy_type == $id_type->id ? 'selected' : '') : '' }}>
                    {{ $id_type->ID_type }}</option>
            @endforeach
        </select>
        <p class="registration-error"></p>
    </div> --}}

    </div>
@else
    <div class="bg-yellow-100 p-6 text-yellow-600 mb-24 rounded-3xl">
        <div class="flex gap-4">
            <i class="bi bi-exclamation-triangle"></i>
            <div class="">
                <p class="text-xl font-semibold mb-1">@lang('user.form.basic_info.messages.title')</p>
                <p>@lang('user.form.basic_info.messages.text')</p>
            </div>
        </div>
    </div>
@endif
