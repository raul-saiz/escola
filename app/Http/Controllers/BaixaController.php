<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baixa;
use Illuminate\Support\Facades\Redirect;
use App\Models\Asignacio;
use App\Models\Mailsender;
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
        $idmail = $request->input('mail');
        $newprofe = $request->input('newprofe');

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
            $week  = date('W', strtotime(now()));
            Baixa::where($data)->delete();
            DB::table("asignades")
                ->where('modul','LIKE','%'.$user.'%')
                ->where('semana', '>=', $week)
                ->delete();

        }

        if ($request->has('chg')) {

            if ( $newprofe == null || $idmail == null) {

            }else{
                if ($idmail.contains('@')){
                    $idmail =  substr($idmail, 0, strpos($idmail, '@'));
                }
                $data = array("profe" => $user);
                $week  = date('W', strtotime(now()));
                Baixa::where($data)->delete();
                DB::table("asignades")
                    ->where('modul','LIKE','%'.$user.'%')
                    ->delete();
                DB::select("UPDATE users SET nom_c = '".$idmail."' , nom_l = '".$newprofe."' , email = '".$idmail."@xtec.cat'  WHERE nom_c = '".$user."';");
                DB::select("UPDATE horaris_horario SET profe = '".$idmail."' WHERE profe = '".$user."';");

            }

        }


        return Redirect::to($request->get('http_referrer') . '/profe/baixes');
    }

    public function salvaguardies(Request $request)
    {

        $week  = date('W', strtotime(now()));
        $day  = date('w', strtotime(now()));
        //dd($week,$day);
        if ( $day > 5) {
            $week  = date('W', strtotime("sunday 1 week"));
            $day  = "1";
        }
        Asignacio::where('semana', $week)->delete();
        $input = $request->collect();

//dd($input);
         $input->each(function ($profe, $modul) {
            $week  = date('W', strtotime(now()));
            $day  = date('w', strtotime(now()));
            //dd($week,$day);
            if ( $day > 5) {
                $week  = date('W', strtotime("sunday 1 week"));
                $day  = "1";
            }

            if (is_numeric($modul[0]) && isset($profe)) {
               // dd($modul);
               $extra = explode('-', $modul, 7);
               //dd($extra);
               $tasca = $extra[3];

                    Asignacio::updateOrCreate(
                        ['semana' => $week, 'modul' => $modul],
                        ['profe' => $profe, 'tasca' => $tasca]
                    );

                    if ( ! DB::table('mailsenviados')->where('semana',$week)
                            ->where('modul',$modul)
                            ->where('profe',$profe)
                            ->where('tasca',$tasca)->exists() ){

                              DB::table('mailsenviados')
                              ->where('modul',$modul)
                              ->delete();

                              Mailsender::Create(
                                ['semana' => $week, 'modul' => $modul,'profe' => $profe,  'tasca' => $tasca]
                            );

                            $diasemana = [ '1'=>'Dilluns', '2'=>'Dimarts', '3'=>'Dimecres', '4'=>'Dijous', '5'=>'Divendres'];
                            $titulo_horas = [
                                '1' =>'8h-9h', '2' =>'9h-10h', '3' =>'10h-11h',
                                '4' =>'11h-11.30h',
                                '5' =>'11.30h-12.30h', '6' =>'12.30h-13.30h', '7' =>'13.30h-14.30h',
                                '8' =>'15h-16h', '9' =>'16h-17h', '10' =>'17h-18h',
                                '11' =>'18h-18.30h',
                                '12' =>'18.30h-19.30', '13' =>'19.30h-20.30h', '14' =>'20.30h-21.30h'
                            ];

                            //$auxdia = $diasemana[($extra[0])];

//$data = array('profe' => $profe.'@xtec.cat', 'modul'=> $extra[4], 'aula' => $extra[5], 'hora' => $extra[1], 'dia' => $auxdia, 'tasca' => $extra[2]);

                            $data = array('profe' => $profe.'@xtec.cat', 'modul'=> $extra[5], 'aula' => $extra[6], 'hora' => $titulo_horas[$extra[1]], 'dia' => $diasemana[$extra[0]],'grup' => $extra[2], 'tasca' => $extra[3]);
//dd($data);
                             $result = app('App\Http\Controllers\MailController')->html_email($data);


                            }


            }
        });
        return Redirect::to($request->get('http_referrer') . '/profe/guardies');
    }

    public function visualGuardia(Request $request)
    {
        $week  = date('W', strtotime(now()));
        $day  = date('w', strtotime(now()));
        //dd($week,$day);
        if ( $day > 5) {
            $week  = date('W', strtotime("sunday 1 week"));
            $day  = "1";
        }

        //dd($day);
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
      // dd($asignados);
        return view('front.pages.mostrar', compact('asignados', 'titulo_horas','day'));

    }

    public function creaVisual($datos)
    {

        //dd($datos);
        foreach ($datos as $dat) {


            $extra = explode('-', $dat->modul, 7);
            //dd($extra);
            $numprofe = 1;
            if (isset($this->asignadosVisual[$extra[1]][$extra[0]])) {
                $numprofe = count($this->asignadosVisual[$extra[1]][$extra[0]]) + 1;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][0] = $extra[5];
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][1] =  $dat->profe;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][2] =  $dat->tasca;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][3] =  $extra[6];
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][4] =   $extra[2];
            } else {
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][0] = $extra[5];
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][1] = $dat->profe;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][2] = $dat->tasca;
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][3] =  $extra[6];
                $this->asignadosVisual[$extra[1]][$extra[0]][$numprofe][4] =   $extra[2];
            }
        }

    }

    public function guardies()
    {
       $week  = date('W', strtotime(now()));
        $day  = date('w', strtotime(now()));
        //dd($week,$day);
        if ( $day > 5) {
            $week  = date('W', strtotime("sunday 1 week"));
            $day  = "1";
        }
       // dd($week,$day);
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


        $assig_a_cobrir = DB::select("SELECT DISTINCT ho.dia, ho.hora,ho.curso, ho.module,  ho.aula, max(ho.profe) as profe , b.tasca , ho.curso FROM horaris_horario ho, baixes b
        WHERE ho.profe = b.profe
        AND ( ho.module NOT LIKE 'TU' AND ho.module NOT LIKE 'G' AND ho.module NOT LIKE 'GB' )
        AND ( ho.curso NOT LIKE 'GUARDIA' AND ho.curso NOT LIKE 'G')
        AND (
            ( WEEK(b.datain) = WEEK(CURDATE()) AND WEEK(b.dataout) = WEEK(CURDATE()) AND ho.dia BETWEEN WEEKDAY(b.datain)+1 AND WEEKDAY(b.dataout)+1)
            OR
            ( WEEK(b.datain) = WEEK(CURDATE()) AND WEEK(b.dataout) > WEEK(CURDATE()) AND ho.dia >=  WEEKDAY(CURDATE()) +1 AND  ho.dia >=  WEEKDAY(b.datain) +1   )
            OR
            ( WEEK(b.datain) < WEEK(CURDATE()) AND WEEK(b.dataout) = WEEK(CURDATE())  AND ho.dia <=  WEEKDAY(b.dataout)+1   )
        )
        group by ho.dia,ho.hora,ho.curso,ho.module,ho.aula,b.tasca,ho.curso;
    ");

    //AND ho.aula NOT LIKE 'PROBLEM'


    //    AND ho.module NOT LIKE 'GB\_%' AND ho.module NOT LIKE 'G1'  AND ho.module NOT LIKE 'G+55')
    //  AND ho.curso NOT LIKE 'GUARDIA%' AND ho.curso NOT LIKE 'G_%' AND ho.curso NOT LIKE 'GB_%' AND ho.curso NOT LIKE 'G1'  AND ho.curso NOT LIKE 'G+55'



// AND (CURDATE() < b.dataout) AND ( ho.dia <= DAYOFWEEK(b.dataout)-1 )
//         AND ((  ".$day." <= DAYOFWEEK(b.dataout)-1 AND (".$week.") = WEEK(b.dataout) AND ho.dia <= DAYOFWEEK(b.dataout)-1 ) OR ( ".$week." < WEEK(b.dataout) AND ho.dia >= ".$day."-1))

  /*   $assig_a_cobrir = DB::select("SELECT DISTINCT ho.dia, ho.hora, ho.module,  ho.aula, max(ho.profe) as profe , b.tasca , ho.curso FROM horaris_horario ho, baixes b
    WHERE ho.profe = b.profe
    AND ho.module NOT LIKE '%TUT%'
    AND ( ho.curso NOT LIKE 'GUARDIA%' OR ho.module NOT LIKE 'G' OR ho.module NOT LIKE 'GB' OR ho.module NOT LIKE 'G_M' OR ho.module NOT LIKE 'G_T' OR ho.module NOT LIKE 'G_B' OR ho.module NOT LIKE 'G1')
    AND ho.aula NOT LIKE 'PROBLEM'
    AND( ho.dia, ho.hora, ho.module, ho.aula ) NOT IN( SELECT ho2.dia, ho2.hora, ho2.module, ho2.aula FROM horaris_horario ho2 WHERE ho2.profe NOT IN(SELECT profe FROM baixes))
    AND (CURDATE() BETWEEN b.datain AND b.dataout)
    AND ( ho.module NOT LIKE 'GUARDIA%'  )
    AND ( (DAYOFWEEK(CURDATE()) <= DAYOFWEEK(b.dataout) AND (WEEK(CURDATE()) = WEEK(b.dataout)) AND ho.dia <= DAYOFWEEK(b.dataout)-1 ) OR WEEK(CURDATE()) < WEEK(b.dataout))
    AND ho.dia >= (DAYOFWEEK(CURDATE()) -1)
    group by ho.dia,ho.hora,ho.module,ho.aula,b.tasca,ho.curso;
"); */

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
                       where week(CURDATE()) BETWEEN week(b.datain) and week(b.dataout) )
        AND ( ho.module NOT LIKE 'G'  AND ho.module NOT LIKE 'GB' AND ho.curso NOT LIKE 'GUARDIA' ))
