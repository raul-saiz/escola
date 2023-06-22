<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baixa;
use Illuminate\Support\Facades\Redirect;
use App\Models\Asignacio;

use Illuminate\Support\Facades\DB;

class BaixaController extends Controller
{
    private $asignadosVisual = [];
    private $asignados = [];
    private $calendario = [];
    private $profes_baixa = [];
    private $assig_a_cobrir = [];

    private $selector = [];

    public function insertform($id)
    {
        $dat = array("profe" => $id);
        $result = Baixa::where($dat)->first();
        if (!empty($result)) {
            $data = array("profe" => $result->profe, "datain" => $result->datain, "dataout" => $result->dataout);
            return view('back.pages.modifbaixa', compact('data'));
        } else {
            $data = array("profe" => $id);
            return view('back.pages.modifbaixa', compact('data'));
        }
    }

    function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = [];
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {
            $j = date('w', $current);
            if ($j > 0 & $j < 6 & !in_array($j, $dates)) {
                $dates[] = $j;
            }
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    public function insert(Request $request)
    {
        $out = $request->input('out');
        $in = $request->input('in');
        $user = $request->input('profe');
        $tasca = $request->input('tasca');

        if ($request->has('add')) {
            Baixa::updateOrCreate(
                ['profe' => $user],
                ['datain' => $in, 'dataout' => $out, 'tasca' =>$tasca]
            );
           // dd($tasca);
            $data = array("profe" => $user);
            $week  = date('W', strtotime(now()));

            DB::table("asignades")
                ->where('modul','LIKE','%'.$user.'%')
                ->where('semana', $week)
                ->update(['tasca' =>$tasca]);
           // Asignacio::where()->update();

        }

        if ($request->has('delete')) {
            $data = array("profe" => $user);
            Baixa::where($data)->delete();
        }
        return Redirect::to($request->get('http_referrer') . '/profe/baixes');
    }

    public function salvaguardies(Request $request)
    {
        $week  = date('W', strtotime(now()));
        Asignacio::where('semana', $week)->delete();
        $input = $request->collect();

//dd($input);
        $input->each(function ($profe, $modul) {
            $week  = date('W', strtotime(now()));


            if (is_numeric($modul[0]) && isset($profe)) {
               // dd($modul);
               $extra = explode('-', $modul, 5);
              // dd($extra);
               $tasca = $extra[2];

                    Asignacio::updateOrCreate(
                        ['semana' => $week, 'modul' => $modul],
                        ['profe' => $profe, 'tasca' => $tasca]
                    );


            }
        });
        return Redirect::to($request->get('http_referrer') . '/profe/guardies');
    }

    public function visualGuardia(Request $request)
    {
        $week  = date('W', strtotime(now()));
        $day  = date('w', strtotime(now()));
        $assig_a_cobrir = DB::select("select * from asignades where semana =".$week." AND modul LIKE '".$day."-%'");

        //dd($assig_a_cobrir);
        $this->creaVisual($assig_a_cobrir);

        $titulo_horas = [
            '8h-9h', '9h-10h', '10h-11h',
            '11h-11.30h',
            '11.30h-12.30h', '12.30h-13.30h', '13.30h-14.30h',
            '15h-16h', '16h-17h', '17h-18h',
            '18h-18.30h',
            '18.30h-19.30', '19.30h-20.30h', '20.30h-21.30h'
        ];

        $asignados = $this->asignadosVisual;
       //dd($asignados);
        return view('front.pages.mostrar', compact('asignados', 'titulo_horas','day'));

    }

    public function creaVisual($datos)
    {

       // dd($datos);
        foreach ($datos as $dat) {


            $extra = explode('-', $dat->modul, 6);
            $numprofe = 1;
            if (isset($this->asignadosVisual[$extra[1]][$extra[0]])) {
                $numprofe = count($this->asignadosVisual[$extra[1]][$extra[0]]) + 1;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][0] = $extra[4];
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][1] =  $dat->profe;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][2] =  $dat->tasca;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][3] =   $extra[5];
            } else {
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][0] = $extra[4];
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][1] = $dat->profe;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][2] = $dat->tasca;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][3] =   $extra[5];
            }
        }

    }

    public function guardies()
    {

        $week  = date('W', strtotime(now()));
        $consulta = array("semana" => $week);
        $asignats = Asignacio::where($consulta)->get();

        $this->parsea($asignats);

        $titulo_horas = [
            '8h-9h', '9h-10h', '10h-11h',
            '11h-11.30h',
            '11.30h-12.30h', '12.30h-13.30h', '13.30h-14.30h',
            '15h-16h', '16h-17h', '17h-18h',
            '18h-18.30h',
            '18.30h-19.30', '19.30h-20.30h', '20.30h-21.30h'
        ];


        $assig_a_cobrir = DB::select("SELECT DISTINCT ho.dia, ho.hora, ho.module, ho.aula, max(ho.profe) as profe , b.tasca FROM horaris_horario ho, baixes b
        WHERE ho.profe = b.profe
        AND ho.module NOT LIKE '%TUT%'
        AND( ho.dia, ho.hora, ho.module, ho.aula ) NOT IN( SELECT ho2.dia, ho2.hora, ho2.module, ho2.aula FROM horaris_horario ho2 WHERE ho2.profe NOT IN(SELECT profe FROM baixes))
        AND (CURDATE() BETWEEN b.datain AND b.dataout)
        AND ho.module NOT LIKE 'GUARDIA'
        AND ( DAYOFWEEK(CURDATE()) <= DAYOFWEEK(b.dataout) OR WEEK(CURDATE()) < WEEK(b.dataout))
        AND ho.dia >= (DAYOFWEEK(CURDATE()) -1)
        group by ho.dia,ho.hora,ho.module,ho.aula,b.tasca;
    ");
   //
       /*  $assig_a_cobrir = DB::select("select DISTINCT ho.dia, ho.hora ,ho.module , ho.aula, ho.profe from horaris_horario ho , baixes b
                                        where ho.profe = b.profe
                                                     and  CURDATE() BETWEEN b.datain and b.dataout
                                                     AND ho.module NOT LIKE 'GUARDIA'
                                                     AND ( WEEK(CURDATE()) < WEEK(b.dataout)
                                                            OR (
                                                            WEEK(CURDATE()) = WEEK(b.dataout) AND DAYOFWEEK(CURDATE()) <= DAYOFWEEK(b.dataout)
                                                            )

                                                        )
                                AND   ( WEEK(CURDATE()) < WEEK(b.dataout)
                                        OR (
                                            WEEK(CURDATE()) = WEEK(b.dataout)
                                                AND
                                            ho.dia <= DAYOFWEEK(b.dataout)-1 AND ho.dia >=  DAYOFWEEK(CURDATE())-1
                                            )
                                    )
                                                            "); */

       /*  $assig_a_cobrir = DB::select("select DISTINCT ho.dia, ho.hora ,ho.module , ho.aula, ho.profe from horaris_horario ho
        where ho.profe in ( select b.profe from baixes b
        where CURDATE() BETWEEN b.datain and b.dataout)
        AND ho.module NOT LIKE 'GUARDIA'
        ORDER BY dia asc, hora asc;"); */


    /*     $profes_baixa = DB::select("SELECT DISTINCT dia, hora, profe from horaris_horario h
                                    where ( h.dia, h.hora )
                                                in ( select DISTINCT ho.dia, ho.hora from horaris_horario ho , baixes b
                                                     where ho.profe = b.profe
                                                     and  CURDATE() BETWEEN b.datain and b.dataout
                                                     AND ho.module NOT LIKE 'GUARDIA'
                                                     AND ( WEEK(CURDATE()) < WEEK(b.dataout)
                                                            OR (
                                                            WEEK(CURDATE()) = WEEK(b.dataout) AND DAYOFWEEK(CURDATE()) <= DAYOFWEEK(b.dataout)
                                                            )
                                                        )
                                                    )
                                    AND module LIKE 'GUARDIA'
                                    ORDER BY dia asc, hora asc;");

SELECT DISTINCT h.dia, h.hora, otra.profe, otra.cnt from horaris_horario h
LEFT JOIN (
SELECT COUNT(a.profe) as cnt , profe
from asignades a group by a.profe ) otra
ON h.profe = otra.profe
where ( h.dia, h.hora )
        in ( select DISTINCT ho.dia, ho.hora from horaris_horario ho
        where ho.profe
            in ( select b.profe from baixes b
                where CURDATE() BETWEEN b.datain and b.dataout)
        AND ho.module NOT LIKE 'GUARDIA')
AND module LIKE 'GUARDIA'
AND h.profe NOT IN (select b.profe from baixes b
                where CURDATE() BETWEEN b.datain and b.dataout)
ORDER BY h.dia asc, h.hora asc;

SELECT DISTINCT h.dia, h.hora, h.profe, IFNULL(otra.cnt,0) as fetes from horaris_horario h
 LEFT JOIN ( SELECT COUNT(a.profe) as cnt , profe from asignades a group by a.profe ) otra
  ON h.profe = otra.profe
  where ( h.dia, h.hora ) in ( select DISTINCT ho.dia, ho.hora from horaris_horario ho
         where ho.profe in ( select b.profe from baixes b
                        where CURDATE() BETWEEN b.datain and b.dataout)
                         AND ho.module NOT LIKE 'GUARDIA')
AND module LIKE 'GUARDIA'
 AND h.profe NOT IN (select b.profe from baixes b
                where CURDATE() BETWEEN b.datain and b.dataout)
ORDER BY h.dia asc, h.hora asc;
                                    */

                                  /*   $profes_baixa = DB::select("SELECT DISTINCT h.dia, h.hora, h.profe from horaris_horario h
                                    where ( h.dia, h.hora )
                                            in ( select DISTINCT ho.dia, ho.hora from horaris_horario ho
                                            where ho.profe
                                                in ( select b.profe from baixes b
                                                    where CURDATE() BETWEEN b.datain and b.dataout)
                                            AND ho.module NOT LIKE 'GUARDIA')
                                    AND module LIKE 'GUARDIA'
                                    AND h.profe NOT IN (select b.profe from baixes b
                                                    where CURDATE() BETWEEN b.datain and b.dataout)
                                    ORDER BY h.dia asc, h.hora asc ;");
 */
$profes_baixa = DB::select("SELECT DISTINCT h.dia, h.hora, h.profe, IFNULL(otra.cnt,0) as fetes from horaris_horario h
LEFT JOIN ( SELECT COUNT(a.profe) as cnt , profe from asignades a group by a.profe ) otra
 ON h.profe = otra.profe
 where ( h.dia, h.hora ) in ( select DISTINCT ho.dia, ho.hora from horaris_horario ho
        where ho.profe in ( select b.profe from baixes b
                       where CURDATE() BETWEEN b.datain and b.dataout)
                        AND ho.module NOT LIKE 'GUARDIA')
AND module LIKE 'GUARDIA'
AND h.profe NOT IN (select b.profe from baixes b
               where CURDATE() BETWEEN b.datain and b.dataout)
ORDER BY h.dia asc, h.hora asc;");


        $this->creaGuardies($profes_baixa, $assig_a_cobrir, $this->asignados);
        $profes_baixa = $this->profes_baixa;
        $assig_a_cobrir = $this->assig_a_cobrir;

        return view('back.pages.guardies', compact('assig_a_cobrir', 'titulo_horas'));
    }

    public function creaGuardies($horas, $assig, $oldassig)
    {
        foreach ($assig as $dat) {
            $profes = 1;
            $d = $dat->dia;
            $h = $dat->hora;
            if (isset($this->assig_a_cobrir[$h][$d])) {
                $profes = $profes + 1;
                $this->selector[$h][$d][$profes] = '<div class="form-floating"> <select class="form-select" id="' . $d . '-' . $h . '-' . $dat->tasca. '-' . $dat->profe .'-' . $dat->module . ' - ' . $dat->aula . '" name="' . $d . '-' . $h . '-' . $dat->tasca .'-' . $dat->profe .'-' .$dat->module . ' - ' . $dat->aula . '" form="assignades"> <option selected=""></option> '; // <option selected=""></option>
                foreach ($horas as $dato) {
                    if ($dato->dia == $d && $dato->hora == $h) {
                        if (isset($oldassig[$h][$d])) {

                        for ($i = 1; $i <=  sizeof($oldassig[$h][$d]); $i++) {

                            if ($oldassig[$h][$d][$i][0] == ($dat->module . '_-_' . $dat->aula) && $oldassig[$h][$d][$i][1] == $dato->profe) { //&& $oldassig[$h][$d][$i][1] == $dato->profe

                                $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $oldassig[$h][$d][$i][1] . '" selected="" >' . $oldassig[$h][$d][$i][1] . '</option>';
                            }  elseif ($oldassig[$h][$d][$i][0] == ($dat->module . '_-_' . $dat->aula) || $oldassig[$h][$d][$i][1] == $dato->profe) {

                                $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >' . $dato->profe .' ('. $dato->fetes.')'. '</option>';
                            }
                        }
                        } else {
                            $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >'. $dato->profe .' ('. $dato->fetes.')'. '</option>';
                        }
                    }
                }
                $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes] . '</select><label for="floatingSelect" style="color:red">' . $dat->module . ' / ' . $dat->aula. ' / ' . $dat->profe . '</label></div>';
                $this->assig_a_cobrir[$h][$d] = $this->assig_a_cobrir[$h][$d] . '<br>' . $this->selector[$h][$d][$profes];
            } else {
                $this->selector[$h][$d][$profes] = '<div class="form-floating"> <select class="form-select" id="' . $d . '-' . $h .'-' . $dat->tasca . '-' .  $dat->profe .'-' .$dat->module . ' - ' . $dat->aula . '" name="' . $d . '-' . $h .'-' . $dat->tasca . '-' . $dat->profe .'-' .$dat->module . ' - ' . $dat->aula . '" form="assignades"> <option selected=""></option>'; //  <option selected=""></option>
                foreach ($horas as $dato) {

                    if ($dato->dia == $d && $dato->hora == $h) {
                        if (isset($oldassig[$h][$d])) {

                            for ($i = 1; $i <= sizeof($oldassig[$h][$d]); $i++) {

                                if ($oldassig[$h][$d][$i][0] == ($dat->module . '_-_' . $dat->aula) && $oldassig[$h][$d][$i][1] == $dato->profe) { //&& $oldassig[$h][$d][$i][1] == $dato->profe

                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $oldassig[$h][$d][$i][1] . '" selected="" >' . $oldassig[$h][$d][$i][1] . '</option>';
                                }  elseif ($oldassig[$h][$d][$i][0] == ($dat->module . '_-_' . $dat->aula) || $oldassig[$h][$d][$i][1] == $dato->profe) {

                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >' . $dato->profe .' ('. $dato->fetes.')'. '</option>';
                                }
                            }
                        } else {
                            $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >' . $dato->profe .' ('. $dato->fetes.')'. '</option>';
                        }
                    }
                }
                $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes] . '</select><label for="floatingSelect" style="color:red">' . $dat->module . ' / ' . $dat->aula. ' / ' . $dat->profe . '</label></div>';
                $this->assig_a_cobrir[$h][$d] = $this->selector[$h][$d][$profes];
            }
        }

    }

    public function parsea($asignats)
    {
        $asignats->collect()->each(function ($profe, $numitem) {
            $extra = explode('-', $profe->modul, 5);
            $numprofe = 1;
            if (isset($this->asignados[$extra[1]][$extra[0]])) {
                $numprofe = count($this->asignados[$extra[1]][$extra[0]]) + 1;
                $this->asignados[$extra[1]][$extra[0]][$numprofe][0] = $extra[4];
                $this->asignados[$extra[1]][$extra[0]][$numprofe][1] = $profe->profe;
            } else {
                $this->asignados[$extra[1]][$extra[0]][$numprofe][0] = $extra[4];
                $this->asignados[$extra[1]][$extra[0]][$numprofe][1] = $profe->profe;
            }
        });
    }

    public function creaCalendar($horas)
    {
        for ($h = 1; $h <= 14; $h++) {
            for ($d = 1; $d <= 5; $d++) {
                foreach ($horas as $dato) {
                    if ($dato->hora === $h &&  $dato->dia === $d) {
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
