<?php

namespace App\DTO\PromoCode;

use App\DTO\DTO;
use Carbon\Carbon;

class PromoCodeDTO implements DTO
{
    public string $code;
    public ?int $discountAmount;
    public ?int $discountPercent;
    public int $max_uses;
    public Carbon $expiredAt;
    public ?array $productVariantId;

    public function __construct(
        string $code,
        ?int   $discountAmount,
        ?int   $discountPercent,
        int    $max_uses,
        Carbon $expiredAt,
        ?array $productVariantId,
    )
    {
        $this->code = $code;
        $this->discountAmount = $discountAmount;
        $this->discountPercent = $discountPercent;
        $this->max_uses = $max_uses;
        $this->expiredAt = $expiredAt;
        $this->productVariantId = $productVariantId;

    }

}
