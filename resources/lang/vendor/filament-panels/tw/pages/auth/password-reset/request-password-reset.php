<?php

return [

    'title' => '重置密码',

    'heading' => '忘记密码？',

    'actions' => [

        'login' => [
            'label' => '返回登录页面',
        ],

    ],

    'form' => [

        'email' => [
            'label' => '電子郵件',
        ],

        'actions' => [

            'request' => [
                'label' => '發送邮件',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => '尝试次数过多',
            'body' => '請在 :seconds 秒后重试。',
        ],

    ],

];
