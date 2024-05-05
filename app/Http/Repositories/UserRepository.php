<?php

namespace App\Http\Repositories;

use App\Exceptions\Analytics\UserException;
use App\Models\User;

class UserRepository implements \App\Http\Interfaces\UserRepositoryInterface

{
    /**
     * Guarda o moelo e usuário.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @var \App\Models\User
     */
    protected \App\Models\User $user;

    /**
     * Inicia o construtor.
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     *
     * @param \App\Models\User $user
     */
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    /**
     * Efetua um fitro dos usuários ou retorna todos em paginação.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $search
     * @param integer $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function users(array $params, int $perPage = 30): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Criando query de consulta.
        $userQuery = $this->user->query();

        // Valida se o search foi informado.
        if (array_key_exists('search', $params)) {

            // Recuperando valor de search.
            $search = $params['search'];

            // Valida se search possui '%' e adiciona se não possuir.
            if (strpos($search, '%') === false) {
                $search = '%' . strtolower($search) . '%';
            }

            // Aplicando filtros.
            $userQuery->where(function ($query) use ($search) {

                $query
                    ->orWhereRaw("LOWER(name) LIKE ?", [$search])
                    ->orWhereRaw("LOWER(email) LIKE ?", [$search])
                    ->orWhereRaw("LOWER(username) LIKE ?", [$search]);
            });
        }

        // Valida se a ordenação foi informada.
        if (array_key_exists('order', $params)) {
            // Valida se a ordenação será por uma coluna específica.
            if (array_key_exists('order_by', $params)) {
                $userQuery->orderBy($params['order_by'], $params['order']);
            } else {
                // Ordena pela data de criação de não for informada outra.
                $userQuery->orderBy('created_at', $params['order']);
            }
        }

        return $userQuery->paginate($perPage);

    }

    /**
     * Encontra um usuário pelo email.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $email O email do usuário a ser encontrado.
     * @return User|null O modelo de usuário encontrado ou null se nenhum for encontrado.
     */
    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    /**
     * Cria um novo usuário com os detalhes fornecidos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param array $attr Os detalhes do usuário para criar, incluindo o username.
     * @return User O modelo de usuário recém-criado.
     */
    public function create(array $attr): User
    {
        // Assegure-se de que a senha seja adequadamente criptografada
        $attr['password'] = \Illuminate\Support\Facades\Hash::make($attr['password']);

        return User::create($attr);
    }

    /**
     * Atualiza um registro e usuário.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param array $attr
     * @param string $userid
     * @return User
     */
    public function update(array $attr, string $userid): User
    {
        // Recuperando usuário para edição.
        $user = $this->user->where('id', $userid)->first();

        // Valida se o registro foi localizado.
        if (!$user) {
            throw new UserException("Usuário não encontrado.");
        }

        // Valida se a senha foi informada.
        if ($attr['password']) {
            // Assegure-se de que a senha seja adequadamente criptografada
            $user->password = \Illuminate\Support\Facades\Hash::make($attr['password']);
        }

        // Atualiza os dados.
        $user->name = $attr['name'];
        $user->username = $attr['username'];
        $user->email = $attr['email'];

        // valida se o usuário foi atualizado corretamente.
        if (!$user->save()) {
            throw new UserException('Erro ao tentar atualizar o usuário.');
        }

        return $user;
    }

    /**
     * Exclui um registro.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $userid
     * @return boolean
     */
    public function destroy(string $userid): bool
    {
        // Recuperando usuário para edição.
        $user = $this->user->where('id', $userid)->first();

        // Valida se o registro foi localizado.
        if (!$user) {
            throw new UserException("Usuário não encontrado.");
        }

        // valida se o usuário foi excluído corretamente.
        if (!$user->delete()) {
            throw new UserException('Erro ao tentar atualizar o usuário.');
        }

        return true;
    }

    /**
     * Valida se o email ou o username já está em uso por outro registro que não seja o atualizado.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $userid
     * @param string $name
     * @param string $name
     * @param string $name
     */
    public function validateExists(string $userid, string $type = 'username', string | null $username = null, string | null $email = null): bool
    {
        if ($type === 'username') {
            if ($this->user->where('username', $username)->where('id', '!=', $userid)->first()) {
                return true;
            }

            return false;
        }

        if ($type === 'email') {
            if ($this->user->where('email', $email)->where('id', '!=', $userid)->first()) {
                return true;
            }

            return false;
        }

        return false;
    }
}
