<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PublicPage extends Model
{
    
    public function getDataArrayGetPublicPage($page_heading_content)
    {
        return array('page_heading_content' => $page_heading_content);
    }
    
}
