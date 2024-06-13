<?php
namespace App\Http\Controllers;
//namespace App\Http\Controllers\Webhook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Infobip\Model\WhatsAppWebhookInboundMessageResult;
use Infobip\Model\WhatsAppWebhookInboundTextMessage;
use Infobip\Model\WhatsAppWebhookInboundImageMessage;
use Infobip\Model\WhatsAppWebhookInboundDocumentMessage;
use Infobip\Model\WhatsAppWebhookInboundLocationMessage;
use Infobip\Model\WhatsAppWebhookInboundContactMessage;
use Infobip\ObjectSerializer;

class WebhookController extends Controller
{
    public function __construct(private ObjectSerializer $objectSerializer)
    {
    }

    public function handleWebhook(Request $request)
    {
        
    }
}
