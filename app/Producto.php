<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table='productos';

    protected $primaryKey='sku';

    public $incrementing=false;

    public $timestamps=false;

    protected $fillable=[
    	'nombre',
    	'precio',
    	'cantidad',
        'foto'
    ];


}
