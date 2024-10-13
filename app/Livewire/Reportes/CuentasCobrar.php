<?php

namespace App\Livewire\Reportes;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Lazy()]
class CuentasCobrar extends Component
{
    #[Title(['Cuentas por cobrar', 'Reportes'])]
    public function render()
    {
        return view('livewire.reportes.cuentas-cobrar');
    }
}
