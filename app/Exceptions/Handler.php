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

        try {
            $method = $this->getMethod($exception);
            $messageData = $this->$method($exception, $request);
        }
        catch(\Exception $e) {
            $messageData = [
                "clientMessage" => "Opa, parece que algo deu errado",
                "statusCode" => $e->getCode(),
                "errorMessage" => $e->getMessage()
            ];
        }

        return $this->customApiResponse($messageData);
    }

    private function getMethod(Throwable $exception) {
        $class_name = get_class($exception);
        $array_class = explode("\\",$class_name);
        $method = end($array_class);

        return $method;
    }

    public function customApiResponse($messageData) {
        $response = [
            "success" => false,
            "message" => $messageData["clientMessage"],
            "error" => [
                "code" => $messageData["statusCode"],
                "message" => $messageData["errorMessage"]
            ]
        ];

        return response()->json($response, $messageData["statusCode"]);
    }

    public function AuthenticationException(Throwable $exception, $request) {
        $exception = $this->unauthenticated($request, $exception);

        return [
            "clientMessage" => "E-mail ou senha inválido(s)",
            "statusCode" => 401,
            "errorMessage" => "Unauthorized"
        ];
    }

    public function AccessDeniedHttpException(Throwable $exception, $request) {
        return [
            "clientMessage" => "Ação não permitida",
            "statusCode" => 403,
            "errorMessage" => "Forbidden"
        ];
    }

    public function NotFoundHttpException(Throwable $exception, $request) {
        $model = $exception->getPrevious()->getModel();
        $id = $exception->getPrevious()->getIds()[0];

        return [
            "clientMessage" => "{$this->mapModels[$model]} de ID {$id} não existe",
            "statusCode" => 404,
            "errorMessage" => "Not Found"
        ];
    }

    public function MethodNotAllowedHttpException(Throwable $exception, $request) {
        $allow = $exception->getHeaders();

        return [
            "clientMessage" => "Método(s) permitido(s) para essa URL: {$allow['Allow']}",
            "statusCode" => 405,
            "errorMessage" => "Method Not Allowed"
        ];
    }

    public function ValidationException(Throwable $exception, $request) {
        $exception = $this->convertValidationExceptionToResponse($exception, $request);

        return [
            "clientMessage" => $exception['errors'],
            "statusCode" => 422,
            "errorMessage" => "Unprocessable Entity"
        ];
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
