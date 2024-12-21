<div class="grid gap-12">
    {{-- <div class="">
        <div class="bg-sky-100 rounded-2xl p-6 flex flex-col justify-end border border-b-4 border-r-4 border-sky-500">
            <h3 class="text-5xl font-semibold text-sky-600">Looking for the best transfer options?</h3>
            <p class="mt-6 mb-12 text-gray-900">Our platform uses your preferences and employment details to
                recommend the most compatible mutual transfer opportunities, making the process faster and more
                efficient.</p>
            <a href="../user-login.html" class="underline text-xs">Learn more</a>
        </div>
    </div> --}}
    <div class="flex flex-col gap-6">
        <div class="flex items-bottom justify-between">
            <p class="text-xl font-medium">@lang('user.dashboard.by_pref.heading')</p>
            <!-- <a href="./search-profiles.html" class="hover:underline text-gray-900 text-xs">View all <i class="bi bi-arrow-up-right"></i></a> -->
        </div>
        <div class="">
            <div class="border rounded-2xl overflow-hidden bg-white">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">@lang('user.dashboard.by_pref.table_col1')</th>
                            <th class="p-4 px-6 font-medium text-sm text-gray-900" width="100px">@lang('user.dashboard.by_pref.table_col2')</th>
                            <th class="text-left p-4 px-6 font-medium text-sm text-gray-900" width="100px">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($preferenceDistricts as $preference_district)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    {{ $preference_district->districts->name }}
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap text-center">{{$countByPrefernceDistrict[$preference_district->district_id]}}</td>
                                <td class="py-4 px-6 text-xs">
                                    <div class="flex justify-center"><a href="{{ url(app()->getLocale().'/employees/search-profile/' . Crypt::encryptString($preference_district->district_id)) }}"
                                            class="disabled:opacity-80 disabled:bg-sky-300 bg-sky-600 hover:bg-sky-700 text-white px-2 py-1.5 rounded-md text-xs" title="@lang('user.dashboard.by_pref.btn_list')"><i
                                                class="bi bi-view-list"></i></a></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
