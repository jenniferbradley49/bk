<?php
namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class PartialDirector
{
    
    public function getNavbarRightPublic()
    {
        $view_raw = view('partials.navbar_right_public');
        return $view_raw->render();
    }
    
    
    public function getNavbarRightClient()
    {
        $view_raw = view('partials.navbar_right_client');
        return $view_raw->render();
    }
    
    
    public function getNavbarRightThreeStepAdmin()
    {
        $view_raw = view('partials.navbar_right_three_step_admin');
        return $view_raw->render();
    }
    
    
    
}
