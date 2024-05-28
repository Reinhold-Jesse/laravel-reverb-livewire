<?php

namespace App\Livewire;

use App\Events\MessageEvent;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageComponent extends Component
{
    public $message = '';

    public $conversation = [];

    #[On('echo:our-channel,MessageEvent')]
    public function listenForMessage($data)
    {
        $this->conversation[] = $data['theMessage'];
    }

    public function render()
    {
        return view('livewire.message-component');
    }

    public function submitMessage()
    {
        MessageEvent::dispatch($this->message);
    }
}
