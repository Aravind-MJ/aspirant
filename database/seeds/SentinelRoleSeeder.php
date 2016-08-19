<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentinelRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Users',
            'slug' => 'users',
        ]);

        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admins',
            'slug' => 'admins',
        ]);
        
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'SuperAdmin',
            'slug' => 'superadmin',
        ]);
        
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Faculty',
            'slug' => 'faculty',
        ]);

        $this->command->info('Roles seeded!');
    }
}
