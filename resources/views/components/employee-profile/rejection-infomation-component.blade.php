<div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-6 sm:p-8 lg:p-10">
    <div class="sm:col-span-2 md:col-span-3">
        <p class="text-lg sm:text-xl md:text-2xl font-bold text-sky-700">@lang('user.form.rej_info.heading')</p>
    </div>
    <div>
        <label class="block mb-1 text-xs sm:text-sm md:text-base font-semibold text-gray-400">@lang('user.form.rej_info.main_com')</label>
        <p class="font-semibold truncate text-sm md:text-base">
            {{ $rejectedData->commnents ?? null }}
        </p>
    </div>

    @foreach ($rejectedData->authority_rejections ?? [] as $info)
        <div class="border rounded-xl bg-neutral-600 p-2 sm:p-4 mb-4">
            <p class="p-1 m-0 border border-blue-100 text-white font-semibold text-xs sm:text-sm truncate">
                {{ $info->remarks ?? null }}
            </p>

            @if ($info->document_location)
                @php
                    $docKey = $info->document_type ?? null;
                    $name = __("user.form.docs.$docKey");
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
    @endforeach
</div>
