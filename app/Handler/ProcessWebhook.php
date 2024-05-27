<?php

namespace App\Handler;

use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessWebhook extends ProcessWebhookJob
{

    public function handle ()
    {
        $dat =  json_decode($this->webhookCall, true);
        $data = $dat['payload'];

        if ($data['event']=='charge.success')
        {
            //perform actions 

            Log::info($data);
        }
        http_response_code(200);
    }

}

