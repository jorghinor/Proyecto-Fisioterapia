<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            return response()->json(['message' => 'Resource not found'], 404);
        });

        $this->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            return response()->json(['errors' => $e->errors()], 422);
        });

        $this->renderable(function (\Throwable $e, $request) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        });
    }
}