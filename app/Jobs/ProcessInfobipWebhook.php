<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessInfobipWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public WebhookCall $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }


    /**
     * Execute the job.
     */
    public function handle(array $payload): void
    {
        //processing payload data
        $payload = $this->webhookCall->payload;

        // Process the webhook payload
        if (isset($payload['messages'])) {
            foreach ($payload['messages'] as $message) {
                // Handle inbound WhatsApp message
                $from = $message['from'];
                $text = $message['text'];
                
            }
        }
        
    }
}
