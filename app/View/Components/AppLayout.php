<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $modulo, $pagina;

    public function __construct($modulo = '', $pagina = '')
    {
        $this->modulo = $modulo;
        $this->pagina = $pagina;
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
