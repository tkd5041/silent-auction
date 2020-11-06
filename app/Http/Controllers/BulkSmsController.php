<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Validator;

class BulkSmsController extends Controller
{
    public function sendSms( Request $request )
    {
        // Your Account SID and Auth Token from twilio.com/console
        $sid    = 'ACa86f2ce31eff8fe2c761a70ca6c5a0bf'; //env( 'TWILIO_ACCOUNT_SID' );
        $token  = '6154642453f435cbbf73a43f767a67da'; //env( 'TWILIO_AUTH_TOKEN' );
        $client = new Client( $sid, $token );
        
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

                // if number has no error codes then send the message
                if ( ! $phone->carrier['error_code'] ) 
                { // if-2
                    $count ++;

                    $client->messages->create(
                        $number,
                        [
                            'from' => '+15206000725', //env( 'TWILIO_FROM' ),
                            'body' => $message,
                        ]
                        );
                } // if-2

            } // foreach
            return back()->with( 'success', $count . " message/s sent!" );
        } // if-1
        else
        { // else
            return back()->withErrors( $validator );
        } // else 
        
    } // function

    

} // class