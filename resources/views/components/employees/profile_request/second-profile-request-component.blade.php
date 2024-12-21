<div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]" id="directRequestModal">
    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
        <div class="space-y-2 mb-6">
            <p class="text-3xl font-semibold">New Request</p>
        </div>
        <form action="" method="">
            <div class="grid gap-8">
                {{-- <div class="">
                    <div class="flex gap-3">
                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                        <p class="text-xs text-gray-500">
                            I have read and understood the
                            <a href="../../assets/docs/sop.pdf" target="_blank" class="text-sky-600 underline">Standard Operating Procedure (SOP)</a>.
                        </p>
                    </div>
                </div> --}}
                {{-- <div class="">
                    <div class="flex gap-3">
                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                        <p class="text-xs text-gray-500">Submitting this request confirms my acceptance of any potential changes to my post, including a lower designation.</p>
                    </div>
                </div> --}}
                <div class="flex gap-1 justify-end">
                    <button type="button" class="bg-white hover:bg-gray-200 border border-transparent text-gray-600 hover:text-black rounded-md block px-4 py-1.5 transition-all duration-300" id="closeDirectRequestModalButton">Close</button>
                    <button type="submit" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Request</button>
                </div>
            </div>
        </form>
    </div>
</div>
