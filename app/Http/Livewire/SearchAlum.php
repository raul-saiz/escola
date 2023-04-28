<?php

namespace App\Http\Livewire;

use App\Models\Alumne;
use Livewire\Component;
use Livewire\WithPagination;

class SearchAlum extends Component
{

    use WithPagination;
    public $term = "";

    public function render()
    {

        // sleep(1);

        $users = Alumne::search('cognom1',$this->term)->paginate(10);

        $data = [
            'users' => $users,
        ];

        return view('livewire.search-alum', $data);
    }
}
