<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Memulai seeding...\n";

        $default_user_value = [
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]; 

        DB::beginTransaction();
        try {
            echo "Membuat users...\n";
            $admin = User::create(array_merge([
                'email' => 'admin@gmail.com',
                'name' => 'admin',
            ], $default_user_value));
    
            $perusahaan = User::create(array_merge([
                'email' => 'perusahaan@gmail.com',
                'name' => 'perusahaan',
                'password' => Hash::make('perusahaan')
            ], $default_user_value));
    
            $pencarikerja = User::create(array_merge([
                'email' => 'pencarikerja@gmail.com',
                'name' => 'pencarikerja',
                'password' => Hash::make('pencarikerja')
            ], $default_user_value));
    
            echo "Membuat roles...\n";
            $role_admin = Role::create(['name' => 'admin']);
            $role_perusahaan = Role::create(['name' => 'perusahaan']);
            $role_pencarikerja = Role::create(['name' => 'pencarikerja']);
    
            echo "Membuat permissions...\n";
            Permission::create(['name' => 'read role']);
            Permission::create(['name' => 'create role']);
            Permission::create(['name' => 'update role']);
            Permission::create(['name' => 'delete role']);
    
            echo "Assigning roles...\n";
            $admin->assignRole('admin');
            $perusahaan->assignRole('perusahaan');
            $pencarikerja->assignRole('pencarikerja');
            
            DB::commit();
            echo "Seeder selesai dengan sukses!\n";
        } catch (\Throwable $th) {
            DB::rollback();
            echo "Seeder gagal: " . $th->getMessage() . "\n";
        }
    }
}
