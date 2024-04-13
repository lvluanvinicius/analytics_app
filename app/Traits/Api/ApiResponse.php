<?php

namespace App\Traits\Api;

trait ApiResponse
{
    /**
     * Envia uma resposta de sucesso.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, string $message = null, int $code = \Illuminate\Http\Response::HTTP_OK): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Envia uma resposta de sucesso apenas com a mensagem de feedback.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successMessageResponse(string $message, int $code = \Illuminate\Http\Response::HTTP_OK): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => $message,
        ], $code);
    }

    /**
     * Envia uma resposta de erro.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string|null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message = null, int $code, bool $noAuth = false): \Illuminate\Http\JsonResponse
    {
        $data = [
            'status' => false,
            'type' => 'error',
            'message' => $message,
        ];

        $noAuth && $data['logged'] = false;

        return response()->json($data, $code);
    }

    /**
     * Envia uma resposta para requisição inválida.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidRequestResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, \Illuminate\Http\Response::HTTP_BAD_REQUEST);
    }

    /**
     * Envia uma resposta para recurso não encontrado.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFoundResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, \Illuminate\Http\Response::HTTP_NOT_FOUND);
    }

    /**
     * Envia uma resposta para recurso criado com sucesso.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param mixed $data
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createdResponse($data, string $message = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => $message,
            'data' => $data,
        ], \Illuminate\Http\Response::HTTP_CREATED);
    }

    /**
     * Envia uma resposta para um conflito de recursos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function conflictResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, \Illuminate\Http\Response::HTTP_CONFLICT);
    }

    /**
     * Envia uma resposta para acesso negado ou permissões insuficientes.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbiddenResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, \Illuminate\Http\Response::HTTP_FORBIDDEN);
    }

    /**
     * Envia uma resposta de não autehnticado com erro 401.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticatedResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, \Illuminate\Http\Response::HTTP_UNAUTHORIZED, true);
    }

    /**
     * Envia uma resposta para erro interno do servidor.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function internalErrorResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse($message, \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Envia uma resposta para requisição aceita mas ainda não concluída.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function acceptedResponse(string $message = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => $message,
        ], \Illuminate\Http\Response::HTTP_ACCEPTED);
    }

    /**
     * Envia uma resposta sem conteúdo (por exemplo, após uma exclusão bem-sucedida).
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function noContentResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json(null, \Illuminate\Http\Response::HTTP_NO_CONTENT);
    }

    /**
     * Gera uma resposta JSON de erro.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param array $errors
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponseError($errors, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'type' => 'error',
            'errors' => $errors,
        ], $code);
    }

    /**
     * Retorna erro customizados com códigos de erros do sistema.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function withErrors(array $errors = [], string $message = "", int $code = 200, array $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'type' => 'error',
            'message' => 'Informe os dados corretamente.',
            'errors' => $errors,
            'data' => $data,
        ], $code);
    }
}