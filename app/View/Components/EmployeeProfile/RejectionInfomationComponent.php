<?php

namespace App\View\Components\EmployeeProfile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RejectionInfomationComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $rejectedData;
    public function __construct($rejectedData = null)
    {
        $this->rejectedData = $rejectedData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.employee-profile.rejection-infomation-component');
    }
}
