<?php

namespace App;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $route = null,
        public ?array $parameters = null,
    )
    {
        //
    }

    public function href(): string
    {
        if ($this->route){
            if (\Illuminate\Support\Facades\Route::has($this->route)){
                return route($this->route, $this->parameters);
            }
        }

        return "#";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.button');
    }
}
