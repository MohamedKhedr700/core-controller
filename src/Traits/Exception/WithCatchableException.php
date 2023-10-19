<?php

namespace Raid\Core\Controller\Traits\Exception;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait WithCatchableException
{
    /**
     * Render an exception into an HTTP response.
     *
     * @throws Exception|Throwable
     */
    public function renderException($request, Throwable $e): JsonResponse
    {
        $exceptionError = $this->catchException($e);

        if (! $exceptionError) {
            return parent::render($request, $e);
        }

        return response()->json([
            'error' => true,
            'message' => $exceptionError['message'],
            'code' => $exceptionError['code'],
            'trace' => $exceptionError['trace'] ?? [],
        ], $exceptionError['code']);
    }

    /**
     * Catch exception.
     */
    private function catchException(Throwable $exception): ?array
    {
        switch (true) {
            case $exception instanceof PostTooLargeException:
                $error['message'] = trans('messages.exception.413');
                $error['code'] = 413;

                break;
            case $exception instanceof AuthenticationException:
                $error['message'] = trans('messages.exception.401');
                $error['code'] = 401;

                break;
            case $exception instanceof NotFoundHttpException:
                $error['message'] = trans('messages.exception.404_not_found_route');
                $error['code'] = 404;

                break;
            case $exception instanceof AuthorizationException:
            case $exception instanceof HttpException:
                $error['message'] = trans('messages.exception.403');
                $error['code'] = 403;

                break;
            case $exception instanceof ModelNotFoundException:
                $error['message'] = trans('messages.exception.404');
                $error['code'] = 404;

                break;
            default:
                $code = $exception->getCode();

                $code = $code === 0 ? 422 : $code;

                $error['message'] = $exception->getMessage();
                $error['code'] = $code;
                $error['trace'] = $exception->getTrace();
        }

        return $error;
    }
}