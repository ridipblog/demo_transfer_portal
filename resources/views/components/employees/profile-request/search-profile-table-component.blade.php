{{-- @if (!$search_profile_table['is_error']) --}}
<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="mt-8 space-y-12">
            <div class="mb-6 space-y-2">
                <p class="text-3xl font-semibold">@lang('user.search_profile.heading')</p>
            </div>
            <div class="flex gap-4">
                <div class="flex-grow">
                    <div class="mb-6 lg:mb-12">
                        <form id="filter-search-profile-form-input">
                            <div class="flex items-center border border-gray-300 text-gray-900 bg-white text-sm rounded-full focus:ring-sky-600 focus:border-sky-600 px-2.5 py-1">
                                <i class="bi bi-search text-gray-900 pl-4"></i>
                                <div class="flex-grow">
                                    <input type="text" name="search_pan_number" class="disabled:bg-gray-100 block p-2.5 w-full border-none focus:ring-0 focus:border-0 text-xs sm:text-sm" placeholder="@lang('user.search_profile.plr')">
                                </div>
                                <div class="col-span-2 flex justify-end">
                                    <button type="" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-2 py-1.5">@lang('user.search_profile.btn_search')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="flex gap-56 items-bottom justify-between mb-6">
                        <form class="flex-grow flex items-end gap-2" id="filter-search-profile-form-select">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 flex-grow">
                                <div class="">
                                    <label class="block mb-1 text-xs font-semibold text-gray-900">@lang('user.search_profile.dist')</label>
                                    <select name="search_district_id" id="search_district_id" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                                        <option value="" {{ $viewData['preference_search_district'] ?: 'selected' }}>All</option>
                                        @foreach ($viewData['districts'] as $district)
                                        <option value="{{ $district->district_id }}" {{ $viewData['preference_search_district'] ? ($viewData['preference_search_district'] == $district->district_id ? 'selected' : '') : '' }}>
                                            {{ $district->districts->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="">
                                    <label class="block mb-1 text-xs font-semibold text-gray-900">@lang('user.search_profile.office')</label>
                                    <select name="search_office_id" id="search_office_id" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                                        <option value="" selected>All</option>
                                        @foreach ($searchProfileTableCom['offices'] as $office)
                                        <option value="{{ $office->office_id }}">{{ $office->office_fin_assam->name ?? 'N/A' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="">
                                    <label class="block mb-1 text-xs font-semibold text-gray-900">Designation</label>
                                    <select name="search_designation_id" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full">
                                        <option value="" selected>All</option>
                                    </select>
                                </div> --}}
                            </div>
                            <button type="submit" title="@lang('user.search_profile.btn_filter')" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-4 py-1.5" id="">
                                <i class="bi bi-filter"></i>
                            </button>
                        </form>
                        <!-- <div class="flex gap-2 items-center text-xs">
                        <p class="text-gray-900 whitespace-nowrap">Sort by:</p>
                        <select name="" class="disabled:bg-gray-100 border-0 bg-gray-50 text-gray-900 text-xs rounded-md focus:ring-0 focus:border-0 block p-1.5 w-full pr-8 font-bold">
                            <option value="1" selected>Relevence</option>
                            <option value="2">Latest</option>
                        </select>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="search-profile-data-div">
            @if (count($viewData['employees_profiles']) != 0)
            <div class="">
                <div class="border rounded-2xl overflow-x-auto bg-white">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left p-4 px-6 font-medium text-xs sm:text-sm text-gray-900 whitespace-nowrap">@lang('user.search_profile.table_col1')</th>
                                <th class="text-left p-4 px-6 font-medium text-xs sm:text-sm text-gray-900 whitespace-nowrap" width="60%">@lang('user.search_profile.table_col2')</th>
                                <th class="text-left p-4 px-6 font-medium text-xs sm:text-sm text-gray-900">@lang('user.search_profile.table_col3')</th>
                                <th class="text-left p-4 px-6 font-medium text-xs sm:text-sm text-gray-900" width="140px"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" id="search-profile-table">
                            @foreach ($viewData['employees_profiles'] as $employee_profile)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    <div class="flex items-center">
                                        <img src="{{ Storage::url($employee_profile->documents[0]->documet_location ?? 'N/A') }}" class="h-8 w-8 rounded-full bg-gray-200 mr-4 object-cover flex-shrink-0 object-top">
                                        <div>
                                            <p class="font-semibold whitespace-nowrap">
                                                {{ $employee_profile->full_name }}
                                            </p>
                                            <p class="text-gray-900 text-xs whitespace-nowrap">
                                                {{ $employee_profile->employment_details->post_names->name ?? 'N/A' }}
                                            </p>
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
                                        <button type="button" data-target-employee-name="{{$employee_profile->full_name ?? ''}}" value="{{ Crypt::encryptString($employee_profile->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1.5 rounded-md text-xs directRequest profile-request-btn" title="@lang('user.search_profile.send_request.heading')">
                                            <i class="bi bi-check sm:hidden"></i> <span class="hidden sm:block">@lang('user.search_profile.send_request.heading')</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="flex flex-col items-center justify-center table_nfDiv">
                <img src="{{ asset('/images/nfd.png') }}" alt="" class="w-36 object-center mb-2">
                <p class="text-gray-500 font-bold text-lg text-center">@lang('user.search_profile.nfd.heading')</p>
                <p class="text-gray-500 text-sm text-center">@lang('user.search_profile.nfd.txt')</p>
            </div>
            @endif
        </div>
    </div>
</div>
{{-- @else
<h1>There is a problem in Search Profile Component </h1>
@endif --}}
