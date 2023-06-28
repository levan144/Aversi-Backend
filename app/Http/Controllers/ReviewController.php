<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

use App\Http\Requests\ReviewStoreRequest;
class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:patient-api');
    }
    

    public function store(ReviewStoreRequest $request){
        
        $review = new Review;
        $review->patient_id = $request->patient_id;
        $review->doctor_id = $request->doctor_id;
        $review->rating = $request->rating;
        $review->description = $request->description;
        $review->save();

        return response()->json([
            'success'   => false,
            'message'   => 'Review added successfully',
            'data'      => $review,
        ]);
    }
}
