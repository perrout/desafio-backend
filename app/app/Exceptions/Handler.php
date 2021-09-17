<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            $response = [
                'status' => false,
                'errors' => 'Record not found.'
            ];
            if ($request->is('api/*')) {
                return response()->json($response, $e->getCode() ?: 404);
            }
        });

        $this->renderable(function (ValidationException $e, $request) {
            $response = [
                'status' => false,
                'code' => $e->getCode() ?: 422,
                'errors' => $e->errors()
            ];
            if ($request->is('api/*')) {
                return response($response, $e->getCode() ?: 422);
            }
        });

        $this->renderable(function (Throwable $e, $request) {
            $response = [
                'status' => false,
                'errors' => $e->getMessage()
            ];
            if ($request->is('api/*')) {
                return response()->json($response, $e->getCode() ?: 400);
            }
        });

    }
}
