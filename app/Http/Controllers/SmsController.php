<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Infobip\Configuration;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsTextualMessage;
use Infobip\ObjectSerializer;
use Infobip\Model\SmsInboundMessageResult;
use App\Models\SmsOutbox;
use App\Models\Clients;
use HTTP_Request2;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    
   
    //fetching sms
    public function index(Request $request)
    {
       //calling the api
       $response = Http::withHeaders([
        'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7'
    ])->get('https://e1kq5n.api.infobip.com/sms/1/inbox/reports');

    $res = json_decode($response->body());

    if (isset($res->results) && is_array($res->results)) {
        foreach ($res->results as $sms) {
            $msg = new SmsOutbox();
            $msg->sentTo = $sms->to; 
            $msg->sentFrom = $sms->from;
            $msg->text = $sms->text;
            $msg->receivedAt = $sms->receivedAt;
  
            $msg->save();
            //Outbox::create($log);
            
        }

        return "Api data accessed successfully.";
     }
     
    }

    //compose sms

    public function compose(Request $request, $id)
    {
        
        $client = Clients::find($id);

        if (!$client)
        {
            return abort(404);
        }

        return view('sms.create', ['client' => $client]);
    }


    //sending sms
    public function sendSms(Request $request, Clients $client)
    {
    $phoneNumber = $request->phone_no;
    $body = $request->sms;

    // Ensure the phone number is valid
    if (!$phoneNumber) {
        return response()->json(['error' => 'Client does not have a valid phone number'], 400);
    }

    try {
        $request = new HTTP_Request2();
        $request->setUrl('https://e1kq5n.api.infobip.com/sms/2/text/advanced');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(['follow_redirects' => true]);
        $request->setHeader([
            'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);
        $requestBody = json_encode([
            'messages' => [[
                'destinations' => [['to' => $phoneNumber]],
                'from' => 'Contacts Vault',
                'text' => $body 
            ]]
        ]);
        $request->setBody($requestBody);

        $response = $request->send();
        if ($response->getStatus() == 200) {
            $message = 'SMS sent successfully';
            return redirect()->back()->with('success', $message);
        } else {
            $errorMessage = 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
            return redirect()->back()->with('error', $errorMessage);
        }
    } catch (HTTP_Request2_Exception $e) {
        $errorMessage = 'Failed to send SMS: ' . $e->getMessage();
        logger()->error($errorMessage);
        return redirect()->back()->with('error', $errorMessage);
    }
    
    }

    public function outboxSms()
    {
         //calling the api
       $response = Http::withHeaders([
        'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7'
    ])->get('https://e1kq5n.api.infobip.com/sms/3/logs');

    $res = json_decode($response->body());

    if (isset($res->results) && is_array($res->results)) {
        foreach ($res->results as $sms) {

            $dateTime = new \DateTime( $sms->sentAt);
            $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

            $msg = new SmsOutbox();
            $msg->sentTo = $sms->destination; 
            $msg->text = $sms->content->text;
            $msg->receivedAt = $formattedDateTime;
            $msg->deliveryStatus = $sms->status->groupName;

            
            $msg->save();
      
        }

        return "Api data accessed successfully.";
     }

    }

}
