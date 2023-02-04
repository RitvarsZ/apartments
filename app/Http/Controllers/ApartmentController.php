<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Inertia\Inertia;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::all();

        return Inertia::render('Apartments/Index', [
            'apartments' => $apartments,
        ]);
    }

    public function show(Apartment $apartment)
    {
        return Inertia::render('Apartments/Show', [
            'apartment' => $apartment,
        ]);
    }
}
