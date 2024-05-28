<?php

namespace App\Livewire;

use App\Events\GotMessageEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatMessage extends Component
{
    public array $messages = [];

    public array $users = [];

    public ?int $chat_user_id = null;

    public function mount()
    {
        $this->users = collect(User::all())->toArray();
    }

    public function render()
    {

        $this->showMessages();

        return view('livewire.chat-message');
    }

    public function sendMessageGlobal(string $message)
    {
        if ($this->chat_user_id) {
            Message::create([
                'user_id' => auth()->id(),
                'chat_user_id' => $this->chat_user_id,
                'text' => $message,
            ]);

            GotMessageEvent::dispatch();
        } else {
            dd('kein user ausgewählt');
        }
    }

    #[On('echo:chat-block,GotMessageEvent')]
    public function listenForMessages()
    {
        $this->showMessages();
    }

    public function showMessages()
    {
        if ($this->chat_user_id) {
            $this->messages = collect(Message::with('user')
                ->where(function ($query) {
                    $query->where('chat_user_id', $this->chat_user_id)
                        ->orWhere('user_id', $this->chat_user_id);
                })->get()->append('time'))->toArray();
        }
    }
}
