<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Horari;
use App\Models\Baixa;
use Illuminate\Support\Facades\DB;


class AuthorController extends Controller
{
    private $calendario = [];

    public function __construct()
    {
        $this->authorizeResource(Schedule::class, 'schedule');
    }

    public function index()
    {
        return view('back.pages.home');
    }


    public function baixa()
    {
        DB::delete('delete from baixes where dataout < CURDATE()');

        $users = Baixa::query();
        $users = $users->paginate(15);
        return view('back.pages.baixes', compact('users'));
    }

    public function baixanova($id)
    {
        $user = Baixa::where('profe', 'like', '%' . $id . '%')->first();
        $us = array("profe" => $user);
        return view('back.pages.modifbaixa', $us);
    }


    public function listado()
    {
        $users = User::query();
        $users = $users->paginate(15);
        return view('back.pages.profes', compact('users'));
    }

    public function horario($id)
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
      
        return view('back.pages.horario', compact('user', 'horas', 'calendario', 'titulo_horas'));
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
