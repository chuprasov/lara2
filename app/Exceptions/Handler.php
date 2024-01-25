<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (!app()->isLocal()) {
                if (app()->bound('sentry')) {
                    app('sentry')->captureException($e);
                }
            }
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response('Not found 404');
        });

        $this->renderable(function (\DomainException $e) {
            session()->flash('error', $e->getMessage());

            return session()->previousUrl()
                ? back()
                : redirect(route('home'));
        });
    }
}
