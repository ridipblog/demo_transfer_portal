@php
    $update_data = isset($viewData['documents']) ? true : false;
@endphp
<div class="grid lg:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-5 lg:p-10">
    <div class="lg:col-span-3">
        <p class="text-lg font-semibold text-sky-500">@lang('user.form.docs.heading')</p>
    </div>

    @php
        $document_arr = $viewData['save_data']->documents->pluck('document_type')->toArray();

    @endphp
    @foreach (config('globalVariables.registration_upload_name') ?? [] as $key => $value)
        <div class="flex-col items-center gap-8 {{ $key == 5 ? (isset($viewData['save_data']->additional_info->pending_govt_dues) ? ($viewData['save_data']->additional_info->pending_govt_dues == 'no' ? '' : 'hidden') : 'hidden') : '' }} "
            id="{{ $key == 5 ? 'noDueCertDoc' : '' }}">
            <p class="text-center text-xs mt-4 font-medium">
                @php
                    $docKey = $key; // Assuming $key is zero-based, add 1 to match the doc number.
                    $doc_value = $viewData['save_data']->documents->firstWhere('document_type', $key);

                    $doc_extension = $doc_value
                        ? strtolower(pathinfo($doc_value->documet_location, PATHINFO_EXTENSION))
                        : null;
                @endphp
                {{ Str::upper(str_replace('_', ' ', __("user.form.docs.$docKey"))) }} <span class="text-red">*</span>
            </p>

            <label for="{{ $value }}"
                class="docUploadDiv relative h-52 bg-gray-50 border border-dashed border-gray-300 text-gray-900 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-2.5 w-full flex flex-col items-center justify-center overflow-hidden up_doc_con">
                <div
                    class="absolute h-full w-full top-0 left-0 z-[1] bg-gray-50 hover:bg-gray-100 flex flex-col items-center justify-center  {{ in_array($key, $document_arr) ? '' : 'hidden' }} up_doc_prev_con">
                    <a class="set-document inline-block absolute top-1.5 left-1.5 text-blue-600 text-[.6rem] rounded-md block px-2 py-1 pdf-icon {{ $doc_extension ? ($doc_extension == 'pdf' ?: 'hidden') : 'hidden' }}"
                        target="_blank"
                        href="{{ isset($doc_value->documet_location) ? Storage::url($doc_value->documet_location ?? null) : '' }}">View
                        File</a>
                    <button type="button"
                        class="absolute top-1.5 right-1.5 text-red-600 text-[.6rem] rounded-md block px-2 py-1 up_doc_rmv_btn">Remove</button>
                    <img class="h-36 max-w-12/12 set-image set-document {{ $doc_extension ? ($doc_extension != 'pdf' ?: 'hidden') : 'hidden' }}"
                        src="{{ isset($doc_value->documet_location) ? Storage::url($doc_value->documet_location ?? null) : '' }}"
                        alt="">
                    <i
                        class="bi bi-filetype-pdf text-5xl pdf-icon {{ $doc_extension ? ($doc_extension == 'pdf' ?: 'hidden') : 'hidden' }}"></i>
                </div>
                <i class="bi bi-cloud-upload text-2xl"></i>
                <p class="text-center">@lang('user.form.docs.txt_1') <span
                        class="hover:underline text-sky-600">@lang('user.form.docs.txt_2')</span></p>
                <p class="text-xs text-gray-500 text-center">@lang('user.form.docs.txt_3') 5MB |
                    {{ $key == 1 ? '.JPG, .JPEG, .PNG' : '.PDF,.JPG, .JPEG, .PNG' }}</p>

                <input type="file" name="{{ $value }}" id="{{ $value }}"
                    class=" registration-input opacity-0 h-0 w-0 up_input registration_documents" value=""
                    accept="{{ $key == 1 ? '.jpg,.jpeg,.png' : '.pdf,.jpg,.jpeg,.png' }}">

            </label>
            {{-- When uploaded pdf --}}
            {{-- <a class="relative h-52 bg-gray-50 hover:bg-gray-100 border border-dashed border-gray-300 text-gray-900 text-xs rounded-md focus:ring-sky-600 focus:border-sky-600 block p-2.5 w-full flex flex-col items-center justify-center" target="_blank" href="">

                <button type="button" class="absolute top-1.5 right-1.5 text-red-600 text-[.6rem] rounded-md block px-2 py-1 up_doc_rmv_btn">Remove</button>
                    <i class="bi bi-filetype-pdf text-5xl"></i>
            </a> --}}
            <p class="registration-error"></p>
        </div>
    @endforeach

</div>
