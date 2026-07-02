<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        // 🔥 HANDLE MODEL NOT FOUND
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Data tidak ditemukan',
                    'error' => true
                ], 404);
            }

            return back()->with('error', 'Data tidak ditemukan');
        });

        // 🔥 HANDLE VALIDATION EXCEPTION
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors(),
                    'error' => true
                ], 422);
            }

            return back()->withErrors($e->errors());
        });
    }
}

