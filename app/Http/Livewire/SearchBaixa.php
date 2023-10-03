<?php

namespace App\Http\Livewire;

use App\Models\Baixa;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SearchBaixa extends Component
{

    use WithPagination;
    public $term = "";

    public function render()
    {

        // sleep(1);

        $users =DB::table("baixes")->search('profe',$this->term)->paginate(35);

        $data = [
            'users' => $users,
        ];

        return view('livewire.search-baixa', $data);
    }
}
