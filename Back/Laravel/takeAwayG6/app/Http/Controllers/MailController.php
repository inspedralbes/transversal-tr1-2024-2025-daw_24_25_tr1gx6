<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\estadoPreparando;
use App\Mail\estadoConfirm;
use App\Mail\estadoConfirmed;
use App\Mail\estadoPreparado;
use App\Mail\estadoEnviado;
use App\Mail\estadoReparto;
use App\Mail\estadoEntregado;


class MailController extends Controller
{
    public function sendMail($type)
    {
        $email = 'a19pabmatpav@inspedralbes.cat'; 

        switch ($type) {
            case 'confirm':
                Mail::to($email)->send(new estadoConfirm);
                break;
            case 'confirmed':
                Mail::to($email)->send(new estadoConfirmed);
                break;
            case 'preparando':
                Mail::to($email)->send(new estadoPreparando);
                break;
            case 'preparado':
                Mail::to($email)->send(new estadoPreparado);
                break;
            case 'enviado':
                Mail::to($email)->send(new estadoEnviado);
                break;
            case 'reparto':
                Mail::to($email)->send(new estadoReparto);
                break;
            case 'entregado':
                Mail::to($email)->send(new estadoEntregado);
                break;
            default:
                return response()->json(['message' => 'Tipus de correu no reconegut'], 400);
        }

        return response()->json(['message' => 'Missatge enviat correctament']);
    }
}
