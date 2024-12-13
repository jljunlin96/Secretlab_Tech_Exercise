<?php

use Illuminate\Support\Arr;

if ( ! function_exists('data_only')) {

    /**
     * Get a subset containing the provided keys with values from the input data.
     *
     * @param
     *
     * @return
     */
    function data_only($input, $keys): array
    {
        $results = [];

        if ( ! is_array($keys)) {
            $keys = [$keys];
        }

        $placeholder = new stdClass;

        foreach ($keys as $key) {
            $value = data_get($input, $key, $placeholder);

            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }
}

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
