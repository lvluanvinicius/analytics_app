<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;

class UserController extends Controller
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
     * Registra um novo usuário.
     *
     * @param \App\Http\Requests\Analytics\UserRegisterRequest $request A request validada para registrar um usuário.
     * @return \Illuminate\Http\JsonResponse Uma resposta JSON contendo os dados do usuário e um token.
     */
    public function register(\App\Http\Requests\Analytics\UserRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Carregando dados do usuário na requisição.
            $user = $this->userRepository->create($request->only(['username', 'password', 'name', 'email']));

            // Criando token de autenticação.
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->successResponse([
                'user' => $user,
                'token' => $token,
            ], 'Usuário registrado com sucesso!');
        } catch (\App\Exceptions\Analytics\UserException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}