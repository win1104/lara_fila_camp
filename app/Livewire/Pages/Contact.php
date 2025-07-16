<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class Contact extends Component
{
    public $member_name = '';
    public $member_phone = '';
    public $member_email = '';
    public $member_company = '';
    public $question_category = '';
    public $member_note = '';
    public $code = '';

    public function submit()
    {
        $this->validate([
            'member_name' => 'required|string|max:255',
            'member_email' => 'required|email',
            // 'captcha' => 'required|captcha'
        ], [
            'member_name.required' => '請輸入姓名',
            'member_email.required' => '請輸入電子信箱',
            'member_email.email' => '請輸入正確的電子信箱格式',
        ]);

        $now = Carbon::now();

        $form_data = [
            'member_name' => $this->member_name,
            'member_email' => $this->member_email,
            'member_cellphone' => $this->member_phone, // 自訂欄位
            'member_phone' => $this->member_company, // 自訂欄位
            'question_category' => $this->question_category,
            'member_note' => $this->member_note,
            'code' => $this->captcha,
            'send_date' => $now->toDateString(),
            'mail_form_title' => '< 混合無限智慧科技（姓名：' . $this->member_name . '） >',
        ];

        // DB::table('contact_data')->insert([
        //     'form_type' => 'contact',
        //     'form_code' => $now->toDateString(),
        //     'form_title' => $this->member_name,
        //     'form_intro' => $this->member_email,
        //     'form_info' => $this->question_category,
        //     'form_content' => $this->member_note,
        //     'form_data' => serialize((object) $form_data),
        //     'form_status' => 'new',
        //     'form_domain' => request()->ip(),
        //     'create_date' => $now,
        //     'modify_date' => $now,
        // ]);

        // 👉 寫入資料庫或發送 email（視你需求）
        session()->flash('success', '表單送出成功！');

        $this->reset(); // 清空表單
    }

    public function render()
    {
        return view('livewire.pages.contact');
    }
}
