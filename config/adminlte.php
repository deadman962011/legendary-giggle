<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'MyBill',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Admin</b>LTE',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-notification',
            'id' => 'my-notification',
            'icon' => 'fas fa-bell',
            'icon_color' => 'warning',
            'label' => 0,
            'label_color' => 'danger',
            'url' => 'notifications/show',
            'topnav_right' => true,
            'dropdown_mode' => true,
            'dropdown_flabel' => 'All notifications',
            'update_cfg' => [
                'url' => 'notifications/get',
                'period' => 30,
            ],
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'approval_requests',
            'icon' => 'far fa-fw fa-file',
            'can'=>['approval_offers','approval_shops'],
            'submenu' => [
                [
                    'text' => 'shops',
                    'url' => '/approval?model=shop&status=pending&action=create',
                    'can'=>['approval_shops']
                ],
                [
                    'text' => 'offers',
                    'url' => '/approval?model=offer&status=pending&action=create',
                    'can'=>['approval_offers']
                ],
            ],
        ],
        [
            'text' => 'categories',
            'icon' => 'far fa-fw fa-file',
            'can'=>['add_category','edit_category','delete_category'],
            'submenu' => [
                [
                    'text' => 'categories_list',
                    'url' => '/category/list',
                ],
                [
                    'text' => 'add_new_category',
                    'url' => '/category/new',
                    'can'=>['add_category']
                ],
            ],
        ],
        [
            'text' => 'shops',
            'icon' => 'far fa-fw fa-file',
            'can'=>['add_shop','edit_shop','delete_shop'],
            'submenu' => [
                [
                    'text' => 'shops_list',
                    'url' => '/shop/list',
                ],
                [
                    'text' => 'add_new_shop',
                    'url' => '/shop/new',
                    'can'=>['add_shop']
                ],
            ],
        ],
        [
            'text' => 'offers',
            'icon' => 'far fa-fw fa-file',
            'can'=>['add_shop_offer','edit_shop_offer','delete_shop_offer'],
            'submenu' => [
                [
                    'text' => 'offers_list',
                    'url' => '/offer/list',
                ],
                [
                    'text' => 'add_new_offer',
                    'url' => '/offer/new',
                    'can'=>['add_shop_offer']
                ],
            ],
        ],
        [
            'text' => 'sliders',
            'icon' => 'far fa-fw fa-file',
            'can'=>['home_slide_add_slide','home_slide_delete_slide'],
            'submenu' => [
                [
                    'text' => 'home_slider',
                    'url' => '/slider/home',
                ],
            ],
        ],

        [
            'text' => 'zones',
            'icon' => 'far fa-fw fa-file',
            'can'=>['add_zone','edit_zone','delete_zone'],
            'submenu' => [
                [
                    'text' => 'zones_list',
                    'url' => '/zone/list',
                ],
                [
                    'text' => 'add_new_zone',
                    'url' => '/zone/new',
                    'can'=>'add_zone'
                ],
            ],
        ],

        [
            'text' => 'staff',
            'icon' => 'far fa-fw fa-file',
            'can'=>['add_staff','delete_staff','add_role','delete_role'],
            'submenu' => [
                [
                    'text' => 'roles',
                    'shift' => 'ms-2',
                    'submenu' => [
                        [
                            'text' => 'list_roles',
                            'url' => '/role/list',
                            'shift' => 'ms-3',
                            'can'=>['add_role','delete_role']
                        ],
                        [
                            'text' => 'add_new_role',
                            'url' => '/role/new',
                            'shift' => 'ms-3',
                            'can'=>['add_role']

                        ]
                    ]
                ],
                [
                    'text' => 'staff',
                    'shift' => 'ms-2',
                    'submenu' => [
                        [
                            'text' => 'list_staff',
                            'url' => '/staff/list',
                            'shift' => 'ms-3',
                            'can'=>['add_staff','delete_staff']
                        ],
                        [

                            'text' => 'add_new_staff',
                            'url' => '/staff/new',
                            'shift' => 'ms-3',
                            'can'=>['add_staff']
                        ]

                    ]
                ],

            ],
        ],



        [
            'text' => 'settings',
            'icon' => 'far fa-fw fa-file',
            'can'=>['edit_general_settings'],
            'submenu' => [
                [
                    'text' => 'general_settings',
                    'url' => '/setting/general',
                    'can'=>['edit_general_settings']
                ],
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'toastr'    => [
            'active'    => true,
            'files'     => [
                [
                    'type'  => 'css',
                    'asset' => false,
                    'location' => '/vendor/toastr/toastr.min.css'
                ],
                [
                    'type'  => 'js',
                    'asset' => false,
                    'location' => '/vendor/toastr/toastr.min.js'
                ]
            ]
        ],
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/select2/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/select2/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],




            ],
        ],
        'tempusdominusBootstrap4' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ]

        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/sweetalert2/sweetalert2.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/sweetalert2/sweetalert2.min.js',
                ],
            ],
        ],

        'Chartjs' => [
            'active' => true,
            'files' => [

                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/vendor/chart.js/Chart.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/vendor/chart.js/Chart.bundle.min.js',
                ],
            ],
        ],
        // 'Pace' => [
        //     'active' => false,
        //     'files' => [
        //         [
        //             'type' => 'css',
        //             'asset' => false,
        //             'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => false,
        //             'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
        //         ],
        //     ],
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
