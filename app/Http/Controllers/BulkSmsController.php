<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Validator;

class BulkSmsController extends Controller
{
    public function sendSms( Request $request )
    {
        //Your Account SID and Auth Token from twilio.com/console
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        $client = new Client( $sid, $token);
        //dd($sid, $token, $from, $client);
        
        // Validate data from form
        $validator = Validator::make($request->all(), [
            'numbers' => 'required',
            'message' => 'required',
            'pin' => 'required',
        ]);
        
        if ( $validator->passes() ) 
        { // if-1

            // set variables for cycle
            $numbers_in_arrays = explode( ',' , $request->input( 'numbers' ) );
            $message = $request->input( 'message' );
            $pin = $request->input( 'pin' );
            $count = 0;
            
            // check pin for authorization
            if ( $pin != 11225 ) {
                return back()->with( 'error', " Invalid PIN" );
            }

            // begin checking numbers and sending messages
            foreach( $numbers_in_arrays as $number )
            { // foreach
                // check if number is valid
                $phone = $client->lookups->v1->phoneNumbers($number)->fetch(["type" => ["carrier"]]);

                try {
                // if number has no error codes then send the message
                if ( ! $phone->carrier['error_code'] ) 
                { // if-2
                    $count ++;

                    $client->messages->create(
                        $number,
                        [
                            'from' => $from,
                            'body' => $message,
                        ]
                        );
                } // if-2
            } catch (\Exception $e) {

                //console.log($e->getMessage());
            }

            } // foreach
            return back()->with( 'success', $count . " message/s sent!" );
        } // if-1
        else
        { // else
            return back()->withErrors( $validator );
        } // else 
        
    } // function

    

} // class