<?php

namespace App\Constants;

class Nav
{
    const NAV_SUPPER_ADMIN = [
        [
            'parent_id' => 0,
            'id' => 1,
            'url' => 'admin.dashboard.index',
            'name' => 'Dashboard',
        ],

        [   
            'parent_id' => 0,
            'id' => 2,
            'url' => 'admin.host.list',
            'name' => 'List Host',
        ],
        [
            'parent_id' => 0,
            'id' => 3,
            'url' => 'admin.campaign.list',
            'name' => 'List Campaign',
        ],
        [
            'parent_id' => 0,
            'id' => 4,
            'url' => '',
            'name' => 'Requests',
        ],
        [
            'parent_id' => 4,
            'id' => 5,
            'url' => 'admin.open-campaign-request.list',
            'name' => 'Approve Campaign',
        ],
        [
            'parent_id' => 4,
            'id' => 6,
            'url' => 'admin.validate-host-request.list',
            'name' => 'Approve Host',
        ],
        [
            'parent_id' => 4,
            'id' => 7,
            'url' => 'admin.withdraw-money-request.list',
            'name' => 'Approve Withdrawal',
        ],
        [
            'parent_id' => 4,
            'id' => 8,
            'url' => 'admin.create-donationActivity-request.list',
            'name' => 'Approve DonationActivity',
        ],
        [
            'parent_id' => 4,
            'id' => 9,
            'url' => 'admin.create-donationActivityCashout-request.list',
            'name' => 'Approve DonationActivity Cashout',
        ],
        [
            'parent_id' => 0,
            'id' => 10,
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