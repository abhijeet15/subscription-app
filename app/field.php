<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Field extends Model
{
    protected $hidden = ['updated_at',"created_at"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'type'
    ];

    /**
     * [ IN CASE NEEDED ]
     * Eloquent Relation: Fields belongs to Subscription.
     */
    /*public function subscriptionFields( )
    {
        return $this->hasMany( SubscriptionField::class, 'field_key', 'key' );
    }*/
}
