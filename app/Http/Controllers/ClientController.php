<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Client;
//use App\Models\Role;
use App\Models\Role_user;
//use App\Models\CloakedClientId;
use App\Models\PublicPage;
//use Hash;
//use Redirect;
//use DB;
use Illuminate\Support\Facades\Auth;
use App\Classes\RoleHelper;
use App\Classes\CommonCode;

class ClientController extends Controller
{
    var $obj_logged_in_user;
    var $arr_logged_in_user;
    var $bool_has_role;
    var $roleHelper;
    var $cloakedClientId;
   
    
    public function __construct(
        Role_user $role_user,
        User $user,
        Client $client,
        RoleHelper $roleHelper)
    {     
        $this->middleware('auth');
        if (Auth::check())
        {
            //			$objClient = $user
            //			->where('id', Auth::user()->id)
            //		->first()->client()->first();
            //			$this->cloakedClientId = $objClient->cloaked_client_id;
            $this->middleware('role:client');
            //			$this->obj_logged_in_user = Auth::user();
            $this->arr_logged_in_user = $client->getClientInfo(Auth::user()->id, Auth::user()->email);
            $this->cloakedClientId = $this->arr_logged_in_user['cloaked_client_id'];
        }  // end if Auth::check()
    } // end __construct function
    
    
    public function index(Client $client, PublicPage $publicPages)
    {
        $dataClient = $client->getDataArrayGetIndex(
            $this->arr_logged_in_user);
        $page_heading_content = "Client Dashboard";
        $dataPublic = $publicPages->getDataArrayGetPublicPage($page_heading_content);
        $data = array_merge($dataClient, $dataPublic);
        return view('client/dashboard')->with('data', $data);
    }
    
    public function getEditUser(
        Client $client,
        User $user,
        PublicPage $publicPage
        )
    {
        $dataClient = $client->getDataArrayGetEditUser(
            $this->arr_logged_in_user);
        $page_heading_content = "Edit your profile";
        $dataPublic = $publicPage->getDataArrayGetPublicPage($page_heading_content);
        $data = array_merge($dataClient, $dataPublic);
        return view('client/edit_user')->with('data', $data);
    }
    
    
    public function postEditUser(
        Request $request,
        User $user,
        Client $client,
        CommonCode $cCode,
        PublicPage $publicPage)
    {
        //   	$bool_include_password = $cCode->setCheckboxVar($request->include_password);
        //   	$bool_include_email = $cCode->setCheckboxVar($request->include_email);
        
        $validation_rules = $client->getValidationRulesEditUser();
        //   	$validation_messages = $client->getValidationMessagesEditUser();
        $this->validate($request, $validation_rules);
        
        $arr_request = $client->getRequestArrayEditUser($request);
        $user = $user->find(Auth::user()->id);
        //    	$user = $cCode->getObject($arr_request, $user);
        //    	$user->first_name = $arr_request->first_name;
        //    	$user->last_name = $arr_request->last_name;
        //   	$user->company = $arr_request->company;
        //    	$arr_request = array();
        //   	// transfer to new array, so as not to propagate teh password
        //    	$arr_request['first_name'] = $request->first_name;
        //    	$arr_request['last_name'] = $request->last_name;
        //    	$arr_request['company'] = $request->company;
        
        //		$user->email = $arr_request['email'];
        //		$user->password = $arr_request['password'];
        //		$user->name = '';
        //		$user->save();
        $client = $user->client;
        //   	$client->cloaked_client_id = $client->getNewCloakedClientId($user->id);
        //    	$client->user_id = $user->id;
        $client->first_name = $arr_request['first_name'];
        $client->last_name = $arr_request['last_name'];
        $client->company = $arr_request['company'];
        $client->client_url = $arr_request['client_url'];
        $client ->save();
        //    	$user_id = $user->id;
        
        $dataClient = $client->getDataArrayPostEditUser(
            $arr_request, $user->id,
            //    			$this->cloakedClientId,
            $this->arr_logged_in_user
            //    			$partialDirector->getNavbarRightClient()
            );
        $page_heading_content = "Edit your profile - results";
        $dataPublic = $publicPages->getDataArrayGetPublicPage($page_heading_content);
        $data = array_merge($dataClient, $dataPublic);
        
        return view('client/edit_user_results')->with('data', $data);
    }
    
}
