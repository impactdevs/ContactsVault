<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use HTTP_Request2;
use Infobip\Configuration;
use Infobip\Api\WhatsAppApi;
use Infobip\Model\WhatsAppTextMessage;
use Infobip\Model\WhatsAppTextContent;
use Infobip\ApiException;

class ComposeController extends Controller
{
    //render composer page 
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
        $request->setUrl('https://n8lr82.api.infobip.com/sms/2/text/advanced');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(['follow_redirects' => true]);
        $request->setHeader([
            'Authorization' => env('INFOBIP_API_KEY'),
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

    //render the email page 
    public function composeEmail(Request $request, $id)
    {
        
        $client = Clients::find($id);

        if (!$client)
        {
            return abort(404);
        }

        return view('email.create', ['client' => $client]);
    }

    //compose email
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
                $message = 'message sent successfully';
                return redirect()->back()->with('success', $message);
                
            } else {
                return response()->json(['error' => 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase()], 500);
            }
        } catch (HTTP_Request2_Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    //render tsap page 
    public function composeWhatsappMessage(Request $request, $id)
    {
       
        $client = Clients::find($id);

        if (!$client)
        {
            return abort(404);
        }

        return view('whatsapp.create', ['client' => $client]);
    }


    //whatsapp message 
    public function sendWhatsapp(Request $request, $id)
    {
        
        $client = Clients::find($id);

    if (!$client) {
        return abort(404);
    }

    $request->validate([
        'phone_no' => 'required|string',
        'message' => 'required|string',
    ]);

    $phoneNumber = $request->input('phone_no');
    $message = $request->input('message');

    try
    {
     
        $configuration = new Configuration(
            host: 'https://n8lr82.api.infobip.com/whatsapp/1/message/text',
            apiKey: env('INFOBIP_API_KEY')
        );

        $whatsAppApi = new WhatsAppApi(config: $configuration);

        $textMessage = new WhatsAppTextMessage(
            from: '256753669047',
            to: $phoneNumber,
            content: new WhatsAppTextContent(
                text: $message
            )
        );

        $messageInfo = $whatsAppApi->sendWhatsAppTextMessage($textMessage);
    
        //dd($messageInfo);
        if($messageInfo->getStatus()->getCode() == 0)
        {
        $message = 'Whatsapp sent successfully';
        return redirect()->back()->with('success', $message);
        } else {
            $message = 'Failed to send messagge' . $messageInfo->getStatus()->getGroupName();
            return redirect()->back()->with('error', $message);
        }
               
    } catch (\Exception $e) {
        $message = 'Failed to send message';
        return redirect()->back()->with('error', $message);
       // return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
    }
    }
    
}