<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortfolioItemController extends Controller
{
    public function index(): JsonResponse
    {
        $portfolioItems = PortfolioItem::orderBy('order')
            ->orderBy('featured', 'desc')
            ->get();
            
        return response()->json($portfolioItems);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'client' => 'nullable|string|max:255',
            'image' => 'required|string',
            'link' => 'nullable|string|max:255',
            'completed_date' => 'nullable|date',
            'featured' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $portfolioItem = PortfolioItem::create($validated);
        
        return response()->json($portfolioItem, 201);
    }

    public function show(PortfolioItem $portfolioItem): JsonResponse
    {
        return response()->json($portfolioItem);
    }

    public function update(Request $request, PortfolioItem $portfolioItem): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'client' => 'nullable|string|max:255',
            'image' => 'required|string',
            'link' => 'nullable|string|max:255',
            'completed_date' => 'nullable|date',
            'featured' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $portfolioItem->update($validated);
        
        return response()->json($portfolioItem);
    }

    public function destroy(PortfolioItem $portfolioItem): JsonResponse
    {
        $portfolioItem->delete();
        
        return response()->json(['message' => 'Proyecto eliminado exitosamente']);
    }
}
