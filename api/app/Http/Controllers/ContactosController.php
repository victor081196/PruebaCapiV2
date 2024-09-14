<?php

namespace App\Http\Controllers;

use App\Models\ContactosModel;
use App\Models\DireccionesModel;
use App\Models\EmailsModel;
use App\Models\TelefonosModel;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    public function index()
    {
        $contactos = ContactosModel::orderBy('cts_id', 'DESC')->get();
        return response()->json(['contactos' => $contactos]);
    }
    public function create(Request $request)
    {
        $datos = $request->only(['cts_nombre', 'cts_pagina_web', 'cts_empresa', 'cts_notas', 'cts_id']);
        $validator = ContactosModel::validar($datos);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => '¡No se pudo crear!',
                'errores' => $validator->errors()
            ]);
        }

        $label = "";
        if ($datos['cts_id'] == "") {
            $create = ContactosModel::create($datos);
            $label = 'agrego';
        } else {
            $create = ContactosModel::where('cts_id', $datos['cts_id'])
                ->update([
                    'cts_nombre' => $datos['cts_nombre'],
                    'cts_pagina_web' => $datos['cts_pagina_web'],
                    'cts_empresa' => $datos['cts_empresa'],
                    'cts_notas' => $datos['cts_notas'],
                ]);
            $label = 'actualizo';
        }
        return response()->json([
            'status' => true,
            'mensaje' => "El contacto se $label correctamente.",
        ]);
    }
    public function get($cts_id)
    {
        $contactos = ContactosModel::find($cts_id);
        $telefonos = TelefonosModel::where('id_contacto', $cts_id)->get();
        $telefonos_array = $telefonos->pluck('tls_telefono')->toArray();
        $phones = implode(', ', $telefonos_array);

        $emails = EmailsModel::where('id_contacto', $cts_id)->get();
        $emails_array = $emails->pluck('eml_email')->toArray();
        $mails = implode(', ', $emails_array);

        $direcciones = DireccionesModel::where('id_contacto', $cts_id)->get();
        $direcciones_array = $direcciones->pluck('dir_direccion')->toArray();
        $dir = implode(', ', $direcciones_array);

        return response()->json(
            array(
                'contactos' => $contactos,
                'telefonos' => $phones,
                'emails' => $mails,
                'direcciones' => $dir,
            )
        );
    }
    public function delete(Request $request)
    {
        $datos = $request->only(['cts_id']);

        $update = ContactosModel::where('cts_id', $datos['cts_id'])
            ->delete();

        if ($update) {
            return response()->json([
                'status' => true,
                'mensaje' => 'El contacto se ha eliminado correctamente',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error al eliminar el contacto.'
            ]);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        $results = ContactosModel::where('cts_nombre', 'LIKE', "%{$query}%")
        ->orWhere('cts_pagina_web', 'LIKE', "%{$query}%")
        ->orWhere('cts_empresa', 'LIKE', "%{$query}%")
        ->get();

        return response()->json($results);
    }

    public function datos_create(Request $request)
    {
        $datos = $request->only(['tls_telefono', 'eml_email', 'dir_direccion', 'id_contacto']);

        $errores_telefonos = TelefonosModel::validar($datos);
        $errores_emails = EmailsModel::validar($datos);

        $errores_combinados = $errores_telefonos->errors()->merge($errores_emails->errors());

        if ($errores_combinados->count() > 0) {
            return response()->json([
                'status' => false,
                'mensaje' => '¡No se pudo crear!',
                'errores' => $errores_combinados
            ]);
        }

        $create_telefono = !empty($datos['tls_telefono']) ? TelefonosModel::create($datos) : "";
        $create_email = !empty($datos['eml_email']) ? EmailsModel::create($datos) : "";
        $create_direccion = !empty($datos['dir_direccion']) ? DireccionesModel::create($datos) : "";

        if ($create_telefono || $create_email || $create_direccion) {
            return response()->json([
                'status' => true,
                'mensaje' => "Los datos se guardaron correctamente.",
            ]);
        }
    }
}
