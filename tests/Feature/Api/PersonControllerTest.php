<?php

namespace Tests\Feature\Api;

use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PersonControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        factory(Person::class, 10)->create();
    }

    /**
     * @return void
     */
    public function test_index_method_returns_list_of_records()
    {
        $response = $this->getJson(route('people.index'));

        $response->assertStatus(200)->assertJsonStructure(['data', 'links', 'meta']);
    }

    /**
     * @return void
     */
    public function test_store_method_creates_new_person_record()
    {
        $person = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ];

        $response = $this->postJson(route('people.store', $person));

        $response->assertStatus(200)->assertJsonStructure(['success']);

        $this->assertNotNull(Person::where('email', $person['email'])->first());
    }

    /**
     * @return void
     */
    public function test_delete_method_soft_deletes_the_given_record()
    {
        $person = Person::get()->first();

        $response = $this->deleteJson(route('people.destroy', ['person' => $person->id]));

        $response->assertStatus(200);

        $this->assertNull(Person::find($person->id));
    }
}
