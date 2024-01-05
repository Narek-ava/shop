<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\User\CreateUserImageDTO;
use App\DTO\User\UserCreateDTO;
use App\Enums\Roles\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Requests\API\V1\User\CreateRequest;
use App\Http\Requests\API\V1\User\FindUserRequest;
use App\Http\Requests\API\V1\User\SearchUserRequest;
use App\Http\Requests\API\V1\User\UploadMediaRequest;
use App\Http\Requests\Media\DeleteMediaByIdRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Managers\User\UserManager;
use App\Models\User\User;
use App\Services\Media\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UserController extends Controller
{
   public UserManager $userManager;
    public MediaService $mediaService;

    public function __construct(
       UserManager $userManager,
       MediaService $mediaService,
   ){
       $this->userManager = $userManager;
       $this->mediaService = $mediaService;
   }

    /**
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): UserResource
    {
        $userDTO = new UserCreateDTO(
            $request->getName(),
            $request->getEmail(),
            $request->password = bcrypt($request->getPasswordValue()),
            $request->role = RolesEnum::CUSTOMER,
            $request->getImage(),
        );

        $createdUser = $this->userManager->create($userDTO);
        $createdUser->load(['image']);

        return new UserResource($createdUser);
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function getAuthUserAction(Request $request): UserResource
    {
        $user = $request->user();
        $user->load(['permissions','image']);

        return new UserResource($user);
    }
    public function updateOrCreateUserImage(UploadMediaRequest $request)
    {
       $createUserImageDTO = new CreateUserImageDTO(
           $request->getImage()
       );
       $user = $this->userManager->updateOrCreateUserImage($createUserImageDTO);

        $user->load(['image']);

        return new UserResource($user);

    }

    /**
     * @param DeleteMediaByIdRequest $request
     * @return JsonResponse
     */
    public function deleteImage(DeleteMediaByIdRequest $request): JsonResponse
    {
        return $this->mediaService->deleteMediaById($request->getId());
    }

    /**
     * @return JsonResponse|void
     */
    public function logOut()
    {
        $userId = \auth()->id();
        if (Auth::check()) {
        DB::table('oauth_access_tokens')
                ->where('user_id', $userId)
                ->update([
                    'revoked' => true
                ]);
            return response()->json(['message' => 'Successfully logged out'],204);
        }
    }

    /**
     * @param GetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetAllRequest $request): AnonymousResourceCollection
    {
        $getAllUsersDTO = new PaginationFilterDTO(
            $request->getFilter(),
            $request->getPerPage(),
            $request->getCurrentPage(),
            ['image']
        );
        $users = $this->userManager->getAll($getAllUsersDTO);

        return UserResource::collection($users);
    }

    public function userSearch(SearchUserRequest $request)
    {
        $users = $this->userManager->searchAction($request->searchText);

        return UserResource::collection($users);

    }

    public function find(FindUserRequest $request)
    {
        return new UserResource($this->userManager->find($request->getId()));
    }

}
