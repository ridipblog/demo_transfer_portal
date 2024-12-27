@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')

    <div class="sm:col-span-2 md:col-span-3 space-y-3">
        <p class="text-sm font-semibold text-red-500">DOCUMENT REJECTED!</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach ($data2 as $info)
                <div class="h-full flex items-top justify- border border-2 rounded-xl px-2 py-3">
                    @php
                        $name = isset($info->document_type)
                            ? (in_array($info->document_type, [1, 2, 3, 4])
                                ? __("user.form.docs.$info->document_type")
                                : 'Additional Document')
                            : 'Additional Document';
                    @endphp
                    <div class="flex items-top justify-center">
                        <p class="block bg-sky-500 text-white text-xs h-5 w-5 flex items-center justify-center rounded-full">
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

@endsection
{{-- --------------------- dynamic js link ------------------ --}}
@section('extra_js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- <script type="module" src="{{ asset('js/verification/login.js') }}"></script> --}}

    @if (session('flash_message'))
        <script>
            $(document).ready(function() {
                var count = {{ session('flash_message') }};
                var message = "{{ session('message') }}";
                console.log(message)
                if (count == 1) {
                    showSuccessPopup(message);
                }
                if (count == 2) {
                    console.log('error')
                    showErrorPopup(message);
                }
                setTimeout(function() {
                    hidePopup()
                }, 1550);
            });
        </script>
    @endif

@endsection

</body>

</html>
