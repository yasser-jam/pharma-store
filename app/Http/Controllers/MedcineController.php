<?php

namespace App\Http\Controllers;

use App\Models\Medcine;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Filters\MedcineFilter;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MedcineResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MedcineCollection;
use App\Http\Requests\StoreMedcineRequest;
use App\Http\Requests\UpdateMedcineRequest;

class MedcineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Medcine::class);

        $filter = new MedcineFilter();
        $queryItems = $filter->transform($request);

        if (empty($queryItems)) {
            return new MedcineCollection(Medcine::all());
        } else {
            // Apply the filters to the query
            return new MedcineCollection(Medcine::where($queryItems)->get());
        }    }
    /**
     * Display the specified resource.
     */
    public function show(Medcine $medcine)
    {
        $medcine->show=true;
        return new MedcineResource($medcine);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedcineRequest $request)
    {
       // dd(Auth::user());
        $validatedData = $request->validated();
        $medcine = Medcine::create($validatedData);
        return new MedcineResource($medcine);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medcine $medcine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedcineRequest $request, Medcine $medcine)
    {
        $validated= $request->validated();
        $medcine->update($validated);
        return new MedcineResource($medcine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medcine $medcine)
    {
        $medcine->delete();
        return response()->json([
            "message"=> "the medcine has been deleted successfully",
        ]);
    }
    public function addToFavorites(Request $request, $medcineId)
    {
        dd(auth()->user());
        $userId = auth()->user()->id;

        // Check if the medicine is already in favorites
        if (Favourite::where('user_id', $userId)->where('medcine_id', $medcineId)->exists()) {
            return response()->json(['message' => 'Medcine is already in favorites']);
        }

        // Add the medicine to favorites
        Favourite::create([
            'user_id' => $userId,
            'medcine_id' => $medcineId,
        ]);

        return response()->json(['message' => 'Medcine added to favorites']);
    }
    //
    public function __construct()
    {
        // $this->authorizeResource(Medcine::class, 'medcine');
    }
}
