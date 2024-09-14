<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class EmailsModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_emails_eml';
    protected $primaryKey = 'eml_id';


    protected $fillable = [
        'id_contacto',
        'eml_email',
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
                'eml_email' => 'nullable|email',
            ]
        ];


        return $rules[$context] ?? $rules['default'];
    }

    public static function getValidationMessages()
    {
        return [
            'eml_email.email' => 'El correo electrónico debe ser válido.',
        ];
    }
}
