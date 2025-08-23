<?php

return [

    'title' => '登录',

    'heading' => '登录',

    'actions' => [

        'register' => [
            'before' => '或者',
            'label' => '註冊账号',
        ],

        'request_password_reset' => [
            'label' => '忘记了密码？',
        ],

    ],

    'form' => [

        'email' => [
            'label' => '電子郵件',
        ],

        'password' => [
            'label' => '密码',
        ],

        'remember' => [
            'label' => '保持登录状态',
        ],

        'actions' => [

            'authenticate' => [
                'label' => '登录',
            ],

        ],

    ],

    'messages' => [

        'failed' => '登录信息有误。',

    ],

    'notifications' => [

        'throttled' => [
            'title' => '尝试登录次数过多',
            'body' => '請在 :seconds 秒后重试。',
        ],

    ],

];
