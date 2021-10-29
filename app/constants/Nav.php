<?php

namespace App\Constants;

class Nav
{
    const NAV_SUPPER_ADMIN = [
        [
            'url' => 'admin.dashboard.index',
            'name' => 'Dashboard',
            'icon' => 'icon-dashboard.png',
        ],

        [
            'url' => 'admin.host.list',
            'name' => 'Danh sách nhà từ thiện',
            'icon' => 'list.png',
        ],
        [
            'url' => 'admin.project.list',
            'name' => 'Danh sách sự kiện',
            'icon' => 'list.png',
        ],
        [
            'url' => 'admin.profile.edit',
            'name' => 'Quản lí tài khoản',
            'icon' => 'user.png',
        ],
        [
            'url' => 'admin.create.account',
            'name' => 'Thêm tài khoản',
            'icon' => 'user.png',
        ],
    ];

    const NAV_ADMIN_DONATOR = [
        [
            'url' => 'donator.list.project',
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
            'url' => 'host.list.project',
            'name' => 'Danh sách dự án',
            'icon' => 'list.png',
        ],
        [
            'url' => 'host.list.my.project',
            'name' => 'Dự Án của tôi',
            'icon' => 'user.png',
        ],
        [
            'url' => 'host.create.project',
            'name' => 'Tạo dự án',
            'icon' => 'user.png',
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
            'icon' => 'logout.png',
        ],

    ];
}