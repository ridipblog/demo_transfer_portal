<?php

namespace App\View\Components\public\user_registration;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SupportDocumentComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.public.user_registration.support-document-component');
    }
}
