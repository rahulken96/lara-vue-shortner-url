<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'links' => $request->user()->links()->latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $shortCode = Str::random(6);
        while (Link::where('short_code', $shortCode)->exists()) {
            $shortCode = Str::random(6);
        }

        $request->user()->links()->create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
        ]);

        return back()->with('success', 'Link shortened successfully!');
    }

    /**
     * Redirect to the original URL.
     */
    public function redirect(string $code): RedirectResponse
    {
        $link = Link::where('short_code', $code)->firstOrFail();
        
        $link->increment('visits');

        return redirect()->away($link->original_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link): RedirectResponse
    {
        if (auth()->id() !== $link->user_id) {
            abort(403);
        }

        $link->delete();

        return back()->with('success', 'Link deleted successfully!');
    }
}
