<?php
return [
    /**
     * App NAME
     * @param string
     */
    'APP_NAME' => env('APP_NAME', 'dash'),

    /**
     *  FILE SYSTEM DISK DRIVER YOU CAN Use public,s3
     * @param string
     */
    'FILESYSTEM_DISK' => env('FILESYSTEM_DISK', 'public'),

    /**
     * DARK MODE Style with  on , off
     * @param string
     */
    'DARK_MODE' => env('DASH_DARK_MODE', 'on'),

    /**
     * App PATH IN DASHBOARD dont leave this is empty default is dash
     * @param string
     */
    'DASHBOARD_PATH' => env('DASHBOARD_PATH', 'dash'),

    /**
     * DASHBOARD ICON you can put url or leave it empty
     * @param string
     */
    'DASHBOARD_ICON' => env('APP_URL') . '/dashboard/assets/dash/images/dash/PNG/black.png',

    /**
     * APP LANGUAGES Availabil Default is ar|en
     * @param array
     */
    'DASHBOARD_LANGUAGES' => [
        'en'                 => 'English',
        'ar'                 => 'العربية',
    ],
    /**
     * DEFAULT LANGUAGE IN DASHBOARD
     * @param string
     */
    'DEFAULT_LANG' => env('DEFAULT_LANG', 'en'),

    /**
     * GUARD default to login dashboard by this driver
     * @param array
     */
    'GUARD'      => [
        'dash'      => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
    ],

    // 'copyright'=>[
    // 	'link'=>'',
    // 	'copyright_text'=>''
    // ],

    'tenancy' => [
        'tenancy_mode' => 'off', // on | off
    ],

    /**
     * don't change anything here this is a default values for dash
     * @param functions
     */
    'THEME_PATH'            => base_path('vendor/phpanonymous/dash/src/resources/views'),
    'LOCALE_PATH'           => base_path('vendor/phpanonymous/dash/src/resources/lang'),
    'DATATABLE_LOCALE_PATH' => base_path('vendor/phpanonymous/dash/src/resources/lang'),
    'ROUTE_PATH'            => base_path('vendor/phpanonymous/dash/src/routes/routelist.php'),

];
