<?php

namespace App\Http\Livewire\Caja;

use Livewire\Component;
use App\Models\Caja;

class IndexComponent extends Component
{
	public $caja;

    public function mount()
    {
        $this->caja = Caja::all();
    }
    public function render()
    {
        return view('livewire.caja.index-component');
    }
}
