{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title', 'Registration')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')
    @if ($view_data['is_error'])
        <h1>Server error please try later </h1>
    @else
        <div class="py-8 my-auto">
            <div class="max-w-5xl mx-auto">
                <div class="mt-8 space-y-12">
                    <div class="mb-6 space-y-2">
                        <p class="text-3xl text-center font-semibold">Let's get you started</p>
                        <p class="text-gray-900 text-center font-medium">Find your profile or create a new account</p>
                    </div>

                    {{-- ---------------------- find pan card details ------------- --}}
                    <form action="{{ route('register') }}" method="GET">
                        <div class="grid gap-6">
                            <div
                                class="grid lg:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                                <div class="lg:col-span-3">
                                    <p class="text-lg font-bold text-sky-700">Find Profile</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-800">Enter PAN
                                        Number</label>
                                    <input type="text" name="request_pan_number" value="{{isset($view_data['request_pan_number']) ? $view_data['request_pan_number'] : ''}}"
                                        class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5">Find</button>
                            </div>
                        </div>
                    </form>
                    {{-- ---------------------- end find pan card details ------------- --}}
                    <form id="register-form">
                        <div class="grid gap-12">
                            {{-- ----------------- start basic information ------------------- --}}
                            @php
                                $component_view_data = [
                                    // 'govt_ID_type' => $view_data['govt_ID_type'],
                                    'caste' => $view_data['caste'],
                                    'disability_types' => $view_data['disability_types'],
                                ];
                            @endphp
                            <x-public.user_registration.basic-information-component :viewData=$component_view_data>

                            </x-public.user_registration.basic-information-component>
                            {{-- ----------------- end basic information ------------------- --}}
                            @php
                                $component_view_data = [
                                    'districts' => $view_data['districts'],
                                    'depertments' => $view_data['depertments'],
                                ];
                            @endphp
                            {{-- -------------------- start employment information ---------------------- --}}
                            <x-public.user_registration.employment-information-component :viewData=$component_view_data>

                            </x-public.user_registration.employment-information-component>
                            {{-- -------------------- end employment information ---------------------- --}}
                            @php
                                $component_view_data = [
                                    'districts' => $view_data['districts'],
                                ];
                            @endphp
                            {{-- ------------------- start preference district --------------- --}}
                            <x-public.user_registration.preference-district-component :viewData=$component_view_data>

                            </x-public.user_registration.preference-district-component>
                            {{-- ------------------- end preference district --------------- --}}

                            {{-- ---------------- start additional info --------------- --}}
                            <x-public.user_registration.additional-info-component>

                            </x-public.user_registration.additional-info-component>

                            {{-- ---------------- end additional info --------------- --}}
                            {{-- -------------- start document information ----------------- --}}
                            <x-public.user_registration.document-component></x-public.user_registration.document-component>
                            {{-- -------------- end document information ----------------- --}}
                            <div class="flex justify-end">
                                <!-- <a href="./otp.html" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5">Preview & Submit</a> -->
                                <button type="submit"
                                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5"
                                    id="prevModalBtn">Save & Preview</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ---------------- registration preview model ------------------- --}}
        <x-public.user_registration.registration-preview-component></x-public.user_registration.registration-preview-component>
    @endif
@endsection

{{-- -------------- end dynamic content ---------------- --}}

{{-- ----------- start extra js links ----------------- --}}
@section('extra_js')
    <script type="module" src="{{ asset('js/public/registration.js') }}"></script>
    <script src="{{ asset('js/public/file_hanlde.js') }}"></script>
@endsection
{{-- ----------- end extra js links ----------------- --}}
