<?php

return [

    'title' => '驗證電子郵件',

    'heading' => '驗證電子郵件',

    'actions' => [

        'resend_notification' => [
            'label' => '已重新發送',
        ],

    ],

    'messages' => [
        'notification_not_received' => '沒有收到我们的邮件？',
        'notification_sent' => '我们已经向 :email 發送了一封驗證邮件。',
    ],

    'notifications' => [

        'notification_resent' => [
            'title' => '我们已经重新發送了邮件。',
        ],

        'notification_resend_throttled' => [
            'title' => '發送邮件次数过多',
            'body' => '請在 :seconds 秒后重试。',
        ],

    ],

];
