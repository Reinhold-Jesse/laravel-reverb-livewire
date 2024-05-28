<div>
    @php
        print '<pre>';
        print_r($conversation);
        print '</pre>';
    @endphp
    <input wire:model='message' type="text">
    <button wire:click='submitMessage'>Submit</button>
</div>
