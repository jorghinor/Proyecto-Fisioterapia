<?php

namespace App\Http\Controllers;

use App\Models\GaitAnalysis;
use App\Http\Requests\StoreGaitAnalysisRequest;
use App\Http\Requests\UpdateGaitAnalysisRequest;
use App\Http\Controllers\Traits\PatientRecordFiltering;
use App\Http\Resources\GaitAnalysisCollection;
use App\Http\Resources\GaitAnalysisResource;
use Illuminate\Http\Request;

class GaitAnalysisController extends Controller
{
    use PatientRecordFiltering;

    protected function getModelClass(): string
    {
        return GaitAnalysis::class;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGaitAnalysisRequest $request)
    {
        $analysis = GaitAnalysis::create($request->validated());

        return new GaitAnalysisResource($analysis);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GaitAnalysis  $gaitAnalysis
     * @return \Illuminate\Http\Response
     */
    public function show(GaitAnalysis $gaitAnalysis)
    {
        return new GaitAnalysisResource($gaitAnalysis);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GaitAnalysis  $gaitAnalysis
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGaitAnalysisRequest $request, GaitAnalysis $gaitAnalysis)
    {
        $gaitAnalysis->update($request->validated());

        return new GaitAnalysisResource($gaitAnalysis);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GaitAnalysis  $gaitAnalysis
     * @return \Illuminate\Http\Response
     */
    public function destroy(GaitAnalysis $gaitAnalysis)
    {
        $gaitAnalysis->delete();

        return response()->json(null, 204);
    }

    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();

        if ($request->has('patient_id')) {
            return new GaitAnalysisCollection($modelClass::where('patient_id', $request->patient_id)->get());
        }

        return new GaitAnalysisCollection($modelClass::all());
    }
}
