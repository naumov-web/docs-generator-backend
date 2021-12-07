<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class RolesSeeder
 * @package Database\Seeders
 */
final class RolesSeeder extends Seeder
{
    /**
     * Seed roles
     *
     * @return void
     */
    public function run()
    {
        $roles = config('defaults.roles');

        foreach ($roles as $role) {
            $role_model = Role::query()
                ->where('system_name', $role['system_name'])
                ->first();

            if ($role_model) {
                $role_model->update($role);
            } else {
                Role::query()->create($role);
            }
        }
    }
}
