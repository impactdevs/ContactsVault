<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\EmailOutbox;
use HTTP_Request2;
use Illuminate\Support\Facades\Http;

class EmailController extends Controller
{
    //fetching emails
        public function inbox()
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


    //compose email
     public function composeEmail(Request $request, $id)
     {
         
         $client = Clients::find($id);
 
         if (!$client)
         {
             return abort(404);
         }
 
         return view('email.create', ['client' => $client]);
     }
 
 
     //sending email
    public function sendEmail(Request $request, Clients $client)
    {
        $email = $request->email;
        $subject = $request->subject;
        $body = $request->body;
        $name = $client->name;

    
        $request = new HTTP_Request2();
        $request->setUrl('https://e1kq5n.api.infobip.com/email/3/send');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7',
            'Content-Type' => 'multipart/form-data',
            'Accept' => 'application/json'
        ));
        $request->addPostParameter(array(
            'from' => 'david <david.ochwo@impactoutsourcing.co.ug>',
            'subject' => $subject,
            'to' => '{"to":"' . $email . '","placeholders":{"firstName":"' . $name . '"}}',
            'text' => $body
        ));
        
        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                return response()->json(['success' => 'Email sent successfully']);
            } else {
                return response()->json(['error' => 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase()], 500);
            }
        } catch (HTTP_Request2_Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    //sent emails
    public function outboxEmail()
    {
          //calling the api
          $response = Http::withHeaders([
            'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7'
        ])->get('https://e1kq5n.api.infobip.com/email/1/logs');
    
        $res = json_decode($response->body());

        if (isset($res->results) && is_array($res->results)) {
            
            foreach ($res->results as $apiemail) {
              
                $dateTime = new \DateTime( $apiemail->sentAt);
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
    
                $email = new EmailOutbox();
                $email->sentTo = $apiemail->to; 
                $email->sentFrom = $apiemail->from; 
                $email->text = $apiemail->text;
                $email->sentAt = $formattedDateTime;
                $email->deliveryStatus = $apiemail->status->groupName;
    
                
                $email->save();
              
            }
    
            return "Api data accessed successfully.";
         }
    
    }
    
    
}
