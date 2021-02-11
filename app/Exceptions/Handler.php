<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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


    private $mapModels = [
        "App\Models\Category" => "Categoria",
        "App\Models\User" => "Usuário",
        "App\Models\Recipe" => "Receita",
        "App\Models\Ingredient" => "Ingrediente",
        "App\Models\Profile" => "Perfil"
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
        if($request->wantsJson()) {
            return $this->handleApiException($request, $exception);
        }
        return parent::render($request, $exception);
    }

    public function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);
        if (config('app.debug')) {
            return parent::render($request, $exception);            
        }

        $clientMessage = "Opa, parece que algo deu errado";
        $statusCode = 500;

        if ($exception instanceof MethodNotAllowedHttpException) {
            $allow = $exception->getHeaders();
            $clientMessage = "Método(s) permitido(s) para essa URL: {$allow['Allow']}";
            $statusCode = 405;
        }

        if ($exception instanceof NotFoundHttpException) {
            $model = $exception->getPrevious()->getModel();
            $id = $exception->getPrevious()->getIds()[0];
            $clientMessage = "{$this->mapModels[$model]} de ID {$id} não existe";
            $statusCode = 404;
        }
    
        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
            $clientMessage = "E-mail ou senha inválido(s)";
            $statusCode = 401;
        }

        if ($exception instanceof AccessDeniedHttpException) {
            $clientMessage = "Ação não permitida";
            $statusCode = 403;
        }
    
        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
            $clientMessage = $exception['errors'];
            $statusCode = 422;
        }

        return $this->customApiResponse($clientMessage, $statusCode);
    }

    public function customApiResponse($clientMessage, $statusCode) {
        $response = [
            "success" => false,
            "message" => $clientMessage,
            "error" => [
                "code" => $statusCode,
                "message" => ""
            ]
        ];

        switch ($statusCode) {
            case 401:
                $response['error']['message'] = 'Unauthorized';
                break;
            case 403:
                $response['error']['message'] = 'Forbidden';
                break;
            case 404:
                $response['error']['message'] = 'Not Found';
                break;
            case 405:
                $response['error']['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['error']['message'] = 'Unprocessable Entity';
                break;
            default:
                $response['error']['message'] = ($statusCode == 500) ? 'Internal Server Error' : 'Whoops, looks like something went wrong';
                break;
        }
    

        return response()->json($response, $statusCode);
    }

    //OVERWRITE INVALID JSON
    protected function invalidJson($request, ValidationException $exception)
    {
        return [
            'message' => $exception->getMessage(),
            'errors' => $exception->errors(),
        ];
    }
}
