<?php

namespace App\Actions;

use App\Models\Candidat;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StoreCandidatAndSendMailToAdmin
{
    public static function index(Request $request): void
    {
        $user = $request['user'];
        $experiences =  $request['experience'];
        $educations =  $request['education'];


        $pdf = PDF::loadView('cv', compact('user', 'experiences', 'educations'));

        Mail::send('response', [], function ($message) use ($pdf) {
            $message->to("wassim@example.com", "wassim@example.com")
                ->subject("test")
                ->attachData($pdf->output(), "test.pdf");
        });
        Candidat::where('user_id', Auth::user()->id)->update([
            'createCv' => 1,
        ]);
        $pdf->save(storage_path("/app/" . Auth::user()->candidat->id . "cv.pdf"));
    }
}
