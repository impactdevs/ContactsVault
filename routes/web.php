<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\OutboxController;
use App\Http\Controllers\ComposeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ConversationsController;
use App\Http\Controllers\WebhookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::PUT('/update-settings', [SettingController::class, 'update'])->name('settings.update');

});

//clients routes
Route::resource('clients', ClientsController::class);

//compose messages
Route::get('/compose_sms/{id}', [ComposeController::class, 'compose'])->name('compose');
Route::post('/sendsms/{id}', [ComposeController::class, 'sendSms'])->name('sendsms');
Route::get('/compose_whatsapp/{id}', [ComposeController::class, 'composeWhatsappMessage'])->name('composeWhatsapp');
Route::match(['get', 'post'], '/sendwhatsapp/{id}', [ComposeController::class, 'sendWhatsapp'])->name('sendwhatsapp');
Route::get('/compose_email/{id}', [ComposeController::class, 'composeEmail'])->name('composeEmail');
Route::post('/sendemail/{id}', [ComposeController::class, 'sendEmail'])->name('sendemail');

//outbox messages
Route::get('/sms_outbox', [OutboxController::class, 'outboxSms'])->name('sms_outbox');
Route::get('/whatsapp_outbox', [OutboxController::class, 'outboxWhatsapp'])->name('whatsapp_outbox');
Route::get('/email_outbox/', [OutboxController::class, 'outboxEmail'])->name('email_outbox');

//inbox messages
Route::get('/whatsapp_inbox', [InboxController::class, 'inboxWhatsapp'])->name('whatsapp_inbox');
Route::get('/email_inbox/', [InboxController::class, 'inboxEmail'])->name('email_inbox');
Route::get('/sms_inbox', [InboxController::class, 'inboxSms'])->name('sms_inbox');

//api
Route::get('/sms_inbox_api', [SmsController::class, 'index'])->name('sms_inbox_api');
Route::get('/email_inbox_api', [EmailController::class, 'inbox'])->name('email_inbox_api');
Route::get('/whatsapp_inbox_api',[WhatsappController::class, ''])->name('whatsapp_inbox_api');
Route::get('/sms_outbox_api', [SmsController::class, 'outboxSms'])->name('sms_outbox_api');
Route::get('/email_outbox_api',[EmailController::class, 'outboxEmail'])->name('email_outbox_api');
Route::get('/whatsapp_outbox_api',[WhatsappController::class,'outboxWhatsapp'])->name('whatsapp_outbox_api');

//webhook
Route::post('webhook/whatsapp_outbox', [WhatsappController::class, 'infobip']);

//omni
Route::get('/omnilogs', [OutboxController::class, 'omniLogs'])->name('logs');

//conversations
Route::get('/get_conversations', [ConversationsController::class, 'index'])->name('conversations');
Route::get('/send_message', [ConversationsController::class, 'sendMessage'])->name('send_msg');


Route::get('/create_message', [MessagesController::class, 'create'])->name('create_msg');
Route::post('/send_message', [MessagesController::class, 'sendMessage'])->name('send_msg');


require __DIR__.'/auth.php';
