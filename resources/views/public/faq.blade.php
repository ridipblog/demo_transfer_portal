{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title','FAQ page')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')
<div class="max-w-4xl w-full mx-auto py-8 px-4 lg:px-8">
    <!-- Title Section -->
    <h1 class="text-3xl font-semibold text-center mb-8 text-gray-800">FAQ</h1>
    
    <!-- FAQ Section -->
    <div class="space-y-4">
            @foreach (__('faq') as $key => $faq)
                @if (str_ends_with($key, '_txt'))
                    @continue
                @endif
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="w-full flex gap-4 justify-between items-center p-4 text-left focus:outline-none faq-toggle bg-sky-600 text-white">
                        <span class="font-bold lg:text-lg">{{ __('faq.' . $key) }}</span>
                        <svg class="faq-icon h-5 w-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </button>
                    <div class="faq-answer hidden p-4 border-t border-gray-200 text-gray-700">
                        @php $answer = __("faq.$key" . '_txt') @endphp
                        @if (is_array($answer))
                            <ul class="list-decimal list-outside space-y-2 pl-4">
                                @foreach ($answer as $step)
                                    <li>{{ $step }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $answer }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
</div>
@endsection
@section('extra_js')
<script>
    $(document).ready(function(){
	    $('.faq-toggle').click(function() {
	        const answer = $(this).next('.faq-answer');
	        const icon = $(this).find('.faq-icon');

	        // Slide up all answers except the one being clicked
	        $('.faq-answer').not(answer).slideUp(200);
	        $('.faq-icon').not(icon).removeClass('rotate-45');

	        // Toggle the clicked answer and icon
	        answer.slideToggle(200);
	        icon.toggleClass('rotate-45');
	    });
	});
  </script>
@endsection

{{-- -------------- end dynamic content ---------------- --}}
