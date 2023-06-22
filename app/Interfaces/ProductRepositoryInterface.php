<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function all();

    public function dataTable();

    public function create($data);

    public function delete($id);

    public function find($id);

    public function bulkAction($data);
}
