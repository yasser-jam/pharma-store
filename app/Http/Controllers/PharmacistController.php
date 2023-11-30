<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\pharmacist;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\registerRequest;
use App\Http\Resources\PharmacistCollection;
use App\Http\Requests\StorepharmacistRequest;
use App\Http\Requests\UpdatepharmacistRequest;

class PharmacistController extends Controller
{
    /**
     * login
     */
    public function login(loginRequest $request){
        $validated= $request->validated();
        if(! Auth::attempt($validated)){
            return response()->json([
                "error"=> "invalid phone number or password"
            ],401);
        }
        $pharmacist=User::where("phoneNumber", $validated["phoneNumber"])->first();
        if($pharmacist->isStoreOwner){
            //$pharmacist->token()->revoke();
            return response()->json([
                'message'=>'User not Authorized'
            ],401);
        }
        return response()->json([
            "access_token"=> $pharmacist->createToken("api_token")->plainTextToken,
            "token_type"=>"bearer"
        ]);
    }
    // store owner login
    public function webLogin(LoginRequest $request){
        $validated= $request->validated();
        if(! Auth::attempt($validated)){
            return response()->json([
                "error"=> "invalid phone number or password"
            ],401);
        }
        $pharmacist=User::where("phoneNumber", $validated["phoneNumber"])->first();
        if(! $pharmacist->isStoreOwner){
            return response()->json([
                "error"=> "Not allowed"
            ],401);
        }
        return response()->json([
            "access_token"=> $pharmacist->createToken("api_token")->plainTextToken,
            "token_type"=>"bearer"
        ]);
    }
    /**
     * register
     */
    public function register(registerRequest $request){
        try{$validated= $request->validated();}
        catch(Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
            ]);
        }
        if($request->phoneNumber[0]!='0' || $request->phoneNumber[1]!='9' || strlen($request->phoneNumber)!= 10){
            return response()->json([
                "error"=> "invalid phone number"
            ],401);
        }
        if($validated){
            $pharmacist=User::create($validated);
        }
        return response()->json([
            "data"=>$pharmacist,
            "access_token"=> $pharmacist->createToken("api_token")->plainTextToken,
            "token_type"=>"bearer"
        ]);
    }
    //logout
    public function logout()
    {
        $user = auth('api')->user();

        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(pharmacist $pharmacist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pharmacist $pharmacist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pharmacist $pharmacist)
    {
        //
    }
}
