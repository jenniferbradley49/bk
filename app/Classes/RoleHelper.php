<?php
namespace App\Classes;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    var $obj_logged_in_user;
    var $arr_logged_in_user;
    
    public function prepare_logged_in_user_info($obj_logged_in_user)
    {
        return array(
            'user_id' => $obj_logged_in_user->id,
            'first_name' => $obj_logged_in_user->first_name,
            'last_name' => $obj_logged_in_user->last_name,
            'email' => $obj_logged_in_user->email
        );
    }
    
    public function no_authorization()
    {
        //    	return Redirect::to('auth/login')
        //		return back()
        //		->withErrors(array('message' => 'Your login does not have the appropriate privileges to view the intended page'));
        $this->obj_logged_in_user = Auth::user();
        $this->arr_logged_in_user = $this->prepare_logged_in_user_info($this->obj_logged_in_user);
        $data = array('arr_logged_in_user' => $this->arr_logged_in_user);
        return view('auth/no_role')->with('data', $data);
    }
}
