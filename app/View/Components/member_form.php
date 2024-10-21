<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class member_form extends Component
{
    /**
     * Create a new component instance.
     */
    private $member;
    private $data;
    private $action;
    private $permissions;

    public function __construct($member, $data, $action, $permissions)
    {
        $this->member = $member;
        $this->data = $data;
        $this->action = $action;
        $this->permissions = $permissions;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member_form');
    }
}
