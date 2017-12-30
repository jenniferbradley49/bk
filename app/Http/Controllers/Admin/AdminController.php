<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
//use App\Models\Client;
use App\Models\Role;
use App\Models\Role_user;
//use App\Models\CloakedClientId;
//use App\Models\PublicPage;
//use Hash;
//use Redirect;
//use DB;
use Illuminate\Support\Facades\Auth;
use App\Classes\RoleHelper;
use App\Classes\CommonCode;

class AdminController extends Controller
{
    var $obj_logged_in_user;
    var $arr_logged_in_user;
    var $bool_has_role;
    var $roleHelper;
    //organization of function
    // 1. __construct
    // 2. index
    // get, alphabetically
    // post, alphabetically
    
    public function __construct(
 //   			Role_user $role_user, 
  //              RoleHelper $roleHelper,
  //              Request $request)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    } // end __construct function
    
    
    public function index( RoleHelper $roleHelper)
    {
        $page_heading_content = "Admin dashboard page";
        $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
        $data = array(
            'page_heading_content' => $page_heading_content,
            'arr_logged_in_user' => $this->arr_logged_in_user);
        return view('admin/dashboard')->with('data', $data);
    }
    
    
    public function get_add_client(
        Admin $admin,
        Client $client,
        State $state,
        User $user,
        RoleHelper $roleHelper,
        Survey_project $survey_project,
        Request $request)
    {
        //    	$data = array('arr_logged_in_user' => $this->arr_logged_in_user);
        $obj_user = $user->find($request->client_user_id);
        $obj_client = $client->where('user_id', $request->client_user_id)->first();
        if (!is_null($obj_client))
        {
            $page_heading_content = "Add client";
            $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
            $data = $admin->getDataArrayGetClientExists(
                $obj_client->user_id,
                $this->arr_logged_in_user);
            
            return view('admin/client_exists')->with('data', $data);
        }
        else
        {
            $arr_states = $state->get_states();
            $survey_project = $survey_project->all();
            $arr_projects = $admin->prepare_projects_for_select($survey_project);
            $page_heading_content = "Add client";
            $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
            $data = $admin->getDataArrayGetAddClient(
                $arr_states,
                $arr_projects,
                $obj_user,
                $request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/add_client')->with('data', $data);
        }
    }
    
      
    public function get_add_role(User $user, Admin $admin, RoleHelper $roleHelper)
    {
        $arr_users_raw = $user->get_all_users_admin(1);  // 1 specifies order by last name
        $arr_users_processed = $user->process_users($arr_users_raw);
        $page_heading_content = "Add role";
        $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
        $data = $admin->getDataArrayGetAddRole(
            $arr_users_processed,
            $page_heading_content,
            $this->arr_logged_in_user);
        return view('admin/add_role_admin')->with('data', $data);
    }
    
    
    
    public function get_add_user(Admin $admin)
    {
        $data = array('arr_logged_in_user' => $this->arr_logged_in_user);
        $page_heading_content = "Admin dashboard page";
        $data = $admin->getDataArrayGetAddUserAdmin(
            $this->arr_logged_in_user);
        return view('admin/add_user_admin')->with('data', $data);
    }
    
    public function get_choose_client(Admin $admin, Client $client)
    {
        $page_heading_content = "Choose a client";
        // 	$obj_all_clients_raw = $client->orderBy('str_company')->get();  // 1 specifies order by last name
        $obj_all_clients_raw = $client->all();
        foreach($obj_all_clients_raw as $client_raw)
        {
        }
        $arr_clients_processed = $client->prepare_clients_for_select($obj_all_clients_raw);
        
        $data = $admin->getDataArrayGetChooseClient(
            $page_heading_content,
            $arr_clients_processed,
            $this->arr_logged_in_user);
        
        
        return view('admin/choose_client')->with('data', $data);
    }
    
    

    public function get_choose_user_add_client(
        User $user,
        Admin $admin,
        Client $client)
    {
        $page_heading_content = "Choose a user";
        $arr_users_raw = $user->get_all_users_admin(1);  // 1 specifies order by last name
        $obj_all_clients = $client->all();
        $arr_users_wo_client = $user->get_users_wo_client($arr_users_raw, $obj_all_clients);
        $arr_users_processed = $user->process_users($arr_users_wo_client);
        $data = $admin->getDataArrayGetEditUser(
            $page_heading_content,
            $arr_users_processed,
            $this->arr_logged_in_user);
        
        
        return view('admin/choose_user_add_client')->with('data', $data);
    }
    
    
    
    public function get_delete_role(User $user, Admin $admin)
    {
        $page_heading_content = "Delete rolex - admin";
        $arr_users_raw = $user->get_all_users_admin(1);  // 1 specifies order by last name
        $arr_users_processed = $user->process_users($arr_users_raw);
        //print_r($arr_users_processed);
        $data = $admin->getDataArrayGetEditUser(
            $page_heading_content,
            $arr_users_processed,
            $this->arr_logged_in_user);
        return view('admin/delete_role_admin')->with('data', $data);
    }
    
    
    public function get_edit_client(
        Admin $admin,
        Client $client,
        State $state,
        Request $request)
    {
        $page_heading_content = "Edit this client";
        $obj_client = $client->where('user_id', $request->client_user_id)->first();
        if (is_null($obj_client))
        {
            $page_heading_content = "No client found";
            $data = $admin->getDataArrayGetNoClient(
                $page_heading_content,
                $request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/no_client')->with('data', $data);
        }
        else
        {
            $arr_states = $state->get_states();
            
            $data = $admin->getDataArrayGetEditClient(
                $page_heading_content,
                $arr_states,
                $obj_client,
                $this->arr_logged_in_user);
            return view('admin/edit_client')->with('data', $data);
        }
    }
    
   
    
    public function get_edit_user(User $user, Admin $admin)
    {
        $page_heading_content = "Edit a user";
        $arr_users_raw = $user->get_all_users_admin(1);  // 1 specifies order by last name
        $arr_users_processed = $user->process_users($arr_users_raw);
        $data = $admin->getDataArrayGetEditUser(
            $page_heading_content,
            $arr_users_processed,
            $this->arr_logged_in_user);
        
        return view('admin/edit_user_admin')->with('data', $data);
    }
    
   
    
    // start post functions
    
  
    
    public function get_view_client(
        Admin $admin,
        Client $client,
        State $state,
        Request $request)
    {
        //    	$data = array('arr_logged_in_user' => $this->arr_logged_in_user);
        $obj_client = $client->where('user_id', $request->client_user_id)->first();
        if (is_null($obj_client))
        {
            //    		echo "no client found for this user";
            $page_heading_content = "No client found";
            $data = $admin->getDataArrayGetNoClient(
                $page_heading_content,
                $request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/no_client')->with('data', $data);
        }
        $arr_user_info = $obj_client->getAttributes();
        $page_heading_content = "View this client";
        //    	else
        //   	{
        //   		$arr_client = $admin->getClientData($obj_client);
            //   	}
            //   	$arr_states = $state->get_states();
            $str_state = $state->find($obj_client->int_state_id)->str_text;
            $data = $admin->getDataArrayGetViewClient(
                $page_heading_content,
                $str_state,
                $obj_client,
                $arr_user_info,
                $this->arr_logged_in_user
                );
            return view('admin/view_client')->with('data', $data);
    }
    
    
    public function get_view_all_contacts(
        Admin $admin,
        Contact $contact,
        Request $request)
    {
        // get all registrations
        $obj_contacts = $contact
        ->orderBy("created_at", 'desc')
        ->get();
        // if no contacts, notify user
        if (is_null($obj_contacts))
        {
            //    		echo "no client found for this user";
            $page_heading_content = "No contacts found";
            $data = $admin->getDataArrayGetNoContacts(
                $page_heading_content,
                //    				$request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/no_contacts')->with('data', $data);
        }
        
        $arr_all_contacts = $obj_contacts->toArray();
        foreach ($arr_all_contacts as &$arr_contact)
        {
            $arr_contact['link'] = '/admin/view_one_contact/'.$arr_contact['id'];
        }
        
        $page_heading_content = "View all contacts";
        $data = $admin->getDataArrayGetViewAllContacts(
            $page_heading_content,
            $arr_all_contacts,
            $this->arr_logged_in_user
            );
        return view('admin/view_all_contacts')->with('data', $data);
    }
    
    
    
    public function get_view_all_registrations(
        Admin $admin,
        Registration $registration,
        Request $request)
    {
        // get all registrations
        $obj_registrations = $registration
        ->orderBy("created_at", 'desc')
        ->get();
        // if no registrations, notify user
        if (is_null($obj_registrations))
        {
            //    		echo "no client found for this user";
            $page_heading_content = "No registrations found";
            $data = $admin->getDataArrayGetNoRegistrations(
                $page_heading_content,
                //    				$request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/no_registrations')->with('data', $data);
        }
        
        $arr_all_regs_registration_data = array();
        
        // iterate through each registration, get registration data
        foreach ($obj_registrations as $foreach_registration)
        {
            $obj_registration_data =
            $registration
            ->find($foreach_registration->id)
            ->registration_data;
            
            $arr_registration_data_raw =
            $obj_registration_data->toArray();
            // reformulate each reg_data to one array with all data
            foreach ($arr_registration_data_raw as $item)
            {
                $arr_registration_data_processed[$item['str_col_name']] =
                $item['str_value'];
            }
            // add registration ID, created at, and link for drill down
            $arr_registration_data_processed['registration_id'] = $foreach_registration->id;
            $arr_registration_data_processed['created_at'] = $foreach_registration->created_at;
            $arr_registration_data_processed['link'] = '/admin/view_one_registration/'.$foreach_registration->id;
            
            // transfer to main array
            $arr_all_regs_registration_data
            [$foreach_registration->id]
            = $arr_registration_data_processed;
        } // end foreach ($obj_registrations
        
        $page_heading_content = "View all registrations";
        $data = $admin->getDataArrayGetViewAllRegistrations(
            $page_heading_content,
            $arr_all_regs_registration_data,
            $this->arr_logged_in_user
            );
        return view('admin/view_all_registrations')->with('data', $data);
    }
    
    
    public function get_view_all_visitors(
        Admin $admin,
        Visitor $visitor,
        Source $source,
        RoleHelper $roleHelper,
        Request $request)
    {
        // get all registrations
        $obj_visitors = $visitor
        ->orderBy("created_at", 'desc')
        ->get();
        // if no contacts, notify user
        if (is_null($obj_visitors))
        {
            //    		echo "no client found for this user";
            $page_heading_content = "No visitors found";
            $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
            $data = $admin->getDataArrayGetNoVisitors(
                $page_heading_content,
                //    				$request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/no_visitors')->with('data', $data);
        }
        
        $arr_all_visitors = $obj_visitors->toArray();
        foreach ($arr_all_visitors as &$arr_visitor		)
        {
            $arr_visitor['str_source_name'] = $source->str_getSourceName($arr_visitor['int_source_id']);
            //    		$arr_contact['link'] = '/admin/view_one_contact/'.$arr_contact['id'];
        }
        //    	echo "admin controller, line 741<br>";
        //    	echo "<pre>";
        //    	print_r($arr_all_visitors);
        //    	echo "</pre>";
        
        $page_heading_content = "View all visitors";
        $data = $admin->getDataArrayGetViewAllVisitors(
            $page_heading_content,
            $arr_all_visitors,
            $this->arr_logged_in_user
            );
        return view('admin/view_all_visitors')->with('data', $data);
    }
    
    
    
    public function get_view_one_contact(
        Admin $admin,
        Contact $contact,
        Request $request)
    {
        // get all contacts
        $obj_contact = $contact
        ->find($request->contact_id);
        // if no contacts, notify user
        if (is_null($obj_contact))
        {
            //    		echo "no client found for this user";
            $page_heading_content = "No contact found";
            $data = $admin->getDataArrayGetNoContacts(
                $page_heading_content,
                //    				$request->client_user_id,
                $this->arr_logged_in_user);
            return view('admin/no_contacts')->with('data', $data);
        }
        
        //   	$arr_all_regs_contact_data = array();
        
        // iterate through each contact, get contact data
        //   	foreach ($obj_contacts as $foreach_contact)
        //    	{
        //    		$obj_contact_data =
        //    		$obj_contact
        //   		->contact_data;
        
        $arr_contact = $obj_contact->toArray();
        // reformulate each reg_data to one array with all data
        //    	foreach ($arr_contact as $item)
        //   	{
        //    		$arr_contact_data_processed[$item['str_col_name']] =
        //    		$item['str_value'];
        //    	}
        // add contact ID, created at, and link for drill down
        //   	$arr_contact_data_processed['contact_id'] = $obj_contact->id;
        //   	$arr_contact_data_processed['created_at'] = $obj_contact->created_at;
        //   		$arr_contact_data_processed['link'] = '/admin/view_contact/'.$foreach_contact->id;
        
        $page_heading_content = "View one contact";
        $data = $admin->getDataArrayGetViewOneContact(
            $page_heading_content,
            $arr_contact,
            $this->arr_logged_in_user
            );
        return view('admin/view_one_contact')->with('data', $data);
}


public function get_view_one_registration(
    Admin $admin,
    Registration $registration,
    RoleHelper $roleHelper,
    Request $request)
{
    // get one registration
    $obj_registration = $registration
    ->find($request->registration_id);
    // if no registrations, notify user
    if (is_null($obj_registration))
    {
        //    		echo "no client found for this user";
        $page_heading_content = "No registrations found";
        $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
        $data = $admin->getDataArrayGetNoRegistrations(
            $page_heading_content,
            //    				$request->client_user_id,
            $this->arr_logged_in_user);
        return view('admin/no_registration')->with('data', $data);
    }
    
    //   	$arr_all_regs_registration_data = array();
    
    // iterate through each registration, get registration data
    //   	foreach ($obj_registrations as $foreach_registration)
        //    	{
        $obj_registration_data =
        $obj_registration
        ->registration_data;
        
        $arr_registration_data_raw =
        $obj_registration_data->toArray();
        // reformulate each reg_data to one array with all data
        foreach ($arr_registration_data_raw as $item)
        {
            $arr_registration_data_processed[$item['str_col_name']] =
            $item['str_value'];
        }
        // add registration ID, created at, and link for drill down
        $arr_registration_data_processed['registration_id'] = $obj_registration->id;
        $arr_registration_data_processed['created_at'] = $obj_registration->created_at;
        //   		$arr_registration_data_processed['link'] = '/admin/view_registration/'.$foreach_registration->id;
        
        $page_heading_content = "View one registration";
        $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
        $data = $admin->getDataArrayGetViewOneRegistration(
            $page_heading_content,
            $arr_registration_data_processed,
            $request->registration_id,
            $this->arr_logged_in_user
            );
        return view('admin/view_one_registration')->with('data', $data);
}



// start post functions



public function post_add_client(
    Request $request,
    Admin $admin,
    User $user,
    Client $client,
    CommonCode $cCode)
    // 		CloakedClientId $cloakedClientId)
{
    $validation_rules = $admin->getValidationRulesAddClientDO();
    $this->validate($request, $validation_rules);
    
    if((int)$request->bool_delivery_crm)
    {
        // if delvery by email
        $validation_rules = $admin->getValidationRulesAddClientEmail();
        $this->validate($request, $validation_rules);
        $arr_request = $admin->getRequestArrayAddClientEmail($request);
        
    }
    else
    {
        // if delivery by CRM
        $validation_rules = $admin->getValidationRulesAddClientCRM();
        $this->validate($request, $validation_rules);
        $arr_request = $admin->getRequestArrayAddClientCRM($request);
        
    }
    // this function was copied from three step, client info not necessary here
    // use publisher as client
    $obj_client = $client->where('user_id', $arr_request['client_user_id'])->first();
    if ($obj_client != null)
        return view('admin/client_exists');
        //		else
            //			echo "this user does not have any client profile<br>";
            //		$user->email = $arr_request['email'];
            //		$user->password = $arr_request['password'];
        //    	$user->name = '';
        //		$user->first_name = $arr_request['first_name'];
        //		$user->last_name = $arr_request['last_name'];
        //		$user->save();
        $client->str_cloaked_client_id = $client->getNewCloakedClientId($user->id);
        $client->user_id = $arr_request['client_user_id'];
        $client->survey_project_id = $arr_request['survey_project_id'];
        //this is set above, by actually creating the cloaked id
        //    	$client->cloaked_client_id = $arr_request['cloaked_client_id'];
        $client->str_email_two = $arr_request['str_email_two'];
        $client->str_website = $arr_request['str_website'];
        $client->bool_delivery_crm = $arr_request['bool_delivery_crm'];
        $client->str_first_name = $arr_request['str_first_name'];
        $client->str_last_name = $arr_request['str_last_name'];
        $client->str_telephone = $arr_request['str_telephone'];
        //	$client->str_telephone_two = $arr_request['str_telephone_two'];
        $client->str_company = $arr_request['str_company'];
        $client->str_city = $arr_request['str_city'];
        $client->str_zip = $arr_request['str_zip'];
        $client->int_state_id = $arr_request['int_state_id'];
        $client->bool_active = $arr_request['bool_active'];
        $client->bool_confirmed = $arr_request['bool_confirmed'];
        if(!$request->bool_delivery_crm)
        {
            $client->str_email_delivery = $arr_request['str_email_delivery'];
        }
        else
        {
            $client->str_crm = $arr_request['str_crm'];
            $client->str_crm_url = $arr_request['str_crm_url'];
            $client->str_lead_destination = $arr_request['str_lead_destination'];
        }
        $client ->save();
        //    	$user_id = $user->id;
        // return to raw password for view
        //   	$arr_request['password'] = $request->password;
        
        $data = $admin->getDataArrayAddClient(
            $client->str_cloaked_client_id,
            $arr_request,
            $this->arr_logged_in_user);
        return view('admin/add_client_results_admin')->with('data', $data);
    }
    
    
    public function post_add_role(
        Request $request, User $user, Role $role,
        Role_user $role_user, Admin $admin)
    {
        $validation_rules = $admin->getValidationRulesAddRole();
        $validation_messages = $admin->getValidationMessagesEditUser();
        $this->validate($request, $validation_rules, $validation_messages);
        
        $arr_request = $admin->getRequestArrayAddRole($request);
        
        // check for identical rows already in role_user
        $arr_role_user = $role_user
        ->where('user_id', '=', $arr_request['user_id'])
        ->where('role_id', '=', $arr_request['role_id'])
        ->get();
        if(empty($arr_role_user))
        {
            $bool_role_user_exists = 0;
            $role_user->add_role($arr_request['user_id'], $arr_request['role_id']);
        }
        else
        {
            $bool_role_user_exists = 1;
        }
        
        //prepare text for output
        $user = $user->find($arr_request['user_id']);
        $arr_request['first_name'] = $user->first_name;
        $arr_request['last_name'] = $user->last_name;
        $role = $role->find($arr_request['role_id']);
        $arr_request['role'] = $role->name;
        
        $data = $admin->getDataArray(
            $arr_request, 0,
            $this->arr_logged_in_user);
        
        if ($bool_role_user_exists)
        {
            return view('admin/add_role_results_failure_admin')->with('data', $data);
        }
        else
        {
            return view('admin/add_role_results_admin')->with('data', $data);
        }
    }
    
   
    
    public function post_add_user(
        Request $request,
        Admin $admin,
        User $user,
        Client $client,
        //   		State $state,
        CommonCode $cCode)
        // 		CloakedClientId $cloakedClientId)
    {
        $validation_rules = $admin->getValidationRules();
        $this->validate($request, $validation_rules);
        
        $arr_request = $admin->getRequestArray($request);
        $user->email = $arr_request['email'];
        $user->password = $arr_request['password'];
        //    	$user->name = '';
        $user->first_name = $arr_request['first_name'];
        $user->last_name = $arr_request['last_name'];
        $user->save();
        // this function was copied from three step, client info not necessary here
        // use publisher as client
        //   	$client->str_cloaked_client_id = $client->getNewCloakedClientId($user->id);
        //   	$client->user_id = $user->id;
        //  	$client->str_first_name = $arr_request['first_name'];
        //  	$client->str_last_name = $arr_request['last_name'];
        //  	$client->str_company = $arr_request['company'];
        //  	$client ->save();
        //    	$user_id = $user->id;
        // return to raw password for view
        $arr_request['password'] = $request->password;
        
        $data = $admin->getDataArray(
            $arr_request, $user->id,
            //		$client->str_cloaked_client_id,
            $this->arr_logged_in_user);
        return view('admin/add_user_results_admin')->with('data', $data);
    }
    
    
    public function post_choose_client(
        Request $request,
        Admin $admin
        )
    {
        $validation_rules = $admin->getValidationRulesChooseClient();
        $this->validate($request, $validation_rules);
        
        if ($request->str_choice == 'test')
            return redirect('admin/test_client/'.$request->client_id);
            
            if ($request->str_choice == 'view')
                return redirect('admin/view_client/'.$request->client_id);
                
                if ($request->str_choice == 'edit')
                    return redirect('admin/edit_client/'.$request->client_id);
                    
                    if ($request->str_choice == 'edit_lead_vars')
                        return redirect('admin/edit_client_lead_vars/'.$request->client_id);
                        
                        //    	return redirect('admin/add_edit_client/'.$request->user_id);
    }
    
    
    
    public function post_choose_user_add_client(
        Request $request,
        Admin $admin
        )
    {
        $validation_rules = $admin->getValidationRulesChooseUser();
        $this->validate($request, $validation_rules);
        
        return redirect('admin/add_client/'.$request->client_user_id);
        
        //    	if ($request->str_choice == 'edit')
            //    		return redirect('admin/edit_client/'.$request->client_user_id);
        
            //    	return redirect('admin/add_edit_client/'.$request->user_id);
    }
    
    
    public function post_delete_role(
        Request $request, User $user,
        Role $role, Role_user $role_user, Admin $admin)
    {
        $validation_rules = $admin->getValidationRulesAddRole();
        $validation_messages = $admin->getValidationMessagesEditUser();
        $this->validate($request, $validation_rules, $validation_messages);
        
        $arr_request = $admin->getRequestArrayAddRole($request);
        $role_user->delete_role($arr_request['user_id'],
            $arr_request['role_id']);
        
        //prepare text for output
        $user = $user->find($arr_request['user_id']);
        $arr_request['first_name'] = $user->first_name;
        $arr_request['last_name'] = $user->last_name;
        $role = $role->find($arr_request['role_id']);
        $arr_request['role'] = $role->name;
        
        $data = $admin->getDataArray(
            $arr_request, 0,
            $this->arr_logged_in_user);
        
        return view('admin/delete_role_results_admin')->with('data', $data);
    }
    
    
    public function post_email_registration_admin(
        Registration $registration,
        PublicForm $publicForm,
        Admin $admin,
        RoleHelper $roleHelper,
        Request $request)
    {
        $page_heading_contents = "Email registration to admin results";
        $this->arr_logged_in_user = $roleHelper->prepare_logged_in_user_info(Auth::user());
        $obj_registration = $registration
        ->find($request->int_registration_id);
        // retrieve all data from this registration
        $arr_registration_data_raw = $obj_registration
        ->registration_data()
        ->get()
        ->toArray();
        $arr_registration_data_formatted = $publicForm->format_registration_data($arr_registration_data_raw);
        
        $registration->notifyAdmin(
            $publicForm,
            $arr_registration_data_formatted
            );
        
        $data = $admin->getDataArrayEmailRegAdmin(
            $page_heading_contents,
            $request->int_registration_id,
            $this->arr_logged_in_user);
        return view('admin/email_reg_admin_results')->with('data', $data);
    }
    
    
    public function post_edit_client(
        Request $request,
        Admin $admin,
        Client $client,
        CommonCode $cCode)
        // 		CloakedClientId $cloakedClientId)
    {
        $validation_rules = $admin->getValidationRulesAddClient();
        $this->validate($request, $validation_rules);
        
        $arr_request = $admin->getRequestArrayAddClient($request);
        // this function was copied from three step, client info not necessary here
        // use publisher as client
        //    	$client->cloaked_client_id = $client->getNewCloakedClientId($user->id);
        $obj_client = $client->where('user_id', $arr_request['client_user_id'])->first();
        if ($obj_client != null)
            $client = $obj_client;
            else
                echo "no user found for client / user_id<br>";
                //    	$client->user_id = $arr_request['client_user_id'];
                $client->str_email_two = $arr_request['str_email_two'];
                $client->str_website = $arr_request['str_website'];
                $client->str_crm = $arr_request['str_crm'];
                $client->str_crm_url = $arr_request['str_crm_url'];
                $client->str_lead_destination = $arr_request['str_lead_destination'];
                $client->str_first_name = $arr_request['str_first_name'];
                $client->str_last_name = $arr_request['str_last_name'];
                $client->str_telephone_one = $arr_request['str_telephone_one'];
                $client->str_telephone_two = $arr_request['str_telephone_two'];
                $client->str_company = $arr_request['str_company'];
                $client->str_city = $arr_request['str_city'];
                $client->str_zip = $arr_request['str_zip'];
                $client->int_state_id = $arr_request['int_state_id'];
                $client->bool_active = $arr_request['bool_active'];
                $client->bool_confirmed = $arr_request['bool_confirmed'];
                //    	$client->str_email_two = $arr_request['str_email_two'];
                $client ->save();
                //    	$user_id = $user->id;
                // return to raw password for view
                //   	$arr_request['password'] = $request->password;
                
                $data = $admin->getDataArrayAddClient(
                    $client->str_cloaked_client_id,
                    $arr_request,
                    $this->arr_logged_in_user);
                return view('admin/edit_client_results_admin')->with('data', $data);
            }
            
            
           
            public function post_edit_user(Request $request,
                User $user, Admin $admin, CommonCode $cCode)
            {
                $bool_include_password = $cCode->setCheckboxVar($request->include_password);
                $bool_include_email = $cCode->setCheckboxVar($request->include_email);
                
                $validation_rules = $admin->getValidationRulesEditUser();
                $validation_messages = $admin->getValidationMessagesEditUser();
                $this->validate($request, $validation_rules, $validation_messages);
                
                if ($bool_include_email)
                {
                    $validation_rules = [
                        'email' => 'required|email|max:50|unique:users',
                    ];
                    $this->validate($request, $validation_rules);
                }
                
                if ($bool_include_password)
                {
                    $validation_rules = [
                        'password' => 'required|confirmed|max:50|min:6'
                    ];
                    $this->validate($request, $validation_rules);
                }
                
                $obj_user = $user->find($request->user_id);
                $obj_user->first_name = $request->first_name;
                $obj_user->last_name = $request->last_name;
                $arr_request = array();
                $arr_request['first_name'] = $request->first_name;
                $arr_request['last_name'] = $request->last_name;
                if ($bool_include_email)
                {
                    $obj_user->email = $request->email;
                    $arr_request['email'] = $request->email;
                }
                if ($bool_include_password)
                {
                    $obj_user->password = $request->password;
                    $arr_request['password'] = $request->password;
                }
                
                $obj_user->save();
                $user_id = $user->id;
                
                $data = $admin->getDataArray(
                    $arr_request, $user_id,
                    $this->arr_logged_in_user);
                
                return view('admin/edit_user_results_admin')->with('data', $data);
            }
                      
}
