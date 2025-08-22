<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class About extends Component
{
    public array $milestones = [];

    public function mount(): void
    {
        // In a real application, you would fetch this data from the database.
        // For example: $this->milestones = Milestone::orderBy('date')->get()->toArray();
        $this->milestones = [
            ['date' => '2022-01-15', 'title' => '專案啟動', 'description' => '舉行了初步會議並完成專案規劃。'],
            ['date' => '2023-03-22', 'title' => '設計階段', 'description' => '線框稿和視覺設計稿已建立並獲得批准。'],
            ['date' => '2023-06-30', 'title' => '開發開始', 'description' => '主要功能的程式碼開發正式開始。'],
            ['date' => '2023-09-10', 'title' => 'Alpha 版本', 'description' => '發布了第一個用於內部測試的版本。'],
            ['date' => '2023-11-05', 'title' => 'Beta 測試', 'description' => '功能完整的版本已發布給部分使用者進行測試。'],
            ['date' => '2025-01-20', 'title' => '正式上線', 'description' => '專案現已對所有使用者開放！'],
        ];
    }

    public function render()
    {
        return view('livewire.pages.about');
    }
}
