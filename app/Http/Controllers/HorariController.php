<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horari;
use App\Models\User;

class HorariController extends Controller
{
    private $calendario = [];

    public function insertform()
    {
        return view('back.pages.modifguardia');
    }


    public function publicListado()
    {
        $users = User::query();
        $users = $users->paginate(15);
        return view('front.pages.profes', compact('users'));
    }

    
    public function visualHorari($id)
    {
        $titulo_horas = [
            '8h-9h', '9h-10h', '10h-11h',
            '11h-11.30h',
            '11.30h-12.30h', '12.30h-13.30h', '13.30h-14.30h',
            '15h-16h', '16h-17h', '17h-18h',
            '18h-18.30h',
            '18.30h-19.30', '19.30h-20.30h', '20.30h-21.30h'
        ];

        $user = User::search('nom_c', $id)->first();
        $horas = Horari::where('profe', 'like', '%' . $id . '%')
        ->orderBy('hora', 'asc')
        ->orderBy('dia', 'asc')
        ->get();

    $this->creaCalendar($horas);
    $calendario = $this->calendario;

    return view('front.pages.horario', compact('user', 'horas', 'calendario', 'titulo_horas'));

    }


    public function insert(Request $request)
    {

        $hora = $request->input('hora');
        $dia = $request->input('dia');
        $user = $request->input('id');
        $aula = '---';
        $curs = '---';
        $modul = 'GUARDIA';

        if ($request->has('add')) {
            $data = array('hora' => $hora, "dia" => $dia, "profe" => $user, "aula" => $aula, "module" => $modul, "curso" => $curs);
            Horari::insert($data);
        }
        if ($request->has('delete')) {
            $data = array('hora' => $hora, "dia" => $dia, "profe" => $user);
            Horari::where($data)->delete();
        }
        return back();
    }

    public function creaCalendar($horas)
    {
        for ($h = 1; $h <= 14; $h++) {
            for ($d = 1; $d <= 5; $d++) {
                foreach ($horas as $dato) {
                    if ($dato['hora'] === $h &&  $dato['dia'] === $d) {
                        $this->calendario[$h][$d] =  $dato['curso'] . '<br>' . $dato['module'] . '<br>' . $dato['aula'];
                        break;
                    } else {
                        $this->calendario[$h][$d] = '-';
                    }
                }
            }
        }
    }
}
