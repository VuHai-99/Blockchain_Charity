<?php

namespace App\Constants;

class Nav
{
    const NAV_ADMIN_DONATOR = [
        [
            'url' => 'donator.index',
            'name' => 'Danh sach su kien',
            'icon' => 'list.png',
        ],
        [
            'url' => 'profile',
            'name' => 'Thong tin ca nhan',
            'icon' => 'user.png',
        ],
        [
            'url' => '',
            'name' => 'Quản lí giao dich',
            'icon' => 'transaction.png',
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
            'icon' => 'logout.png',
        ],
    ];

    const NAV_ADMIN_HOST = [
        [
            'url' => 'donator.index',
            'name' => 'Dự án của bạn',
            'icon' => 'list.png',
        ],
        [
            'url' => '',
            'name' => 'Thong tin ca nhan',
            'icon' => 'user.png',
        ],
        [
            'url' => '',
            'name' => 'Quản lí giao dich',
            'icon' => 'transaction.png',
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
            'icon' => 'logout.png',
        ],

    ];
}