@if (count($employees_profiles) != 0)
    <div class="border rounded-2xl overflow-x-auto bg-white">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900 whitespace-nowrap">Name &
                        Designation</th>
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900 whitespace-nowrap" width="60%">Office &
                        Department</th>
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                    <th class="text-left p-4 px-6 font-medium text-sm text-gray-900" width="140px"></th>
                </tr>
            </thead>
            <tbody class="divide-y" id="search-profile-table">
                @foreach ($employees_profiles as $employee_profile)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-xs text-gray-900">
                            <div class="flex items-center">
                                <img src="{{ Storage::url($employee_profile->documents[0]->documet_location ?? 'N/A') }}"
                                    class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                <div>
                                    <p class="font-semibold whitespace-nowrap">
                                        {{ $employee_profile->full_name }}
                                    </p>
                                    <p class="text-gray-900 text-xs whitespace-nowrap">{{$employee_profile->employment_details->post_names->name ?? 'N/A'}}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-900">
                            <p class="min-w-[15rem]">{{ $employee_profile->employment_details->offices_finassam->name ?? 'N/A' }},
                            {{ $employee_profile->employment_details->departments->name ?? 'N/A' }},
                            {{ $employee_profile->employment_details->districts->name ?? 'N/A' }}</p>
                        </td>
                        <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">
                            {{ $employee_profile->phone }}
                        </td>
                        <td class="py-4 px-6 text-xs">
                            <div class="flex justify-center">
                                <button type="button" data-target-employee-name="{{$employee_profile->full_name ?? ''}}" value="{{ Crypt::encryptString($employee_profile->id) }}"
                                    class="bg-green-500 hover:bg-green-600 text-white px-2 py-1.5 rounded-md text-xs directRequest profile-request-btn" title="@lang('user.search_profile.send_request.heading')">
                                    <i class="bi bi-check sm:hidden"></i> <span class="hidden sm:block">@lang('user.search_profile.send_request.heading')</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="flex flex-col items-center justify-center table_nfDiv">
        <img src="{{asset('/images/nfd.png')}}" alt="" class="w-36 object-center mb-2">
        <p class="text-gray-500 font-bold text-lg text-center">@lang('user.search_profile.nfd.heading')</p>
        <p class="text-gray-500 text-sm text-center">@lang('user.search_profile.nfd.txt')</p>
    </div>
@endif
