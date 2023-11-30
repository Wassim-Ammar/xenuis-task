<?php

namespace App\Actions;

use App\Mail\CandidatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailToCandidat
{
    public static function index(Request $request)
    {
        Mail::to($request->email)->send(new CandidatResponse($request->response, ($request->response == 'accept') ? 'candidacy_accepted' : 'candidacy_rejected'));
    }
}
