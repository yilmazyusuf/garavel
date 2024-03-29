<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 29.01.2020
 */

namespace Garavel\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
Use Throwable;

class GaravelExceptionHandler extends ExceptionHandler {

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


    public function report(Throwable  $exception)
    {
        parent::report($exception);
    }

    function getHttpExceptionView(HttpExceptionInterface $e)
    {
        return "adminlte::errors.{$e->getStatusCode()}";
    }


}
