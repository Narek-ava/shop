<?php

namespace Database\Seeders;

use App\Enums\EnumHelper;
use App\Enums\Locale\LocalesEnum;
use App\Enums\Price\PriceTypesEnum;
use App\Models\Price\PriceType;
use App\Models\Price\PriceTypeTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws \Throwable
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            foreach (PriceTypesEnum::cases() as $type) {
                if (!PriceType::query()->where('type', $type->toString())->exists()) {
                    $priceType = new PriceType();
                    $priceType->type = $type->toString();
                    $priceType->priority = $type->getPriority();
                    $priceType->save();

                    foreach (LocalesEnum::cases() as $locale) {
                        $priceTypeTranslation = new PriceTypeTranslation();
                        $priceTypeTranslation->price_type_id = $priceType->id;
                        $priceTypeTranslation->locale = $locale->toString();
                        $priceTypeTranslation->field = PriceType::NAME_FIELD;
                        $priceTypeTranslation->value = $type->toString();
                        $priceTypeTranslation->save();
                    }
                }
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
    }
}
