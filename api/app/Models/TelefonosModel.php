<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TelefonosModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_telefonos_tls';
    protected $primaryKey = 'tls_id';


    protected $fillable = [
        'id_contacto',
        'tls_telefono',
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
                'tls_telefono' => 'nullable|numeric|digits:10',
            ]
        ];


        return $rules[$context] ?? $rules['default'];
    }

    public static function getValidationMessages()
    {
        return [
            'tls_telefono.numeric' => 'El teléfono debe ser numérico.',
            'tls_telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
        ];
    }
}