AND  ( h.module LIKE 'G' OR h.module LIKE 'GUARDIA')
AND h.profe NOT IN (select b.profe from baixes b where CURDATE() < b.dataout)
ORDER BY h.dia asc, h.hora asc;");
// AND ( ho.module NOT LIKE 'GUARDIA%'  AND ho.module NOT LIKE 'G1' AND ho.module NOT LIKE 'GB\_%' AND ho.module NOT LIKE 'G\_%'AND ho.module NOT LIKE 'G+55'))
//OR h.module LIKE 'G\_%'  OR h.module LIKE 'GB\_%' OR h.module LIKE 'G+55')
// OR ho.module NOT LIKE 'G' OR ho.module NOT LIKE 'GB' OR ho.module NOT LIKE 'G_M' OR ho.module NOT LIKE 'G_T' OR ho.module NOT LIKE 'G_B' OR ho.module NOT LIKE 'G1'
        $this->creaGuardies($profes_baixa, $assig_a_cobrir, $this->asignados);
        $profes_baixa = $this->profes_baixa;
        $assig_a_cobrir = $this->assig_a_cobrir;
//dd($assig_a_cobrir);
        return view('back.pages.guardies', compact('assig_a_cobrir', 'titulo_horas'));
    }

    public function creaGuardies($horas, $assig, $oldassig)
    {
        //dd($assig);
        foreach ($assig as $dat) {
            $profes = 1;
            $d = $dat->dia;
            $h = $dat->hora;
            if (isset($this->assig_a_cobrir[$h][$d])) {
                $profes = $profes + 1;

                $this->selector[$h][$d][$profes] = '<div class="form-floating"> <select class="form-select" id="' . $d . '-' . $h . '-' . $dat->curso . '-' . $dat->tasca. '-' . $dat->profe .'-' . $dat->module . '-' . $dat->aula  . '" name="' . $d . '-' . $h . '-' . $dat->curso . '-' . $dat->tasca .'-' . $dat->profe .'-' .$dat->module . '-' . $dat->aula .'" form="assignades"> <option selected=""></option> '; // <option selected=""></option>
                //$unavez = true;
                foreach ($horas as $dato) {
                    if ($dato->dia == $d && $dato->hora == $h ) {
                        //$unavez = false;

                        if (isset($oldassig[$h][$d])) {

                            //$i=1;
                        for ($i = 1; $i <=  sizeof($oldassig[$h][$d]); $i++) {

                            if ($oldassig[$h][$d][$i][0] == ($dat->module . '-' . $dat->aula) && $oldassig[$h][$d][$i][1] == $dato->profe) { //&& $oldassig[$h][$d][$i][1] == $dato->profe
                                $texto ='<option  value="' . $oldassig[$h][$d][$i][1] . '" selected="" >' . $oldassig[$h][$d][$i][1] . '</option>';
                                if(strpos($this->selector[$h][$d][$profes], $texto) === false){
                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . $texto;
                                }
                            }  elseif ($oldassig[$h][$d][$i][0] == ($dat->module . '-' . $dat->aula) && $oldassig[$h][$d][$i][1] != $dato->profe) {
                                $texto ='<option  value="' . $dato->profe . '" >' . $dato->profe .' ('. $dato->fetes.')'. '</option>';
                                if(strpos($this->selector[$h][$d][$profes], $texto) === false){
                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . $texto;
                                }
                            }  else {
                                $texto = '<option  value="' . $dato->profe . '" >'. $dato->profe .' ('. $dato->fetes.')'. '</option>';
                                if(strpos($this->selector[$h][$d][$profes], $texto) === false){
                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . $texto;
                                }
                            }
                        }

                         }
                        else {
                            $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >'. $dato->profe .' ('. $dato->fetes.')'. '</option>';
                        }
                        //$profes = $profes+1;
                    }

                }
                $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes] . '</select><label for="floatingSelect" style="color:red">'. $dat->curso . ' / ' .  $dat->module . ' / ' . $dat->aula. ' / ' . $dat->profe . '</label></div>';
                $this->assig_a_cobrir[$h][$d] = $this->assig_a_cobrir[$h][$d] . '<br>' . $this->selector[$h][$d][$profes];
            } else {
                $this->selector[$h][$d][$profes] = '<div class="form-floating"> <select class="form-select" id="' . $d . '-' . $h . '-' . $dat->curso . '-' . $dat->tasca . '-' .  $dat->profe .'-' .$dat->module . '-' . $dat->aula . '" name="' . $d . '-' . $h .'-' . $dat->curso  .'-' . $dat->tasca . '-' . $dat->profe .'-' .$dat->module . '-' . $dat->aula . '" form="assignades"> <option selected=""></option>'; //  <option selected=""></option>
                foreach ($horas as $dato) {

                    if ($dato->dia == $d && $dato->hora == $h) {
                        if (isset($oldassig[$h][$d])) {

                            $i=1; // for ($i = 1; $i <= sizeof($oldassig[$h][$d]); $i++) {

                                if ($oldassig[$h][$d][$i][0] == ($dat->module . '-' . $dat->aula) && $oldassig[$h][$d][$i][1] == $dato->profe) { //&& $oldassig[$h][$d][$i][1] == $dato->profe

                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $oldassig[$h][$d][$i][1] . '" selected="" >' . $oldassig[$h][$d][$i][1] . '</option>';
                                } elseif ($oldassig[$h][$d][$i][0] == ($dat->module . '-' . $dat->aula) && $oldassig[$h][$d][$i][1] != $dato->profe) {

                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >' . $dato->profe .' ('. $dato->fetes.')'. '</option>';
                                }  else {
                                    $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >'. $dato->profe .' ('. $dato->fetes.')'. '</option>';
                                }
                            //}
                        }
                        else {
                            $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes]  . '<option  value="' . $dato->profe . '" >' . $dato->profe .' ('. $dato->fetes.')'. '</option>';
                        }
                    }
                }
                $this->selector[$h][$d][$profes] = $this->selector[$h][$d][$profes] . '</select><label for="floatingSelect" style="color:red">' . $dat->curso . ' / '. $dat->module . ' / ' . $dat->aula. ' / ' . $dat->profe . '</label></div>';
                $this->assig_a_cobrir[$h][$d] = $this->selector[$h][$d][$profes];
            }
        }

    }

    public function parsea($asignats)
    {
        $asignats->collect()->each(function ($profe, $numitem) {
            $extra = explode('-', $profe->modul, 6);
            $numprofe = 1;
            if (isset($this->asignados[$extra[1]][$extra[0]])) {
                $numprofe = count($this->asignados[$extra[1]][$extra[0]]) + 1;
                $this->asignados[$extra[1]][$extra[0]][$numprofe][0] = $extra[5];
                $this->asignados[$extra[1]][$extra[0]][$numprofe][1] = $profe->profe;
            } else {
                $this->asignados[$extra[1]][$extra[0]][$numprofe][0] = $extra[5];
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
