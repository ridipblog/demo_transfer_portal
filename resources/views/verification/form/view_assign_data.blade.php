@if ($view_data['status'] == 200)
    <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg datatable text-xs">
        <thead>
            <tr class="bg-gray-50">
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2 text-left">Name</th>
                <th class="border px-4 py-2 text-left">Role</th>
                <th class="border px-4 py-2 text-left">Office</th>
                <th class="border px-4 py-2 text-left">District</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($view_data['assign_data']->authority_office_dist_map ?? [] as $assign_data)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $view_data['assign_data']->name }}</td>
                    <td class="border px-4 py-2">{{ $assign_data->roles->display_name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">
                        {{ $assign_data->office_id == null ? 'All' : $assign_data->office_fin_assam->name ?? 'N/A' }}
                    </td>
                    {{-- <td class="border px-4 py-2">{{ $assign_data->district_id == null ? 'All' : ($assign_data->districts->name ?? 'N/A') }}</td> --}}
                    <td class="border px-4 py-2">
                        @php
                            $districtName = $assign_data->district_id
                                ? $assign_data->districts->name ?? 'N/A'
                                : ($assign_data->office_id
                                    ? collect($assign_data->office_fin_assam->office_dist_dept_map ?? [])->map(function (
                                            $district,
                                        ) {
                                            return $district->districts->name ?? 'N/A';
                                        })->implode(', ') ?? []
                                : 'ALL'); @endphp
                        @php
                            $name=empty($districtName) ? 'N/A' : $districtName;
                            echo $name;
                        @endphp
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@else
    <h1>Server error please try later !</h1>
@endif
