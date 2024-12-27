{{-- ------------ implement app layout------------------ --}}
@extends('layouts.employees_layouts.employee_app')

@section('title', 'Update Profile')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')
    @if ($view_data['is_error'])
        <h1>Server error please try later </h1>
    @else
        <div class="py-8 px-4 my-auto">
            <div class="max-w-5xl mx-auto">
                <div class="mt-8 space-y-12">
                    <div class="mb-6 space-y-2">
                        <p class="text-3xl text-center font-semibold">@lang('user.heading')</p>
                        <p class="text-gray-900 text-center font-medium">@lang('user.text')</p>
                    </div>

                    {{-- ---------------------- find pan card details ------------- --}}

                    <x-employee-profile.search-pan-number-component :viewData=$view_data :panComponent=$pan_component>

                    </x-employee-profile.search-pan-number-component>
                    {{-- ---------------------- end find pan card details ------------- --}}



                    @if (
                        ($view_data['search_pan_number'] ? ($view_data['is_pan_found'] ? true : false) : false) ||
                            ($view_data['search_pan_number']
                                ? false
                                : ($view_data['save_data']->persional_details->pan_number
                                    ? true
                                    : false)))
                        <form id="save-profile-form">
                            <div class="grid gap-6">
                                {{-- ----------------- start basic information ------------------- --}}
                                @php
                                    $component_view_data = [
                                        'caste' => $view_data['caste'],
                                        'save_data' => $view_data['save_data'],
                                        'pan_request_data' => $view_data['pan_request_data'],
                                        'search_pan_number' => $view_data['search_pan_number'],
                                        'is_pan_found' => $view_data['is_pan_found'],
                                        'districts' => $view_data['districts'],
                                    ];

                                @endphp
                                <x-public.user_registration.basic-information-component :viewData=$component_view_data>

                                </x-public.user_registration.basic-information-component>
                                {{-- ----------------- end basic information ------------------- --}}
                                @php
                                    $component_view_data = [
                                        'districts' => $view_data['districts'],
                                        'depertments' => $view_data['depertments'],
                                        'directorates' => $view_data['directorates'],
                                        'save_data' => $view_data['save_data'],
                                        'is_pan_found' => $view_data['is_pan_found'],
                                        'pan_request_data' => $view_data['pan_request_data'],
                                        'offices' => $view_data['offices'],
                                        'posts' => $view_data['posts'],
                                    ];
                                @endphp
                                {{-- -------------------- start employment information ---------------------- --}}
                                <x-public.user_registration.employment-information-component :viewData=$component_view_data>

                                </x-public.user_registration.employment-information-component>
                                {{-- -------------------- end employment information ---------------------- --}}
                                @php
                                    $component_view_data = [
                                        'districts' => $view_data['districts'],
                                        'save_data' => $view_data['save_data'],
                                    ];
                                @endphp
                                {{-- ------------------- start preference district --------------- --}}
                                <x-public.user_registration.preference-district-component :viewData=$component_view_data>

                                </x-public.user_registration.preference-district-component>
                                {{-- ------------------- end preference district --------------- --}}

                                {{-- ---------------- start additional info --------------- --}}
                                @php
                                    $component_view_data = [
                                        'save_data' => $view_data['save_data'],
                                    ];
                                @endphp
                                <x-public.user_registration.additional-info-component :viewData=$component_view_data>

                                </x-public.user_registration.additional-info-component>

                                {{-- ---------------- end additional info --------------- --}}
                                {{-- -------------- start document information ----------------- --}}
                                @php
                                    $component_view_data = [
                                        'save_data' => $view_data['save_data'],
                                    ];
                                @endphp
                                <x-public.user_registration.document-component :viewData=$component_view_data>

                                </x-public.user_registration.document-component>
                                {{-- -------------- end document information ----------------- --}}
                                {{-- -------------- declaration and SOP ----------------- --}}

                                {{-- -------------- end declaration and SOP ----------------- --}}
                                <x-employee-profile.submit-profile-button-component :submitButton=$submit_button_component>

                                </x-employee-profile.submit-profile-button-component>
                            </div>
                        </form>
                    @else
                        @php
                            $pop_data = [
                                'success' => 'hidden',
                                'message' => $view_data['error_message'],
                                'action' => 'button',
                                'url' => '',
                            ];
                        @endphp
                        @if ($view_data['search_pan_number'])
                            <x-reuse_components.pop-message-component :viewData=$pop_data>

                            </x-reuse_components.pop-message-component>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- ---------------- registration preview model ------------------- --}}
        @php
            $component_data = [
                'save_data' => $view_data['save_data'],
            ];
        @endphp
        <x-public.user_registration.registration-preview-component :viewData=$component_data>

        </x-public.user_registration.registration-preview-component>
    @endif
@endsection

{{-- -------------- end dynamic content ---------------- --}}

{{-- ----------- start extra js links ----------------- --}}
@section('extra_js_links')
    {{-- <script type="module" src="{{ asset('js/public/registration.js') }}"></script> --}}
    <script type="module" src={{ asset('js/employee_access/employee_profile.js') }}></script>
    <script src="{{ asset('js/public/file_hanlde.js') }}"></script>
    <script src="{{ asset('js/public/pop_message.js') }}"></script>
@endsection
{{-- ----------- end extra js links ----------------- --}}
