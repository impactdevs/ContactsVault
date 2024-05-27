<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use HTTP_Request2;
use Infobip\Configuration;
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
    
        $url = 'https://e1kq5n.api.infobip.com/whatsapp/1/message/text';
        $authorization = 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7';
    
        $payload = [
            'from' => '441134960000',
            'to' => $phoneNumber,
            'messageId' => 'a28dd97c-1ffb-4fcf-99f1-0b557ed381da',
            'content' => ['text' => $message],
            'callbackData' => 'Callback data',
            'notifyUrl' => 'https://www.example.com/whatsapp',
            'urlOptions' => [
                'shortenUrl' => true,
                'trackClicks' => true,
                'trackingUrl' => 'https://example.com/click-report',
                'removeProtocol' => true,
                'customDomain' => 'example.com'
            ]
        ];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $authorization,
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);
    
        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);
    
        if ($response === false) {
            return response()->json(['error' => 'Curl error: ' . $error], 500);
        }
    
        $responseDecoded = json_decode($response, true);
    
        if ($httpStatusCode == 200) {
            //return response()->json(['success' => 'Message sent successfully', 'response' => $responseDecoded]);
            $message = 'whatsapp message sent successfully';
            return redirect()->back()->with('success', $message);
        } else {
            //return response()->json(['error' => 'Unexpected HTTP status: ' . $httpStatusCode, 'response' => $responseDecoded], 500);
            $message = 'Whatsapp mesage not sent';
            return redirect()->back()->with('error', $message);
        }
    }
}