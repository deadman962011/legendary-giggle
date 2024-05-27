<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Shop;
use App\Models\ShopAdmin;
use App\Models\ShopAvailabiltiy;
use App\Models\ShopCategory;
use App\Models\ShopTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     **/
    public function run(): void
    {
        $this->seedAdminRole();
        $this->seedAdmin();
        $this->seedShopRoles();
        $this->seedLanguage();
        $this->seedHomeSlider();
        $this->seedZones();
        $this->seedCategory();
        $this->seedConfig();
        $this->seedShop();
    }



    public function seedAdminRole()
    {

        $admin_permissions = [

            [
                'name' => 'display_shops',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Shops'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض المتاجر'],
                ]
            ],
            [
                'name' => 'add_shop',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add Shop'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'اضافة متجر'],
                ]
            ],
            [
                'name' => 'edit_shop',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit Shop'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'تعديل المتجر'],
                ]
            ],
            [
                'name' => 'delete_shop',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delet Shop'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'حذف المتجر'],
                ]

            ],
            [
                'name' => 'approval_offers',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Approval Offers'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'طلبات الموافقة للعروض'],
                ]
            ],
            [

                'name' => 'approval_shops',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Approval Shops'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'طلبات الموافقة للمتاجر'],
                ]
            ],
            [
                'name' => 'display_categories',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Categories'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض التصنيفات'],
                ]
            ],
            [
                'name' => 'add_category',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add new category'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'اضافة تصنيف جديد'],
                ]
            ],
            [
                'name' => 'edit_category',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit category'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'تعديل تصنيف '],
                ]

            ],
            [
                'name' => 'delete_category',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete category'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'حذف تصنيف '],
                ]

            ],
            [
                'name' => 'display_shop_offers',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Shop offers '],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض عروض المتاجر'],
                ]
            ],
            [
                'name' => 'add_shop_offer',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add shop offer'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة عرض للمتجر"],
                ]
            ],
            [
                'name' => 'edit_shop_offer',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit shop offer'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل عرض للمتجر"],
                ]
            ],
            [
                'name' => 'delete_shop_offer',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete shop offer'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة عرض للمتجر"],
                ]
            ],
            [
                'name' => 'home_slide_add_slide',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Home slide add slider'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'سلايدر الرئيسسية اضافة سلايدر '],
                ]

            ],

            [
                'name' => 'home_slide_delete_slide',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Home slide delete slide'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'سلايدر الرئيسسية حذف سلايدر '],
                ]

            ],

            [
                'name' => 'display_zones',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Zones '],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض المناطق'],
                ]
            ],
            [
                'name' => 'add_zone',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add zone'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'اضافة منطقة '],
                ]

            ],
            [
                'name' => 'edit_zone',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit Zone'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'تعديل منطقة '],
                ]

            ],
            [
                'name' => 'delete_zone',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete Zone'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة منطقة"],
                ]

            ],
            [
                'name' =>
                'edit_general_settings',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit general settings'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل الاعدادات العامة"],
                ]

            ],
            [
                'name' => 'display_staff',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Staff '],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض الموظفين'],
                ]
            ],
            [
                'name' => 'add_staff',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add Staff'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة موظف"],
                ]

            ],

            [
                'name' => 'delete_staff',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete Staff'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة موظف"],
                ]

            ],
            [
                'name' => 'display_roles',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Roles '],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض الادوار'],
                ]
            ],
            [
                'name' => 'add_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add Role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة دور"],
                ]
            ],
            [
                'name' => 'delete_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete Role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة دور"],
                ]
            ],


            [
                'name' => 'display_coupons',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Coupons'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض الكوبونات'],
                ]
            ],
            [
                'name' => 'add_coupon',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add new coupon'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'اضافة كوبون جديد'],
                ]
            ],
            [
                'name' => 'edit_coupon',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit coupon'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'تعديل كوبون '],
                ]

            ],
            [
                'name' => 'delete_coupon',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete coupon'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'حذف كوبون '],
                ]

            ],
        ];

        $role = \App\Models\Role::query()->create([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        foreach ($admin_permissions as $permission) {
            $perm = \App\Models\Permission::query()->create([
                'name'          =>  $permission['name'],
                'guard_name'    =>  'web',
                // 'section'       =>  'Shop Admin',
            ]);

            //save translation
            foreach ($permission['translation'] as $permTranslation) {
                \App\Models\PermissionTranslation::create([
                    'key' => $permTranslation['key'],
                    'value' => $permTranslation['value'],
                    'lang' => $permTranslation['lang'],
                    'permission_id' => $perm->id
                ]);
            }

            $role->givePermissionTo($perm->id);
        }
    }



    public function seedAdmin(): void
    {

        $admin = \App\Models\Admin::create([
            'name' => 'blaxk',
            'email' => 'blaxk@blaxk.cc',
            'password' => bcrypt('123456789')
        ]);

        $role = Role::where('name', 'Admin')->first();

        $admin->assignRole($role);
    }


    public function seedShopRoles()
    {


        $role = \App\Models\Role::query()->create([
            'name' => 'Shop Admin',
            'guard_name' => 'shop'
        ]);



        // [
        //     'name' =>'delete_staff',
        //     'translation' => [
        //         ['key' => 'name', 'lang' => 'en', 'value' => 'Delete Staff'],
        //         ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة موظف"],
        //     ]

        // ],



        /**
         * Shop Admin Permissions
         */

        $shop_admin_permissions =   [
            [
                'name' => 'add_shop_offer',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add shop offer'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة عرض للمتجر"],
                ]
            ],
            [
                'name' => 'edit_shop_offer',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit shop offer'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل عرض للمتجر"],
                ]
            ],
            [
                'name' => 'delete_shop_offer',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete shop offer'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة عرض للمتجر"],
                ]
            ]
        ];

        foreach ($shop_admin_permissions as $permission) {

            $perm = \App\Models\Permission::query()->create([
                'name'          =>  $permission['name'],
                'guard_name'    =>  'shop',
                // 'section'       =>  'Shop Admin',
            ]);

            foreach ($permission['translation'] as $permTranslation) {
                \App\Models\PermissionTranslation::create([
                    'key' => $permTranslation['key'],
                    'value' => $permTranslation['value'],
                    'lang' => $permTranslation['lang'],
                    'permission_id' => $perm->id
                ]);
            }


            $role->givePermissionTo($perm->id);
        }
    }

    public function seedLanguage()
    {
        \App\Models\Language::insert([
            [
                'name' => 'العربية',
                'key' => 'ar',
                'dir' => 'rtl',
                'status' => true
            ],
            [
                'name' => 'English',
                'key' => 'en',
                'dir' => 'ltr',
                'status' => true
            ],
        ]);
    }

    public function seedHomeSlider()
    {
        $slider = \App\Models\Slider::create([
            'name' => 'home',
            'status' => true
        ]);


        $uploads = [
            ['file_original_name' => 'dummy/default_avatar.png', 'file_name' => 'dummy/default_avatar.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
        ];

        foreach ($uploads as $uploadData) {
            $upload = \App\Models\Upload::create($uploadData);
            \App\Models\Slide::create([
                'upload_id' => $upload->id,
                'slider_id' => $slider->id
            ]);
        }
    }


    public function seedZones()
    {

        $coordinates = '(24.68378854671517, 46.72524386721549),(24.671933803036012, 46.75545626955924),(24.646972765194313, 46.75476962405143),(24.633866222353177, 46.732110322293615),(24.637611089203887, 46.70533114748893),(24.664729487638667, 46.696404755887365),(24.68157633831391, 46.71357089358268)';

        $zones = [
            [
                'name' => 'Al Malaz Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Al Malaz Area'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'منطقة الملز'],
                ],
            ],
            [
                'name' => 'Al Faisaliyah Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Al Faisaliyah Area'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'منطقة الفيصلية'],
                ],
            ],
            [
                'name' => 'Al Anoud Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Al Anoud Area'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'منطقة العنود'],
                ],
            ],
            [
                'name' => 'Al Aqiq Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Al Aqiq Area'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'منطقة العقيع'],
                ],
            ],
            [
                'name' => 'Al Murabba Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Al Murabba Area'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'منطقة المربع'],
                ],
            ],
        ];

        foreach ($zones as $zoneData) {
            $coordinates = $this->processCoordinates($zoneData['coordinates']);
            $zone = \App\Models\Zone::create([
                'name' => $zoneData['name'],
                'coordinates' => $coordinates,
                'status' => true,
                'isDeleted' => $zoneData['isDeleted'],
            ]);

            foreach ($zoneData['translation'] as $translation) {
                \App\Models\ZoneTranslation::create([
                    'key' => 'name',
                    'value' => $translation['value'],
                    'lang' => $translation['lang'],
                    'zone_id' => $zone->id,
                ]);
            }
        }
    }

    private function processCoordinates($coordinatesString)
    {
        $coordinates = explode('),(', trim($coordinatesString, '()'));
        $polygon = [];
        foreach ($coordinates as $index => $singleArray) {
            if ($index == 0) {
                $lastCord = explode(',', $singleArray);
            }
            $coords = explode(',', $singleArray);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $polygon[] = new Point($lastCord[0], $lastCord[1]);
        return new Polygon([new LineString($polygon)]);
    }


    public function seedCategory()
    {
        //
        $uploads = [
            ['file_original_name' => 'dummy/category/1.png', 'file_name' => 'dummy/category/1.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'dummy/category/2.png', 'file_name' => 'dummy/category/2.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'dummy/category/3.png', 'file_name' => 'dummy/category/3.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'dummy/category/4.png', 'file_name' => 'dummy/category/4.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'dummy/category/5.png', 'file_name' => 'dummy/category/5.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
        ];

        $uploadIds = [];
        foreach ($uploads as $uploadData) {
            $upload = \App\Models\Upload::create($uploadData);
            // Save the ID of the created upload for later use
            $uploadIds[] = $upload->id;
        }


        $categories = [
            [
                'name' => 'Automotive',
                'order_level' => 0,
                'banner' => null,
                'parent_id' => null,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Automotive'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'تنقل'],
                ],
            ],
            [
                'name' => 'Food',
                'order_level' => 1,
                'banner' => null,
                'parent_id' => null,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Food'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'أطعمة'],
                ],
            ],
            [
                'name' => 'Grocery',
                'order_level' => 2,
                'banner' => null,
                'parent_id' => null,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Grocery'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'بقالة'],
                ],
            ],
            [
                'name' => 'Fashion',
                'order_level' => 3,
                'banner' => null,
                'parent_id' => null,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Fashion'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'أزياء'],
                ],
            ],
            [
                'name' => 'Drinks',
                'order_level' => 4,
                'banner' => null,
                'parent_id' => null,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Drinks'],
                    ['key' => 'name', 'lang' => 'en', 'value' => 'مشروبات'],
                ],
            ],
        ];


        foreach ($categories as $key => $categoryData) {
            $category = \App\Models\Category::create([
                'name' => $categoryData['name'],
                'order_level' => $categoryData['order_level'],
                'cover_image' => $uploadIds[$key],
                'status' => true,
            ]);

            // Seed the CategoryTranslations model for each category
            foreach ($categoryData['translation'] as $translationData) {
                \App\Models\CategoryTranslation::create([
                    'key' => 'name',
                    'value' => $translationData['value'],
                    'lang' => $translationData['lang'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }

    public function seedConfig()
    {

        $settings = [
            [
                'key' => 'commission_amount',
                'value' => '10',
                'sub_value' => '',
                'section' => 'general',
                'input_type' => 'number',
                'translations' => [
                    [
                        'key' => 'name',
                        'lang' => 'en',
                        'value' => 'Commission Amount',
                    ],
                    [
                        'key' => 'name',
                        'lang' => 'ar',
                        'value' => 'قيمة العمولة',
                    ]
                ],
            ],
            [
                'key' => 'cashbak_amounts',
                'value' => '10,20,30,40',
                'sub_value' => '',
                'section' => 'general',
                'input_type' => 'numeric_taglist',
                'translations' => [
                    [
                        'key' => 'name',
                        'lang' => 'en',
                        'value' => 'Cashback Amounts',
                    ],
                    [
                        'key' => 'name',
                        'lang' => 'ar',
                        'value' => 'قيم الكاشباك',
                    ],
                ],
            ],
            [
                'key' => 'firebase_push_notification_key',
                'value' => 'AAAAq2_rST8:APA91bGEo6H2ctbVIgvdnTSg5Jw2V85Yfi3cfhF9eVRorSiLsZy1-0wDRICeger-Im4xYfVMU2B-5zqIiovAkuED_FGTNwDCK1i7ID8fG8J8n7vyp8ZIpIwK-L8yKgqk6YHv-YoIjfOD',
                'sub_value' => '',
                'section' => 'general',
                'input_type' => 'text',
                'translations' => [
                    [
                        'key' => 'name',
                        'lang' => 'en',
                        'value' => 'Firebase push notification key ',
                    ],
                    [
                        'key' => 'name',
                        'lang' => 'ar',
                        'value' => 'Firebase push notification key',
                    ],
                ],
            ],
        ];


        foreach ($settings as $setting) {
            $settingId = \App\Models\Setting::insertGetId([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'sub_value' => $setting['sub_value'],
                'section' => $setting['section'],
                'input_type' => $setting['input_type']
            ]);

            // Loop through each translation and insert into the setting_translations table
            foreach ($setting['translations'] as $translation) {
                \App\Models\SettingTranslation::insert([
                    'key' => $translation['key'],
                    'value' => $translation['value'],
                    'lang' => $translation['lang'],
                    'setting_id' => $settingId,
                ]);
            }
        }
    }

    public function seedShop()
    {

        //
        $shop = Shop::create([
            'shop_name' => 'United Fuel Company',
            'shop_logo' => '1',
            'longitude' => '46.63744866638183',
            'latitude' => '24.79895579253349',
            'zone_id' => '1',
            'address' => '',
            'shop_contact_email' => 'deadman962111@gmail.com',
            'shop_contact_phone' => '1234567890',
            'tax_register' => '301071869100003',
            'status' => true
        ]);

        $shopAdmin = ShopAdmin::create([
            'name' => 'blaxk',
            'email' => 'deadman962011@gmail.com',
            'phone' => '1234567890',
            'password' => generate_random_token(12),
            'auth_token' => generate_random_token(12),
            'shop_id' => $shop->id
        ]);


        //save roles for the shop
        $base_shop_admin_role = Role::query()->where('shop_id', 0)->where('name', 'Shop Admin')->first();
        $shop_admin_role_name = $shop->shop_name . '- Shop Admin' . now();

        $adminRole = Role::create([
            'name' => $shop_admin_role_name,
            'guard_name' => 'shop',
            'shop_id' => $shop->id
        ]);

        $adminRole->givePermissionTo($base_shop_admin_role->permissions()->pluck('id'));


        $shopAdmin->assignRole($adminRole);

        //save shop categories items 
        $categories_ids = ['1', '2', '3'];

        foreach ($categories_ids as  $cat_id) {
            ShopCategory::create(['category_id' => $cat_id, 'shop_id' => $shop->id]);
        }

        ShopTranslation::insert([

            [
                'key' => 'name',
                'lang' => 'en', //default language
                'value' => 'Macdonalds',
                'shop_id' => $shop->id
            ],
            [
                'key' => 'name',
                'lang' => 'ar', //default language
                'value' => 'ماكدونالدز',
                'shop_id' => $shop->id
            ],
            

        ]);

        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $status = true;
        foreach ($daysOfWeek as $day) {
            ShopAvailabiltiy::create([
                'day' => $day,
                'status' => $status,
                'shop_id' => $shop->id,
            ]);
        }
    }
}
