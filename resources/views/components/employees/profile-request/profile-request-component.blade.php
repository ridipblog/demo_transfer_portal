<div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]" id="directRequestModal">
    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
        <div class="space-y-2 mb-6">
            <p class="text-3xl font-semibold text-center">@lang('user.search_profile.send_request.heading')</p>
        </div>
        <form id="request-profile-form">
            <div class="grid gap-2 text-center">
                <p class="transfer-request-error text-red-500 w-full text-center"></p>
                <div class="">
                    <p class="text-xs md:text-base text-gray-500">@lang('user.search_profile.send_request.p_1') <span class="font-semibold" id="employee-name">[target employee]</span></p>
                </div>
                <div class="">
                    <p class="text-xs md:text-base text-gray-500">@lang('user.search_profile.send_request.p_2')</p>
                </div>
                <div class="flex gap-1 justify-center mt-4">
                    <button type="button" class="text-xs md:text-base bg-white hover:bg-gray-200 border border-transparent text-gray-600 hover:text-black rounded-md block px-4 py-1.5 transition-all duration-300" id="closeDirectRequestModalButton">@lang('user.search_profile.send_request.btn_close')</button>
                    <button type="submit" id="request-profile-form-btn" class="text-xs md:text-base bg-green-500 hover:bg-green-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">@lang('user.search_profile.send_request.btn_accept')</button>
                </div>
            </div>
        </form>
    </div>
</div>
