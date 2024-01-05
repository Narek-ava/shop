<?php

namespace App\Http\Requests\API\V1\Review;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $rating
 * @property mixed $reviewTitle
 * @property mixed $review
 * @property mixed $productVariantId
 */
class ProductVariantReviewRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'rating' => ['required', 'integer', 'max:5',],
            'reviewTitle' => ['string',],
            'review' => ['string',],
            'productVariantId' => ['required', 'integer'],
        ];
    }

    public function getRating(): int|null
    {
        return $this->rating;
    }

    public function getReviewTitle(): string|null
    {
        return $this->reviewTitle;
    }

    public function getReview(): string|null
    {
        return $this->review;
    }

    public function getProductVariantId(): int|null
    {
        return $this->productVariantId;
    }
}
