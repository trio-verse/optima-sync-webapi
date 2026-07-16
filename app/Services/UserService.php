<?php


namespace App\Services;

use App\Models\User;

class UserService
{
   
    public function findOrFail(string $email): User|bool
    {
        $user = User::where('email', $email)->first();
        return $user ? $user : false;
    }

    public function createUser(array $data): User
    {
        if (!isset($data['name']) || $data['name'] == null || $data['name'] == '') {
            $data['name'] = explode('@', $data['email'])[0];
        }
        $data['email_verified_at'] = now();

        return User::create($data);
    }
}
