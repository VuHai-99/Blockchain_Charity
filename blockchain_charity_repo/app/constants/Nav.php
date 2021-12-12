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
            'url' => 'admin.campaign.list',
            'name' => 'List Campaign',
        ],
        [
            'url' => '',
            'name' => 'Requests',
            'sub_menu' => [
                [
                    'url' => 'admin.open-campaign-request.list',
                    'name' => 'Approve Campaign',
                ],
                [
                    'url' => 'admin.validate-host-request.list',
                    'name' => 'Approve Host',
                ],
                [
                    'url' => 'admin.create-donationActivity-request.list',
                    'name' => 'Approve DonationActivity',
                ],
                [
                    'url' => 'admin.create-donationActivityCashout-request.list',
                    'name' => 'Approve DonationActivity Cashout',
                ],
                [
                    'url' => 'admin.create-donationActivityOrder-request.list',
                    'name' => 'Approve DonationActivity Order',
                ],
            ]
        ],

        [
            'url' => 'admin.logout',
            'name' => 'Logout',
        ]
    ];

    const NAV_SUPPER_AUTHORITY = [
        [
            'url' => '',
            'name' => 'Dashboard',
        ],

        [
            'url' => '',
            'name' => 'Requests',
        ],
        [
            'url' => 'authority.logout',
            'name' => 'Logout',
        ],
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
            'url' => 'wallet',
            'name' => 'My Wallet',
        ],
        [
            'url' => 'user.profile',
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
            'url' => 'wallet',
            'name' => 'My Wallet',
        ],
        [
            'url' => 'user.profile',
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
            'url' => 'host.list.request',
            'name' => 'List Requests',
        ],
        [
            'url' => 'user.profile',
            'name' => 'Profile',
        ],
        [
            'url' => 'wallet',
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
            'url' => 'hostws.list.request',
            'name' => 'List Requests',
        ],
        [
            'url' => 'user.profile',
            'name' => 'Profile',
        ],
        [
            'url' => 'wallet',
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

    const NAV_RETAILER = [
        [
            'url' => 'retailer.index',
            'name' => 'Home',
        ],
        [
            'url' => '',
            'name' => 'About',
        ],
        [
            'url' => 'retailer.product.list',
            'name' => 'retailer.product',
        ],
        [
            'url' => 'retailer.order',
            'name' => 'Order',
        ],
        [
            'url' => '',
            'name' => 'Contact',
        ],
        [
            'url' => 'retailer.logout',
            'name' => 'Login',
        ],
        [
            'url' => 'retailer.profile',
            'name' => 'Profile',
        ]
    ];
}