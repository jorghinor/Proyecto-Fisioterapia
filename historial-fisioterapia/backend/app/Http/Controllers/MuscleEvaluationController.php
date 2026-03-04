<?php

namespace App\Http\Controllers;

use App\Models\MuscleEvaluation;
use App\Http\Requests\StoreMuscleEvaluationRequest;
use App\Http\Requests\UpdateMuscleEvaluationRequest;
use App\Http\Controllers\Traits\PatientRecordFiltering;
use App\Http\Resources\MuscleEvaluationCollection;
use App\Http\Resources\MuscleEvaluationResource;
use Illuminate\Http\Request;

class MuscleEvaluationController extends Controller
{
    use PatientRecordFiltering;

    protected function getModelClass(): string
    {
        return MuscleEvaluation::class;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMuscleEvaluationRequest $request)
    {
        $muscleEvaluation = MuscleEvaluation::create($request->validated());

        return new MuscleEvaluationResource($muscleEvaluation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MuscleEvaluation  $muscleEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(MuscleEvaluation $muscleEvaluation)
    {
        return new MuscleEvaluationResource($muscleEvaluation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MuscleEvaluation  $muscleEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMuscleEvaluationRequest $request, MuscleEvaluation $muscleEvaluation)
    {
        $muscleEvaluation->update($request->validated());

        return new MuscleEvaluationResource($muscleEvaluation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MuscleEvaluation  $muscleEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(MuscleEvaluation $muscleEvaluation)
    {
        $muscleEvaluation->delete();

        return response()->json(null, 204);
    }

    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();

        if ($request->has('patient_id')) {
            return new MuscleEvaluationCollection($modelClass::where('patient_id', $request->patient_id)->get());
        }

        return new MuscleEvaluationCollection($modelClass::all());
    }
}
