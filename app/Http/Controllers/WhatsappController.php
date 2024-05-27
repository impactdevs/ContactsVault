<?php

namespace App\Http\Controllers;
//.namespace App\Controller\Webhook;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\WhatsappOutbox;
use HTTP_Request2;
use Infobip\Configuration;
use Infobip\Model\WhatsAppTextMessage;
use Infobip\Api\WhatsAppApi;
use Illuminate\Support\Facades\Log;
use App\Services\ObjectSerializer;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Http;


class WhatsappController extends Controller
{
    

    //#[Route('/whatsapp', name: 'webhook_whatsapp', methods: ['POST'])]
    public function receiveAction(Request $request)
    {
       
    }



    //compose whatsapp
    public function composeWhatsappMessage(Request $request, $id)
    {
       
        $client = Clients::find($id);

        if (!$client)
        {
            return abort(404);
        }

        return view('whatsapp.create', ['client' => $client]);
    }


    //sending whatsapp
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
    

    public function outboxWhatsapp ()
    {
        
        //calling the api
        $response = Http::withHeaders([
            'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7'
        ])->get('https://e1kq5n.api.infobip.com/omni/1/logs?channel=WHATSAPP');
    
        $res = json_decode($response->body());

        if (isset($res->results) && is_array($res->results)) {
            foreach ($res->results as $tsap) {
    
                $dateTime = new \DateTime($tsap->sentAt);
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

                $whatsappOutbox = new WhatsappOutbox();
                $whatsappOutbox->sentTo = $tsap->to;
                $whatsappOutbox->sentFrom = $tsap->from;
                $whatsappOutbox->text = $tsap->text;
                $whatsappOutbox->sentAt = $formattedDateTime;
                $whatsappOutbox->deliveryStatus = $tsap->status->groupName;

                $whatsappOutbox->save();
                
            }
    
            return "Api data accessed successfully.";
         }
    

    }

    public function inboxWhatsappWebhook(Resquest $request)
    {

        $data = $request -> all();

        \log :: info('Webhook received:', $data);

        return response ()->json(['status'=>'success'], 200);
    }
    
}
