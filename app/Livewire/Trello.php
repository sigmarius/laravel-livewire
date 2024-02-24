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

    /**
     * Сортирует группы и карточки
     * @param array $order приходит из плагина livewire-sortable
     * при изменении порядка групп или карточек
     * содержит id элемента (ключ 'value')
     * и обновленный порядок элементов (ключ 'order')
     * @return void
     */
    public function sorting(array $order): void
    {
        foreach ($order as $group) {
            Group::where(['id' => $group['value']])
                ->update(['sort' => $group['order']]);

            if (isset($group['items'])) {
                foreach ($group['items'] as $card) {
                    Card::where(['id' => $card['value']])
                        ->update(['sort' => $card['order']]);
                }
            }
        }
    }

    public function render()
    {
        $groups = Group::orderBy('sort')->get();

        return view('livewire.trello', compact('groups'));
    }
}
