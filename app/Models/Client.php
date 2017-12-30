<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function getValidationRulesEditUser()
    {
        return array(
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'company' => 'required|max:50',
            'client_url' => 'required'
        );
    }
    
    
    public function getRequestArrayEditUser($request)
    {
        return array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company'    => $request->company,
            'client_url'    => $request->client_url
        );
    }
    
    
    public function getDataArrayGetEditUser($arr_logged_in_user)
    {
        return array(
            'input_old' =>array(
                'first_name' => Input::old('first_name', $arr_logged_in_user['first_name']),
                'last_name' => Input::old('last_name', $arr_logged_in_user['last_name']),
                'company' => Input::old('company', $arr_logged_in_user['company']),
                'client_url' => Input::old('client_url', $arr_logged_in_user['client_url']),
            ),
            //				'cloaked_client_id' => $cloaked_client_id,
            'arr_logged_in_user' => $arr_logged_in_user
            //			'navbar_right' => $navbar_right
        );
    }
    
    
    public function getDataArrayGetIndex($arr_logged_in_user)
    {
        return array(
            'arr_logged_in_user' => $arr_logged_in_user
            //				'navbar_right' => $navbar_right
        );
    }
    
    
    public function getDataArrayPostEditUser(
        $arr_request, $user_id,
        //			$cloaked_client_id,
        $arr_logged_in_user
        //			$navbar_right
        )
    {
        return array(
            'arr_request' => $arr_request,
            'user_id' => $user_id,
            //				'cloaked_client_id' => $cloaked_client_id,
            'arr_logged_in_user' => $arr_logged_in_user
            //				'navbar_right' => $navbar_right
        );
    }
    
    
    public function getNewCloakedClientId()
    {
        // check database for pre-existing instance of this ID
        $objClient = "dummy val";
        while ($objClient != null)
        {
            $new_cloaked_client_id = str_random(10);
            $objClient = $this->getObjClient($new_cloaked_client_id);
            //			->where('cloaked_client_id', $new_cloaked_client_id)
            //			->first();
        }
        return $new_cloaked_client_id;
    }
    
    public function clientIdIsNotValid($cloaked_client_id)
    {
        $objClient = $this->getObjClient($cloaked_client_id);
        return ($objClient == null);
    }
    //
    //	public function getUserID($cloaked_client_id)
    //	{
    //		$objClient = $this->getObjClient($cloaked_client_id);
    //		return $objClient->user_id;
    //	}
    
    //	public function getObjByCloakedId($cloaked_client_id)
    //	{
    //		return $this
    //		->where('cloaked_client_id', $cloaked_client_id)
    //		->first();
    //	}
    
    public function getClientInfo($user_id, $email)
    {
        $objClient = $this
        ->where('user_id', $user_id)
        ->first();
        
        if ($objClient != null)
        {
            return array(
                'email'		=> $email,
                'last_name' => $objClient->last_name,
                'first_name' => $objClient->first_name,
                'company' => $objClient->company,
                'client_url' => $objClient->client_url,
                'cloaked_client_id'	=>$objClient->cloaked_client_id
            );
        }
        else
        {
            return array();
        }
        
    }
    
    
    
    public function getObjClient($cloaked_client_id)
    {
        //		echo "client model,line 82, cloaked client id = $cloaked_client_id<br>";
        return $this
        ->where('cloaked_client_id', $cloaked_client_id)
        ->first();
    }
    
    
    }
    