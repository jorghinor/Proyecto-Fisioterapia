<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait PatientRecordFiltering
{
    public function index(Request $request)
    {
        $modelClass = $this->getModelClass();

        if ($request->has('patient_id')) {
            return $modelClass::where('patient_id', $request->patient_id)->get();
        }

        return $modelClass::all();
    }

    abstract protected function getModelClass(): string;
}
