<?php

namespace Tests\Unit;

use App\Models\KeyValue\Facades\KeyValueRepositories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KeyValueControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test that the index method returns a valid JSON response.
     *
     * @return void
     */
    public function test_index_returns_json_response()
    {
        // Arrange: Set up any necessary data.
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        KeyValueRepositories::create($data);

        $data['key_value']['key'] = 'test_key_2';
        $data['key_value']['value'] = ['test_value_2'=>'test_value_2'];
        KeyValueRepositories::create($data);

        // Act: Perform a GET request to the index route
        $response = $this->getJson(route('key.value.index'));

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                [
                    'test_key' => 'test_value',
                ],
                [
                    'test_key_2' => ['test_value_2'=>'test_value_2']
                ]
            ]);
        // Assert: Check the response that not contains the value
        $response->assertJsonMissing([
            'test_key_3' => 'test_value_3'
        ]);

    }

    /**
     * Test that the index method handles empty data gracefully.
     *
     * @return void
     */
    public function test_index_with_no_data()
    {
        // Act: Perform a GET request to the index route with no data in the database
        $response = $this->getJson(route('key.value.index'));

        // Assert: The response should return an empty array
        $response->assertStatus(200)
            ->assertJson([]);
    }

    public function test_show_returns_json_response()
    {
        // Arrange: Set up any necessary data.
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        KeyValueRepositories::create($data);

        // Act: Perform a GET request to the show route
        $response = $this->getJson(route('key.value.show', 'test_key'));

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'test_key' => 'test_value',
            ]);
    }

    public function test_show_returns_json_response_with_timestamp()
    {
        // Arrange: Set up any necessary data.
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        $key1 = KeyValueRepositories::create($data);
        $key1->created_at = '2021-01-01 00:00:00';
        $key1->save();

        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value_2';
        $key2 = KeyValueRepositories::create($data);

        //convert to epoch timestamp
        $oneYearAgo = now()->subYear()->timestamp;
        // Act: Perform a GET request to the show route
        $response = $this->getJson(route('key.value.show',['key'=>'test_key','timestamp'=>$oneYearAgo]));

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'test_key' => 'test_value',
            ]);
    }

    public function test_show_with_no_data()
    {
        // Act: Perform a GET request to the index route with no data in the database
        $response = $this->getJson(route('key.value.show', 'test_key'));

        // Assert: The response should return an empty array
        $response->assertStatus(404)
            ->assertJson(['message' =>
                'Sorry, we couldn\'t find any object matching your key: test_key. Please verify the key or try again.']);
    }

    public function test_show_with_timestamp_error()
    {
        $timestamp = 'not_a_timestamp';
        // Act: Perform a GET request to the index route with no data in the database
        $response = $this->getJson(route('key.value.show',['key'=>'test_key','timestamp'=>$timestamp]));

        // Assert: The response should return an error
        $response->assertStatus(422)->assertJsonValidationErrors(['timestamp']);;
    }

    public function test_show_with_null_timestamp()
    {
        $data['key_value']['key'] = 'test_key';
        $data['key_value']['value'] = 'test_value';
        KeyValueRepositories::create($data);

        // Act: Perform a GET request to the show route with null timestamp
        $response = $this->getJson(route('key.value.show',['key'=>'test_key','timestamp'=>'']));

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'test_key' => 'test_value',
            ]);
    }
    public function test_store()
    {
        // Arrange: Set up any necessary data.
        $data = [
            'test_key' => 'test_value',
        ];

        // Act: Perform a POST request to the store route
        $response = $this->postJson(route('key.value.store'), $data);

        // Assert: Check the response
        $response->assertStatus(201)
            ->assertJson(['message' => 'Key-value pairs successfully stored.',]);
    }

    public function test_store_with_no_data(){
        // Act: Perform a POST request to the store route with no data
        $response = $this->postJson(route('key.value.store'));

        // Assert: The response should return an error
        $response->assertStatus(400)->assertJson(['message' => 'No key-value pairs found.']);
    }

    public function test_store_with_file(){
        // Arrange: Fake the file system so files are not actually stored on disk
        Storage::fake('local');

        // Create a fake file
        $file = UploadedFile::fake()->image('test-image.jpg');

        // Prepare the data with the fake file
        $data = [
            'test_key' => $file,
        ];


        // Act: Perform a POST request to the store route
        $response = $this->postJson(route('key.value.store'), $data);

        // Assert: The response should return an error
        $response->assertStatus(400)->assertJson(['message' => 'File upload is not supported.']);
    }
}
