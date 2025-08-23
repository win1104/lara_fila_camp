<?php

return [

    'title' => '註冊',

    'heading' => '註冊',

    'actions' => [

        'login' => [
            'before' => '或者',
            'label' => '登录你的账号',
        ],

    ],

    'form' => [

        'email' => [
            'label' => '電子郵件',
        ],

        'name' => [
            'label' => '姓名',
        ],

        'password' => [
            'label' => '密码',
            'validation_attribute' => '密码',
        ],

        'password_confirmation' => [
            'label' => '確認密碼',
        ],

        'actions' => [

            'register' => [
                'label' => '提交註冊',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => '尝试註冊次数过多',
            'body' => '請在 :seconds 秒后重试。',
        ],

    ],

];
