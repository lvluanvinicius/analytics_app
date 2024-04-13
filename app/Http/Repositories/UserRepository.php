<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository implements \App\Http\Interfaces\UserRepositoryInterface

{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
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