<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function createUser($request);

    public function createWebUser($request);

    public function findUserByEmail($email);

    public function findUserById($id);

    public function updateUser($id, $data);

    public function logout($id);

    public function getUserData();

    public function delete($id);

    public function all();
}
