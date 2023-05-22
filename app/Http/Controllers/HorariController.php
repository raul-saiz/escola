<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horari;

class HorariController extends Controller
{
    private $calendario = [];

    public function insertform()
    {
        return view('back.pages.modifguardia');
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
