<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Tag;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view collections')) {
            abort(403);
        }

        $collections = Collection::all();
        return view('collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create collections')) {
            abort(403);
        }

        return view('collections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Collection::create([
            'name' => $request->collection_name,
            'condition_type' => $request->condition_type,
            'conditions' => json_encode(
                [
                    "condition_type" => $request->condition_type,
                    "tags" => $request->tags
                ]
            ),
            'status' => $request->status,
        ]);

        return redirect()->route('collections.index')->with('success', 'Collection Added successfully.');
        if(!Gate::allows('create collections')) {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        //
    }

    public function collectionOptionData($type=null){
        $tags = Tag::all();
        $maxPrice = Product::max('price') ?? 0;
        $productTypes = ProductType::all();

        return response()->json([
            'view' => view('collections.partials.collection-data', compact('type','tags','maxPrice','productTypes'))->render(),
        ]);
    }
}
