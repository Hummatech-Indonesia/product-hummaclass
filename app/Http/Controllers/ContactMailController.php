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
        $data = $request->validated();
        Mail::to('frsnaifla@gmail.com')->send(new ContactMail($data));
        dd("Email is sent successfully.");
    }
}
