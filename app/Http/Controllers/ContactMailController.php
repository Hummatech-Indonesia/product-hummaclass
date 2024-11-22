<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMailRequest;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMailController extends Controller
{
    public function index(ContactMailRequest $request)
    {
        Mail::to('hummaclass@gmail.com')->send(new ContactMail($request->validated()));
        dd('berhasil mengirim email');
    }
}
