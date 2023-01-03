<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * endpoint for saving a property
     *
     */
    protected function store(Request $request )
    {
        //check that PropertyController is received
//        Log::info('PropertyController store =====>  '.json_encode($request->all()));
        try
        {
            // check validation for necessary parameters
            $validator = Validator::make($request->all(), [
                'name'  =>  'required||max:255',
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

            // create a property
            $property = Property::create($input);

            Log::info('PropertyController store property created =====>  '.json_encode($property));

            return response()->json( [
                'status' => true,
                'message' => "Property have been created successfully.",
                'data' =>  ["property" => $property ]
            ]);
        }
        catch(\Exception $e)
        {
            // leave for logging error purpose
            Log::info('PropertyController store catch =====>  '. $e->getMessage());
            // return false message
            return response()->json([
                'status' => false,
                'message' => "There was an error processing this request",
                'data' =>  null
            ], 500);
        }
    }

    /**
     * endpoint for listing all properties
     *
     */
    protected function index(Request $request )
    {
        // Get list of all Properties
        $properties = Property::all();

        return response()->json( [
            'status' => true,
            'message' => "Properties has been listed successfully.",
            'data' =>  ["properties" => $properties ]
        ]);
    }
}
