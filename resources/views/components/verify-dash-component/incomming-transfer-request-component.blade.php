<div class="grid gap-6 my-6">
    <div class="flex items-bottom justify-between">
        <p class="text-xl font-medium">@lang('user.dashboard.no_inc.heading')</p>
    </div>
    @if (count($incommingDataTable['incomming_requests']) != 0)
        <div class="border rounded-2xl overflow-x-auto bg-white">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col1')</th>
                            <th width="70%" class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col2')</th>
                            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.search_profile.table_col3')</th>
                            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900" width="100px"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($incommingDataTable['incomming_requests'] as $incomming_request)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    <div class="flex items-center">
                                        <img src="{{ Storage::url($incomming_request->transfer_employee_user->documents[0]->documet_location) }}"
                                            class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                        <div>
                                            <p class="font-semibold">
                                                {{ $incomming_request->transfer_employee_user->full_name }}
                                            </p>
                                            <p class="text-gray-900 text-xs whitespace-nowrap">{{$incomming_request->transfer_employee_user->employment_details->post_names->name ?? 'N/A'}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    {{$incomming_request->transfer_employee_user->employment_details->offices_finassam->name ?? 'N/A'}},
                                    {{ $incomming_request->transfer_employee_user->employment_details->departments->name ?? 'N/A' }},
                                    {{ $incomming_request->transfer_employee_user->employment_details->districts->name ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">
                                    {{ $incomming_request->transfer_employee_user->phone ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-xs">
                                    <div class="flex- gap-1">

                                        <div class="flex gap-1 justify-center">
                                            <button type="button"
                                                {{ $incommingDataTable['is_request_process'] ? 'disabled' : '' }}
                                                value="{{ Crypt::encryptString($incomming_request->id) }}"
                                                class="accpect-by-target bg-green-500 hover:bg-green-600 text-white px-2 py-1.5 rounded-md text-xs">@lang('user.dashboard.no_inc.button.yes')</button>
                                                <button type="button" id=""
                                                {{-- {{ $incommingDataTable['is_request_process'] ? 'disabled' : '' }} --}}
                                                value="{{ Crypt::encryptString($incomming_request->id) }}"
                                                class="reject-by-target bg-red-500 hover:bg-red-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">@lang('user.dashboard.no_inc.button.no')</button></div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    @else
        <div class="h-24 col-span-2 flex items-center justify-center mb-6">
            <p class="text-gray-600">@lang('user.dashboard.no_inc.txt')</p>
        </div>
    @endif
</div>
