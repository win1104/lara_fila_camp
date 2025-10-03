<?php

namespace App\Services;

use App\Mail\FormMailSend;
use Illuminate\Support\Carbon;

class ContactService
{
    /**
     * 處理聯絡表單流程：封裝資料 + 發送郵件 + 記錄
     *
     * @param array $data 來自前端表單的資料
     * @return array 回傳處理結果 ['success' => bool, 'message' => string]
     */
    public static function handleContactForm(array $data): array
    {
        $now = Carbon::now();

        // 封裝寄信內容
        $mailData = [
            ...$data,
            'send_date' => $now->toDateString(),
            'mail_form_title' => '< 混合無限智慧科技（姓名：' . $data['member_name'] . '） >',
        ];

        // 準備要記錄到資料庫的資料
        $logData = [
            'title' => $data['member_name'],
            'slug' => $now->toDateString(),
            'email' => $data['member_email'],
            'phone' => $data['member_phone'] ?? '',
            'company' => $data['member_company'] ?? '',
            'info' => $data['question_category'] ?? '',
            'content' => $data['member_note'] ?? '',
            'intro' => serialize((object) $mailData),
            'send_ip' => $data['send_ip'] ?? request()->ip(),
        ];

        // 建立郵件物件
        $mailable = new FormMailSend($mailData);

        // 使用 MailService 發送並記錄
        return MailService::sendAndLog(
            recipients: $data['member_email'],
            mailable: $mailable,
            type: 'contact',
            logData: $logData
        );
    }
}
