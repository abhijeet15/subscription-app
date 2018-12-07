<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Subscription extends Model
{
    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

    /**
     * The attributes that appends relations.
     *
     * @var array
     */
    protected $with = ['fields'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'email', 'state',
    ];

    /**
     * The Model validation rules while add/edit.
     *
     * @return array
     */
    public static function validations_rules( $user_id, $id=0 )
    {
        $rules = [
            'name'  => 'required|max:255',
            'email' => 'required|email|custom_domain_check|unique_custom:subscriptions,email,'.$user_id.',user_id,'.$id.',id',
            'state'  => 'sometimes|required|in:' . implode( ",", config('app.subscription_state') ),
        ];

        $fields = \App\Models\Field::all( )->toArray();
        foreach ( $fields as $field ) {
            
            if( empty( $rules[ $field[ 'key' ] ] ) )
            {
                if( $field[ 'type' ] == "date" ){
                    $rules[ 'fields.' . $field[ 'key' ] ] = 'sometimes|required|date_format:"Y-m-d"';
                } elseif( $field[ 'type' ] == "number" ){
                    $rules[ 'fields.' . $field[ 'key' ] ] = 'sometimes|required|integer';
                }
                elseif( $field[ 'type' ] == "boolean" ){
                    $rules[ 'fields.' . $field[ 'key' ] ] = 'sometimes|required|in:0,1';
                }
            }
        }

        return $rules;
    }

    /**
     * Eloquent Relation: Subscription can have One-to-Many 
     * relations with Fields.
     */
    public function fields( )
    {
    	return $this->hasMany( SubscriptionField::class );
    }
}
