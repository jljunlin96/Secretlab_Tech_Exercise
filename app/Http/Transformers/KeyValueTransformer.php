<?php

namespace App\Http\Transformers;

use App\Enums\DataTypes;
use App\Models\KeyValue\KeyValue;

class KeyValueTransformer
{
    /**
     * Transform the key value data
     *
     * @param KeyValue $keyValue
     * @return array
     */
    public static function transform(KeyValue $keyValue): array
    {
        return [
            $keyValue->key => $keyValue->type == DataTypes::Json->value ? json_decode($keyValue->value) : $keyValue->value
        ];
    }
}
