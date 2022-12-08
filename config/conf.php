<?php

return [
    'status'             => [
        'active'   => 'Active',
        'inactive' => 'Inactive',
    ],

    'is_default'         => [
        '1' => 'Default',
        '0' => 'Not Default',
    ],

    'smsApi'             => [
        'host'   => 'https://api.mobireach.com.bd/SendTextMessage',
        'host2'  => 'https://api.mobireach.com.bd/SendTextMultiMessage',
        'params' => [
            'Username' => 'indexsms',
            'Password' => 'X-Index2020',
            'From'     => '8801847170249',
        ],
    ],

    'is_multiple'        => [
        0 => 'No',
        1 => 'Yes',
    ],

    'time_duration_unit' => [
        'day'  => 'Day',
        'week' => 'Week',
    ],

    'unit'               => 'Shop/Farm/Pond',
    'max_tab_company_limit' => env('MAX_TAB_COMPANY_LIMIT', 2),
    'api_pagination_limit' => env('API_PAPINATION_LIMIT', 5)
];
