<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormMailSend extends Mailable
{
    use Queueable, SerializesModels;

    // 這個資料會自動傳到 view
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        // 在 contact_form.blade.php 可用 $data
        $this->data = $data;
    }

    /**
     * 📬 主旨：Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '聯絡表單 - ' . $this->data['member_name'] . ' (' . $this->data['question_category'] . ')',
        );
    }

    /**
     * 📄 內容（視圖模板）：Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_form',
        );
    }

    /**
     * 📎 附件：Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
