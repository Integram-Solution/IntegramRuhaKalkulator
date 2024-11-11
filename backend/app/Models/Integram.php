<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integram extends Model
{
public $table = "integram";

    protected $fillable = [
        'cegnev',
        'cim',
        'adoszam',
        'nev',
        'tel',
        'email'
    ];
}
