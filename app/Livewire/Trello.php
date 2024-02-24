<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Group;
use Livewire\Component;

class Trello extends Component
{
    public function addGroup()
    {
        Group::create([
            'title' => uniqid()
        ]);
    }

    public function addCard($groupId)
    {
        Card::create([
            'group_id' => $groupId,
            'title' => uniqid()
        ]);
    }

    public function deleteGroup($groupId)
    {
        Group::destroy($groupId);
    }

    public function deleteCard($cardId)
    {
        Card::destroy($cardId);
    }

    public function render()
    {
        $groups = Group::orderBy('sort')->get();

        return view('livewire.trello', compact('groups'));
    }
}
