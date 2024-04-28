<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

    }



    public function seedAdmin():void
    {

        \App\Models\Admin::create([
            'name'=>'blaxk',
            'email'=>'blaxk@blaxk.cc',
            'password'=>bcrypt('123456789')
        ]);

    }


    public function seedShopRoles()
    {


        $role=\App\Models\Role::query()->create([
            'name'=>'Shop Admin',
            'guard_name'=>'shop'
        ]);


        /**
        * Shop Admin Permissions
        */

        $shop_admin_permissions =   [
            'add_shop_offer',
            'edit_shop_offer',
            'delete_shop_offer',
        ];

        foreach($shop_admin_permissions as $permission)
        {
            $perm=\App\Models\Permission::query()->create([
                'name'          =>  $permission,
                'guard_name'    =>  'shop',
                // 'section'       =>  'Shop Admin',
            ]);

            $role->givePermissionTo($perm->id);
        }

    }

    public function seedLanguage(){
        \App\Models\Language::insert([
            [
                'name'=>'العربية',
                'key'=>'ar',
                'dir'=>'rtl',
                'status'=>true
            ],
            [
                'name'=>'English',
                'key'=>'en',
                'dir'=>'ltr',
                'status'=>true
            ],
        ]);
    }

    public function seedHomeSlider() {
        
        \App\Models\Slider::create([
            'name'=>'home',
            'status'=>true
        ]);

    }
}
