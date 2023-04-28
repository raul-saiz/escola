<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Horari;
use App\Models\Uf;
use Livewire\WithPagination;

class MatriculaAlum extends Component
{

    use WithPagination;

    public function render($id)
    {

        $modulos = Horari::distinct()
        ->select('module')
        ->where('profe', 'like', '%'.$id.'%')
        //->orderBy('hora', 'asc')
        //->orderBy('dia', 'asc')
        ->get();

        dd($modulos);

        $ufs = Uf::whereIn('modul_id',$modulos)
        ->get();

        dd($ufs);

       // $users = Alumne::search('cognom1',$this->term)->paginate(10);

        $data = [
            'moduls' => $modulos,
            'ufs' => $ufs,
            'user' => $id,
        ];
        return view('livewire.matricula-alum',$data);
    }
}
