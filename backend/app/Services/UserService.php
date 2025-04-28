<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserServiceInterface;
use Spatie\Permission\Models\Permission;

class UserService implements UserServiceInterface
{
    public function getAllUsers(): Collection
    {
        $currentUserId = auth()->user()->id;

        return User::with(['roles', 'permissions'])
                ->where('id', '!=', $currentUserId)
                ->get();
    }

    public function getUserById(int $id): User
    {
        return User::with(['roles', 'permissions'])->findOrFail($id);
    }

    public function createUser(array $data): User
    {
       $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Hash the password
        ]);

        $user->assignRole($data['role']); // Assign role to the user
        
        if($data['role'] == 'admin') {
            $permissions = Permission::pluck('name')->toArray();
            $user->givePermissionTo($permissions);
        }
        return $user;
    }

    public function updateUser(Request $request, int $id): User
    {
        $user = User::findOrFail($id);
        if ($request->has('first_name')) {
            $user->first_name = $request->input('first_name');
        }
        if ($request->has('last_name')) {
            $user->last_name = $request->input('last_name');
        }
        if ($request->has('username')) {
            $user->username = $request->input('username');
        }
        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }
        if ($request->has('address')) {
            $user->address = $request->input('address');
        }
        if ($request->has('postal_code')) {
            $user->postal_code = $request->input('postal_code');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        
        if ($request->has('password')) {
            // Hash the password before saving
            $user->password = Hash::make($request->input('password'));
        }

        // Save the updated user
        $user->save();

        return  User::findOrFail($id);
    }

    public function deleteUser(int $id): bool
    {
        $currentUserId = auth()->user()->id;

        if($id == $currentUserId) {
            return false; // Prevent deletion of the current user
        }   

        return User::destroy($id) > 0;
    }

    public function bulkDeleteUsers(array $ids): void
    {
        $currentUserId = auth()->user()->id;

        $filterIds = array_filter($ids, fn($id) => $id != $currentUserId);

        User::whereIn('id', $filterIds)->delete();
    }
}