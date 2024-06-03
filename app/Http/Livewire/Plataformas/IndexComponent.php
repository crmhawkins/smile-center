<?php

namespace App\Http\Livewire\Plataformas;

use App\Models\Plataforma;
use Livewire\Component;

class IndexComponent extends Component
{
    public $plataformas;

    public function mount()
    {
        $this->plataformas = Plataforma::all();
    }

    public function render()
    {

        return view('livewire.plataformas.index-component');
    }

}
