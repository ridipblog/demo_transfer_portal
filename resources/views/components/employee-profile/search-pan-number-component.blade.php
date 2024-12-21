@if (!$panComponent['is_update'])
    @if (!$panComponent['is_final'])
        <form action="{{ route('update.profile',['lang'=>app()->getLocale()]) }}" method="GET">
            <div class="grid gap-6">
                <div class="grid lg:grid-cols-3 gap-4 lg:gap-8 rounded-2xl p-10">
                    {{-- <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">Find Profile</p>
                        </div> --}}
                    <div class=""></div>
                    <div>
                        <label class="block mb-1 text-xs md:text-sm font-bold reqd text-gray-800">@lang('user.search_pan.pan_no')</label>
                        <input type="text" name="request_pan_number" value="{{ $viewData['search_pan_number'] }}"
                            value="{{ isset($viewData['request_pan_number']) ? $viewData['request_pan_number'] : '' }}"
                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full uppercase">
                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-3 py-1.5">@lang('user.search_pan.button')</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
@endif
