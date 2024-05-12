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
     * Efetua o login do usuário.
     *
     * @author Luan VP Santos <lvluansantos@gmail.com>
     *
     * @param \App\Http\Requests\Admin\SignInRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signIn(\App\Http\Requests\Admin\SignInRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Autenticando o  usuário.
            if (\Illuminate\Support\Facades\Auth::attempt([
                'username' => $request->username,
                'password' => $request->password,
            ], $request->filled('remember'))) {

                $request->session()->regenerate();

                return $this->successResponse([
                    'user' => null,
                    'token' => \Illuminate\Support\Facades\Auth::user(),
                ], "Usuário autenticado com sucesso.");
            }

            throw new \Exception('Usuário e/ou sernha estão incorretos.');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Valida se um login está ativo.
     *
     * @author Luan VP Santos <lvluansantos@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validate(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successMessageResponse("Validação concluída.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Efetua o logout de um usuário.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOut(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Limpa a sessão do usuário.
            $request->session()->invalidate();

            // Regenera o token da sessão para evitar ataques CSRF.
            $request->session()->regenerateToken();

            return $this->successMessageResponse("Validação concluída.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
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

            // Valida se o usuário foi localizado.
            if (!$user) {
                throw new \App\Exceptions\Analytics\AuthException("Usuário e/ou senha estão incorretos.");
            }

            $user->tokens()->delete(); // Limpa os tokens (caso existam)

            // Validando dados.
            if (!$user || !password_verify($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Usuário e/ou senha estão incorretos.',
                ], 200);
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
