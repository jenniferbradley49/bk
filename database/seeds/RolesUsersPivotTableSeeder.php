<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role_user;
use App\Models\Role;
use App\User;


class RolesUsersPivotTableSeeder extends Seeder
{
    var $role;
    var $user;
    
    public function __construct(
        Role $role,
        User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->delete();
        
        $obj_user = $this->user
        ->where('email', 'bittids@gmail.com')
        ->first();   
  // create admin      
        $obj_role = $this->role
        ->where('name', 'admin')
        ->first();
        
        Role_user::create(array(
            'role_id'     => $obj_role->id,
            'user_id' => $obj_user->id
        ));
        
 // create client       
        $obj_role = $this->role
        ->where('name', 'client')
        ->first();
        
        Role_user::create(array(
            'role_id'     => $obj_role->id,
            'user_id' => $obj_user->id
        ));
        
        
        // create agent (client employee)
        $obj_role = $this->role
        ->where('name', 'agent')
        ->first();
        
        Role_user::create(array(
            'role_id'     => $obj_role->id,
            'user_id' => $obj_user->id
        ));
        
        
    }
    

}
