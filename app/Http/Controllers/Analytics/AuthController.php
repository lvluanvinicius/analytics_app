<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda o respositório de usuários.
     *
     * @var \App\Http\Interfaces\UserRepositoryInterface
     */
    protected \App\Http\Interfaces\UserRepositoryInterface $userRepository;

    /**
     * Inicializa o controller.
     *
     * @param \App\Http\Interfaces\UserRepositoryInterface $userRepository
     */
    public function __construct(\App\Http\Interfaces\UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Efetua a autenticação de um usuário e retorna um token.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Recuperando dados da requisição.
            $requestData = $request->only([
                'username',
                'password',
            ]);

            // Recuperando usuário para autenticação.
            $user = $this->userRepository->findByUsername($requestData['username']);

            $user->tokens()->delete(); // Limpa os tokens (caso existam)

            // Validando dados.
            if (!$user || !password_verify($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Credenciais inválidas',
                ], 401);
            }

            // Criando novo token.
            $token = $user->createToken($user->id . ":" . md5(rand(99999, 999999999999999)))->plainTextToken;

            return $this->successResponse([
                'user' => $user,
                'token' => $token,
            ], 'Usuário logado com sucesso.');

        } catch (\App\Exceptions\Analytics\AuthException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

}