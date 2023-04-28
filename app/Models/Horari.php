<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $hora
 * @property string $aula
 * @property string $module
 * @property string $profe
 * @property string $curso
 * @property AsignaturasAula $asignaturasAula
 * @property PersonasProfe $personasProfe
 */
class Horari extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'horaris_horario';

    /**
     * @var array
     */
    protected $fillable = ['aula', 'dia', 'hora','profe','curso','module'];


    protected $primaryKey = 'profe';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asignaturasAula()
    {
        return $this->belongsTo('App\Models\Aula', 'aula', 'nom_c');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personasProfe()
    {
        return $this->belongsTo('App\Models\Profe', 'profe', 'nom_c');
    }


}
