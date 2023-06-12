<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $nom
 * @property int $hores
 * @property string $modul_id
 * @property string $curs_id
 * @property string $nom_l
 */
class Uf extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ufs';

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
    protected $fillable = ['nom', 'hores', 'modul_id', 'curs_id', 'nom_l'];
}
