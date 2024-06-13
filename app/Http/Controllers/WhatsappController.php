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


//     //sending whatsapp
//     public function sendWhatsapp(Request $request, $id)
// {
//     $client = Clients::find($id);

//     if (!$client) {
//         return abort(404);
//     }

//     $request->validate([
//         'phone_no' => 'required|string',
//         'message' => 'required|string',
//     ]);

//     $phoneNumber = $request->input('phone_no');
//     $message = $request->input('message');

//     try
//     {
     

//         $curl = curl_init();
        
//         curl_setopt_array($curl, array(
//             CURLOPT_URL => 'https://y3qnrd.api.infobip.com/whatsapp/1/message/text',
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_ENCODING => '',
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => 'POST',
//             CURLOPT_POSTFIELDS =>'{
//                 "from":"441134960000",
//                 "to":'.$phoneNumber.',
//                 "messageId":"a28dd97c-1ffb-4fcf-99f1-0b557ed381da",
//                 "content":{"text":'.$message.'},
//                 "callbackData":"Callback data",
//                 "notifyUrl":"https://www.example.com/whatsapp",
//                     "urlOptions":{"shortenUrl":true,
//                         "trackClicks":true,
//                         "trackingUrl":"https://example.com/click-report",
//                         "removeProtocol":true,
//                         "customDomain":"example.com"
//                     }
//             }',
//             CURLOPT_HTTPHEADER => array(
//                 'Authorization: {App 1aa432238cba3403475e3d63d4e57602-ebcd8786-ade9-4122-a975-979121c615a6}',
//                 'Content-Type: application/json',
//                 'Accept: application/json'
//             ),
//         ));
        
//         $response = curl_exec($curl);
        
//         curl_close($curl);
      
//     dd($response);

//     if ($response->successful()) {
//         return response()->json(['success' => 'Message sent successfully']);
//     } else {
//         return response()->json(['error' => 'Unexpected HTTP status: ' . $response->status() . ' ' . $response->body()], 500);
//     }
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
//     }
// }
    

    public function outboxWhatsapp ()
    {
        
        //calling the api
        $response = Http::withHeaders([
            'Authorization' => env('INFOBIP_API_KEY')
        ])->get('https://n8lr82.api.infobip.com/omni/1/logs?channel=WHATSAPP');
    
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

    public function whatsappInbox(Request $request)
    {
      
        $response = Http::withHeaders([
            'Authorization' => env('INFOBIP_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://n8lr82.api.infobip.com/subscriptions/1/certificates/test/webhook', [
            'certificateId' => 'my-certificate-1',
            'webhookUrl' => 'https://webhook.site/f08bf8ee-7997-4754-80b6-64f528bdbe11/whatsapp_inbox'
        ]);
    
        $res = json_decode($response->body());
       
        if ($res !== 200 )
        {
            return $res ;
            die();
        } else {
            return response ()->json(['status'=>'success'], 200);
        }
  
    }

    public function inboxWhatsappWebhook(Request $request)
    {
        
        // Your logic here
        // $response = Http::withHeaders([
        //     'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7',
        //     'Content-Type' => 'application/json'
        // ])->post('https://e1kq5n.api.infobip.com/subscriptions/1/certificates/test/webhook', [
        //     'certificateId' => 'my-certificate-1',
        //     'webhookUrl' => 'http://127.0.0.1:8000/whatsapp_inbox'
        // ]);
    

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://n8lr82.api.infobip.com/subscriptions/1/certificates/test/webhook',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"certificateId":"my-certificate-1","webhookUrl":"http://127.0.0.1:8000/whatsapp_inbox"}',
            CURLOPT_HTTPHEADER => array(
                'Authorization:'. env('INFOBIP_API_KEY'),
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
          
    }
    
}
