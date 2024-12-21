{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title', 'update profile')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')
    @if ($view_data['is_error'])
        <h1>{{ $view_data['error_message'] }} </h1>
    @else
        <div class="py-8 my-auto">
            <div class="max-w-5xl mx-auto">
                <div class="mt-8 space-y-12">
                    <div class="mb-6 space-y-2">
                        <p class="text-3xl text-center font-semibold">Let's get you started</p>
                        <p class="text-gray-500 text-center font-medium">Enter the details to get going</p>
                    </div>
                    <form id="update-employee-profile-form">
                        <div class="grid gap-12">
                            {{-- ----------------- start basic information ------------------- --}}
                            @php

                                $component_view_data = [
                                    'caste' => $view_data['caste'],
                                    'user_credentials' => $view_data['employee_all_data'],
                                    'persional_details' => $view_data['employee_all_data']->persional_details,
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
                                    'employment_details' => $view_data['employee_all_data']->employment_details,
                                ];
                            @endphp
                            {{-- -------------------- start employment information ---------------------- --}}
                            <x-public.user_registration.employment-information-component :viewData=$component_view_data>

                            </x-public.user_registration.employment-information-component>
                            {{-- -------------------- end employment information ---------------------- --}}
                            @php
                                $component_view_data = [
                                    'districts' => $view_data['districts'],
                                    'preferences_district' => $view_data['employee_all_data']->preferences_district,
                                ];
                            @endphp
                            {{-- ------------------- start preference district --------------- --}}
                            <x-public.user_registration.preference-district-component :viewData=$component_view_data>

                            </x-public.user_registration.preference-district-component>
                            {{-- ------------------- end preference district --------------- --}}
                            {{-- ---------------- start additional info --------------- --}}
                            @php
                                $component_view_data = [
                                    'additional_info' => $view_data['employee_all_data']->additional_info,
                                ];
                            @endphp
                            <x-public.user_registration.additional-info-component :viewData=$component_view_data>

                            </x-public.user_registration.additional-info-component>

                            {{-- ---------------- end additional info --------------- --}}
                            {{-- -------------- start document information ----------------- --}}
                            @php
                                $component_view_data = [
                                    'documents' => $view_data['employee_all_data']->documents,
                                ];
                            @endphp
                            <x-public.user_registration.document-component :viewData=$component_view_data>

                            </x-public.user_registration.document-component>
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
    <script type="module" src="{{ asset('js/employee_access/employee_profile.js') }}"></script>
    <script src="{{ asset('js/public/file_hanlde.js') }}"></script>
@endsection
{{-- ----------- end extra js links ----------------- --}}
