<?php 

namespace App\Handler;

Use Spatie\WebhookClient\ProcessWebhookJob;

class WebhookHandler extends ProcessInfobipWebhook 
{

    public function handle ()
    {

        logger('webhook alert');
        logger($this->webhookcall);
        
    }
}
