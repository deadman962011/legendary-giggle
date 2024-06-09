<?php

namespace App\Services;

use App\Mail\ShopApproved;
use App\Models\Role;
use App\Models\Shop;
use App\Models\ShopAdmin;
use App\Models\ShopAvailabiltiy;
use App\Models\ShopCategory;
use App\Models\ShopTranslation;
use App\Models\ShopWallet;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Mail;
class ShopService
{
    public function createShop($data, $from)
    {
        DB::beginTransaction();
        try {
            //save shop
            $shop = Shop::create([
                'shop_name' => $from === 'approval' ? $data->shop_name :  $data->{'shop_name_' . $data->lang[0]},
                'shop_logo' => $data->shop_logo,
                'longitude' => $data->longitude,
                'latitude' => $data->latitude,
                'zone_id' => $data->zone_id,
                'district_id'=>$data->district_id,
                'tax_register' => $data->tax_register,
                'address' => '',
                'shop_contact_email'=>'',
                'shop_contact_phone'=>'',
                'status' => $from === 'cp' ? false : true
            ]);


            //save shop admin
            $shopAdmin = ShopAdmin::create([
                'name' => $data->shop_admin_name,
                'email' => $data->shop_admin_email,
                'phone' => $data->shop_admin_phone,
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
            $categories_ids = explode(',', $data->categories_ids);

            foreach ($categories_ids as  $cat_id) {
                ShopCategory::create(['category_id' => $cat_id, 'shop_id' => $shop->id]);
            }

            if ($from === 'approval') {
                //save shop translation
                ShopTranslation::create([
                    'key' => 'name',
                    'lang' => 'en', //default language
                    'value' => $data->shop_name,
                    'shop_id' => $shop->id
                ]);
            } elseif ($from === 'cp') {
                for ($i = 0; $i < count($data->lang); $i++) {
                    ShopTranslation::create([
                        'key' => 'name',
                        'lang' => $data->lang[$i], //default language
                        'value' => $data->{"shop_name_" . $data->lang[$i]},
                        'shop_id' => $shop->id
                    ]);
                }
            }



            //save shop availability
            $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            $status = true; 
            foreach ($daysOfWeek as $day) {
                ShopAvailabiltiy::create([
                    'day' => $day,
                    'status' => $status,
                    'shop_id' => $shop->id,
                ]);
            }

            //save shop wallet
            ShopWallet::create([
                'shop_id'=>$shop->id
            ]);
            
            Mail::to($data->shop_admin_email)->send(new ShopApproved());


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            throw $th;
        }
    }

    // public function createShopAdmin($data){

    // }

    // public function getUserById($id)
    // {
    //     return User::findOrFail($id);
    // }

    // public function updateUser($id, $data)
    // {
    //     $user = $this->getUserById($id);
    //     $user->update($data);
    //     return $user;
    // }

    // public function deleteUser($id)
    // {
    //     $user = $this->getUserById($id);
    //     // $user->delete();
    // }
}
