<?php

namespace App\Enums\Permissions;

use App\Enums\StringableEnum;

enum PermissionsEnum:string implements StringableEnum {

    //user
    case USER_CHANGE_ROLE = 'userChangeRole';
    case USER_VIEW = 'userView';
    case USER_EDIT = 'userEdit';
    case USER_DELETE = 'userDelete';
    //Order
    case ORDER_VIEW = 'orderView';
    //Product
    case PRODUCT_CREATE = 'productCreate';
    case PRODUCT_DELETE = 'productDelete';
    case PRODUCT_UPDATE = 'productUpdate';
    //Category
    case CATEGORY_CREATE = 'categoryCreate';
    case CATEGORY_DELETE = 'categoryDelete';
    case CATEGORY_UPDATE = 'categoryUpdate';
    case ATTRIBUTE_CREATE = 'attributeCreate';

    case OPTION_CREATE = 'optionCreate';
    case OPTION_DELETE = 'optionDelete';


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
}
