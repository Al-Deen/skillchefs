<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function render($request, Throwable $exception)
    {

        if ($request->is('api/*')) {
           Log::info(($request->headers));
            // Handle API errors
            if ($this->isHttpException($exception)) {
                $statusCode = $exception->getStatusCode();
                $errorResponse = [
                    'error' => 'An error occurred',
                ];

                if ($statusCode == 404) {
                    $errorResponse['message'] = 'Not Found';
                } elseif ($statusCode == 403) {
                    $errorResponse['message'] = 'Forbidden';
                } elseif ($statusCode == 405) {
                    $errorResponse['message'] = 'Method Not Allowed';
                } elseif ($statusCode == 500) {
                    $errorResponse['message'] = 'Internal Server Error';
                }

                return response()->json($errorResponse, $statusCode);
            }
        }

        if ($this->isHttpException($exception)) {

            if ($exception->getStatusCode() == 404) {

                return response()->view('errors.404');

            } elseif ($exception->getStatusCode() == 403) {

                return response()->view('errors.403');

            } elseif ($exception->getStatusCode() == 405) {

                return response()->view('errors.405');
            } elseif ($exception->getStatusCode() == 500) {

                return response()->view('errors.500');

            }
        }

        return parent::render($request, $exception);
    }

}
