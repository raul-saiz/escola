<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* SELECT DISTINCT dia, hora, profe from horaris_horario h
where ( h.dia, h.hora )
in ( select DISTINCT ho.dia, ho.hora from horaris_horario ho where ho.profe
in ( select b.profe from baixes b
where CURDATE() BETWEEN b.datain and b.dataout)
AND ho.module NOT LIKE 'GUARDIA')
AND module LIKE 'GUARDIA'
ORDER BY dia asc, hora asc; */



/**
 * @property string $profe
 * @property string $modul
 * @property string $tasca
 * @property int $semana
 */
class Asignacio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asignades';
    public $incrementing = false;
    public $timestamps = false;
    //protected $primaryKey = 'profe';
    /**
     * @var array
     */
    protected $fillable = ['profe', 'modul', 'semana','tasca'];
}

