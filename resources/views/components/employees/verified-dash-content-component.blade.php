<!-- After verification completed and NOC generated -->
@php
    if ($viewData->profile_verify_status == 1 && $viewData->noc_generate == 1) {
        $is_noc_generated = true;
    } else {
        $is_noc_generated = false;
    }
@endphp
<div class="">
    <div class="">
        @if ($is_noc_generated)
            <!--<a href="{{ route('search.profile', ['lang' => app()->getLocale()]) }}" type="button"
                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit"
                id="createRequest"><i class="bi bi-plus"> </i>New transfer request</a></a>-->
        @else
            @lang('user.profile_alter_text.noc_status.0.body')
        @endif
    </div>
    <div class="grid gap-24 mt-12">
        <div class="grid gap-6">
            <div class="flex items-bottom justify-between">
                <p class="text-xl font-medium">@lang('user.dashboard.my_request.heading')</p>
                <!-- <a href="./search-profiles.html" class="hover:underline text-gray-900 text-xs">View all <i class="bi bi-arrow-up-right"></i></a> -->
            </div>
            @if ($transferData)
                <div class="grid gap-6">
                    <div
                        class="bg-neutral-100 rounded-2xl relative text-xs flex flex-col border border-b-4 border-r-4 border-gray-400">
                        <!-- if request is active -->
                        @if ($transferData->final_approval == 0)
                            <span
                                class="absolute py-1 px-4 -top-3 left-6 text-xs bg-black text-white rounded-full">@lang('user.dashboard.my_request.card.status')</span>
                        @endif
                        {{-- {{dd($transferData)}} --}}
                        <div class="grid gap-2 p-6">
                            <div class="flex justify-between gap-4 mb-3">
                                <div class="w-full">
                                    <div class="flex justify-between gap-4">
                                        <p class="text-lg sm:text-xl font-semibold">@lang('user.dashboard.my_request.card.heading')</p>
                                        @if ($transferData->request_status == 1 && $transferData->final_approval != 1)
                                            <a href="/employees/download-join-transfer/{{ Crypt::encryptString($transferData->id) }}"
                                                target="__blank" style="" title="@lang('user.dashboard.my_request.card.btn_appDown')"
                                                class="text-sky-600"><i class="bi bi-file-earmark-pdf text-xl"> </i>
                                                <span class="text-xs hidden sm:block">@lang('user.dashboard.my_request.card.btn_appDown')</span></a>
                                        @endif
                                    </div>
                                    @php
                                        $final_status = ['pending', 'accepted', 'rejected', 'N/A'];
                                    @endphp
                                    <p class="text-gray-900 mt-3 italic">Request status
                                        {{ $final_status[$transferData->final_approval ?? 3] }}
                                        @if ($transferData->final_approval != 0)
                                            by approver
                                            {{ $transferData->appointing_authorities->name ?? 'N/A' }},
                                            {{ $transferData->appointing_authorities->designation ?? 'N/A' }}
                                        @endif
                                </div>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4 sm:gap-12">
                                <div class="grid gap-2">
                                    <div class="flex gap-2 font-medium"><i class="bi bi-person"></i>
                                        <p class="">
                                            {{ $viewData->id == $transferData->target_employee_id ? $transferData->transfer_employee_user->full_name ?? 'N/A' : $transferData->transfer_employee_target_user->full_name ?? 'N/A' }},
                                            {{ $viewData->id == $transferData->target_employee_id ? $transferData->transfer_employee_user->employment_details->post_names->name ?? 'N/A' : $transferData->transfer_employee_target_user->employment_details->post_names->name ?? 'N/A' }},
                                        </p>
                                    </div>
                                    <div class="flex gap-2 font-medium"><i class="bi bi-geo-alt"></i>
                                        <p class="">
                                            {{ $viewData->id == $transferData->target_employee_id ? $transferData->transfer_employee_user->employment_details->offices_finassam->name ?? 'N/A' : $transferData->transfer_employee_target_user->employment_details->offices_finassam->name ?? 'N/A' }},
                                            {{ $viewData->id == $transferData->target_employee_id ? $transferData->transfer_employee_user->employment_details->departments->name ?? 'N/A' : $transferData->transfer_employee_target_user->employment_details->departments->name ?? 'N/A' }},
                                            {{ $viewData->id == $transferData->target_employee_id ? $transferData->transfer_employee_user->employment_details->districts->name ?? 'N/A' : $transferData->transfer_employee_target_user->employment_details->districts->name ?? 'N/A' }},
                                        </p>
                                    </div>
                                    <div class="flex gap-2 font-medium"><i class="bi bi-telephone"></i>
                                        <p class="">
                                            {{ $viewData->id == $transferData->target_employee_id ? $transferData->transfer_employee_user->phone ?? 'N/A' : $transferData->transfer_employee_target_user->phone ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                {{-- Approver remarks --}}
                                <div class="grid gap-2">
                                    @if ($transferData->final_approval != 0)
                                        <div class="flex gap-2 font-medium"><i class="bi bi-person-check"></i>
                                            <p class="">
                                                {{ isset($transferData->appointing_authorities->designation) ? $transferData->appointing_authorities->designation : '' }}{{ isset($transferData->appointing_authorities->departments->name) ? ',' . $transferData->appointing_authorities->departments->name : '' }}{{ isset($transferData->appointing_authorities->districts->name) ? ',' . $transferData->appointing_authorities->districts->name : '' }}
                                            </p>
                                        </div>
                                        <div class="flex gap-2 font-medium"><i class="bi bi-chat"></i>
                                            <p class="">{{ $transferData->approver_remarks ?? 'N/A' }}</p>
                                        </div>
                                        <div class="flex gap-2 font-medium"><i class="bi bi-clock"></i>
                                            @php
                                                $final_approval_updated = new DateTime($transferData->updated_at);
                                            @endphp
                                            <p class="">{{ $final_approval_updated->format('F,j Y') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="border-t mt-auto">
                            <div class="px-6 py-3 flex gap-4 items-center justify-between">
                                <div class="flex gap-2 text-gray-900"><i class="bi bi-clock"></i>
                                    @php
                                        $request_time = new DateTime($transferData->created_at);
                                    @endphp
                                    <p class="">{{ $request_time->format('F,j Y') }}</p>
                                </div>
                                <div class="flex gap-1">
                                    @if ($transferData->final_approval == 1 && $transferData->jto_generate_status == 1)
                                        `
                                        <a href="/jto-certificate/{{ Crypt::encryptString($transferData->id) }}"
                                            target="__blank"
                                            class="bg-sky-600 hover:bg-sky-700 rounded-md flex gap-1 px-2 py-1.5 w-fit text-white text-xs"
                                            title="@lang('user.dashboard.my_request.button.order')"><i class="bi bi-download"> </i> <span
                                                class="hidden sm:block"> @lang('user.dashboard.my_request.button.order')</span></a>
                                    @endif
                                    @if ($transferData->final_approval == 2)
                                        <div class="bg-red-100 p-1 px-2 text-red-600 rounded">
                                            @lang('user.dashboard.my_request.status.rej_aa')
                                        </div>
                                    @elseif ($transferData->final_approval == 1)
                                        <div class="bg-green-100 p-1 px-2 text-green-600 rounded">
                                            @lang('user.dashboard.my_request.status.apr_aa')
                                        </div>
                                    @else
                                        @if ($transferData->request_status == 1)
                                            <div class="bg-green-100 p-1 px-2 text-green-600 rounded">
                                                {{ $viewData->id == $transferData->employee_id ? __('user.dashboard.my_request.status.acc_usr') : '' }}
                                            </div>
                                        @elseif ($transferData->request_status == 2)
                                            <div class="bg-red-100 p-1 px-2 text-red-600 rounded">
                                                {{ $transferData->remarks ? __('user.dashboard.my_request.status.cnl_you') : __('user.dashboard.my_request.status.rej_usr') }}
                                            </div>
                                        @endif
                                        @if ($transferData->request_status == 0)
                                            <button type="button" id="request-cancel-by-user"
                                                value={{ Crypt::encryptString($transferData->id) }}
                                                class="disabled:cursor-not-allowed disabled:hover:bg-red-700 bg-red-600 border border-transparent text-white rounded-md block px-3 py-1 w-fit"><i
                                                    class="bi bi-ban"></i> @lang('user.dashboard.my_request.button.cancel')</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="h-24 col-span-2 flex items-center justify-center mb-6">
                    <p class="text-gray-600">@lang('user.dashboard.my_request.no_req_act')
                        @if ($is_noc_generated)
                            <a href="{{ route('search.profile', ['lang' => app()->getLocale()]) }}"
                                class="underline text-sky-600"> @lang('user.dashboard.my_request.req_now')</a>
                        @else
                            @lang('user.profile_alter_text.noc_status.0.body')
                    </p>
            @endif
        </div>
        @endif
    </div>
    {{-- ------------- incomming request table -------------- --}}
</div>
</div>
<!-- After verification completed and NOC generated end -->
