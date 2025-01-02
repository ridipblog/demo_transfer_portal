{{-- ---------------- extending employee app layout --------------- --}}
@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('extra_css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
@endsection()
@section('content')

    <x-admin.admin-header></x-admin.admin-header>

    @if (!$view_data['is_error'])


        {{-- ----------------- start table data ---------------- --}}

        <table border="1" class="w-full mt-12 datatable text-xs">
            <thead>
                <tr class="bg-gray-300">
                    <td>SI NO</td>
                    <td>Full name</td>
                    <td>email</td>
                    <td>phone</td>
                    <td>Pan number</td>
                    <td>Revert</td>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($view_data['all_users'] ?? [] as $user)
                    <tr>
                        <td>{{ $loop->iteration ?? 'N/A' }}</td>
                        <td>{{ $user->full_name ?? 'N/A' }}</td>
                        <td>{{ $user->email ?? 'N/A' }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>{{ $user->persional_details->pan_number ?? 'N/A' }}</td>
                        <td>
                            <button value="{{ Crypt::encryptString($user->id) }}"
                                class="revert_id bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ease-in-out">
                                Revert User
                            </button>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- --------------------- end table data ------------------------ --}}
    @else
        <p class="text-red-600">{{ $view_data['message'] }}</p>
    @endif
@endsection
@section('extra_js')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script type="module" src="{{ asset('js/admin/admin.js') }}"></script>
    <script>
        $('.datatable').DataTable();
    </script>

@endsection
