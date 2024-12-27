<div
    class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-3 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-6 sm:p-8 lg:p-10">
    <div class="sm:col-span-2 md:col-span-3">
        <p class="text-lg sm:text-xl md:text-2xl font-bold text-sky-700">@lang('user.form.rej_info.heading')</p>
    </div>
    {{-- <div>
        <label class="block mb-1 text-xs sm:text-sm md:text-base font-semibold text-gray-400">@lang('user.form.rej_info.main_com')</label>
        <p class="font-semibold truncate text-sm md:text-base">
            {{ $rejectedData->commnents ?? null }}
        </p>
    </div> --}}

    <div class="sm:col-span-2 md:col-span-3 space-y-3">
        <p class="text-sm font-semibold text-red-500">DOCUMENT REJECTED!</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach ($rejectedData->authority_rejections ?? [] as $info)
                <div class="h-full flex items-top justify- border border-2 rounded-xl px-2 py-3">
                    @php
                        $name = isset($info->document_type)
                            ? (in_array($info->document_type, [1, 2, 3, 4])
                                ? __("user.form.docs.$info->document_type")
                                : 'Additional Document')
                            : 'Additional Document';
                    @endphp
                    <div class="flex items-top justify-center">
                        <p
                            class="block bg-sky-500 text-white text-xs h-5 w-5 flex items-center justify-center rounded-full">
                            {{ $loop->iteration }}</p>
                    </div>

                    <div class="grow ml-1">
                        <div class="flex items-center">
                            <p class="text-sm font-semibold">{{ Str::upper(str_replace('_', ' ', $name)) }}</p>
                            @if ($info->document_location)
                                <a class="ms-auto hover:underline hover:underline-sky-600 hover:text-sky-600 text-gray-900 text-xs"
                                    target="_blank" href="{{ Storage::url($info->document_location ?? 'N/A') }}">
                                    view document
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                                @else
                                <p class="ms-auto  text-gray-900 text-xs">
                                    No Document Available
                            </p>
                            @endif

                        </div>
                        <p class="text-[0.65rem] font-bold text-gray-400">Remarks:</p>
                        <p class="text-xs font-bold text-gray-600 text-justify">
                            {{ $info->remarks ?? 'No remarks ' }}
                        </p>
                    </div>
                </div>
            @endforeach

            {{-- <div class="h-full flex items-top justify-center border border-2 rounded-xl px-2 py-3">
                <div class="flex items-top justify-center">
                    <p
                        class="block bg-sky-500 text-white text-xs h-5 w-5 flex items-center justify-center rounded-full">
                        3</p>
                </div>
                <div class="ml-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold">Document Name 3</p>
                        <a class="hover:underline hover:underline-sky-600 hover:text-sky-600 text-gray-900 text-xs"
                            target="_blank" href="#">
                            view document
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                    <p class="text-[0.65rem] font-bold text-gray-400">Remarks:</p>
                    <p class="text-xs font-bold text-gray-600 text-justify">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                        Expedita provident consectetur perspiciatis quidem commodi a sit odit impedit odio iste ad
                        recusandae laboriosam,
                        reprehenderit adipisci totam nobis vitae rem dignissimos!
                    </p>
                </div>
            </div> --}}
        </div>
        <p class="text-sm font-semibold text-red-500">ADDITIONAL REMARKS</p>
        <div class="grid grid-cols-2 gap-2">
            <div class="col-span-2 h-full">
                <p class="text-sm">
                    {{ $rejectedData->commnents ?? null }}
                </p>
            </div>
        </div>

        {{-- <div class="grid grid-cols-2 gap-2">
            <div class="col-span-2 h-full">
                <p class="text-sm">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor autem iste,
                    corrupti dignissimos numquam sed doloremque ipsa sint in excepturi,
                    beatae est ea ab. Minus quisquam ducimus a labore quaerat?
                </p>
            </div>
            <div class="h-full">
                <div class="border border-2 rounded-md py-1 px-1.5">
                    <div class="flex items-center">
                        <p class="text-xs font-bold text-gray-400">Document for</p>
                        <a class="ms-auto hover:underline hover:underline-sky-600 hover:text-sky-600 text-gray-900 text-xs"
                            target="_blank" href="#">
                            view document
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>

                    <p class="text-sm">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit neque aut reiciendis
                        aliquam ipsa.
                    </p>
                </div>
            </div>

        </div> --}}
    </div>

    {{-- @foreach ($rejectedData->authority_rejections ?? [] as $info)
        <div class="border rounded-xl bg-neutral-600 p-2 sm:p-4 mb-4">
            <p class="p-1 m-0 border border-blue-100 text-white font-semibold text-xs sm:text-sm truncate">
                {{ $info->remarks ?? null }}
            </p>

            @if ($info->document_location)
                @php
                    $name = isset($info->document_type) ?($info->document_type==0 ? 'Additional Document' :__("user.form.docs.$info->document_type")):null;
                @endphp

                <div class="h-44 p-2 pt-0">
                    <img src="{{ Storage::url($info->document_location ?? 'N/A') }}" alt=""
                        class="w-full h-full object-contain object-center">
                </div>
                <div class="text-white text-center p-2 text-xs sm:text-sm">
                    {{ Str::upper(str_replace('_', ' ', $name)) }}
                </div>
            @else
                <!-- When there is no document, make the comment section full width and center the text -->
                <div class="sm:col-span-2 md:col-span-3 text-center">
                    <p class="text-sm md:text-base font-semibold text-gray-300">No Document Available</p>
                </div>
            @endif
        </div>
    @endforeach --}}
</div>
