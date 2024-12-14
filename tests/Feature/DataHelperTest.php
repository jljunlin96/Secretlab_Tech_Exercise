<?php

namespace Tests\Feature;

use Tests\TestCase;

class DataHelperTest extends TestCase
{
    public function test_data_all_without_key()
    {
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        $data['key_value']['type'] = 'number';
        $result = data_all($data);

        $expected['key_value'] = [
            'key' => 'test_key',
            'value' => 'test_value',
            'type' => 'number',
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_data_all_with_key()
    {
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        $data['key_value']['type'] = 'number';
        $result = data_all($data, [
            'key_value.key',
            'key_value.value',
        ]);

        $expected['key_value'] = [
            'key' => 'test_key',
            'value' => 'test_value',
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_data_all_with_string()
    {
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        $data['key_value']['type'] = 'number';
        $result = data_all($data, 'key_value.key');

        $expected['key_value'] = [
            'key' => 'test_key'
        ];

        $this->assertEquals($expected, $result);
    }
}
