<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $title=array();

    public function __construct($modulo = '', $pagina = '')
    {
        $this->title[1] = $modulo;
        $this->title[0] = $pagina;
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
