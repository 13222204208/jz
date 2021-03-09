<?php

namespace App\Exceptions;

use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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

        /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception->getPrevious() instanceof TokenExpiredException) {
            return response()->json(['msg' => '过期的token','code'=>-1]);
        } else if ($exception->getPrevious() instanceof TokenInvalidException) {
            return response()->json(['msg' => '错误的token','code'=>-1]);
        } /* else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
            return response()->json(['error' => '列入黑名单']);
        } */

        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(['msg' => '没有提供token，请登陆获取','code'=>-1]);
        }

        if ($this->isHttpException($exception)) {
            //return $this->toIlluminateResponse($this->renderHttpException($e), $e);
            return response()->json(['msg' => '请求地址错误','code'=>0]);
        } 

        return parent::render($request, $exception);
    }
}
