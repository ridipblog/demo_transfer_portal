{{-- ---------------- extending employee app layout --------------- --}}
@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

    @if (!$view_data['is_error'])
        {{-- ---------------- start registration and profile count ---------------- --}}

        <h1>Total Regisration : {{ $view_data['profile_verification']->registered ?? 'N/A' }}</h1>
        <h1>Total Completed Profile : {{ $view_data['profile_verification']->completed ?? 'N/A' }} </h1>

        {{-- ---------------- end registration and profile count ---------------- --}}

        {{-- --------------- start profile verification counts -------------- --}}

        <h1>
            Total Verification Pendding: {{ $view_data['profile_verification']->pendding ?? 'N/A' }}
        </h1>
        <h1>
            Total Verification Completed : {{ $view_data['profile_verification']->verified ?? 'N/A' }}
        </h1>
        <h1>
            Total Verification Rejected : {{ $view_data['profile_verification']->rejected ?? 'N/A' }}
        </h1>

        {{-- --------------- end profole verification counts ---------------- --}}

        {{-- ---------------- start profile recomendation status ------------------- --}}

        <h1>
            Total Recomendation Pendding: {{ $view_data['profile_verification']->profile_recomendation_pending ?? 'N/A' }}
        </h1>
        <h1>
            Total Recomendation Completed
            :{{ $view_data['profile_verification']->profile_recomendation_completed ?? 'N/A' }} </h1>
        <h1>
            Total Recomendation Rejected : {{ $view_data['profile_verification']->profile_recomendation_rejected ?? 'N/A' }}
        </h1>


        {{-- ---------------- end profile recomendation status ------------------- --}}

        {{-- ------------------------- start transfer counts ----------------------------- --}}

        <h1>
            Total Process Transfers : {{ $view_data['transfer_counts']->total_process_transfers ?? 'N/A' }}
        </h1>
        <h1>
            Total Pendding Transfers : {{ $view_data['transfer_counts']->transfer_pendding ?? 'N/A' }}
        </h1>
        <h1>
            Total Accepted Transfers : {{ $view_data['transfer_counts']->transfer_accepted ?? 'N/A' }}
        </h1>
        <h1>
            Total Rejected Transfers : {{ $view_data['transfer_counts']->transfer_rejected ?? 'N/A' }}
        </h1>

        {{-- ------------------------- end transfer counts ----------------------------- --}}

        {{-- ----------------- start table data ---------------- --}}

        <table border="1" class="w-full mt-12 datatable text-xs">
            <thead>
                <tr class="bg-gray-300">
                    <td class="text-center">Sl No</td>
                    <td>Date</td>
                    <td>Total Registration</td>
                    <td>Total Verified Profile </td>
                    <td>Total Recomended Profile</td>
                    <td>Total JTO Generated</td>
                    <td>Total Approved Transfers</td>

                </tr>
            </thead>
            <tbody class="divide-y">

                @foreach ($view_data['date_range'] as $key => $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        @php
                            $date = \Carbon\Carbon::parse($value)->format('Y-F-d');
                        @endphp
                        <td>{{ $date }}</td>
                        <td>{{ $view_data['date_wise_registration']->firstWhere('date', $value)->total_registration ?? '0' }}
                        </td>
                        {{-- <td>
                            @php
                                $total_registration = in_array(
                                    $value,
                                    $view_data['date_wise_registration']->pluck('date')->toArray(),
                                )
                                    ? $view_data['date_wise_registration']->firstWhere('date', $value)
                                        ->total_registration
                                    : '0';
                            @endphp
                            {{ $total_registration }}
                        </td> --}}
                        <td> {{ $view_data['date_wise_verification']->firstWhere('date', $value)->total_profile_verification ?? '0' }}
                        </td>
                        <td> {{ $view_data['date_wise_recomendation']->firstWhere('date', $value)->total_profile_recomendation ?? '0' }}
                        </td>
                        <td> {{ $view_data['date_wise_transfer_JTO']->firstWhere('date', $value)->total_JTO ?? '0' }} </td>
                        <td> {{ $view_data['date_wise_transfer_approved']->firstWhere('date', $value)->total_approved_transfers ?? '0' }}
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
@section('extra_js_links')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $('.datatable').DataTable();
        $('.select2').select2();
    </script>
@endsection
