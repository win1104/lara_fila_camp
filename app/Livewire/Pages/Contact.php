<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Mail\FormMailSend;
use Illuminate\Support\Facades\Mail;
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

        $now = Carbon::now();

        $form_data = [
            'member_name' => $this->member_name,
            'member_phone' => $this->member_phone, // 自訂欄位
            'member_email' => $this->member_email,
            'member_company' => $this->member_company, // 自訂欄位
            'question_category' => $this->question_category,
            'member_note' => $this->member_note,
            // 'code' => $this->captcha,
            'send_date' => $now->toDateString(),
            'mail_form_title' => '< 混合無限智慧科技（姓名：' . $this->member_name . '） >',
        ];

        ContactService::handleContactForm($form_data);

        session()->flash('success', '表單送出成功！');

        $this->reset();
        // $this->reset(
        //     'member_name',
        //     'member_phone',
        //     'member_email',
        //     'member_company',
        //     'question_category',
        //     'member_note',
        //     'captcha'
        // );
        $this->formKey = rand();
    }

    // public function resetForm()
    // {
    //     $this->reset();
    //     $this->reset(
    //         'member_name',
    //         'member_phone',
    //         'member_email',
    //         'member_company',
    //         'question_category',
    //         'member_note',
    //         'captcha'
    //     );

    //     session()->flash('success', '已清空表單');

    // }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.contact');
    }
}
