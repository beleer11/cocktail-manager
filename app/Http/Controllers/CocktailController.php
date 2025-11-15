<?php

namespace App\Http\Controllers;

use App\Models\Cocktail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CocktailController extends Controller
{
    public function indexApi(Request $request)
    {
        $search = $request->get('q', 'a');
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 12;

        $res = Http::get("https://www.thecocktaildb.com/api/json/v1/1/search.php", ['s' => $search]);
        $drinks = $res->json()['drinks'] ?? [];

        $col = collect($drinks);

        $allCategories = $col->pluck('strCategory')->filter()->unique()->values()->all();
        $allAlcoholic  = $col->pluck('strAlcoholic')->filter()->unique()->values()->all();

        if ($request->filled('category')) {
            $col = $col->where('strCategory', $request->get('category'));
        }
        if ($request->filled('alcoholic')) {
            $col = $col->where('strAlcoholic', $request->get('alcoholic'));
        }

        if ($request->get('sort') === 'name_asc') {
            $col = $col->sortBy('strDrink');
        } elseif ($request->get('sort') === 'name_desc') {
            $col = $col->sortByDesc('strDrink');
        }

        $items = $col->values();
        $total = $items->count();
        $paginated = $items->slice(($page - 1) * $perPage, $perPage)->values()->all();
        $hasMore = ($page * $perPage) < $total;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'drinks'   => $paginated,
                'has_more' => $hasMore,
                'page'     => $page,
            ]);
        }

        return view('cocktails.api_index', [
            'drinks'        => $paginated,
            'filters'       => [
                'categories' => $allCategories,
                'alcoholic'  => $allAlcoholic,
            ],
            'has_more'      => $hasMore,
            'current_page'  => $page,
            'search_query'  => $search,
        ]);
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
