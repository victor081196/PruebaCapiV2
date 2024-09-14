<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class DireccionesModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_direcciones_dir';
    protected $primaryKey = 'dir_id';


    protected $fillable = [
        'id_contacto',
        'dir_direccion',
    ];
    public $timestamps = false;

}
