<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Sms;
use HTTP_Request2;
use Infobip\Configuration;
use Infobip\ApiException;
use App\Http\Controllers\SmsController;

class InboxController extends Controller
{
    //
    public function inboxSms(Request $request)
    {
        //calling the sms controller 
        $sms= Sms::all();
       
        return view('sms.index', compact('sms'));
    }

    //
    public function inboxEmail()
    {
        $curl = curl_init();

        $url = 'e1kq5n.api.infobip.com'; 
        $authorization = 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7'; 

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:'.$authorization,
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            // Handle cURL error
            return response()->json(['error' => $error], 500);
        }

        curl_close($curl);

        // You may want to decode the JSON response if it's JSON
        $responseData = json_decode($response, true);
    
        // Render the view with response data
        return view('email.inbox', ['response' => $responseData]);
    }

    //
    public function inboxWhatsapp(Request $request)
    {
       
    }




}
