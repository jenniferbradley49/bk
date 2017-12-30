<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Classes\PartialDirector;
//use Illuminate\Users\Repository as UserRepository;


class PublicComposer
{
    protected $partialDirector;
    
    public function __construct(PartialDirector $partialDirector)
    {
        // Dependencies automatically resolved by service container...
        $this->partialDirector = $partialDirector;
    }
    
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navbar_right', $this->partialDirector->getNavbarRightPublic());
    }
}