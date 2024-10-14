<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda o respositório de usuários.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @var \App\Http\Interfaces\UserRepositoryInterface
     */
    protected \App\Http\Interfaces\UserRepositoryInterface $userRepository;

    /**
     * Inicializa o controller.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \App\Http\Interfaces\UserRepositoryInterface $userRepository
     */
    public function __construct(\App\Http\Interfaces\UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retorna todos os usuarios com filtros e paginação.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Recuperando dados da requisição.
            $params = $request->only(['search', 'order', 'order_by']);
            $perPage = $request->get('per_page') ?? 20;

            // Recuperando usuários.
            $users = $this->userRepository->users($params, $perPage);

            return $this->successResponse($users, 'Usuários recuperados com sucesso.');
        } catch (\App\Exceptions\Analytics\UserException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Registra um novo usuário.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
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

    /**
     * Atualiza um usuário.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \App\Http\Requests\Analytics\UserUpdateRequest $request
     * @param string $userid
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\App\Http\Requests\Analytics\UserUpdateRequest $request, string $userid): \Illuminate\Http\JsonResponse
    {
        try {
            // Carregando dados do usuário na requisição.
            $user = $this->userRepository->update(
                $request->only(['username', 'password', 'name', 'email']),
                $userid
            );

            return $this->successResponse([
                'user' => $user,
            ], 'Usuário atualizado com sucesso!');
        } catch (\App\Exceptions\Analytics\UserException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Exclui um usuário.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $userid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $userid): \Illuminate\Http\JsonResponse
    {
        try {
            // Valida se o ID de exclusão é o mesmo a quem está efetuando a ação.
            $userid === strval(auth()->user()->id) && throw new \App\Exceptions\Analytics\UserException("Você não pode excluír a si mesmo.");

            // Carregando dados do usuário na requisição.
            $this->userRepository->destroy(
                $userid
            );

            return $this->successMessageResponse('Usuário excluído com sucesso!');
        } catch (\App\Exceptions\Analytics\UserException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}
