<?php

namespace App\Http\Controllers;

use App\Models\Therapist;
use App\Models\User;
use App\Http\Requests\StoreTherapistRequest;
use App\Http\Requests\UpdateTherapistRequest;
use App\Http\Resources\TherapistCollection;
use App\Http\Resources\TherapistResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TherapistCollection(Therapist::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTherapistRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'therapist',
        ]);

        $therapist = $user->therapist()->create([
            'license' => $validatedData['license'],
            'specialization' => $validatedData['specialization'],
        ]);
        
        DB::commit();

        return new TherapistResource($therapist->load('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Therapist $therapist)
    {
        return new TherapistResource($therapist->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTherapistRequest $request, Therapist $therapist)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();

        if (isset($validatedData['name']) || isset($validatedData['email'])) {
            $userData = [];
            if (isset($validatedData['name'])) {
                $userData['name'] = $validatedData['name'];
            }
            if (isset($validatedData['email'])) {
                $userData['email'] = $validatedData['email'];
            }
            $therapist->user()->update($userData);
        }

        if (isset($validatedData['license']) || isset($validatedData['specialization'])) {
            $therapistData = [];
            if (isset($validatedData['license'])) {
                $therapistData['license'] = $validatedData['license'];
            }
            if (isset($validatedData['specialization'])) {
                $therapistData['specialization'] = $validatedData['specialization'];
            }
            $therapist->update($therapistData);
        }
        
        DB::commit();

        return new TherapistResource($therapist->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        $therapist->user()->delete();

        return response()->json(null, 204);
    }
}