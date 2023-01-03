<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * endpoint for saving a property
     *
     */
    protected function store(Request $request )
    {
        try
        {
            // check validation for necessary parameters
            $validator = Validator::make($request->all(), [
                'summary'  =>  'required|max:150',
                'description'  =>  'required|max:500',
                'property_id'  =>  'required|exists:properties,id',
                'last_name'  =>  'required|max:255',
                'first_name'  =>  'required|max:255',
                'email'  =>  'required|max:255',
            ]);

            if ($validator->fails())
            {
                //return if an validation error occurred
                return response()->json( [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' =>  null
                ], 422);
            }

            // extract all request parameters in array
            $input = $request->all();

            // check if user exist or else create new user
            $user = User::where("email", $input['email'])->first();
            if(empty($user))
            {
                // create new User
                $user = User::create(
                    [
                        "first_name" => $input['first_name'],
                        "last_name" => $input['last_name'],
                        "name" => $input['first_name'] . " " . $input['last_name'],
                        "email" => $input['email'],
                        "password" => Hash::make($input['email']),
                    ]);
            }
            $input['user_id'] = $user->id;

            // create a property
            $job = Job::create($input);

            Log::info('JobController store job created =====>  '.json_encode($job));

            return response()->json( [
                'status' => true,
                'message' => "Job has been created successfully.",
                'data' =>  ["job" => $job ]
            ]);
        }
        catch(\Exception $e)
        {
            // leave for logging error purpose
            Log::info('JobController store catch =====>  '. $e->getMessage());
            // return false message
            return response()->json([
                'status' => false,
                'message' => "There was an error processing this request",
                'data' =>  null
            ], 500);
        }
    }

    /**
     * endpoint for saving a property
     *
     */
    protected function index(Request $request )
    {
            // Get list of all jobs
            $jobs = Job::with(['property', 'user'])->latest()->get();
//            Log::info('JobController store job created =====>  '.json_encode($jobs));

            return response()->json( [
                'status' => true,
                'message' => "Job has been created successfully.",
                'data' =>  ["jobs" => $jobs ]
            ]);
    }
}
