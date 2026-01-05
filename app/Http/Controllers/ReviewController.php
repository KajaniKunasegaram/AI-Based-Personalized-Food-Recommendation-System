<?php

namespace App\Http\Controllers;
use App\Models\ReviewModel;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Show reviews page
   public function index()
    {
        $reviews = ReviewModel::latest()->take(20)->get();

        $totalReviews = ReviewModel::count();              // total reviews
        $averageRating =ReviewModel::sum('rating'); 

        return view('client.review', compact(
            'reviews',
            'totalReviews',
            'averageRating'
        ));
    }

    // Save new review
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        ReviewModel::create($request->only([
            'name','email','rating','comment'
        ]));

        return redirect()->back()->with('success', 'Thank you for your review!');
    }




    public function indexAdmin()
    {
        // Get latest 50 reviews, paginate if needed
        $reviews = ReviewModel::latest()->paginate(50);

        // Optional stats
        $totalReviews  = ReviewModel::count();
        $averageRating = round(ReviewModel::avg('rating'), 1);

        return view('admin.reviews', compact('reviews','totalReviews','averageRating'));
    }

    public function destroy($id)
    {
        ReviewModel::findOrFail($id)->delete();
        return redirect()->back()->with('success','Review deleted successfully!');
    }

   
}
