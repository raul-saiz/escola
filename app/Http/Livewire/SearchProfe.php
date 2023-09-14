<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SearchProfe extends Component
{

    use WithPagination;
    public $term = "";

    public function render()
    {

        // sleep(1);
        $users =DB::table("users")
        ->search('nom_l',$this->term)
        ->paginate(10);
//dd($users);
        //$users = User::search('nom_c',$this->term)->paginate(10);

        $data = [
            'users' => $users,
        ];

        return view('livewire.search-profe', $data);
    }
}
