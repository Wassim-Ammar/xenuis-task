<?php

namespace App\Http\Controllers;

use App\Actions\StoreCandidatAndSendMailToAdmin;
use App\Http\Responses\ApiResponse;
use App\Mail\CandidatResponse;
use App\Models\Candidat;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class CandidatController extends Controller
{
    function index(): JsonResponse
    {

        return ApiResponse::success(Candidat::whereNot('applyToAnOffer', 0)->get());
    }

    public function store(Request $request): JsonResponse
    {
        StoreCandidatAndSendMailToAdmin::index($request);
        return $this->me();
    }

    function getCv(Candidat $candidat)
    {
        return Storage::download('/' . $candidat->id . 'cv.pdf', 'filename.pdf');

        // return $candidat;
    }

    function apply(Offer $offer): JsonResponse
    {

        Candidat::where('id', Auth::user()->candidat->id)->update([
            'applyToAnOffer' => 1,
        ]);
        return ApiResponse::success(Offer::whereNot('id', $offer->id)->get());
    }

    public function me(): JsonResponse
    {
        $candidat = Candidat::where('user_id', Auth::user()->id)->with('user')->get()[0];
        return ApiResponse::success($candidat);
    }

    function sendEmailToTheCandidat(Request $request): JsonResponse
    {


        return ApiResponse::success();
    }
}
