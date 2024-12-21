<?php

namespace App\View\Components\employees;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PenddingDashContentComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $viewData;
    public $verifierAddDocuments;
    public function __construct($viewData=null,$verifierAddDocuments=null)
    {
        $this->viewData=$viewData;
        $this->verifierAddDocuments=$verifierAddDocuments;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.employees.pendding-dash-content-component');
    }
}
