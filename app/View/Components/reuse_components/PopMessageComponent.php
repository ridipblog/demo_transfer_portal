<?php

namespace App\View\Components\reuse_components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PopMessageComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $viewData;
    public function __construct($viewData=null)
    {
        $this->viewData=$viewData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reuse_components.pop-message-component');
    }
}
