<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class JobTest extends TestCase
{
    use DatabaseTransactions;

    protected function  setUp() : void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    /**
     * Should be able to create a job
     * @test
     * @return void
     */
    public function it_should_be_able_to_save_a_new_job()
    {
        // create new User
        $user = User::factory()->create();
        $this->assertNotNull($user);
        // create new Property
        $property = Property::factory()->create();

        $this->assertNotNull($property);
        // create a new job array using raw
        $jobArray =  Job::factory()->raw(["property_id" => $property->id,"last_name" => $user->last_name,"first_name" => $user->first_name,"email" => $user->email]);
        // call jobs post route to save new job in the DB
        $jobCreateResponse = $this->post("/api/jobs", $jobArray );
        // assert that response is ok
        $decodedJobResponse= json_decode($jobCreateResponse->getContent(), true);
//        dd($decodedJobResponse);
        $this->assertNotNull($decodedJobResponse);
        // assert that response has status equal to true
        $status =  array_key_exists("status", $decodedJobResponse ) ? $decodedJobResponse["status"] :  null;
        $this->assertTrue( $status);

        // assert property name generated is same as property name of model
        $jobSummary =  array_key_exists("data", $decodedJobResponse ) ? $decodedJobResponse["data"]["job"]["summary"] :  null;

        $this->assertEquals( $jobArray["summary"], $jobSummary);


    }

    /**
     * Should be able to retrieve list of jobs
     * @test
     * @return void
     */
    public function it_should_be_able_to_retrieve_list_of_jobs()
    {
        $jobListResponse = $this->get("/api/jobs" );
        // assert that response is ok
        $decodedJobResponse= json_decode($jobListResponse->getContent(), true);
//        dd($decodedJobResponse);
        $this->assertNotNull($decodedJobResponse);
        // assert that response has status equal to true
        $status =  array_key_exists("status", $decodedJobResponse ) ? $decodedJobResponse["status"] :  null;
        $this->assertTrue( $status);

        // assert jobs exisiting in database are same as jobs list send
        $jobs = Job::all();
        $this->assertNotNull($jobs);
        $jobsList =  array_key_exists("data", $decodedJobResponse ) ? $decodedJobResponse["data"]["jobs"] :  null;

        $this->assertEquals( count($jobsList), $jobs->count());

    }
}
