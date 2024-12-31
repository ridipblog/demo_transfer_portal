<div class="row-span-2">
    <div class="bg-sky-100 rounded-3xl p-12">
        <div class="grid gap-6 items-start">
            <div class="flex gap-12 justify-between">
                <div class="space-y-2">
                    @if (isset($profileData->documents[0]))
                        {{-- {{dd($profileData->documents[0])}} --}}
                        <img src="{{ Storage::url($profileData->documents[0]->documet_location) }}" alt=""
                            class="h-32 w-32 rounded-full object-cover object-center">
                    @else
                        <img src="{{ asset('images/profile.jpg') }}" alt=""
                            class="h-32 w-32 rounded-full object-cover object-center">
                    @endif
                </div>
            </div>
            <div class="grid gap-6 flex-grow">
                <div class="flex gap-12 justify-between">
                    <div class="">
                        <p class="font-bold text-xl">{{ $viewData->full_name }}</p>
                        <p class="text-sm">{{ $viewData->employment_details->post_names->name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="">
                    @php
                        $profile_status = [
                            '0' => [
                                'bg' => 'bg-gray-400',
                                'text' => 'text-gray-600',
                                'icon' => 'bi bi-exclamation-circle',
                            ],
                            '1' => [
                                'bg' => 'bg-green-600',
                                'text' => 'text-green-600',
                                'icon' => 'bi bi-check-circle',
                            ],
                            '2' => [
                                'bg' => 'bg-red-400',
                                'text' => 'text-red-600',
                                'icon' => 'bi bi-x-circle',
                            ],
                        ];
                    @endphp
                    {{-- @if ($viewData->profile_verify_status == 1 && $viewData->noc_generate != 0)
                        <div
                            class="bg-{{ $viewData->noc_generate != 1 ? 'red' : 'green' }}-300 text-{{ $viewData->noc_generate != 1 ? 'red' : 'green' }}-600 border border-transparent text-xs rounded block px-2 py-1 font-semibold mb-2 w-fit">
                            {!! $viewData->noc_generate != 1 ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>' !!}
                            {{ $viewData->noc_generate != 1 ? __('user.profile_status.status.not_recc') : __('user.profile_status.status.recc') }}
                        </div>
                    @else
                        <div
                            class="bg-{{ $viewData->profile_verify_status != 1 ? 'yellow' : 'green' }}-300 text-{{ $viewData->profile_verify_status != 1 ? 'yellow' : 'green' }}-600 border border-transparent text-xs rounded block px-2 py-1 font-semibold mb-2 w-fit">
                            {!! $viewData->profile_verify_status != 1 ? '<i class="bi bi-clock"></i>' : '<i class="bi bi-check-circle"></i>' !!}
                            {{ $viewData->profile_verify_status != 1 ? __('user.profile_status.status.pending') : __('user.profile_status.status.verified') }}
                        </div>
                    @endif --}}

                    <div
                        class="bg-{{ $viewData->profile_verify_status != 1 ? 'yellow' : 'green' }}-300 text-{{ $viewData->profile_verify_status != 1 ? 'yellow' : 'green' }}-600 border border-transparent text-xs rounded block px-2 py-1 font-semibold mb-2 w-fit">
                        {!! $viewData->profile_verify_status != 1 ? '<i class="bi bi-clock"></i>' : '<i class="bi bi-check-circle"></i>' !!}
                        {{ $viewData->profile_verify_status != 1 ? __('user.profile_status.status.pending') : __('user.profile_status.status.verified') }}
                    </div>

                </div>

                <div class="grid gap-0">
                    <div class="flex flex-col gap-0">
                        <div class="flex gap-2 items-center text-sm text-green-600"><i class="bi bi-check-circle"></i>
                            @lang('user.profile_status.steps.1')</div>
                        <div class="h-6 w-0.5 ml-1.5 bg-green-600"></div>
                    </div>
                    {{-- <div class="flex flex-col gap-0">
                        <div
                            class="flex gap-2 items-center text-sm {{ $viewData->profile_verify_status == 3 ? 'text-gray-400' : 'text-green-600' }}">
                            <i class="bi bi-check-circle"></i> @lang('user.profile_status.steps.2')
                        </div>
                        <div
                            class="h-6 w-0.5 ml-1.5 {{ $viewData->profile_verify_status == 3 ? 'bg-gray-300' : 'bg-green-600' }}">
                        </div>
                    </div> --}}
                    <div class="flex flex-col gap-0">
                        {{-- <div
                            class="flex gap-2 items-center text-sm {{ in_array($viewData->profile_verify_status, [0, 3]) ? 'text-gray-400' : ($viewData->profile_verify_status == 2 ? 'text-red-600' : 'text-green-600') }}">
                            <i
                                class="{{ in_array($viewData->profile_verify_status, [0, 3]) ? 'bi bi-exclamation-circle' : ($viewData->profile_verify_status == 2 ? 'bi bi-x-circle' : 'bi bi-check-circle') }}"></i>
                            @lang('user.profile_status.steps.3')
                        </div>
                        <div
                            class="h-6 w-0.5 ml-1.5 {{ in_array($viewData->profile_verify_status, [0, 3]) ? 'bg-gray-300' : ($viewData->profile_verify_status == 2 ? 'bg-red-600' : 'bg-green-600') }} ">
                        </div> --}}
                        <div
                            class="flex gap-2 items-center text-sm {{ $profile_status[$viewData->profile_verify_status]['text'] }}">
                            <i class="{{ $profile_status[$viewData->profile_verify_status]['icon'] }}"></i>
                            @lang('user.profile_status.steps.3')
                        </div>
                        <div class="h-6 w-0.5 ml-1.5 {{ $profile_status[$viewData->profile_verify_status]['bg'] }} ">
                        </div>
                    </div>
                    {{-- <div class="flex flex-col gap-0">
                        <div
                            class="flex gap-2 items-center text-sm {{ $profile_status[$viewData->noc_generate]['text'] }} ">
                            <i class="{{ $profile_status[$viewData->noc_generate]['icon'] }}"></i>
                            @lang('user.profile_status.steps.4') --}}
                    {{-- ({{ $viewData->noc_generate == 1 ? 'Recommended' : 'Pending' }} ) --}}
                    {{-- </div> --}}
                    {{-- <div class="h-6 w-0.5 ml-1.5 {{ $profile_status[$viewData->noc_generate]['bg'] }} ">
                        </div> --}}
                    {{-- <div class="h-6 w-0.5 ml-1.5 {{$viewData->noc_generate==1 ? 'bg-green-600' :'bg-gray-300'}}"></div> --}}
                    {{-- @if ($viewData->noc_generate == 1)
                        <a href="{{ route('download.noc.user') }}" target="__blank"
                            class="mt-2 bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit"
                            id="createRequest"><i class="bi bi-file-earmark-pdf"></i></a>
                        @endif --}}
                    {{-- </div> --}}

                    {{-- <div class="flex flex-col gap-0">
                        <div
                            class="flex gap-2 items-center text-sm {{ isset($transferData) ? $profile_status[$transferData['2nd_recommend']]['text'] : $profile_status[0]['text'] }}">
                            <i
                                class="{{ isset($transferData) ? $profile_status[$transferData['2nd_recommend']]['icon'] : $profile_status[0]['icon'] }}"></i>
                            Recommended (By Department HOD)
                        </div>
                        <div
                            class="h-6 w-0.5 ml-1.5 {{ isset($transferData) ? $profile_status[$transferData['2nd_recommend']]['bg'] : $profile_status[0]['bg'] }}">
                        </div>
                    </div> --}}
                    <div class="flex flex-col gap-0">
                        <div
                            class="flex gap-2 items-center text-sm {{ isset($transferData) ? $profile_status[$transferData['final_approval']]['text'] : $profile_status[0]['text'] }}">
                            <i
                                class="{{ isset($transferData) ? $profile_status[$transferData['final_approval']]['icon'] : $profile_status[0]['icon'] }}"></i>
                            Transfer Approved
                        </div>
                        <div
                            class="h-6 w-0.5 ml-1.5 {{ isset($transferData) ? $profile_status[$transferData['final_approval']]['bg'] : $profile_status[0]['bg'] }}">
                        </div>
                    </div>
                    <div class="flex flex-col gap-0">
                        <div
                            class="flex gap-2 items-center text-sm {{ isset($transferData) ? $profile_status[$transferData['jto_generate_status']]['text'] : $profile_status[0]['text'] }}">
                            <i
                                class="{{ isset($transferData) ? $profile_status[$transferData['jto_generate_status']]['icon'] : $profile_status[0]['icon'] }}"></i>
                            Transfer Order
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!$isRequestDone)
        <div class="mt-12">
            <div
                class="{{ $viewData->profile_verify_status != 1 || $viewData->noc_generate != 1 ? 'hidden' : '' }} grid">
                <a href="{{ route('search.profile', ['lang' => app()->getLocale(), 'preference_search_district' => null]) }}"
                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit"
                    id="createRequest"><i class="bi bi-plus"> </i>@lang('user.profile_status.button.request')</a>
            </div>
        </div>
    @endif
</div>
