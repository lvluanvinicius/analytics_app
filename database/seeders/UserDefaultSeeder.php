<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email'    => 'admin@grupocednet.com.br',
            'password' => Hash::make('password'),
            'name'     => 'Administrador Padrão',
        ]);
    }
}
