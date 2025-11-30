<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    /**
     * Get the about section (singleton)
     */
    public function show(): JsonResponse
    {
        $about = AboutSection::getInstance();
        return response()->json($about);
    }

    /**
     * Update the about section
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_image' => 'nullable|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'highlighted_text' => 'required|string',
            'years_experience' => 'required|integer|min:0',
            'happy_clients' => 'required|integer|min:0',
        ]);

        $about = AboutSection::getInstance();
        $about->update($validated);

        return response()->json($about);
    }
}
