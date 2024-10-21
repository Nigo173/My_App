<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class admins_form extends Component
{
    /**
     * Create a new component instance.
     */
    private $admin;
    private $data;
    private $action;
    private $permissions;

    public function __construct($admin, $data, $action, $permissions)
    {
        $this->admin = $admin;
        $this->data = $data;
        $this->action = $action;
        $this->permissions = $permissions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admins_form');
    }
}
