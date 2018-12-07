<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionField extends Model
{
    /**
     * The attributes that are hidden.
     *
     * @var array
     */
	protected $hidden = ['updated_at',"created_at", "field"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id', 'key', 'value'
    ];

    /**
     * The attributes that are appends.
     *
     * @var array
     */
    protected $appends = ['type', 'title'];

    /**
     * Eloquent Relation: SubscriptionFields belongs to Fields .
     */
    public function field( ) {
        return $this->belongsTo( Field::class, 'key', 'key' );
    }

    /**
     * Eloquent Relation: SubscriptionFields belongs to Subscription .
     */
    public function subscription( ) {
        return $this->belongsTo( Subscription::class );
    }

    /**
     * Accessors for get field type
     */
    function getTypeAttribute( ) {
      return $this->field->type;
    }

    /**
     * Accessors for get field type
     */
    function getTitleAttribute( ) {
      return $this->field->title;
    }
}
