<?php

namespace App\Services\User;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\User\CreateUserImageDTO;
use App\DTO\User\UserCreateDTO;
use App\Models\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserService
{

    /**
     * @param UserCreateDTO $userCreateDTO
     * @return User
     */
    public function create(UserCreateDTO $userCreateDTO): User
    {
        $user = new User();
        $user->name = $userCreateDTO->name;
        $user->email = $userCreateDTO->email;
        $user->password = $userCreateDTO->password;
        $user->save();

        if ($userCreateDTO->image)
        {
                $user->setNewMedia($userCreateDTO->image)->toMediaCollection('images');
        }

        $user->assignRole($userCreateDTO->role->toString());

        return $user;

    }

    public function updateOrCreateUserImage(CreateUserImageDTO $createUserImageDTO)
    {
        $user = User::query()->where('id',auth()->id())->first();
        if ($user->getFirstMedia('images')){
            $user->clearMediaCollection('images');
            $user->addMedia($createUserImageDTO->image)->toMediaCollection('images');

        }else{
            $user->addMedia($createUserImageDTO->image)->toMediaCollection('images');
        }
       return $user;
    }


    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return User::query()->with($paginationFilterDTO->relations)->paginate($paginationFilterDTO->perPage, ['*'], 'page', $paginationFilterDTO->page);
    }

    public function userSearch(string $searchText, int $limit = 10)
    {
        return User::query()->where('name', 'LIKE', "%$searchText%")
            ->orWhere('email', 'LIKE', "%$searchText%")
            ->limit($limit)->get();
    }

    public function find(int $id)
    {
        return User::query()->where('id',$id)->first();
    }
}
