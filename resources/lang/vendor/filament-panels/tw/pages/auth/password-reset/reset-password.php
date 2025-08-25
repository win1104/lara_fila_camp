<?php

return [

    'title' => '重置密码',

    'heading' => '重置密码',

    'form' => [

        'email' => [
            'label' => '電子郵件',
        ],

        'password' => [
            'label' => '密码',
            'validation_attribute' => '密码',
        ],

        'password_confirmation' => [
            'label' => '確認密碼',
        ],

        'actions' => [

            'reset' => [
                'label' => '重置密码',
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
