<div>
    <div x-data="{
        message: null,
        chatWithUserId: null,
    }">
        <div class="flex gap-5">

            <div>
                <div class="w-[350px] grid grid-cols-1 gap-3">
                    @if (count($users) > 1)
                        @foreach ($users as $user)
                            @if ($user['id'] != auth()->id())
                                @if ($chat_user_id == $user['id'])
                                    <button
                                        x-on:click="$wire.set('chat_user_id',{{ $user['id'] }}), chatWithUserId='{{ $user['id'] }}'"
                                        type="button"
                                        class="block w-full px-5 py-3 text-left text-white bg-green-500 rounded-full shadow-sm">
                                        {{ $user['name'] }}
                                    </button>
                                @else
                                    <button
                                        x-on:click="$wire.set('chat_user_id',{{ $user['id'] }}), chatWithUserId='{{ $user['id'] }}'"
                                        type="button"
                                        class="block w-full px-5 py-3 text-left bg-gray-100 rounded-full shadow-sm hover:bg-gray-300">
                                        {{ $user['name'] }}
                                    </button>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <span>create more users</span>
                    @endif

                </div>
            </div>


            <div class="grid w-full grid-cols-1 gap-5">
                @if ($chat_user_id)
                    @if ($messages)
                        <div class="grid grid-cols-1 gap-5 p-3 bg-gray-100 rounded-lg">

                            @foreach ($messages as $message)
                                @if (auth()->id() == $message['user_id'])
                                    <div class="p-3 bg-green-300 rounded-lg">
                                        <div class="grid grid-cols-1 gap-2">
                                            <div class="flex items-center justify-between gap-5">
                                                <span
                                                    class="px-5 py-2 bg-green-400 rounded-full">{{ $message['user']['name'] }}</span>
                                                <span
                                                    class="text-sm">{{ Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</span>
                                            </div>
                                            <div class="px-3">
                                                {{ $message['text'] }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 bg-gray-300 rounded-lg">
                                        <div class="grid grid-cols-1 gap-2">
                                            <div class="flex items-center justify-between gap-5">
                                                <span
                                                    class="px-5 py-2 bg-gray-400 rounded-full">{{ $message['user']['name'] }}</span>
                                                <span
                                                    class="text-sm">{{ Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</span>
                                            </div>
                                            <div class="px-3">
                                                {{ $message['text'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    @else
                        <span>keine Nachrichten</span>
                    @endif

                    <div class="flex items-center gap-5">
                        <div class="w-full">
                            <input type="text" x-model="message"
                                class="block w-full px-5 py-3 bg-green-100 border border-green-500 rounded-full" />
                        </div>
                        <div class="w-[80px]">
                            <template x-if="chatWithUserId && message">
                                <button type="button" x-on:click="$wire.sendMessageGlobal(message), message=null"
                                    class="flex items-center justify-center text-white bg-green-500 rounded-full shadow-sm hover:bg-green-600 w-14 h-14">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="24px"
                                        viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                        <path
                                            d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z" />
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
