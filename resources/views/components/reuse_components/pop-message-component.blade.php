<!-- Messages -->
<div class="fixed z-[99] w-full h-screen top-0 left-0 flex items-center justify-center bg-black/30 main-pop-card-div" style="margin: 0!important;">
    <!-- success -->

    <div class="{{ $viewData['success'] ?? '' }} pop-card-div max-w-xs w-full bg-white rounded-2xl p-6 py-10">
        <div class="flex flex-col items-center justify-center gap-6">
            <i class="bi bi-check-circle text-green-600 text-7xl"></i>
            <div class="space-y-2 mb-6">
                <p class="text-3xl text-center font-semibold">Success!</p>
                <p class="text-gray-900 text-center text-xs pop-text">{{ $viewData['message'] }}.</p>
            </div>
            <a href="#"
                class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-4 py-1.5 w-fit">Continue</a>
        </div>
    </div>
    <!-- error -->
    <div class="{{ $viewData['error'] ?? '' }} pop-card-div max-w-xs w-full bg-white rounded-2xl p-6 py-10">
        <div class="flex flex-col items-center justify-center gap-6">
            <i class="bi bi-x-circle text-red-600 text-7xl"></i>
            <div class="space-y-2 mb-6">
                <p class="text-3xl text-center font-semibold">Error!</p>
                <p class="text-gray-900 text-center text-xs pop-text">{{ $viewData['message'] }}.</p>
            </div>
            @if (isset($viewData['action']) ? $viewData['action']== 'redirect' :'')
                <a href="{{ $viewData['url'] ?? '' }}"
                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-4 py-1.5 w-fit">OK</a>
            @else
                <button id="pop-close-btn"
                    class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-4 py-1.5 w-fit">Try
                    again!</button>
            @endif
        </div>
    </div>
</div>
