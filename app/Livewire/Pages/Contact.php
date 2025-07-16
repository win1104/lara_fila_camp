<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Mail\FormMailSend;
use Illuminate\Support\Facades\Mail;

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
            'member_phone' => $this->member_phone, // 自訂欄位
            'member_email' => $this->member_email,
            'member_company' => $this->member_company, // 自訂欄位
            'question_category' => $this->question_category,
            'member_note' => $this->member_note,
            // 'code' => $this->captcha,
            'send_date' => $now->toDateString(),
            'mail_form_title' => '< 混合無限智慧科技（姓名：' . $this->member_name . '） >',
        ];

        DB::table('mail_logs')->insert([
            'type' => 'contact',
            'title' => $this->member_name,
            'slug' => $now->toDateString(),
            'email' => $this->member_email,
            'phone' => $this->member_phone,
            'company' => $this->member_company,
            'info' => $this->question_category,
            'content' => $this->member_note,
            'intro' => serialize((object) $form_data),
            'send_ip' => request()->ip(),
            'send_status' => 'success',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $bcc = '52sherry1123@gmail.com';

        Mail::to($this->member_email)
            ->bcc($bcc) // ← 加這行
            ->send(new FormMailSend($form_data));


        session()->flash('success', '表單送出成功！');

        // $this->reset(); // 清空表單
        $this->reset(
            'member_name',
            'member_phone',
            'member_email',
            'member_company',
            'question_category',
            'member_note',
            // 'captcha'
        );
    }

    public function render()
    {
        return view('livewire.pages.contact');
    }
}
