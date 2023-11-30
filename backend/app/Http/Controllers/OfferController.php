<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Candidat;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{

    public function index(): JsonResponse
    {
        if (Auth::user()->role == 1)
            return ApiResponse::success(Offer::all());
        else
            return ApiResponse::success(Offer::whereNot('id', Auth::user()->candidat->applyToAnOffer)->get());
    }




    public function store(Request $request)
    {

        $offer = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Offer::create($offer);

        return $this->index();
    }

    public function update(Request $request, string $id)
    {
        Offer::where('id', $id)->update([
            'title' => $request->title,
            'decription' => $request->description,
        ]);

        return $this->index();
    }


    public function destroy(string $id)
    {

        Offer::where('id', $id)->delete();
        return $this->index();
    }
}
