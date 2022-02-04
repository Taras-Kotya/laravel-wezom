<?php

namespace App\Composers;

class MainComposer
{

    public function compose($view)
    {
        //Add your variables
        $view->with('variable1',      'I am Data')
            ->with('variable2',      'I am Data 2');
    }
}
