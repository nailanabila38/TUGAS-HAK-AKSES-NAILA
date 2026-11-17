<?php

namespace Database\Seeders;

use App\Models\HakAkses;
use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AksesSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['nama' => 'admin']);
        $petugas = Role::create(['nama' => 'petugas']);

        $ruangan = Module::create(['nama' => 'Ruangan', 'slug' => 'ruangan']);

        HakAkses::create([
            'role_id' => $admin->id, 'module_id' => $ruangan->id,
            'can_view' => true, 'can_create' => true,
            'can_edit' => true, 'can_delete' => true,
        ]);

        HakAkses::create([
            'role_id' => $petugas->id, 'module_id' => $ruangan->id,
            'can_view' => true, 'can_create' => true,
        ]);

        User::create([
            'name' => 'Admin', 'email' => 'admin@test.com',
            'password' => bcrypt('password'), 'role_id' => $admin->id,
        ]);

        User::create([
            'name' => 'Petugas', 'email' => 'petugas@test.com',
            'password' => bcrypt('password'), 'role_id' => $petugas->id,
        ]);
    }
}