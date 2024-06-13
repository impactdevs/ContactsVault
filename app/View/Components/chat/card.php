<?php

namespace App\View\Components\chat;

use App\Models\Chat;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class card extends Component
{
    //sender name
    public Chat $chat;
    /**
     * Create a new component instance.
     */
    public function __construct(
        Chat $chat,
    ) {
        $this->chat = $chat;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chat.card');
    }
}
