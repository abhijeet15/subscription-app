<?php

namespace App\Jobs\Subscription;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Http\Request;

class Add implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data = [ ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $data )
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "<pre>";
        $this->data[ 'state' ] = "active";
        unset($this->data['fields']);
        unset($this->data['_token']);
        // print_r(\Input::get());die;
        print_r($this->data);
        $request =  Request::create('/api/v1/subscriber', 'POST', []);
        // $request->headers->set('Content-type', 'application/json');
       print_r( (\Route::dispatch($request)->getContent()) );
        die;
        /*$client = new \GuzzleHttp\Client();
        $res = $client->get('http://127.0.0.1:8000/api/v1/subscribers');
        echo $res->getStatusCode(); // 200
        echo $res->getBody(); // { "type": "User", ....*/

        return [ "test" ];
    }
}
