<?php

namespace App\Interfaces;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function  getAllUsers(): Collection;
    public function getUserById(int $id): User;
    public function createUser(array $data): User;
    public function updateUser(Request $request, int $id): User;
    public function deleteUser(int $id): bool;
    public function bulkDeleteUsers(array $ids): void;
}