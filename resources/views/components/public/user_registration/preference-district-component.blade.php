    @php
        $prefernce_distrcits = $viewData['save_data']->preferences_district ?? null;
        $employment_data = $viewData['save_data']->employment_details ?? null;
    @endphp
    <div class="grid lg:grid-cols-3 gap-2 lg:gap-2 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-5 lg:p-10">
        <div class="lg:col-span-3">
            <p class="text-lg font-semibold text-sky-500">@lang('user.form.prefs.heading')</p>
            <div class="mt-2 text-sm bg-yellow-100 text-yellow-600 p-4 rounded-2xl italic mb-4">
                <p>@lang('user.form.prefs.note_1')</p>
                <p class="mt-1">@lang('user.form.prefs.note_2')</p>
            </div>
        </div>
        @php
            $preference_text = [];
            for ($i = 1; $i <= 5; $i++) {
                $preference_text[] = __("user.form.prefs.$i");
            }
        @endphp
        @for ($i = 0; $i < 5; $i++)
            <div class="relative">
                <span
                    class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-500 -mt-2.5">{{ $preference_text[$i] }}</span>
                <select name="preference_location[]" id="preference_district_{{ $i + 1 }}"
                    class="registration-input preference_districts disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 pl-12 w-full">
                    <option value=""
                        {{ isset($prefernce_distrcits[$i]->district_id) ? (in_array($employment_data->district_id, $viewData['districts']->pluck('id')->toArray()) ? 'selected' : '') : 'selected' }}
                        disabled>
                        — Select —</option>

                    @foreach ($viewData['districts'] as $district)

                            <option value="{{ $district->id }}"
                                {{ isset($prefernce_distrcits[$i]->district_id) ? ($prefernce_distrcits[$i]->district_id == $district->id ? 'selected' : '') : '' }} class=" {{ isset($employment_data->district_id) ? ($employment_data->district_id == $district->id ? 'hidden' : '') : '' }}">
                                {{ $district->name }}</option>

                    @endforeach

                </select>
                <p class="registration-error"></p>
            </div>
        @endfor
    </div>
