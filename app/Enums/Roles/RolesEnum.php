<?php

namespace App\Enums\Roles;

use App\Enums\EnumHelper;
use App\Enums\Permissions\PermissionsEnum;
use App\Enums\StringableEnum;
use JetBrains\PhpStorm\Pure;

enum RolesEnum: string implements StringableEnum {
    case SUPER_ADMIN = 'superAdmin';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case CUSTOMER = 'customer';


    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getGuard(): string
    {
        return 'api';
    }

    /**
     * todo move this function
     * @param RolesEnum $role
     * @return array
     */
    public static function getRolePermissions(RolesEnum $role): array
    {
        return match ($role) {
            self::SUPER_ADMIN => EnumHelper::values(self::superAdminPermissions()),
            self::ADMIN => EnumHelper::values(self::adminPermissions()),
            self::MODERATOR => EnumHelper::values(self::moderatorPermissions()),
            self::CUSTOMER => EnumHelper::values(self::customerPermissions()),
            default => [],
        };
    }

    /**
     * @return array
     */
    private static function superAdminPermissions(): array
    {
        return PermissionsEnum::cases();
    }

    /**
     * @return array
     */
    #[Pure] private static function adminPermissions(): array
    {
        return [
            PermissionsEnum::USER_VIEW,
            PermissionsEnum::USER_EDIT,
            PermissionsEnum::USER_DELETE,
            PermissionsEnum::ORDER_VIEW,
            PermissionsEnum::PRODUCT_CREATE,
            PermissionsEnum::PRODUCT_DELETE,
            PermissionsEnum::PRODUCT_UPDATE,
            PermissionsEnum::CATEGORY_CREATE,
            PermissionsEnum::CATEGORY_DELETE,
            PermissionsEnum::CATEGORY_UPDATE,
            PermissionsEnum::ATTRIBUTE_CREATE,
            PermissionsEnum::OPTION_CREATE,
            PermissionsEnum::OPTION_DELETE,
        ];
    }

    /**
     * @return array
     */
    #[Pure] private static function moderatorPermissions(): array
    {
        return [
            PermissionsEnum::PRODUCT_CREATE,
            PermissionsEnum::PRODUCT_DELETE,
            PermissionsEnum::PRODUCT_UPDATE,
            PermissionsEnum::CATEGORY_CREATE,
            PermissionsEnum::CATEGORY_DELETE,
            PermissionsEnum::CATEGORY_UPDATE,
            PermissionsEnum::ATTRIBUTE_CREATE,
            PermissionsEnum::OPTION_CREATE,
            PermissionsEnum::OPTION_DELETE,
        ];
    }

    /**
     * @return array
     */
    #[Pure] private static function customerPermissions(): array
    {
        return [
            PermissionsEnum::ORDER_VIEW,
        ];
    }
}
