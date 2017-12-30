<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Auth;
//use Hash;

class Admin extends Model
{
    // organization
    // 1. get validation, alphabetical
    // 2. get validation messges
    // 3. get request array
    // 4. get data array
    // 5. get data array for get functions
    // 6. unclassified
    
    public function getValidationRules()
    {
        return array(
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|confirmed|max:50|min:6'
        );
    }
    
    
    public function getValidationRulesAddClient()
    {
        return array(
            'client_user_id' => 'integer|exists:users,id',
            'str_email_two' => 'email|max:60',
            'str_website' => 'required|url|max:60',
            'str_first_name' => 'required|max:40',
            'str_last_name' => 'required|max:40',
            'str_telephone_one' => 'required|max:20',
            'str_telephone_two' => 'max:20',
            'str_company' => 'max:40',
            'str_city' => 'required|max:40',
            'str_zip' => 'required|max:15',
            'int_state_id' => 'required|integer|exists:states,id',
            'bool_active' => 'integer|min:0|max:1',
            'bool_confirmed' => 'integer|min:0|max:1'
            
        );
    }

    
    
    
    public function getValidationRulesAddRole()
    {
        return array(
            'user_id' => 'required|integer|min:1',
            'role_id' => 'required|integer|min:1',
        );
    }
    
  
    
    
    public function getValidationRulesChooseClient()
    {
        return array(
            'client_id' => 'required|integer|exists:clients,user_id'
        );
    }
    
   
    
    public function getValidationRulesChooseUser()
    {
        return array(
            'client_user_id' => 'required|integer|exists:users,id'
        );
    }
    
    
    
    
    public function getValidationRulesEditUser()
    {
        return array(
            'user_id' => 'required|integer|min:1',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50'
            //    		'company' => 'required|max:50'
        );
    }
    
    
    public function getValidationMessagesEditUser()
    {
        return array(
            'user_id.min' => 'Please choose a user in the drop down box.  The current choice of &quot;Please choose a user&quot; is not acceptable.',
        );
    }
    
    
    public function getValidationRulesTestClient()
    {
        return array(
            'str_lead_destination_tested' => 'url|max:60',
            'int_client_id' => 'required|integer|exists:clients,id',
            'str_test_id' => 'required|max:40'
            
            //    			'' => 'required|url',
            
            
        );
    }
    
    
    
