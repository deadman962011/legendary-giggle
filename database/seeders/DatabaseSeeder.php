<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
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
    }



    public function seedAdminRole()
    {

        $admin_permissions = [

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
                'name' =>'delete_category',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete category'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'حذف تصنيف '],
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
                'name' =>'home_slide_add_slide',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Home slide add slider'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'سلايدر الرئيسسية اضافة سلايدر '],
                ]

            ],

            [
                'name' => 'home_slide_delete_slide',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Home slide add slide'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'سلايدر الرئيسسية حذف سلايدر '],
                ]

            ],


            [
                'name' => 'add_zone',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'اضافة منظقة'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'ازالة منطقة '],
                ]

            ],
            [
                'name' =>'edit_zone',
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
                'name' => 'add_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add Role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة دور"],
                ]
            ],
            [
                'name' => 'delete_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete Role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة دور"],
                ]
            ]
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
            ['file_original_name' => 'dummy/home_slide/1.jpg', 'file_name' => 'dummy/home_slide/1.jpg', 'file_size' => 3158, 'extension' => 'jpg', 'type' => 'image', 'external_link' => null],
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


    public function seedShop()
    {
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
}
