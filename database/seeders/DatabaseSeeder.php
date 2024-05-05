<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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


        $this->seedAdmin();
        $this->seedShopRoles();
        $this->seedLanguage();
        $this->seedHomeSlider();
        $this->seedZones();
        $this->seedCategory();
        $this->seedConfig();


        // try {
        //     DB::beginTransaction();

        //     $this->seedAdmin();
        //     $this->seedShopRoles();
        //     $this->seedLanguage();
        //     $this->seedHomeSlider();
        //     $this->seedZones();
        //     $this->seedCategory();
        //     $this->seedConfig();

        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     // return $th->getMessage();


        // }
    }



    public function seedAdmin(): void
    {

        \App\Models\Admin::create([
            'name' => 'blaxk',
            'email' => 'blaxk@blaxk.cc',
            'password' => bcrypt('123456789')
        ]);
    }


    public function seedShopRoles()
    {


        $role = \App\Models\Role::query()->create([
            'name' => 'Shop Admin',
            'guard_name' => 'shop'
        ]);


        /**
         * Shop Admin Permissions
         */

        $shop_admin_permissions =   [
            'add_shop_offer',
            'edit_shop_offer',
            'delete_shop_offer',
        ];

        foreach ($shop_admin_permissions as $permission) {
            $perm = \App\Models\Permission::query()->create([
                'name'          =>  $permission,
                'guard_name'    =>  'shop',
                // 'section'       =>  'Shop Admin',
            ]);

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
            ['file_original_name' => 'uploads/dummy/home_slide/1.jpg', 'file_name' => 'uploads/dummy/home_slide/1.jpg', 'file_size' => 3158, 'extension' => 'jpg', 'type' => 'image', 'external_link' => null],
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
                    ['lang' => 'en', 'value' => 'Al Malaz Area'],
                    ['lang' => 'ar', 'value' => 'منطقة الملز'],
                ],
            ],
            [
                'name' => 'Al Faisaliyah Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['lang' => 'en', 'value' => 'Al Faisaliyah Area'],
                    ['lang' => 'ar', 'value' => 'منطقة الفيصلية'],
                ],
            ],
            [
                'name' => 'Al Anoud Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['lang' => 'en', 'value' => 'Al Anoud Area'],
                    ['lang' => 'ar', 'value' => 'منطقة العنود'],
                ],
            ],
            [
                'name' => 'Al Aqiq Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['lang' => 'en', 'value' => 'Al Aqiq Area'],
                    ['lang' => 'ar', 'value' => 'منطقة العقيع'],
                ],
            ],
            [
                'name' => 'Al Murabba Area',
                'coordinates' => $coordinates,
                'status' => false,
                'isDeleted' => false,
                'translation' => [
                    ['lang' => 'en', 'value' => 'Al Murabba Area'],
                    ['lang' => 'ar', 'value' => 'منطقة المربع'],
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
            ['file_original_name' => 'uploads/dummy/category/1.png', 'file_name' => 'uploads/dummy/category/1.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'uploads/dummy/category/2.png', 'file_name' => 'uploads/dummy/category/2.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'uploads/dummy/category/3.png', 'file_name' => 'uploads/dummy/category/3.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'uploads/dummy/category/4.png', 'file_name' => 'uploads/dummy/category/4.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
            ['file_original_name' => 'uploads/dummy/category/5.png', 'file_name' => 'uploads/dummy/category/5.png', 'file_size' => 3158, 'extension' => 'png', 'type' => 'image', 'external_link' => null],
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
                    ['lang' => 'en', 'value' => 'Automotive'],
                    ['lang' => 'ar', 'value' => 'تنقل'],
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
                    ['lang' => 'en', 'value' => 'Food'],
                    ['lang' => 'ar', 'value' => 'أطعمة'],
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
                    ['lang' => 'en', 'value' => 'Grocery'],
                    ['lang' => 'ar', 'value' => 'بقالة'],
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
                    ['lang' => 'en', 'value' => 'Fashion'],
                    ['lang' => 'ar', 'value' => 'أزياء'],
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
                    ['lang' => 'en', 'value' => 'Drinks'],
                    ['lang' => 'ar', 'value' => 'مشروبات'],
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
                'input_type'=>$setting['input_type']
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
