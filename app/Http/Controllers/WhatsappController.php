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

    try {
        $response = Http::withHeaders([
            'Authorization' => 'App 178ffc5906619ad39ca8b839f57d861e-c466493b-4429-4f92-a172-98c6c4fb03d7',
            'Accept' => 'application/json'
        ])->post('https://e1kq5n.api.infobip.com/whatsapp/1/message/text', [
            'from' => '447860099299',
            'to' => $phoneNumber,
            'text' => $message
        ]);

        if ($response->successful()) {
            return response()->json(['success' => 'Message sent successfully']);
        } else {
            return response()->json(['error' => 'Unexpected HTTP status: ' . $response->status() . ' ' . $response->body()], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
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

    public function whatsappInbox(Resquest $request)
    {
        dd('$request');
        if (isset($data) && !empty($data))
        {
            $data = $request -> all();

            \log :: info('Webhook received:', $data);
    
            return response ()->json(['status'=>'success'], 200);
        } else {
            echo "error ";
        }
       
    }
    
}
