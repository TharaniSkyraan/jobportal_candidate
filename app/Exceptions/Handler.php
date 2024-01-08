<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    // ...

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->jsonResponse($request, $exception);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    private function jsonResponse($request, AuthenticationException $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json([
                'error' => 'Unauthenticated',
                'message' => 'You are not authenticated.'
            ], 401);
        }

        return response()->json([
            'error' => 'Unauthenticated',
            'message' => $exception->getMessage(),
            'data' => []
        ], 401);
    }

    // ...
}
