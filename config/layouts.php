<?php

$conf = [
    // toolbar
    'subheader' => [
        'enable' => true,
        'fixed' => true,
    ],
    'sticky_drawer' => [
        'demo' => false,
        'help' => false,
    ],
    'modal' => [
        'upgrade_plan' => false,
        'create_app' => false,
        'invite_friends' => false,
        'user_search' => false,
    ],
    'header_menu' => true,

    'toolbar' => [
        'search' => false,
        'activities' => false,
        'notifications' => false,
        'chat' => false,
        'quick_links' => false,
        'theme_mode' => false,
        'user_menu' => true,
    ],

    //toolbar notifications
    'notifications' => [
        'alert_tab' => true,
        'logs_tab' => false,
    ],
    // asidebar
    'aside' => [
        'brand' => true,
        'menu' => true,
        'footer' => false,
    ],
];

$conf['header_drawer']['activities'] = $conf['toolbar']['activities'];
$conf['header_drawer']['chat'] = $conf['toolbar']['chat'];
$conf['notifications']['upgrade_tab'] = $conf['modal']['upgrade_plan'];

return $conf;
