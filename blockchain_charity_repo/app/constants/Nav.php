<?php

namespace App\Constants;

class Nav
{
    const NAV_SUPPER_AUTHORITY = [
        [
            'url' => '',
            'name' => 'Trang chủ',
        ],

        [
            'url' => '',
            'name' => 'Danh sách yêu cầu',
        ],
        [
            'url' => 'authority.logout',
            'name' => 'Đăng xuất',
        ],
    ];

    const NAV_ADMIN_DONATOR = [
        [
            'url' => 'donator.home',
            'name' => 'Trang chủ',
        ],
        [
            'url' => 'donator.campaign',
            'name' => 'Dự án',
        ],
        [
            'url' => 'wallet',
            'name' => 'Tài khoản',
        ],
        [
            'url' => 'user.profile',
            'name' => 'Thông tin cá nhân',
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
        ],
    ];

    const NAV_ADMIN_DONATOR_WS = [
        [
            'url' => 'donatorws.home',
            'name' => 'Trang chủ',
        ],
        [
            'url' => 'donatorws.campaign',
            'name' => 'Dự án',
        ],
        [
            'url' => 'wallet',
            'name' => 'Tài khoản',
        ],
        [
            'url' => 'user.profile',
            'name' => 'Thông tin cá nhân',
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
        ],
    ];


    const NAV_ADMIN_HOST = [
        [
            'url' => 'host.home',
            'name' => 'Trang chủ',
        ],
        [
            'url' => 'host.campaign',
            'name' => 'Dự án',
        ],
        [
            'url' => 'host.validate.host',
            'name' => 'Xác nhận tài khoản',
        ],
        [
            'url' => 'host.campaign.create',
            'name' => 'Tạo dự án',
        ],
        [
            'url' => 'host.list.request',
            'name' => 'Danh sách yêu cầu',
        ],
        [
            'url' => 'user.profile',
            'name' => 'Thông tin cá nhân',
        ],
        [
            'url' => 'wallet',
            'name' => 'Tài khoản',
            //'icon' => 'images/icons/walet.png'
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
        ],

    ];


    const NAV_ADMIN_HOST_WS = [
        [
            'url' => 'hostws.home',
            'name' => 'Trang chủ',
        ],
        [
            'url' => 'hostws.campaign',
            'name' => 'Dự án',
        ],
        [
            'url' => 'hostws.validate.host',
            'name' => 'Xác thực tài khoản',
        ],
        [
            'url' => 'hostws.campaign.create',
            'name' => 'Tạo dự án',
        ],
        [
            'url' => 'hostws.list.request',
            'name' => 'Danh sách yêu cầu',
        ],
        [
            'url' => 'user.profile',
            'name' => 'Thông tin cá nhân',
        ],
        [
            'url' => 'wallet',
            'name' => 'Tài khoản',
            //'icon' => 'images/icons/walet.png'
        ],
        [
            'url' => 'logout',
            'name' => 'Đăng xuất',
        ],

    ];


    const NAV_HOME = [
        [
            'url' => 'home',
            'name' => 'Trang chủ',
        ],
        [
            'url' => 'campaign',
            'name' => 'Dự án',
        ],
        [
            'url' => '',
            'name' => 'Hỗ trợ',
        ],
        [
            'url' => '',
            'name' => 'Liên hệ',
        ],
        [
            'url' => 'login',
            'name' => 'Đăng nhập',
        ],
        [
            'url' => 'register',
            'name' => 'Đăng kí',
        ]
    ];
}
