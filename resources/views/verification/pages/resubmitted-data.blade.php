@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="space-y-6">
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $base_data)
                    <div class="">
                        <div class="flex items-center px-2">
                            <p class="text-red-500 font-semibold">Not Certify Profile {{ $i }}<sup>nd</sup></p>
                            <p class="text-gray-500 ml-auto text-xs">
                                {{ \Carbon\Carbon::parse($base_data->created_at)->format('d-m-Y || h:i A') }}
                            </p>
                        </div>
                        {{-- Loop through the documents in $data2 --}}
                        {{-- {{ dd($info['document_location']) }} --}}
                        <div
                            class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-3 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-6 sm:p-8 lg:p-10">
                            <div class="sm:col-span-2 md:col-span-3">
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-sky-700">@lang('user.form.rej_info.heading')</p>
                            </div>
                            <div class="sm:col-span-2 md:col-span-3 space-y-3">
                                <p class="text-sm font-semibold text-red-500">DOCUMENT REJECTED!</p>
                                {{-- @foreach ($data2 as $info)
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="h-full flex items-top justify- border border-2 rounded-xl px-2 py-3">
                                            @php
                                                $doc_type = $info['document_type'];
                                                $name = isset($info['document_type'])
                                                    ? (in_array($info['document_type'], [1, 2, 3, 4])
                                                        ? __("user.form.docs.$doc_type")
                                                        : 'Additional Document')
                                                    : 'Additional Document';
                                            @endphp

                                            <div class="flex items-top justify-center">
                                                <p
                                                    class="block bg-sky-500 text-white text-xs h-5 w-5 flex items-center justify-center rounded-full">
                                                    {{ $loop->iteration }}
                                                </p>
                                            </div>
                                            <div class="grow ml-1">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-semibold">
                                                        {{ Str::upper(str_replace('_', ' ', $name)) }}
                                                    </p>
                                                    @if ($info['document_location'])
                                                        <a class="ms-auto hover:underline hover:underline-sky-600 hover:text-sky-600 text-gray-900 text-xs"
                                                            target="_blank"
                                                            href="{{ Storage::url($info['document_location'] ?? 'N/A') }}">
                                                            view document
                                                            <i class="bi bi-arrow-up-right"></i>
                                                        </a>
                                                    @else
                                                        <p class="ms-auto text-gray-900 text-xs">
                                                            No Document Available
                                                        </p>
                                                    @endif
                                                </div>
                                                <p class="text-[0.65rem] font-bold text-gray-400">Remarks:</p>
                                                <p class="text-xs font-bold text-gray-600 text-justify">
                                                    {{ $info['remarks'] ?? 'No remarks' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($base_data->commnents != null)
                                        <p class="text-sm font-semibold text-red-500">ADDITIONAL REMARKS</p>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="col-span-2 h-full">
                                                <p class="text-sm">
                                                    {{ $base_data->commnents ?? null }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach --}}
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($data2 as $info)
                                        @if ($info['rejection_id'] == $base_data->id)
                                            @continue;
                                        @endif
                                        <div class="h-full flex items-top justify- border border-2 rounded-xl px-2 py-3">
                                            @php
                                                $doc_type = $info['document_type'];
                                                $name = isset($info['document_type'])
                                                    ? (in_array($info['document_type'], [1, 2, 3, 4])
                                                        ? __("user.form.docs.$doc_type")
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
                                                    <p class="text-sm font-semibold">
                                                        {{ Str::upper(str_replace('_', ' ', $name)) }}
                                                    </p>
                                                    @if ($info['document_location'])
                                                        <a class="ms-auto hover:underline hover:underline-sky-600 hover:text-sky-600 text-gray-900 text-xs"
                                                            target="_blank"
                                                            href="{{ Storage::url($info['document_location'] ?? 'N/A') }}">
                                                            view document
                                                            <i class="bi bi-arrow-up-right"></i>
                                                        </a>
                                                    @else
                                                        <p class="ms-auto text-gray-900 text-xs">
                                                            No Document Available
                                                        </p>
                                                    @endif
                                                </div>
                                                <p class="text-[0.65rem] font-bold text-gray-400">Remarks:</p>
                                                <p class="text-xs font-bold text-gray-600 text-justify">
                                                    {{ $info['remarks'] ?? 'No remarks' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($base_data->commnents != null)
                                    <p class="text-sm font-semibold text-red-500">ADDITIONAL REMARKS</p>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="col-span-2 h-full">
                                            <p class="text-sm">
                                                {{ $base_data->commnents ?? null }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <hr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>
        </div>
    </div>



    {{-- <div class="">
        <div class="flex items-center px-2">
            <p class="text-red-500 font-semibold">Not Certify Profile 2<sup>st</sup></p>
            <p class="text-gray-500 ml-auto text-xs">DD-MM-YYYY || 00:00 A.M.</p>
        </div>
        <div
            class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-3 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-6 sm:p-8 lg:p-10">
            <div class="sm:col-span-2 md:col-span-3">
                <p class="text-lg sm:text-xl md:text-2xl font-bold text-sky-700">@lang('user.form.rej_info.heading')</p>
            </div>
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
                                <p
                                    class="block bg-sky-500 text-white text-xs h-5 w-5 flex items-center justify-center rounded-full">
                                    {{ $loop->iteration }}</p>
                            </div>
                            <div class="grow ml-1">
                                <div class="flex items-center">
                                    <p class="text-sm font-semibold">
                                        {{ Str::upper(str_replace('_', ' ', $name)) }}
                                    </p>
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
                </div>
                @if ($data != null)
                    <p class="text-sm font-semibold text-red-500">ADDITIONAL REMARKS</p>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="col-span-2 h-full">
                            <p class="text-sm">
                                {{ $data->commnents ?? null }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div> --}}



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
