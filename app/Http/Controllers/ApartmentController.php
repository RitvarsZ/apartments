<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentUser;
use Auth;
use Inertia\Inertia;
use Response;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::orderBy('created_at', 'desc')->get();

        return Inertia::render('Apartments/Index', [
            'apartments' => $apartments,
        ]);
    }

    public function map()
    {
        $user = Auth::user();
        $apartments = Apartment::all();

        return Inertia::render('Apartments/Map', [
            'apartments' => $apartments,
            'seen_apartments' => $user ? $user->seenApartments()->pluck('id') : [],
            'favorite_apartments' => $user ? $user->favoriteApartments()->pluck('id') : [],
        ]);
    }
    
    public function show(Apartment $apartment)
    {
        return Inertia::render('Apartments/Show', [
            'apartment' => $apartment,
        ]);
    }

    public function seen(Apartment $apartment)
    {
        $user = Auth::user();
        if ($user->seenApartments->contains($apartment)) {
            return Response::json([
                'status' => 'success', 
            ]);
        }

        $user->seenApartments()->attach($apartment);

        return Response::json([
            'status' => 'success', 
        ]);
    }

    public function favorite(Apartment $apartment)
    {
        $user = Auth::user();
        $is_favorite = $user->favoriteApartments->contains($apartment);
        $user->seenApartments()->syncWithoutDetaching([$apartment->id => ['is_favorite' => !$is_favorite]]);

        return Response::json([
            'is_favorite' => !$is_favorite,
            'status' => 'success', 
        ]);
    }
}
