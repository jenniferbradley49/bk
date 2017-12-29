<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\PublicPage;

class PublicPagesController extends Controller
{
    public function index(PublicPage $publicPage)
    {
        $page_heading_content = "Welcome";
        // prepare genre sub page
        
        // end prepare genre sub page
        
        $data = $publicPage->getDataArrayGetPublicPage($page_heading_content);
        return view('public/index')->with('data', $data);
    }
    
}
