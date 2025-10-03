<?php

namespace App\Services;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * 發送郵件並記錄到資料庫
     *
     * @param string|array $recipients 收件者 email（可以是字串或陣列）
     * @param Mailable $mailable 郵件物件
     * @param string $type 郵件類型（contact, registration, quote 等）
     * @param array $logData 要記錄到 mail_logs 的資料
     * @param string|null $bcc 密件副本收件者（預設使用 .env 的管理員信箱）
     * @return array ['success' => bool, 'message' => string]
     */
    public static function sendAndLog(
        string|array $recipients,
        Mailable $mailable,
        string $type,
        array $logData,
        ?string $bcc = null
    ): array {
        $now = Carbon::now();
        $sendStatus = 'success';
        $result = ['success' => true, 'message' => '郵件發送成功！'];

        // 預設 BCC 為管理員信箱
        $bcc = $bcc ?? config('mail.admin_email');

        try {
            // 發送郵件
            $mailInstance = Mail::to($recipients);

            if ($bcc) {
                $mailInstance->bcc($bcc);
            }

            $mailInstance->send($mailable);
        } catch (\Exception $e) {
            $sendStatus = 'failed';
            $result = [
                'success' => false,
                'message' => '郵件發送失敗，但您的訊息已記錄，我們會儘快與您聯繫。'
            ];

            // 記錄錯誤
            Log::error('郵件發送失敗：' . $e->getMessage(), [
                'type' => $type,
                'recipients' => $recipients,
                'log_data' => $logData,
                'exception' => $e
            ]);
        }

        // 記錄到資料庫
        static::logToDatabase($type, $logData, $sendStatus, $now);

        return $result;
    }

    /**
     * 將郵件資訊記錄到 mail_logs 資料表
     *
     * @param string $type 郵件類型
     * @param array $data 表單資料
     * @param string $sendStatus 發送狀態（success/failed）
     * @param Carbon $timestamp 時間戳記
     * @return void
     */
    protected static function logToDatabase(
        string $type,
        array $data,
        string $sendStatus,
        Carbon $timestamp
    ): void {
        DB::table('mail_logs')->insert([
            'type' => $type,
            'title' => $data['title'] ?? '',
            'slug' => $data['slug'] ?? $timestamp->toDateString(),
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'company' => $data['company'] ?? '',
            'info' => $data['info'] ?? '',
            'content' => $data['content'] ?? '',
            'intro' => $data['intro'] ?? serialize((object) $data),
            'send_ip' => $data['send_ip'] ?? request()->ip(),
            'send_status' => $sendStatus,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }

    /**
     * 僅發送郵件（不記錄到資料庫）
     *
     * @param string|array $recipients 收件者 email
     * @param Mailable $mailable 郵件物件
     * @param string|null $bcc 密件副本收件者
     * @return array ['success' => bool, 'message' => string]
     */
    public static function send(
        string|array $recipients,
        Mailable $mailable,
        ?string $bcc = null
    ): array {
        $result = ['success' => true, 'message' => '郵件發送成功！'];
        $bcc = $bcc ?? config('mail.admin_email');

        try {
            $mailInstance = Mail::to($recipients);

            if ($bcc) {
                $mailInstance->bcc($bcc);
            }

            $mailInstance->send($mailable);
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => '郵件發送失敗，請稍後再試。'
            ];

            Log::error('郵件發送失敗：' . $e->getMessage(), [
                'recipients' => $recipients,
                'exception' => $e
            ]);
        }

        return $result;
    }
}