    public function getRequestArray($request)
    {
        return array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            //    		'company' => $request->company,
            'email'    => $request->email,
            'password' => \Hash::make($request->password)
        );
    }
    
    
     public function getRequestArrayAddClient($request)
     {
     //    echo "in admin, getRequestArrayAddClient, client_user_id = $request->client_user_id";
     //echo "<br>";
     return array(
     'client_user_id' => $request->client_user_id,
     'survey_project_id' => $request->int_survey_project_id,
     'str_email_two' => $request->str_email_two,
     'str_website' => $request->str_website,
     'str_first_name' => $request->str_first_name,
     'str_last_name' => $request->str_last_name,
     'str_telephone_one' => $request->str_telephone_one,
     'str_telephone_two' => $request->str_telephone_two,
     'str_company' => $request->str_company,
     'str_city' => $request->str_city,
     'str_zip' => $request->str_zip,
     'int_state_id' => $request->int_state_id,
     'bool_active' => (is_null($request->bool_active))?0:(int)$request->bool_active,
     'bool_confirmed' => (is_null($request->bool_confirmed))?0:(int)$request->bool_confirmed,
     );
     }
     

    
    
    
    public function getRequestArrayAddRole($request)
    {
        return array(
            'user_id'	=> $request->user_id,
            'role_id' 	=> $request->role_id
        );
    }
    
    
    
    public function getDataArray(
        $arr_request, $user_id,
        $arr_logged_in_user)
    {
        return array(
            'arr_request' => $arr_request,
            'user_id' => $user_id,
            'arr_logged_in_user' => $arr_logged_in_user
        );
    }
    
    
    public function getDataArrayAddClient(
        $str_cloaked_client_id,
        $arr_request,
        $arr_logged_in_user)
    {
        return array(
            'str_cloaked_client_id' => $str_cloaked_client_id,
            'arr_request' => $arr_request,
            'arr_logged_in_user' => $arr_logged_in_user
        );
    }
    
    
    public function getDataArrayEmailRegAdmin(
        $page_heading_content,
        $int_registration_id,
        $arr_logged_in_user)
    {
        
        return array(
            'int_registration_id' => $int_registration_id,
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user
        );
    }
    
    
   
    
    public function getDataArrayGetAddClient(
        $arr_states,
        $arr_projects,
        $obj_user,
        $client_user_id,
        $arr_logged_in_user)
    {
        //   	echo "in admin, getDataArrayGetAddClient, client_user_id = $client_user_id";
        //   	echo "<br>";
        
        return array(
            'client_user_id' => $client_user_id,
            'arr_logged_in_user' => $arr_logged_in_user,
            'arr_states' => $arr_states,
            'arr_projects' => $arr_projects,
            'input_old' =>array(
                'str_company' => Input::old('str_company'),
                'str_email_two' => Input::old('str_email_two'),
                'str_telephone' => Input::old('str_telephone'),
                //   					'str_telephone_two' => Input::old('str_telephone_two'),
                'str_website' => Input::old('str_website'),
                'str_first_name' => Input::old('str_first_name', $obj_user->first_name),
                'str_last_name' => Input::old('str_last_name', $obj_user->last_name),
                'str_city' => Input::old('str_city'),
                'str_zip' => Input::old('str_zip'),
                'int_state_id' => Input::old('int_state_id'),
                'bool_active' => Input::old('bool_active'),
                'bool_confirmed' => Input::old('bool_confirmed'),
                
                
            )
            
        );
        
    }
    
    
    public function getDataArrayGetAddRole(
        $arr_users_processed, $page_heading_content, $arr_logged_in_user)
    {
        return array(
            'arr_users' => $arr_users_processed,
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user,
            'input_old' =>array(
                'user_id' => Input::old('user_id', 0)
            )
            
        );
    }
    
   
    
    public function getDataArrayGetAddUserAdmin(
        $arr_logged_in_user)
    {
        return array(
            'arr_logged_in_user' => $arr_logged_in_user,
            'input_old' =>array(
                'first_name' => Input::old('first_name'),
                'last_name' => Input::old('last_name'),
                //   					'company' => Input::old('company'),
                'email' => Input::old('email'),
            )
            
        );
    }
    
    
    public function getDataArrayGetChooseClient(
        $page_heading_content,
        $arr_clients,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_clients' => $arr_clients,
            'arr_logged_in_user' => $arr_logged_in_user,
            'input_old' =>array(
                'id' => Input::old('id', 0)
            )
            
            
        );
        
    }
    
    
  
    
    public function getDataArrayGetClientExists(
        $client_user_id, $arr_logged_in_user)
    {
        return array(
            'arr_logged_in_user' => $arr_logged_in_user,
            'client_user_id' => $client_user_id,
        );
        
    }
    
    
    public function getDataArrayGetEditClient(
        $page_heading_content,
        $arr_states,
        $obj_client,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_states' => $arr_states,
            'arr_logged_in_user' => $arr_logged_in_user,
            'input_old' =>array(
                'str_company' => Input::old('str_company', $obj_client->str_company),
                'str_email_two' => Input::old('str_email_two', $obj_client->str_email_two),
                'str_telephone_one' => Input::old('str_telephone_one', $obj_client->str_telephone_one),
                'str_telephone_two' => Input::old('str_telephone_two', $obj_client->str_telephone_two),
                'str_website' => Input::old('str_website', $obj_client->str_website),
                'str_first_name' => Input::old('str_first_name', $obj_client->str_first_name),
                'str_last_name' => Input::old('str_last_name', $obj_client->str_last_name),
                'str_city' => Input::old('str_city', $obj_client->str_city),
                'str_zip' => Input::old('str_zip', $obj_client->str_zip),
                'int_state_id' => Input::old('int_state_id', $obj_client->int_state_id),
                'bool_active' => Input::old('bool_active', $obj_client->bool_active),
                'bool_confirmed' => Input::old('bool_confirmed', $obj_client->bool_confirmed)
            )
        );
        
    }
    
    
    
    public function getDataArrayGetEditUser(
        $page_heading_content, $arr_users_processed, $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_users' => $arr_users_processed,
            'arr_logged_in_user' => $arr_logged_in_user,
            'input_old' =>array(
                'user_id' => Input::old('user_id', 0),
                'first_name' => Input::old('first_name', ''),
                'last_name' => Input::old('last_name', ''),
                'company' => Input::old('company'),
                'include_email' => Input::old('include_email', 0),
                'email' => Input::old('email', ''),
                'include_password' => Input::old('include_password', 0),
            )
            
        );
    }
    
    
    
    public function getDataArrayGetNoClient(
        $page_heading_content,
        $client_user_id,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'client_user_id' => $client_user_id,
            'arr_logged_in_user' => $arr_logged_in_user
        );
        
    }
    
    public function getDataArrayGetNoContacts(
        $page_heading_content,
        //    		$client_user_id,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            //    			'client_user_id' => $client_user_id,
            'arr_logged_in_user' => $arr_logged_in_user
        );
        
    }
    
    
    public function getDataArrayGetNoRegistrations(
        $page_heading_content,
        //    		$client_user_id,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            //    			'client_user_id' => $client_user_id,
            'arr_logged_in_user' => $arr_logged_in_user
        );
        
    }
    
    
    public function getDataArrayGetNoVisitors(
        $page_heading_content,
        //   		$client_user_id,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            //   			'client_user_id' => $client_user_id,
            'arr_logged_in_user' => $arr_logged_in_user
        );
        
    }
    
    
    
    public function getDataArrayGetViewAllContacts(
        $page_heading_content,
        $arr_all_contacts,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user,
            'arr_all_contacts' => $arr_all_contacts
        );
        
    }
    
    
    public function getDataArrayGetViewAllVisitors(
        $page_heading_content,
        $arr_all_visitors,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user,
            'arr_all_visitors' => $arr_all_visitors
        );
        
    }
    
    
    public function getDataArrayGetViewOneContact(
        $page_heading_content,
        $arr_contact,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user,
            'arr_contact' => $arr_contact
        );
        
    }
    
    
    
    public function getDataArrayGetViewAllRegistrations(
        $page_heading_content,
        $arr_all_regs_registration_data,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user,
            'arr_all_regs_registration_data' => $arr_all_regs_registration_data
        );
        
    }
    
    
    public function getDataArrayGetViewOneRegistration(
        $page_heading_content,
        $arr_registration_data,
        $int_registration_id,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $arr_logged_in_user,
            'int_registration_id' => $int_registration_id,
            'arr_registration_data' => $arr_registration_data
        );
        
    }
    
    
    
    public function getDataArrayGetViewClient(
        $page_heading_content,
        $str_state,
        $obj_client,
        $arr_user_info,
        $arr_logged_in_user)
    {
        return array(
            'page_heading_content' => $page_heading_content,
            'str_state' => $str_state,
            'arr_logged_in_user' => $arr_logged_in_user,
            'arr_user_info' => $arr_user_info,
            'obj_client' => $obj_client
            /*
             'input_old' =>array(
             'str_company' => Input::old('str_company', $obj_client->str_company),
             'str_email_two' => Input::old('str_email_two', $obj_client->str_email_two),
             'str_telephone_one' => Input::old('str_telephone_one', $obj_client->str_telephone_one),
             'str_telephone_two' => Input::old('str_telephone_two', $obj_client->str_telephone_two),
             'str_website' => Input::old('str_website', $obj_client->str_website),
             'str_crm_url' => Input::old('str_crm_url', $obj_client->str_crm_url),
             'str_crm' => Input::old('str_crm', $obj_client->str_crm),
             'str_lead_destination' => Input::old('str_lead_destination', $obj_client->str_lead_destination),
             'str_first_name' => Input::old('str_first_name', $obj_client->str_first_name),
             'str_last_name' => Input::old('str_last_name', $obj_client->str_last_name),
             'str_city' => Input::old('str_city', $obj_client->str_city),
             'str_zip' => Input::old('str_zip', $obj_client->str_zip),
             'int_state_id' => Input::old('int_state_id', $obj_client->int_state_id),
             'bool_active' => Input::old('bool_active', $obj_client->bool_active),
             'bool_confirmed' => Input::old('bool_confirmed', $obj_client->bool_confirmed)
                 
             )
             */
        );
        
    }
    
    
    
    public function getUserInfoForViewClient($obj_client)
    {
        $arr_user_info = array();
        
        $arr_user_info['first_name'] = $obj_client->user->first_name;
        $arr_user_info['last_name'] = $obj_client->user->last_name;
        $arr_user_info['email'] = $obj_client->user->email;
        foreach ($obj_client as $key => $val)
        {
            $arr_user_info[$key] = $val;
        }
        echo "in admin, line 1048<br>";
        echo "<pre>";
        print_r($arr_user_info);
        echo "</pre>";
        return $arr_user_info;
    }
    /*
     public function getNewCloakedClientId($email)
     {
     // check database for pre-existing instance of this ID
     $objCloakedClientId = null;
     //	$counterOne = 0;
     //    	$counterTwo = 0;
     while ($objCloakedClientId == null)
     {
     $counter = 0;
     while (($objCloakedClientId == null) && ($counter < 20))
     {
     echo "counter = $counter<br>";
     // create new cloaked client Id
     $rawHash = Hash::make($email.microtime());
     $new_cloaked_client_id = substr($rawHash, (20 + $counter), 10);
     $objCloakedClientId = $this
     ->where('cloaked_client_id', $new_cloaked_client_id)
     ->first();
     usleep(10);
     $counter ++;
     }
     sleep(1);
     //		$counterOne ++;
     }
     return $objCloakedClientId->cloaked_client_id;
     }
     */
    /*
     * no longer used, used toArray()
     public function convertObjectToArray($obj)
     {
     $arr_return = array();
     foreach ($obj as $key => $val)
     {
     $arr_return[$key] = $val;
     }
     return $arr_return;
     
     }
     */
   
}
