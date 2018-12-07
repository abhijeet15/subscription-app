<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JavaScript;

class BaseController extends Controller
{
    
    protected $data;
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function toDom( $input = array( ) )
    {
        /*if( ! is_array( $input ) )
            $input = array( );*/

         if( ! is_array( $this->data ) )
            $this->data = array( );

        JavaScript::put( array_merge( $input, $this->data, [
            'base_url' => url( '' ),
            'api_base_url' => url( 'api/' . config( "api.version" ) ),
            'user' => \Auth::user( ),
            'apiToken' => 'test-token',
            'template_tokens' => config( 'template.tokens' ),
            'app'  => [ 
                        'name' => config( 'app.name' ),
                        'site_name' => config( 'app.site_name' ),
            ]

        ] ) );
    }

}
