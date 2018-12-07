<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // -- Custom Doamin Active validation
        Validator::extend('custom_domain_check', function ($attribute, $value) {
            $email_parts = explode( "@", $value );
            if( count($email_parts) == 2 ){
                return count(dns_get_record($email_parts[ 1 ], DNS_A | DNS_AAAA)) > 0;
            }
            else
                return false;
        });

        // -- While creating field generate key.
        \App\Models\Field::creating(function($model) {
            $model->key = str_slug( $model->title );
        });

        // -- Custom unique validation.
        Validator::extend('unique_custom', function ($attribute, $value, $parameters) {
            list($table, $field, $field2Value, $field2, $skipfield2Value, $skipfield2) = $parameters;
            $queryObj = DB::table($table)->where($field, $value)->where($field2, $field2Value);
            if( $skipfield2Value > 0 )
                $queryObj->where(  $skipfield2, '!=', $skipfield2Value );
            return $queryObj->count() == 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
