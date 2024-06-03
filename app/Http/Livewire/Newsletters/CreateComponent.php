<?php

namespace App\Http\Livewire\Newsletters;

use App\Models\Paciente;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateComponent extends Component
{
    use LivewireAlert;
    public $pacientes_array_id = [];
    public $newsletters;
    public $pacientes;
    public $leads;
    public $date_sent;
    public $first_title_newsletter;
    public $banner_description;
    public $second_title_newsletter;
    public $images_promo;
    public $urls;

    public function mount()
    {
        $this->pacientes = Paciente::where('estado_id', 3)->where('newsletter',1)->whereNotNull('email')->get();
        $this->leads = Paciente::where('estado_id', 1)->where('newsletter',1)->whereNotNull('email')->get();
    }
    public function render()
    {
        return view('livewire.newsletters.create-component');
    }
}
