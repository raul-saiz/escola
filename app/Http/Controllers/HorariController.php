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

        // dd($request);


        if ($request->has('add')) {

            $data = array('hora' => $hora, "dia" => $dia, "profe" => $user, "aula" => $aula, "module" => $modul, "curso" => $curs);
            // DB::table('student_details')->insert($data);
            Horari::insert($data);

            /*         $horas = Horari::where('profe', 'like', '%'.$user.'%')
        ->orderBy('hora','asc')
        ->orderBy('dia','asc')
        ->get();


        $this->creaCalendar($horas);

        $calendario = $this->calendario; */
        }

        if ($request->has('delete')) {


            $data = array('hora' => $hora, "dia" => $dia, "profe" => $user);
            Horari::where($data)->delete();
        }

        return back();

        //return view('back.pages.horario',compact('user','horas','calendario'));

    }

    /*     public function delete(Request $request)
    {

        if($request->has('delete')){
            $hora = $request->input('hora');
            $dia = $request->input('dia');
            $user = $request->input('id');
            $aula = '---';
            $curs = '---';
            $modul = 'GUARDIA';
            $data = array('hora' => $hora, "dia" => $dia, "profe" => $user);
           // DB::table('student_details')->insert($data);
            $chundi = Horari::where($data)->first();

            $chundi->delete();

           Horari::where('hora', '=', $hora)
           ->where('dia', '=', $dia)
           ->where('profe', 'LIKE', $user.'%')
           ->delete();

            ->where(
               function($query) {
                 return $query
                        ->where('hora', 'LIKE', '%fake%')
                        ->orWhere('that_too', '=', 1);
                })



         }


         return back();


    }
 */
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
