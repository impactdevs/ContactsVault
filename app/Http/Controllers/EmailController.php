<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\EmailOutbox;
use App\Models\Email;
use HTTP_Request2;
use Illuminate\Support\Facades\Http;

class EmailController extends Controller
{
    //fetching emails
        public function inbox()
    {
       
         //calling the api
         $response = Http::withHeaders([
            'Authorization' =>  env('INFOBIP_API_KEY')
        ])->get('https://n8lr82.api.infobip.com/email/1/logs');
    
        $res = json_decode($response->body());

        if (isset($res->results) && is_array($res->results)) {
            
            foreach ($res->results as $apiemail) {
              
                $dateTime = new \DateTime( $apiemail->sentAt);
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
    
                $email = new Email();
                $email->sentTo = $apiemail->to; 
                $email->sentFrom = $apiemail->from; 
                $email->text = $apiemail->text;
                $email->recievedAt = $formattedDateTime;
               // $email->deliveryStatus = $apiemail->status->groupName;
    
                
                $email->save();
              
            }
    
            return "Api data accessed successfully.";
         }

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
        $request->setUrl('https://n8lr82.api.infobip.com/email/3/send');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => env('INFOBIP_API_KEY'),
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
            'Authorization' => env('INFOBIP_API_KEY')
        ])->get('https://n8lr82.api.infobip.com/email/1/logs');
    
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
