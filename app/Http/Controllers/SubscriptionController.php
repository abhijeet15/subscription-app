<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Validator;
use Response;
use Auth;


class SubscriptionController extends Controller
{
    public function index()
    {
        return Subscription::paginate( config( "app.records_per_page" ) );
    }

    public function show(Subscription $subscription)
    {
        return $subscription;
    }

    public function store(Request $request)
    {

        $user = Auth::guard('api')->user();

        // -- Validation
        if ( ( $validator = Validator::make(
                $request->all(), Subscription::validations_rules( $user->id ) ) )->fails() ) {
            return Response::json($validator->errors(), 422);
        }

	    // -- make subscriber entry.
	    $data = Subscription::create( array_merge( [ 'user_id' => $user->id ], $request->all( ) ) );
        
	    // -- make field entries.
	    $fields = $request->input("fields");
	    if( ! empty( $fields ) ){
            foreach ( $fields as $key=>$value ) {
    	    	$data->fields( )->create([
                    'key' => $key,
                    'value' => $value
                ]);
            }
	    }

	    return response()->json($data, 201);
    }

    public function update(Request $request, Subscription $subscription)
    {

        $id = $subscription->id;
        $user = Auth::guard('api')->user();

        // -- Validation
        if ( ( $validator = Validator::make(
                $request->all(), Subscription::validations_rules( $user->id, $id ) ) )->fails() ) {
            return Response::json($validator->errors(), 422);
        }

        $input = $request->all( );
        unset( $input[ 'state' ] );
        unset( $input[ 'user_id' ] );

        // -- make subscriber entry.
        $data = Subscription::find( $id );
        $data->update( $input );
        
        // -- make field entries.
        $fields = $request->input("fields");
 
       if( ! empty( $fields ) ){
            foreach ( $fields as $key=>$value ) {
                $data->fields( )->where('key',$key)->update([
                    'value' => $value
                ]);
            }
        }

        return response()->json($data->refresh(), 200);
    }

    public function delete(Subscription $subscription)
    {
        $subscription->fields()->delete();
	    $subscription->delete();
	    return response()->json([ "Record deleted successfully." ], 201);
    }
}
