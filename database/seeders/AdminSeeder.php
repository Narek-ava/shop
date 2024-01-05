<?php

namespace Database\Seeders;

use App\Http\Requests\API\V1\ProductVariant\CreateRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User\User;
use http\Env\Request;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //todo artsol.am@gmail.com get from env
        if (!User::query()->where('email', 'artsol.am@gmail.com')->exists()) {
            $user = new User();
            $user->name = "Admin";
            $user->email = "artsol.am@gmail.com";
            $user->password = bcrypt("Artsol2018");
            $user->save();

            $user->assignRole('superAdmin');
        }
    }
}
