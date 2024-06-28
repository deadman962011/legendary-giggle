<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DepositBankAccount;
use App\Models\District;
use App\Models\DistrictTranslation;
use App\Models\Role;
use App\Models\RoleTranslation;
use App\Models\Shop;
use App\Models\ShopAdmin;
use App\Models\ShopAvailabiltiy;
use App\Models\ShopCategory;
use App\Models\ShopTranslation;
use App\Models\ShopWallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        $this->seedDepositBankAccouts();
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


            [
                'name' => 'display_withdraw_balance_requests',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض طلبات سحب الرصيد '],
                ]
            ],
            [
                'name' => 'show_withdraw_balance_request',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض  معلومات طلب سحب الرصيد '],
                ]
            ],

            [
                'name' => 'approve_withdraw_balance_requests',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Approve Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'موافقة طلبات سحب الرصيد '],
                ]
            ],

            [
                'name' => 'reject_withdraw_balance_requests',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Reject Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'رفض طلبات سحب الرصيد '],
                ]
            ],
            [
                'name' => 'display_shop_offers_commission_payment_requests',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض طلبات دفع عمولة العروض '],
                ]
            ],
            [
                'name' => 'show_shop_offers_commission_payment_request',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض معلومات طلبات سحب الرصيد '],
                ]
            ],

            [
                'name' => 'approve_shop_offers_commission_payment_request',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'موافقة طلبات سحب الرصيد '],
                ]
            ],

            [
                'name' => 'reject_shop_offers_commission_payment_request',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Withdraw balance requests'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'رفض طلبات سحب الرصيد '],
                ]
            ],
            [
                'name' => 'display_deposit_bank_accounts',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Display Depoist Bank Accounts'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'عرض حسابات الايداع'],
                ]
            ],
            [
                'name' => 'add_deposit_bank_account',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add Depoist Bank Account'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة حساب ايداع"],
                ]
            ],
            [
                'name' => 'edit_deposit_bank_account',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit Deposit Bank Account'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل حساب ايداع"],
                ]
            ],
            [
                'name' => 'delete_deposit_bank_account',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete Depoist Bank Account'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة حساب ايداع"],
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
                'name' => 'add_shop_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add shop role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة صلاحية للمتجر"],
                ]
            ],
            [
                'name' => 'edit_shop_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit shop role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل صلاحية للمتجر"],
                ]
            ],
            [
                'name' => 'delete_shop_role',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete shop role'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة صلاحية للمتجر"],
                ]
            ],
            [
                'name' => 'add_shop_staff',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Add shop staff'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "اضافة موظف للمتجر"],
                ]
            ],
            [
                'name' => 'edit_shop_staff',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit shop staff'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل موظف للمتجر"],
                ]
            ],
            [
                'name' => 'delete_shop_staff',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Delete shop staff'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ازالة موظف للمتجر"],
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
                'name' => 'edit_shop_informations',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit shop informations'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل معلومات المتجر"],
                ]
            ],
            [
                'name' => 'edit_shop_contact_informations',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Edit shop contact informations'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل معلومات التواصل للمتجر"],
                ]
            ],
            [
                'name' => 'edit_shop_availability',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'edit shop availabiliy'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "تعديل مواعيد المتجر"],
                ]
            ],
            [
                'name' => 'pay_offer_commission',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'pay offer commission'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "دفع عمولة العرض"],
                ]
            ],
            [
                'name' => 'upgrade_shop',
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Upgrade shop'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => "ترقية المتجر"],
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

        $ryCoordinates = '(24.850466661767697, 46.81010626482896),(24.70583069558511, 46.88975714373521),(24.62346270793282, 46.88701056170396),(24.556030317950675, 46.94194220232896),(24.493560569073278, 46.90623663592271),(24.501058579334394, 46.74418829607896),(24.51105523074001, 46.60136603045396),(24.536043379713945, 46.48051642107896),(24.815569968678023, 46.56016729998521),(24.885353514061144, 46.70573614764146)';
        $jeCoordinates = '(21.822721107238852, 39.06673741544988),(21.802321591224008, 39.02828526701238),(21.391166610482507, 39.16012120451238),(21.273480093676476, 39.13814854826238),(21.270179611315047, 39.29745030607488),(21.39554087309879, 39.33315587248113),(21.45690316338791, 39.40182042326238),(21.607642251891797, 39.30019688810613),(21.804133378007727, 39.22878575529363)';
        $makkahCoordinatis = '(21.497349775105906, 39.83950588718258),(21.414271862093248, 39.93014309421383),(21.34010088869307, 39.93426296726071),(21.337542598904726, 39.80380032077633),(21.359286639308245, 39.71041653171383),(21.4053221878885, 39.67883083835446)';
        $zones = [
            [
                'name' => 'Al Ryiadh City',
                'coordinates' => $ryCoordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Al Ryiadh City'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => ' مدينة الرياض'],
                ],
            ],
            [
                'name' => 'Jaddeh City',
                'coordinates' => $jeCoordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Jaddeh City'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'مدينة جدة'],
                ],
            ],
            [
                'name' => 'Makkah City',
                'coordinates' => $makkahCoordinatis,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['key' => 'name', 'lang' => 'en', 'value' => 'Makkah City'],
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'مدينة مكة'],
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

        $json = File::get(public_path("/static_json/districts.json"));
        $data = json_decode($json);
        foreach ($data as $data) {
            $s_district = new District();
            $s_district->name = $data->name_en;
            $s_district->zone_id = $data->zone_id;
            $s_district->save();

            // Create translations for the district
            $translations = [
                ['lang' => 'ar', 'value' => $data->name_ar],
                ['lang' => 'en', 'value' => $data->name_en],
            ];

            foreach ($translations as $translation) {
                $districtTranslation = new DistrictTranslation();
                $districtTranslation->district_id = $s_district->id;
                $districtTranslation->key = 'name';
                $districtTranslation->value = $translation['value'];
                $districtTranslation->lang = $translation['lang'];
                $districtTranslation->save();
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
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'تنقل'],
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
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'أطعمة'],
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
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'بقالة'],
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
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'أزياء'],
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
                    ['key' => 'name', 'lang' => 'ar', 'value' => 'مشروبات'],
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
            [
                'key' => 'user_minimum_withdraw_amount',
                'value' => '1000',
                'sub_value' => '',
                'section' => 'general',
                'input_type' => 'number',
                'translations' => [
                    [
                        'key' => 'name',
                        'lang' => 'en',
                        'value' => 'User minimum withdraw balance amount',
                    ],
                    [
                        'key' => 'name',
                        'lang' => 'ar',
                        'value' => 'الحد الادنى لسحب الرصيد للعميل',
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
            'district_id' => '1',
            'address' => '',
            'shop_contact_email' => 'deadman962111@gmail.com',
            'shop_contact_phone' => '1234567890',
            'tax_register' => '301071869100003',
            'status' => true
        ]);

        //save shop wallet
        ShopWallet::create([
            'shop_id' => $shop->id
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
        $shop_admin_role_name =$shop->id.'-'.$shop->shop_name .'-shop_admin_role';

        $adminRole = Role::create([
            'name' => $shop_admin_role_name,
            'guard_name' => 'shop',
            'shop_id' => $shop->id
        ]);


        RoleTranslation::insert([
            [
                'key' => 'name',
                'lang' => 'en', //default language
                'value' => 'Shop admin',
                'role_id' => $adminRole->id
            ],
            [
                'key' => 'name',
                'lang' => 'ar', //default language
                'value' => 'مدير المتجر',
                'role_id' => $adminRole->id
            ],
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

    public function seedDepositBankAccouts()
    {

        DepositBankAccount::insert([
            [
                'bank_name' => 'Al-Rajhi Bank',
                'full_name' => 'MyBill LLC',
                'iban' => 'SA465412789621544521748565238451',
                'account_number' => '8654408562102368'
            ],
            [
                'bank_name' => 'Arab National Bank (ANB)',
                'full_name' => 'MyBill2 LLC',
                'iban' => 'SA465412789621544521748565238451',
                'account_number' => '7654428562102231'
            ],
        ]);
    }
}
