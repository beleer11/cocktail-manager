<?php

namespace App\Http\Controllers;

use App\Models\Cocktail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CocktailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexApi()
    {
        $res = Http::get('https://www.thecocktaildb.com/api/json/v1/1/search.php?s=a');
        $data = $res->json();
        $drinks = $data['drinks'] ?? [];
        return view('cocktails.api_index', compact('drinks'));
    }


    public function store(Request $request)
    {
        $payload = $request->validate([
            'cocktail_id' => 'required',
            'name' => 'required',
            'category' => 'nullable',
            'alcoholic' => 'nullable',
            'glass' => 'nullable',
            'instructions' => 'nullable',
            'thumbnail' => 'nullable',
            'ingredients' => 'nullable',
        ]);


        $cocktail = Cocktail::updateOrCreate(
            ['cocktail_id' => $payload['cocktail_id']],
            [
                'name' => $payload['name'],
                'category' => $payload['category'] ?? null,
                'alcoholic' => $payload['alcoholic'] ?? null,
                'glass' => $payload['glass'] ?? null,
                'instructions' => $payload['instructions'] ?? null,
                'thumbnail' => $payload['thumbnail'] ?? null,
                'ingredients' => $payload['ingredients'] ?? null,
            ]
        );


        return response()->json(['success' => true, 'cocktail' => $cocktail]);
    }

    public function storedIndex()
    {
        $cocktails = Cocktail::orderBy('created_at', 'desc')->get();
        return view('cocktails.stored_index', compact('cocktails'));
    }


    public function edit(Cocktail $cocktail)
    {
        return view('cocktails.edit', compact('cocktail'));
    }


    public function update(Request $request, Cocktail $cocktail)
    {
        $data = $request->validate([
            'name' => 'required',
            'category' => 'nullable',
            'alcoholic' => 'nullable',
            'glass' => 'nullable',
            'instructions' => 'nullable',
            'thumbnail' => 'nullable',
            'ingredients' => 'nullable',
        ]);


        $cocktail->update($data);
        return redirect()->route('cocktails.stored')->with('success', 'Cóctel actualizado');
    }


    public function destroy(Cocktail $cocktail)
    {
        $cocktail->delete();
        return response()->json(['success' => true]);
    }
}