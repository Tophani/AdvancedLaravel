<?php

namespace Database\Seeders;

use App\Models\PasswordModel;
use App\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserModel::factory(1)->create([
            'name'=>"adamu",
            'profile_pic'=>"ajajjk",
            "address"=>"akpizone",
            "phone"=>8133087596,
            "password"=>Hash::make("akpizone")
        ])->each(function ($user){
            PasswordModel::factory(1)->create([
                'platform'=>"dodge",
                'password'=>"ajajjk",
                'user_id'=>$user->id,

            ]);
        });
    }
}
