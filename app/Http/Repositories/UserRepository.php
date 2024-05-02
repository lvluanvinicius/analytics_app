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
    public function users(string | null $search, int $perPage = 30): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Criando query de consulta.
        $userQuery = $this->user->query();

        // Ordenando valores por data de criação.
        $userQuery->orderBy('created_at', 'desc');

        // Validando valor de search.
        if (!$search) {
            return $userQuery->paginate($perPage);
        }

        // Efetuando filtro de string se houver.
        $userQuery->where(function ($query) use ($search) {
            // dd(!strpos('%', $search));
            // Valida se não há nenhum porcentagem coringa e adiciona.

            if (strpos($search, '%') === false) {
                $search = "%{$search}%";
            }

            // Transformando string em minúsculas.
            $search = strtolower($search);

            // Adicionando filtros.
            $query->orWhereRaw("LOWER(users.name) LIKE ?", [$search])
                ->orWhereRaw("LOWER(users.email) LIKE ?", [$search])
                ->orWhereRaw("LOWER(users.username) LIKE ?", [$search]);
        });

        // Retorna consulta com filtros.
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

        // Validando se o username já está em uso.
        if ($this->validateExists($user->id, 'username', $attr['username'])) {
            throw new UserException('O username informado já está em uso.');
        }

        // Validando se o email já está em uso.
        if ($this->validateExists($user->id, 'email', null, $attr['email'])) {
            throw new UserException('O email informado já está em uso.');
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
