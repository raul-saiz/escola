<?php

namespace App\Http\Livewire;

use App\Models\Baixa;
use Livewire\Component;
use Livewire\WithPagination;

class SearchBaixa extends Component
{

    use WithPagination;
    public $term = "";

    public function render()
    {

        // sleep(1);

        $users = Baixa::search('profe',$this->term)->paginate(10);

        $data = [
            'users' => $users,
        ];

        return view('livewire.search-baixa', $data);
    }
}
