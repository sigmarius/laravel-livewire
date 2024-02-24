<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Group;
use Livewire\Component;

class Trello extends Component
{
    /**
     * @var bool Начальное состояние для кнопки добавления группы
     */
    public bool $addGroupState = false;

    /**
     * @var string Начальное состояние для кнопки добавления карточки
     * при нажатии на кнопку в компоненте будет содержать переданное id группы
     */
    public string $addCardState = '';

    /**
     * @var string Будет содержать название для элемента,
     * приходящее при submit формы в компоненте
     */
    public string $title;

    /**
     * Валидация
     * @var string[]
     */
    protected $rules = [
        'title' => 'required'
    ];

    /**
     * При клике на кнопку отображает input для ввода данных,
     * и переходит в активное состояние
     * @return void
     */
    public function addGroup()
    {
        $this->addGroupState = true;
    }

    /**
     * При клике на кнопку отображает input для ввода данных,
     * и сохраняет в addCardState id группы
     *
     * @param $groupId
     * @return void
     */
    public function addCard($groupId)
    {
        $this->addCardState = $groupId;
    }


    /**
     * В зависимости от переменных state
     * сохраняет либо группу, либо карточку для группы
     * @return void
     */
    public function saveEntity()
    {
        $data = $this->validate();

        if ($this->addGroupState) {
            Group::create($data);
        } else {
            $data['group_id'] = $this->addCardState;
            Card::create($data);
        }

        // все переменные перейдут в начальное значение
        $this->reset();
    }

    /**
     * Удаляет группу с переданным id
     * @param $groupId
     * @return void
     */
    public function deleteGroup($groupId)
    {
        Group::destroy($groupId);
    }

    /**
     * Удаляет карточку с переданным id
     * @param $cardId
     * @return void
     */
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

    /**
     * Рендерит компонент
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        $groups = Group::orderBy('sort')->get();

        return view('livewire.trello', compact('groups'));
    }
}
