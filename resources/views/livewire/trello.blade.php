<!-- component -->
<div class="p-8 bg-green-200 w-full h-screen font-sans">
    @if($addGroupState)
        <form class="p-4 max-w-xs"
            wire:submit.prevent="saveEntity"
        >
            <input
                wire:model.defer="title"
                type="text"
                id="group"
                name="group"
                class="mt-1 p-2 w-full border rounded-md
                @error('title') border-red-500 @enderror"
                placeholder="Enter new group name..."
            >
        </form>
    @else
        <button
            wire:click="addGroup"
            class="min-w-44 max-w-44 p-3 flex justify-center items-center transition ease-in-out delay-150 bg-slate-50 hover:-translate-y-1 hover:scale-110 hover:bg-green-500 duration-300 cursor-pointer rounded"
        >
            Add Desk
        </button>
    @endif

    <div
        class="flex py-8 items-start"
        wire:sortable="sorting" wire:sortable-group="sorting"
    >
        @foreach($groups as $group)
            <div
                class="rounded bg-slate-50 flex-no-shrink w-64 p-2 mr-3"
                wire:key="group-{{ $group->id }}" wire:sortable.item="{{ $group->id }}"
            >
                <div class="flex justify-between py-1">
                    <h3 class="font-bold text-green-700 cursor-pointer"
                        wire:sortable.handle
                    >
                        {{ $group->title }}
                    </h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 cursor-pointer"
                     wire:click="deleteGroup({{ $group->id }})"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>

                <div class="text-sm mt-2"
                     wire:sortable-group.item-group="{{ $group->id }}"
                >
                    @foreach($group->cards as $card)
                        <div class="flex bg-white p-2 justify-between rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter"
                             wire:key="card-{{ $card->id }}" wire:sortable-group.item="{{ $card->id }}"
                        >
                            <h4 class="flex cursor-pointer">
                                {{ $card->title }}
                            </h4>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 cursor-pointer"
                                 wire:click="deleteCard({{ $card->id }})"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </div>
                    @endforeach

                @if($addCardState === (string)$group->id)
                    <form class="py-4 max-w-xs"
                          wire:submit.prevent="saveEntity"
                    >
                        <input
                            wire:model.defer="title"
                            type="text"
                            id="card"
                            name="card"
                            class="mt-1 p-2 w-full border rounded-md
                            @error('title') border-red-500 @enderror"
                            placeholder="Enter new card name..."
                        >
                    </form>
                @else
                    <button
                        class="mt-3 text-grey-dark"
                        wire:click="addCard({{ $group->id }})"
                    >
                        Add a card...
                    </button>
                @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
