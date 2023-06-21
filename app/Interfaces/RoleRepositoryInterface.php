<?php

namespace App\Interfaces;

interface RoleRepositoryInterface
{
    public function all();

    public function dataTable();

    public function create($data);

    public function delete($id);

    public function find($id);

    public function findByName($roleName);

    public function getPermissions($id);

    public function getAllPermissions();
}
