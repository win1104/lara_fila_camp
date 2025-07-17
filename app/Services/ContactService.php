<?php

namespace App\Services;

use App\Mail\FormMailSend;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    /**
     * 處理聯絡表單流程：儲存 + 寄信
     *
     * @param array $data 來自前端表單的資料
     * @return void
     */
    public static function handleContactForm(array $data): void
    {
        $now = Carbon::now();
        $sendStatus = 'success';

        // 封裝寄信內容
        $form_data = [
            ...$data,
            'send_date' => $now->toDateString(),
            'mail_form_title' => '< 混合無限智慧科技（姓名：' . $data['member_name'] . '） >',
        ];

        try {
            Mail::to($data['member_email'])
                ->bcc('52sherry1123@gmail.com') // 可自行更換
                ->send(new FormMailSend($form_data));
        } catch (\Exception $e) {
            $sendStatus = 'failed';

            // 你也可以 log 起來
            \Log::error('寄送聯絡信件失敗：' . $e->getMessage());
        }

        // 儲存資料到 mail_logs 資料表
        DB::table('mail_logs')->insert([
            'type' => 'contact',
            'title' => $data['member_name'],
            'slug' => $now->toDateString(),
            'email' => $data['member_email'],
            'phone' => $data['member_phone'] ?? '',
            'company' => $data['member_company'] ?? '',
            'info' => $data['question_category'] ?? '',
            'content' => $data['member_note'] ?? '',
            'intro' => serialize((object) $form_data),  // 方便後續備查
            'send_ip' => $data['send_ip'] ?? request()->ip(),
            'send_status' => $sendStatus,
            'created_at' => $now,
            'updated_at' => $now,
        ]);


        // 寄信
        // Mail::to($data['member_email'])
        //     ->bcc('52sherry1123@gmail.com') // ← 你可替換成實際管理員信箱
        //     ->send(new FormMailSend($form_data));
    }
}
