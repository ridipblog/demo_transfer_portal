{{-- ---------------- extending employee app layout --------------- --}}
@extends('layouts.employees_layouts.employee_app')
@section('title', 'Employee Dashboard')

@section('content')
    @if (!$view_data['is_error'])

        {{-- --------------- start employee profile table ---------------- --}}

        <x-employees.profile-request.search-profile-table-component :viewData=$search_profile_table :searchProfileTableCom=$search_profile_table_component>

        </x-employees.profile-request.search-profile-table-component>
        {{-- --------------- end employee profile table ---------------- --}}

        {{-- -------------- start profile request modal --------------- --}}
        <x-employees.profile-request.profile-request-component>

        </x-employees.profile-request.profile-request-component>
        {{-- --------------------- end profile request modal --------------- --}}
    @else
        @php
            $pop_data = [
                'success' => 'hidden',
                'message' => $view_data['message'],
                'action' => 'redirect',
                'url'=>'/'.app()->getLocale().'/employees/dashboard'
            ];
        @endphp
        <x-reuse_components.pop-message-component :viewData=$pop_data>

        </x-reuse_components.pop-message-component>
    @endif
@endsection
{{-- --------------- extra js links ------------- --}}
@section('extra_js_links')
    <script type="module" src="{{ asset('/js/employee_access/profile_request.js') }}"></script>
@endsection
