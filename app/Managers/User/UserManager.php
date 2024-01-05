<?php

namespace App\Managers\User;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\User\CreateUserImageDTO;
use App\DTO\User\UserCreateDTO;
use App\Http\Requests\API\V1\User\FindUserRequest;
use App\Models\User\User;
use App\Services\User\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserManager
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws Throwable
     */
    public function create(UserCreateDTO $userCreateDTO): User
    {

        DB::beginTransaction();
        try {
            $user = $this->userService->create($userCreateDTO);
            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param CreateUserImageDTO $createUserImageDTO
     * @return null
     * @throws Throwable
     */
    public function updateOrCreateUserImage(CreateUserImageDTO $createUserImageDTO)
    {

        DB::beginTransaction();
        try {
            $user = $this->userService->updateOrCreateUserImage($createUserImageDTO);
            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return $this->userService->getAll($paginationFilterDTO);
    }

    /**
     * @param string $searchText
     * @param int $limit
     * @return Collection|array
     */
    public function searchAction(string $searchText, int $limit = 10): Collection|array
    {
        return $this->userService->userSearch($searchText,$limit);
    }

    public function find(int $id)
    {
        return $this->userService->find($id);
    }
}
