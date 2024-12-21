{{-- @php
    $additional_info = $viewData['save_data']->additional_info ?? null;
@endphp
@if ($additional_info)
    <div class="grid lg:grid-cols-3 gap-2 lg:gap-2 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-5 lg:p-10">
        <div class="lg:col-span-3">
            <p class="text-lg font-bold text-sky-700">@lang('user.form.addl_info.heading')</p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.addl_info.ccp')</label>
            <div class="flex gap-6 mt-2">
                <div class="flex gap-3">

                    <input type="radio" name="case_pendding"
                        {{ $additional_info->criminal_case == 'yes' ? 'checked' : '' }} value="yes"
                        class="registration-input border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                    <p class="text-xs text-gray-900">Yes</p>
                </div>
                <div class="flex gap-3">
                    <input type="radio" name="case_pendding"
                        {{ $additional_info->criminal_case == 'no' ? 'checked' : '' }} value="no"
                        class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                    <p class="text-xs text-gray-900">No</p>
                </div>
            </div>
            <p class="registration-error"></p>
        </div>
        <div>
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.addl_info.dpp')</label>
            <div class="flex gap-6 mt-2">
                <div class="flex gap-3">
                    <input type="radio" name="departmental_proceedings"
                        {{ $additional_info->departmental_proceedings == 'yes' ? 'checked' : '' }} value="yes"
                        class="registration-input border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                        >
                    <p class="text-xs text-gray-900">Yes</p>
                </div>
                <div class="flex gap-3">
                    <input type="radio" name="departmental_proceedings"
                        {{ $additional_info->departmental_proceedings == 'no' ? 'checked' : '' }} value="no"
                        class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                        >
                    <p class="text-xs text-gray-900">No</p>
                </div>
            </div>
            <p class="registration-error"></p>
        </div>
        <div class="">
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.addl_info.mtb')</label>
            <div class="flex gap-6 mt-2">
                <div class="flex gap-3">
                    <input type="radio" name="before_mutual_transfer"
                        {{ $additional_info->mutual_transfer == 'yes' ? 'checked' : '' }} value="yes"
                        class="registration-input  border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                    <p class="text-xs text-gray-900">Yes</p>
                </div>
                <div class="flex gap-3">
                    <input type="radio" name="before_mutual_transfer"
                        {{ $additional_info->mutual_transfer == 'no' ? 'checked' : '' }} value="no"
                        class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                    <p class="text-xs text-gray-900">No</p>
                </div>
            </div>
            <p class="registration-error"></p>
        </div>
        <div class="{{ $additional_info->mutual_transfer != 'yes' ? 'hidden' : '' }} " id="avlTfrVal">
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.addl_info.no_mt')</label>
            <select name="mutual_transfer_number" id="mutual_transfer_number"
                class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                >
                <option value="" {{ $additional_info->mutual_transfer == 'yes' ? '' : 'selected' }} disabled>—
                    Select
                    —</option>
                <option value="1" {{ $additional_info->no_mutual_transfer == 1 ? 'selected' : '' }}>1</option>
                <option value="2" {{ $additional_info->no_mutual_transfer == 2 ? 'selected' : '' }}>2</option>
            </select>
            <p class="registration-error"></p>
        </div>
        <div class="">
            <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.addl_info.govt_due')</label>
            <div class="flex gap-6 mt-2">
                <div class="flex gap-3">
                    <input type="radio" name="pending_govt_dues"
                        {{ $additional_info->pending_govt_dues == 'yes' ? 'checked' : '' }} value="yes"
                        class="registration-input border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                    <p class="text-xs text-gray-900">Yes</p>
                </div>
                <div class="flex gap-3">
                    <input type="radio" name="pending_govt_dues"
                        {{ $additional_info->pending_govt_dues == 'no' ? 'checked' : '' }} value="no"
                        class="border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5">
                    <p class="text-xs text-gray-900">No</p>
                </div>
            </div>
            <p class="registration-error"></p>
        </div>
    </div>
@else
    <div class="bg-yellow-100 p-6 text-yellow-600 mb-24 rounded-3xl">
        <div class="flex gap-4">
            <i class="bi bi-exclamation-triangle"></i>
            <div class="">
                <p class="text-xl font-semibold mb-1">@lang('user.form.addl_info.messages.title')</p>
                <p>@lang('user.form.addl_info.messages.text')</p>
            </div>
        </div>
    </div>
@endif --}}

@php
    $additional_info = $viewData['save_data']->additional_info ?? null;
@endphp
{{-- --------- times of muatal transer -------------- --}}
<div class="grid lg:grid-cols-3 gap-2 lg:gap-2 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-5 lg:p-10">
    <div class="lg:col-span-3">
        <p class="text-lg font-bold text-sky-700">Tranfser History</p>
    </div>
    <div class="" id="avlTfrVal">
        {{-- <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">@lang('user.form.addl_info.no_mt')</label> --}}
        <label class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">How many times have you availed mutual transfer ?</label>
        <select name="times_mutual_transfer" id="times_mutual_transfer"
            class="registration-input disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
            <option value="" disabled selected>Select</option>
            <option value="0" {{$additional_info->times_mutual_transfer == 0 ? 'selected' : ''}}>0</option>
            <option value="1" {{$additional_info->times_mutual_transfer == 1 ? 'selected' : ''}}>1</option>
            <option value="2" {{$additional_info->times_mutual_transfer == 2 ? 'selected' : ''}}>2</option>
        </select>
        <p class="registration-error"></p>
    </div>
    <div class=""></div>
    <div class="flex flex-col items-center justify-center table_nfDiv">
        <img src="/images/nfd.png" alt="" class="w-36 object-center mb-2">
        <p class="text-gray-500 font-bold text-lg text-center">No Tranfser History Found!</p>
    </div>

</div>
