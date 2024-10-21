<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class crud_menu extends Component
{
    /**
     * Create a new component instance.
     */
    private $title;
    private $action;
    private $permissions;

    public function __construct($title, $action, $permissions)
    {
        $this->title = $title;
        $this->action = $action;
        $this->permissions = $permissions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.crud_menu');
    }
}
