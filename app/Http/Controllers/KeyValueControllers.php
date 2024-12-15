<?php

namespace App\Http\Controllers;


use App\Http\Transformers\KeyValueTransformer;
use App\Models\KeyValue\Facades\KeyValueRepositories;
use App\Models\KeyValue\KeyValue;
use App\Rules\UnixTimestamp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeyValueControllers
{
    /**
     * Get all key-value pairs
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Fetch all data
        $values = KeyValue::orderBy('created_at', 'desc')->get();

        // Transform data using the transformer
        $filterValues = $values->map(function ($value) {
            return KeyValueTransformer::transform($value);
        });
        return response()->json($filterValues);
    }

    /**
     * Get the key-value pair by key
     * Return the key-value pair created before a specific date if the timestamp is provided
     * @param $key
     * @param Request $request
     * @return JsonResponse
     */
    public function show($key,Request $request): JsonResponse
    {

        // Validate the request
        $request->validate([
            'timestamp' => [new UnixTimestamp],
        ]);

        if($request->has('timestamp')){
            // Convert the timestamp to a date
            $date = date('Y-m-d H:i:s', $request->timestamp);
            //Get the value of the key created before the date
            $value = KeyValue::where('key', $key)->where('created_at','<=',$date)
                ->orderBy('created_at','desc')->first();
        }else{
            //Get the value of the key
            $value = KeyValue::where('key', $key)->orderBy('created_at','desc')->first();
        }

        if ($value){
            return response()->json(KeyValueTransformer::transform($value));
        }

        return response()->json(['message' =>
            'Sorry, we couldn\'t find any object matching your key: ' . $key . '. Please verify the key or try again.'], 404);
    }

    /**
     * Store key-value pairs
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        //Optional fields to exclude
        $except = [];

        if(!$request->except($except)){
            return response()->json(['message' => 'No key-value pairs found.'], 400);
        }
        //Get all the key-value pairs from the request
        foreach ($request->except($except) as $key => $value){
           //Set the key to lowercase
           $data['key_value']['key'] = strtolower($key);

            //Return if the value is file
            //Can implement handling of file if needed
            if($request->file($key)){
                return response()->json(['message' => 'File upload is not supported.'], 400);
            }
           $data['key_value']['value'] = $value;
           //Create the key-value pair
           KeyValueRepositories::create($data);
        }

        return response()->json(['message' => 'Key-value pairs successfully stored.',], 201);
    }
}
