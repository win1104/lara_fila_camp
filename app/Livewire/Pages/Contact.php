<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\ContactService;

class Contact extends Component
{
    public $member_name = '';
    public $member_phone = '';
    public $member_email = '';
    public $member_company = '';
    public $question_category = '';
    public $member_note = '';
    public $captcha = '';
    public $code = '';
    public $formKey;

    public function mount()
    {
        $this->formKey = rand();
    }

    public function submit()
    {
        // 驗證表單
        $this->validate([
            'member_name' => 'required|string|max:255',
            'member_email' => 'required|email',
            'captcha' => ['required', function ($attribute, $value, $fail) {
                if (strtolower($value) !== strtolower(session('captcha'))) {
                    $fail('驗證碼錯誤');
                }
            }],
        ], [
            'member_name.required' => '請輸入姓名',
            'member_email.required' => '請輸入電子信箱',
            'member_email.email' => '請輸入正確的電子信箱格式',
            'captcha' => '驗證碼不對喔',
        ]);

        // 準備表單資料
        $formData = [
            'member_name' => $this->member_name,
            'member_phone' => $this->member_phone,
            'member_email' => $this->member_email,
            'member_company' => $this->member_company,
            'question_category' => $this->question_category,
            'member_note' => $this->member_note,
        ];

        // 呼叫 ContactService 處理
        $result = ContactService::handleContactForm($formData);

        // 根據結果顯示訊息
        if ($result['success']) {
            session()->flash('success', $result['message']);
            $this->reset();
            $this->formKey = rand();
        } else {
            session()->flash('error', $result['message']);
            // 發生錯誤時不清空表單，讓使用者可以修改後重新送出
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.contact');
    }
}
