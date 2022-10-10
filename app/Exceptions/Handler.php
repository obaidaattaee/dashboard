<?php

namespace App\Exceptions;

use App\Traits\RestExceptionHandlerTrait;
use App\Traits\RestTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use RestTrait;
    use RestExceptionHandlerTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isApiCall($request)) {
            if ($exception instanceof ValidationException) {
                return  $this->sendError(t('validation error'), $exception->errors(), 422);
            } else if ($exception instanceof NotFoundHttpException) {
                return $this->sendError(t('not found'), [], 404);
            } else if ($exception instanceof HttpException) {
                return  $this->sendError(t('you must verify your account'),  ['exception' => get_class($exception), 'message' => $exception->getMessage(), 'details' => $exception], 401);
            } else if ($exception instanceof AuthenticationException) {
                return  $this->sendError(t('your are not authorize'), [], 403);
            } else if ($exception instanceof ModelNotFoundException) {
                return  $this->sendError(t('cannot found you request, please try again later.'), [], 404);
            } else {
                return $this->sendError(t('something went wrong'), ['exception' => get_class($exception), 'message' => $exception->getMessage(), 'details' => $exception], 500);
            }
        }
        return  parent::render($request, $exception);
    }
}
