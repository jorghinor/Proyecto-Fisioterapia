<?php

namespace App\Http\Controllers;

use App\Models\FunctionalAssessment;
use App\Http\Requests\StoreFunctionalAssessmentRequest;
use App\Http\Requests\UpdateFunctionalAssessmentRequest;
use App\Http\Controllers\Traits\PatientRecordFiltering;
use App\Http\Resources\FunctionalAssessmentCollection;
use App\Http\Resources\FunctionalAssessmentResource;
use Illuminate\Http\Request;

class FunctionalAssessmentController extends Controller
{
    use PatientRecordFiltering;

    protected function getModelClass(): string
    {
        return FunctionalAssessment::class;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFunctionalAssessmentRequest $request)
    {
        $assessment = FunctionalAssessment::create($request->validated());

        return new FunctionalAssessmentResource($assessment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FunctionalAssessment  $functionalAssessment
     * @return \Illuminate\Http\Response
     */
    public function show(FunctionalAssessment $functionalAssessment)
    {
        return new FunctionalAssessmentResource($functionalAssessment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FunctionalAssessment  $functionalAssessment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFunctionalAssessmentRequest $request, FunctionalAssessment $functionalAssessment)
    {
        $functionalAssessment->update($request->validated());

        return new FunctionalAssessmentResource($functionalAssessment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FunctionalAssessment  $functionalAssessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(FunctionalAssessment $functionalAssessment)
    {
        $functionalAssessment->delete();

        return response()->json(null, 204);
    }

    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();

        if ($request->has('patient_id')) {
            return new FunctionalAssessmentCollection($modelClass::where('patient_id', $request->patient_id)->get());
        }

        return new FunctionalAssessmentCollection($modelClass::all());
    }
}
