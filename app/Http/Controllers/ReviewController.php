<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function Add(Request $request, $prod_category, $prod_id)
    {
        // NOTE: Auth check ديال الـ route middleware كافي، لكن نبقاوها كـ fallback
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must login first');
        }

        $request->validate([
            'stars'  => 'required|numeric|min:1|max:5', // FIX: range validation
            'review' => 'required|string|max:1000',
        ]);

        // FIX: منع المستخدم من إضافة review مرتين لنفس المنتج
        $alreadyReviewed = Review::where('client_id', Auth::id())
            ->where('prod_id', $prod_id)
            ->where('prod_category', $prod_category)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('info', 'لقد قمت بتقييم هذا المنتج من قبل');
        }

        $newReview = new Review();
        $newReview->client_id     = Auth::id();
        $newReview->prod_id       = $prod_id;
        $newReview->prod_category = $prod_category;
        $newReview->stars         = $request->stars;
        $newReview->review        = $request->review;
        $newReview->is_approved   = 1;
        $newReview->save();

        return redirect()->back()->with('success', 'Review added');
    }

    public function IndexForUser()
    {
        $reviews = Review::where('client_id', Auth::id())->get();
        return view('user.dashboard.review.index', compact('reviews'));
    }

    public function Remove(Review $review)
    {
        if ($review->client_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();
        return redirect()->route('indexForUser');
    }

    public function Edit(Request $request, Review $review)
    {
        if ($review->client_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'stars'  => 'required|numeric|min:1|max:5', // FIX: range validation
            'review' => 'required|string|max:1000',
        ]);

        $review->stars  = $request->stars;
        $review->review = $request->review;
        $review->save();

        return redirect()->route('indexForUser');
    }
}
