<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(){
        Mail::to('toavina.hasinjo@gmail.com')
        ->send(new ConfirmationMail());
        return view("template.Layout", [
            'title' => 'Dashoard',
            'page' => "admin.Acceuil"
        ]);
    }
}
