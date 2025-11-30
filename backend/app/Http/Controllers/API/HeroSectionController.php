<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index(): JsonResponse
    {
        $heroSections = HeroSection::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        return response()->json($heroSections);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $heroSection = HeroSection::create($validated);
        
        return response()->json($heroSection, 201);
    }

    public function show(HeroSection $heroSection): JsonResponse
    {
        return response()->json($heroSection);
    }

    public function update(Request $request, HeroSection $heroSection): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $heroSection->update($validated);
        
        return response()->json($heroSection);
    }

    public function destroy(HeroSection $heroSection): JsonResponse
    {
        $heroSection->delete();
        
        return response()->json(['message' => 'Hero section eliminada exitosamente']);
    }
}
