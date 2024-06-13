<div class="card m-3 shadow">
    <a href="/inbox/{{$chat->id}}" style="text-decoration: none;">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3">
            <img src="https://via.placeholder.com/50" class="rounded-circle" alt="avatar">
            <div>
                <h6 class="mb-0">{{ $chat->name }}<span class="badge bg-primary">{{ $chat->messageCount }}</span></h6>
                <p class="small text-muted mb-0 @if ($chat->status == 'unread') fw-bold text-primary @endif">
                    {{ $chat->message }}
                </p>
            </div>
            <div class="ms-auto text-end">
                <p class="small text-muted mb-0">
                    @if ($chat->channel == 'sms')
                        <i class="bi bi-chat"></i>
                    @elseif($chat->channel == 'email')
                        <i class="bi bi-envelope"></i>
                    @elseif($chat->channel == 'whatsapp')
                        <i class="bi bi-whatsapp"></i>
                    @endif
                </p>
                <p class="small text-muted mb-0">{{ $chat->created_at }}</p>
            </div>
        </div>
    </div>
    </a>
</div>
