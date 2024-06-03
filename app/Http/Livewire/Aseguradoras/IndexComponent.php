<?php

namespace App\Http\Livewire\Aseguradoras;

use App\Models\Aseguradora;
use Livewire\Component;

class IndexComponent extends Component
{
    public $aseguradoras;

    public function mount()
    {
        $this->aseguradoras = Aseguradora::all();
    }

    public function render()
    {

        return view('livewire.aseguradoras.index-component');
    }

}
