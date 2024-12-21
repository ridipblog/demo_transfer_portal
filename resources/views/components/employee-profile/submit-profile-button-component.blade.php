
@if (!$submitButton['is_error'])

    <div class="grid gap-4">
        @if (!$submitButton['is_update'])
            @if (!$submitButton['is_final'])
                <div class="flex gap-3">
                    <input type="checkbox"
                        class="declaration-checkbox border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                        required>
                    <p class="text-xs text-gray-900">
                        @lang('user.form.submit.decl_1')
                    </p>
                </div>
                <div class="flex gap-3">
                    <input type="checkbox"
                        class="declaration-checkbox border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5"
                        required>
                    <p class="text-xs text-gray-900">
                        @lang('user.form.submit.decl_2')
                        <a href="{{asset('/docs/sop_new.pdf')}}" target="_blank" class="text-sky-600 underline">@lang('user.form.submit.decl_2_link')</a>.
                    </p>
                </div>
                <div class="flex justify-end" style="gap: 10px">
                    <!-- <a href="./otp.html" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5">Preview & Submit</a> -->
                    <button type="button"
                        class="disabled:bg-sky-500 disabled:opacity-60 bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5 submit-profile-btn"

                        id="save_profile">@lang('user.form.submit.button.save')</button>
                    <button type="button" disabled
                        class="disabled:bg-sky-500 disabled:opacity-60 bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5 submit-profile-btn final_complete_btn"
                        id="prevModalBtn">@lang('user.form.submit.button.submit')</button>
                </div>
            @endif
        @else
            <div class="flex justify-end" style="gap: 10px">
                <button type="button"
                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-full block px-4 py-1.5"
                    id="update-profile-btn">@lang('user.form.submit.button.update')</button>
            </div>
        @endif
    </div>
@else
    <h1>{{ $submitButton['error_message'] }}</h1>
@endif
