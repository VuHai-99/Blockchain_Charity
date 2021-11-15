<?php

namespace App\Constants;

class Nav
{
    const NAV_SUPPER_ADMIN = [
        [
            'url' => 'admin.dashboard.index',
            'name' => 'Dashboard',
        ],

        [
            'url' => 'admin.host.list',
            'name' => 'List Host',
        ],
        [
            'url' => 'admin.project.list',
            'name' => 'List Campaign',
        ],
        [
            'url' => 'admin.open-project-request.list',
            'name' => 'Approve Campaign',
        ],
        [
            'url' => 'admin.validate-host-request.list',
            'name' => 'Approve Host',
        ],
        [
            'url' => 'admin.withdraw-money-request.list',
            'name' => 'Approve Withdrawal',
        ],
        [
            'url' => 'admin.logout',
            'name' => 'Logout',
        ]
    ];

    const NAV_ADMIN_DONATOR = [
        [
            'url' => 'donator.home',
            'name' => 'Home',
        ],
        [
            'url' => 'donator.campaign',
            'name' => 'List Campaign',
        ],
        [
            'url' => '',
            'name' => 'My Wallet',
            //'icon' => 'images/icons/walet.png'
        ],
        [
            'url' => 'profile',
            'name' => 'Profile',
        ],
        [
            'url' => 'logout',
            'name' => 'Logout',
        ],
    ];

    const NAV_ADMIN_DONATOR_WS = [
        [
            'url' => 'donatorws.home',
            'name' => 'Home',
        ],
        [
            'url' => 'donatorws.campaign',
            'name' => 'List Campaign',
        ],
        [
            'url' => '',
            'name' => 'My Wallet',
            //'icon' => 'images/icons/walet.png'
        ],
        [
            'url' => 'profile',
            'name' => 'Profile',
        ],
        [
            'url' => 'logout',
            'name' => 'Logout',
        ],
    ];


    const NAV_ADMIN_HOST = [
        [
            'url' => 'host.home',
            'name' => 'Home',
        ],
        [
            'url' => 'host.campaign',
            'name' => 'List Campaign',
        ],
        [
            'url' => 'host.validate.host',
            'name' => 'Validate Account',
        ],
        [
            'url' => 'host.campaign.create',
            'name' => 'Create Campaign',
        ],
        [
            'url' => '',
            'name' => 'Profile',
        ],
        [
            'url' => '',
            'name' => 'My Wallet',
            //'icon' => 'images/icons/walet.png'
        ],
        [
            'url' => 'logout',
            'name' => 'Logout',
        ],

    ];


    const NAV_ADMIN_HOST_WS = [
        [
            'url' => 'hostws.home',
            'name' => 'Home',
        ],
        [
            'url' => 'hostws.campaign',
            'name' => 'List Campaign',
        ],
        [
            'url' => 'hostws.validate.host',
            'name' => 'Validate Account',
        ],
        [
            'url' => 'hostws.campaign.create',
            'name' => 'Create Campaign',
        ],
        [
            'url' => '',
            'name' => 'Profile',
        ],
        [
            'url' => '',
            'name' => 'My Wallet',
            //'icon' => 'images/icons/walet.png'
        ],
        [
            'url' => 'logout',
            'name' => 'Logout',
        ],

    ];


    const NAV_HOME = [
        [
            'url' => 'home',
            'name' => 'Home',
        ],
        [
            'url' => '',
            'name' => 'About',
        ],
        [
            'url' => 'campaign',
            'name' => 'Campaign',
        ],
        [
            'url' => '',
            'name' => 'Help',
        ],
        [
            'url' => '',
            'name' => 'Contact',
        ],
        [
            'url' => 'login',
            'name' => 'Login',
        ],
        [
            'url' => 'register',
            'name' => 'Register',
        ]
    ];
}