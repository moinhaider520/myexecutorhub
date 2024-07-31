<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'description' => 'required|string|max:255',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'document_id' => $request->document_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Review added successfully.');
    }

    public function show($id)
    {
        $reviews = Review::where('document_id', $id)->with('user')->get();
        return response()->json(['reviews' => $reviews]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
