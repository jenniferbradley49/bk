<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        Role::create(array(
            'name'     => 'client',
           	'cloaked_id' => Hash::make('tpo'.(string)time())
        ));
        // agent is an employee/contractor of a client
        Role::create(array(
            'name'     => 'agent',
           	'cloaked_id' => Hash::make('agt'.(string)time())
        ));
        
        Role::create(array(
            'name'     => 'admin',
           	'cloaked_id' => Hash::make('adm'.(string)time())
        ));
        
    }
}
