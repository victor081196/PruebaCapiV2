<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ContactosModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_contactos_cts';
    protected $primaryKey = 'cts_id';


    protected $fillable = [
        'cts_nombre',
        'cts_pagina_web',
        'cts_notas',
        'cts_empresa',
    ];
    public $timestamps = false;

    public static function validar(array $data, $context = 'default')
    {
        $rules = self::getValidationRules($context);
        $messages = self::getValidationMessages();

        return Validator::make($data, $rules, $messages);
    }

    public static function getValidationRules($context)
    {
        $rules = [
            'default' => [
                'cts_nombre' => 'required',
                'cts_pagina_web' => 'required',
                'cts_empresa' => 'required',
            ],
            'update' => [
                'cts_nombre' => 'required',
                'cts_pagina_web' => 'required',
                'cts_empresa' => 'required',
            ]
        ];


        return $rules[$context] ?? $rules['default'];
    }

    public static function getValidationMessages()
    {
        return [
            'cts_nombre.required' => 'El nombre es obligatorio.',
            'cts_pagina_web.required' => 'La pagina web es obligatoria.',
            'cts_empresa.required' => 'La empresa es obligatoria.',
        ];
    }


}
