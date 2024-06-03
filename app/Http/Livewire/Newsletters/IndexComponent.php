<?php

namespace App\Http\Livewire\Newsletters;

use App\Models\Newsletters\NewsletterManual;
use App\Models\Paciente;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class IndexComponent extends Component
{
    use LivewireAlert;
    public $newsletters;
    public $pacientes;

    public function mount()
    {
        $this->newsletters = NewsletterManual::orderBy('created_at', 'desc')->get();
        $this->pacientes = Paciente::all();
    }

    public function getNombre($id)
    {
        $paciente = Paciente::find($id);
        if(isset($paciente)){
            $nombre= $paciente->nombre.' '.$paciente->apellidos;
        }else{
            $nombre = 'Paciente no encontrado';
        }
        return $nombre;
    }
    public function render()
    {
        return view('livewire.newsletters.index-component');
    }
}
