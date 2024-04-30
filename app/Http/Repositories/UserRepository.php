<?php

namespace App\Http\Repositories;

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
}
