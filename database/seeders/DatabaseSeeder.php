<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

         //creación de roles de la página administrable
        $role1 = Role::create(['name' => 'administrador']);
        $role2 = Role::create(['name' => 'visitante']);

        Permission::create(['name' =>'admin.home.index'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.usuario.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.usuario.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.usuario.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.usuario.destroy'])->syncRoles([$role1]);

        permission::create(['name' => 'admin.articulo.index'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.articulo.store'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.articulo.update'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.articulo.destroy'])->syncRoles([$role1]);

        permission::create(['name' => 'admin.entrada.index'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.entrada.store'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.entrada.update'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.entrada.destroy'])->syncRoles([$role1]);

        permission::create(['name' => 'admin.salida.index'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.salida.store'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.salida.update'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.salida.destroy'])->syncRoles([$role1]);

        permission::create(['name' => 'admin.persona.index'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.persona.store'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.persona.update'])->syncRoles([$role1]);
        permission::create(['name' => 'admin.persona.destroy'])->syncRoles([$role1]);

        User::factory()->create([
            'name' => 'José Palomino Armona',
            'email' => 'iestplasallealmacen@gmail.com',
            'password' => bcrypt('Almacen100%@')
        ])->assignRole('Administrador');

        User::factory()->create([
            'name' => 'Jairo Gorka Vargas Berrios',
            'email' => 'jairogvb@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('visitante');
    }
}
