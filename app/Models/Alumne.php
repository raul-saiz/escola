<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nom
 * @property string $cognom1
 * @property string $cognom2
 * @property string $dni
 * @property string $nie
 * @property string $pas
 */
class Alumne extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnes';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['nom', 'cognom1', 'cognom2', 'dni', 'nie', 'pas'];
}
