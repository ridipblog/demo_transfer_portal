{{-- ---------------- extending employee app layout --------------- --}}
@extends('layouts.employees_layouts.employee_app')
@section('title', 'Employee Dashboard')
@section('content')
    @php
        // try {
        // if (Auth::guard('user_guard')) {
        // $logged_persion = Auth::guard('user_guard')->user();
        // } else {
        // $view_data['is_error'] = true;
        // }
        // } catch (Exception $err) {
        // $view_data['is_error'] = true;
        // }
    @endphp
    @if (!$view_data['is_error'])
        @php
            $logged_persion = $view_data['logged_persion'];
        @endphp
        @php
            if ($logged_persion->profile_verify_status != 1 || $logged_persion->noc_generate != 1) {
                $view_data['is_verified'] = false;
            } else {
                $view_data['is_verified'] = true;
            }
            $view_data['icon_status'] = isset($transfer_data)
                ? ($transfer_data['2nd_recommend'] == 2 || $transfer_data['final_approval'] == 2
                    ? false
                    : true)
                : $view_data['is_verified'];
        @endphp

        <div class="py-8 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mt-8 grid lg:grid-cols-3 gap-6 lg:gap-12">
                    {{-- --------------------- start profile status component --------------- --}}
                    <x-employees.profile-status-component :viewData=$logged_persion :profileData=$profile_data
                        :isRequestDone=$is_request_done :transferData=$transfer_data>
                    </x-employees.profile-status-component>
                    {{-- ------------------- end profile status component -------------------- --}}
                    <div class="lg:col-span-2">

                        @php
                            $profile_status_text =
                                $logged_persion->profile_verify_status == 1
                                    ? (isset($transfer_data)
                                        ? ($transfer_data['2nd_recommend'] == 1 || $transfer_data['final_approval'] == 2
                                            ? 'second_transfer_verification'
                                            : 'noc_status')
                                        : 'noc_status')
                                    : 'profile_status';
                            $profile_status_index =
                                $logged_persion->profile_verify_status == 1
                                    ? (isset($transfer_data)
                                        ? ($transfer_data['final_approval'] == 2
                                            ? $transfer_data['final_approval']
                                            : ($transfer_data['2nd_recommend'] == 1
                                                ? $transfer_data['2nd_recommend']
                                                : $logged_persion->noc_generate))
                                        : $logged_persion->noc_generate)
                                    : $logged_persion->profile_verify_status;
                        @endphp
                        <div class="mb-6 lg:mb-12">

                            @if (
                                !$transfer_data ||
                                    (isset($transfer_data)
                                        ? ($transfer_data['2nd_recommend'] == 1 && $transfer_data['final_approval'] == 0) ||
                                            $transfer_data['final_approval'] == 2
                                        : false))
                                <div @php $color=__('user.profile_alter_text.'.$profile_status_text. '.' . $profile_status_index . '.color' ) ?? '' ; @endphp
                                    class="bg-{{ $color }}-100 p-6 text-{{ $color }}-600 mb-12 rounded-3xl">
                                    <div class="flex items- justify-center gap-6">
                                        <i
                                            class="{{ $view_data['icon_status'] ? 'bi bi-check-circle' : 'bi bi-exclamation-triangle' }} text-3xl"></i>
                                        <div class="">
                                            <p class="text-xl font-semibold mb-1">
                                                {{ __('user.profile_alter_text.' . $profile_status_text . '.' . $profile_status_index . '.header') ?? 'Error found here!' }}
                                            </p>
                                            <p>
                                                {!! __('user.profile_alter_text.' . $profile_status_text . '.' . $profile_status_index . '.body') ??
                                                    'Error found here!' !!}
                                            </p>
                                            <p>
                                                {{ $logged_persion->profile_verify_status == 2 ? __('user.profile_alter_text.reason') . ' - ' . $logged_persion->verified_remarks : ($logged_persion->noc_generate == 2 ? __('user.profile_alter_text.reason') . ' - ' . $logged_persion->noc_remarks : '') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!$view_data['is_verified'])
                                <!-- start Until verification pending -->
                                @if ($logged_persion->profile_verify_status != 3)
                                    @php
                                        $employee_all_details = $view_data['employee_all_data'];
                                        $verifier_add_documents = $verifier_add_documents;
                                    @endphp
                                    <x-employees.pendding-dash-content-component :viewData=$employee_all_details :verifierAddDocuments=$verifier_add_documents>
                                    </x-employees.pendding-dash-content-component>
                                @endif
                                <!-- end Until verification pending -->
                            @else
                                <!-- After verification completed and NOC generated start -->
                                @php
                                    $verifi_data = [
                                        'view_data' => $logged_persion,
                                        'transfer_data' => $transfer_data,
                                        'incomming_data_table' => $incomming_data_table,
                                        'preference_districts' => $preference_districts,
                                        'count_by_prefernce_district' => $count_by_prefernce_district,
                                    ];
                                @endphp
                                <x-employees.verified-dash-content-component :viewData=$logged_persion
                                    :transferData=$transfer_data>
                                </x-employees.verified-dash-content-component>
                                @if (!$is_request_done)
                                    <x-verify-dash-component.incomming-transfer-request-component
                                        :incommingDataTable=$incomming_data_table>
                                    </x-verify-dash-component.incomming-transfer-request-component>
                                    {{-- ----------------- recommend by preference ---------------- --}}
                                    <x-verify-dash-component.recomendedby-reference-component
                                        :preferenceDistricts=$preference_districts
                                        :countByPrefernceDistrict=$count_by_prefernce_district>
                                    </x-verify-dash-component.recomendedby-reference-component>
                                @endif
                                <!-- After verification completed and NOC generated end -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h1>{{ $view_data['message'] }} .</h1>
            @php
                $pop_data = [
                    'success' => 'hidden',
                    'message' => $view_data['message'],
                    'action' => 'close',
                    // 'url'=>'/employees/dashboard'
                ];
            @endphp
            <x-reuse_components.pop-message-component :viewData=$pop_data>
            </x-reuse_components.pop-message-component>
    @endif
@endsection
@section('extra_js_links')
    <script type="module" src="{{ asset('/js/employee_access/profile_request.js') }}"></script>
@endsection
