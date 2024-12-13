<?php

namespace App\Models\KeyValue\Repositories;

use App\Enums\DataTypes;
use App\Models\KeyValue\KeyValue;
use Illuminate\Support\Facades\DB;

class KeyValueRepositories
{
    /**
     * Create a new key value
     *
     * @param array $input
     * @return KeyValue
     */
    public function create(array $input)
    {
        //Filter the input data
        $data = data_only($input, [
            'key_value.key',
            'key_value.value',
        ]);

        return DB::transaction(function () use ($data) {

            //Check if the value is an json
            if (is_array($data['key_value']['value'])) {
                //Encode the array to json string
                $data['key_value']['value'] = json_encode($data['key_value']['value']);
                $data['key_value']['type'] = DataTypes::Json->value;
            }

            return KeyValue::create($data['key_value']);
        });
    }
}
