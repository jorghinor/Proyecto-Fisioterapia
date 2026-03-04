<?php

namespace App\Http\Controllers;

use App\Models\MobilityArc;
use App\Http\Requests\StoreMobilityArcRequest;
use App\Http\Requests\UpdateMobilityArcRequest;
use App\Http\Controllers\Traits\PatientRecordFiltering;
use App\Http\Resources\MobilityArcCollection;
use App\Http\Resources\MobilityArcResource;
use Illuminate\Http\Request;

class MobilityArcController extends Controller
{
    use PatientRecordFiltering;

    protected function getModelClass(): string
    {
        return MobilityArc::class;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMobilityArcRequest $request)
    {
        $mobilityArc = MobilityArc::create($request->validated());

        return new MobilityArcResource($mobilityArc);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MobilityArc  $mobilityArc
     * @return \Illuminate\Http\Response
     */
    public function show(MobilityArc $mobilityArc)
    {
        return new MobilityArcResource($mobilityArc);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MobilityArc  $mobilityArc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMobilityArcRequest $request, MobilityArc $mobilityArc)
    {
        $mobilityArc->update($request->validated());

        return new MobilityArcResource($mobilityArc);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MobilityArc  $mobilityArc
     * @return \Illuminate\Http\Response
     */
    public function destroy(MobilityArc $mobilityArc)
    {
        $mobilityArc->delete();

        return response()->json(null, 204);
    }

    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();

        if ($request->has('patient_id')) {
            return new MobilityArcCollection($modelClass::where('patient_id', $request->patient_id)->get());
        }

        return new MobilityArcCollection($modelClass::all());
    }
}
