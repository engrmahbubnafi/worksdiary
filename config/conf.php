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
];