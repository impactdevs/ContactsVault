<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Sms;
use HTTP_Request2;
use Infobip\Configuration;
use Infobip\ApiException;
use App\Http\Controllers\SmsController;

use Infobip\Model\WhatsAppWebhookInboundContactMessage;
use Infobip\Model\WhatsAppWebhookInboundDocumentMessage;
use Infobip\Model\WhatsAppWebhookInboundImageMessage;
use Infobip\Model\WhatsAppWebhookInboundLocationMessage;
use Infobip\Model\WhatsAppWebhookInboundMessageResult;
use Infobip\Model\WhatsAppWebhookInboundTextMessage;
use Infobip\ObjectSerializer;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

class InboxController extends Controller
{
    public function __construct(private ObjectSerializer $objectSerializer)
    {
    }

    //
    public function inboxSms(Request $request)
    {
        //calling the sms controller 
        $data= Sms::all();
       
        return view('sms.index', compact('data'));
    }

    //
    public function inboxEmail()
    {
        $curl = curl_init();

        $url = 'https://n8lr82.api.infobip.com/email/1/logs'; 
        $authorization = env('INFOBIP_API_KEY'); 

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

    
        $responseData = json_decode($response, true);
       
        if (json_last_error() != JSON_ERROR_NONE )
        {
            return redirect()->back()->with('error', __('Invalid JSON response data.'));
        }

        $data =  array();
       // dd($responseData);
        // Render the view with response data
        return view('email.inbox', compact('responseData'));
    }

    //
    public function inboxWhatsapp(Request $request)
    {
       /**
         * @var WhatsAppWebhookInboundMessageResult $messageData
         */
        $messageDataResult = $this->objectSerializer->deserialize(
            $request->getContent(),
            WhatsAppWebhookInboundMessageResult::class
        );

        foreach ($messageDataResult as $messageData) {
            foreach ($messageData->getResults() as $result) {
                $message = $result->getMessage();

                if ($message instanceof WhatsAppWebhookInboundTextMessage) {
                    $text = $message->getText();
                } elseif ($message instanceof WhatsAppWebhookInboundImageMessage) {
                    $text = $message->getCaption();
                } elseif ($message instanceof WhatsAppWebhookInboundDocumentMessage) {
                    $text = $message->getCaption();
                } elseif ($message instanceof WhatsAppWebhookInboundLocationMessage) {
                    $text = $message->getAddress();
                } elseif ($message instanceof WhatsAppWebhookInboundContactMessage) {
                    $names = array_map(
                        function ($contact) {
                            $nameModel = $contact->getName();
                            return $nameModel->getFirstName() . ' ' . $nameModel->getLastName();
                        },
                        $message->getContacts()
                    );

                    $text = implode(', ', $names);
                } else {
                    $text = "Unknown message type";
                }

                echo sprintf(
                    'From: %s - %s',
                    $result->getFrom(),
                    $text
                );
            }
        }
    }




}
