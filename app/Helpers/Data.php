<?php

use Illuminate\Support\Arr;

if ( ! function_exists('data_all')) {

    /**
     * Get all of the input based on.
     *
     * @param
     *
     * @return
     */
    function data_all($input, $keys = [])
    {
        if ( ! $keys) {
            return $input;
        }

        $results = [];

        if ( ! is_array($keys)) {
            $keys = [$keys];

        }

        foreach ($keys as $key) {
            Arr::set($results, $key, Arr::get($input, $key));
        }

        return $results;
    }
}
