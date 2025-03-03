<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CollectionList;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\Collection;
use Exception;

class CollectionController extends Controller
{

    public function collections(Request $request)
    {
        $collections = Collection::where('status', 1)->paginate($request->input('length', 10));
   
        return new CollectionList($collections);
    }

    public function showCollection(Request $request, $id){
        $collection = Collection::find($id);

        if(!$collection)
        {
            return response()->json([
                'success' => false,
                'data' => (object)[]
            ]);     
        }
        return response()->json([
            'success' => true,
            'data' => $collection
        ]);

    }
}
