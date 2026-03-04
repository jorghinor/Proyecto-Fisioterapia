<?php

namespace App\Http\Controllers;

use App\Models\PostureEvaluation;
use App\Http\Requests\StorePostureEvaluationRequest;
use App\Http\Requests\UpdatePostureEvaluationRequest;
use App\Http\Controllers\Traits\PatientRecordFiltering;
use App\Http\Resources\PostureEvaluationCollection;
use App\Http\Resources\PostureEvaluationResource;
use Illuminate\Http\Request;

class PostureEvaluationController extends Controller
{
    use PatientRecordFiltering;

    protected function getModelClass(): string
    {
        return PostureEvaluation::class;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostureEvaluationRequest $request)
    {
        $postureEvaluation = PostureEvaluation::create($request->validated());

        return new PostureEvaluationResource($postureEvaluation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostureEvaluation  $postureEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(PostureEvaluation $postureEvaluation)
    {
        return new PostureEvaluationResource($postureEvaluation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostureEvaluation  $postureEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostureEvaluationRequest $request, PostureEvaluation $postureEvaluation)
    {
        $postureEvaluation->update($request->validated());

        return new PostureEvaluationResource($postureEvaluation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostureEvaluation  $postureEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostureEvaluation $postureEvaluation)
    {
        $postureEvaluation->delete();

        return response()->json(null, 204);
    }

    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();

        if ($request->has('patient_id')) {
            return new PostureEvaluationCollection($modelClass::where('patient_id', $request->patient_id)->get());
        }

        return new PostureEvaluationCollection($modelClass::all());
    }
}
