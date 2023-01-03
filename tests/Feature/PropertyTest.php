<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use DatabaseTransactions;

    protected function  setUp() : void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }
    /**
     * Should be able to create a Property
     *
     *  @test
     * @return void
     */
    public function it_should_be_able_to_save_a_new_property()
    {

        // create a new property array using raw
        $propertyArray = Property::factory()->raw();
        // call property post route to save new property in the DB
        $propertyCreateResponse = $this->post("/api/properties", $propertyArray );
        $decodedPropertyResponse= json_decode($propertyCreateResponse->getContent(), true);
        $this->assertNotNull($decodedPropertyResponse);
        // test assertions
        // assert that response is ok
        $propertyCreateResponse->assertSuccessful();
        // assert that response has status equal to true
        $status =  array_key_exists("status", $decodedPropertyResponse ) ? $decodedPropertyResponse["status"] :  null;
        $this->assertTrue( $status);
        // assert property name generated is same as property name of model
        $propertyName =  array_key_exists("data", $decodedPropertyResponse ) ? $decodedPropertyResponse["data"]["property"]["name"] :  null;

        $this->assertEquals( $propertyArray["name"], $propertyName);

    }
}
