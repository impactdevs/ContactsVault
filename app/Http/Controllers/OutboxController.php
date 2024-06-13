<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Outbox;
use App\Models\SmsOutbox;
use App\Models\EmailOutbox;
use Illuminate\Support\Facades\Http;
use App\Models\WhatsappOutbox;

class OutboxController extends Controller
{
    // Render SMS outbox
    public function outboxSms()
    {
        $msg = SmsOutbox::all();
       
        return view('sms.outbox',  compact('msg'));
    }
   
    // Render email outbox
    public function outboxEmail()
    {
        $data = EmailOutbox::all();
       // dd($data);
        return view('email.outbox', compact('data'));
    }


    
    public function outboxWhatsapp()
    {
        $data = WhatsappOutbox::all();
        return view('whatsapp.outbox', compact('data'));
    }

    // Fetch Omni logs
    public function omniLogs()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'App ' . env('INFOBIP_API_KEY')
            ])->get('https://n8lr82.api.infobip.com/omni/1/logs?channel=EMAIL');

            $res = json_decode($response->body());

            if (isset($res->results) && is_array($res->results)) {
                foreach ($res->results as $lg) {
                    $log = new Outbox();
                    $log->sentTo = $lg->to; 
                    $log->sentFrom = $lg->from;
                    $log->body = $lg->text;
                    $log->channel = $lg->channel;
                    $log->deliveryStatus = $lg->status->groupName; 
                    $log->save();
                }
                return "API data accessed successfully.";
            } else {
                // Handle empty or invalid response
                return response()->json(['error' => 'No valid results found in the response.'], 400);
            }
        } catch (\Exception $e) {
            // Handle request error
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
