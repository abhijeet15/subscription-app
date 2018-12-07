<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Http\Request;

class FrontendController extends BaseController
{
    public function index()
    {
        $this->toDom( [ 
            'custom_fields' => $this->get_custom_field( ),
            'page'=> 'add'
        ] );

        return view( "subscription" );
    }

    public function subscriptionlist()
    {
        $this->toDom( [ 
            'custom_fields' => $this->get_custom_field( ),
            'page'=> 'listing'
        ] );

        return view( "subscription" );
    }

    public function login( Request $request ){

    	$this->toDom( [ ] );

        return view( "login" );
    }

    public function register( Request $request ){

        $this->toDom( [ ] );

        return view( "register" );
    }

    private function get_custom_field( )
    {
    	// -- temporary it returns array, in real scienario api call to 
        // -- api: /field/list.
    	return \App\Models\Field::all();
    }
}
