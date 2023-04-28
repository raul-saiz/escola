<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Horari;
use App\Models\User;
use App\Models\Uf;

class MatriculaController extends Controller
{

   // private $calendario = [];

   /*  public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    } */

   public function index(){
    return view('back.pages.matricula');
   }

    public function matricula(Request $request,$id)
    {
        $user = User::search('nom_c', $id)->first();

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
        //$this->creaCalendar($horas);



        //$calendario = $this->calendario;

        /*  $data = [
        'users' => $user,
        'horas' => $horas,
    ]; */

        return view('back.pages.matricula', compact('user', 'modulos', 'ufs'));
    }
}
