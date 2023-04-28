<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Horari;

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

    public function listado()
    {

        $users = User::query();
        //$users->asignaturasAsignaturas();
        $users = $users->paginate(15);

        return view('back.pages.profes', compact('users'));
    }

    public function horario($id)
    {


        $user = User::search('nom_c', $id)->first();

        $horas = Horari::where('profe', 'like', '%' . $id . '%')
            ->orderBy('hora', 'asc')
            ->orderBy('dia', 'asc')
            ->get();

        $this->creaCalendar($horas);

        $calendario = $this->calendario;

        /*  $data = [
        'users' => $user,
        'horas' => $horas,
    ]; */

        return view('back.pages.horario', compact('user', 'horas', 'calendario'));
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
