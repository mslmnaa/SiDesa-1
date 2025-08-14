<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Content\LandingContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingContentController extends Controller
{
    public function index(Request $request)
    {
        $query = LandingContent::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('section', 'like', '%' . $request->search . '%');
        }
        
        // Section filter
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $contents = $query->orderBy('section')->orderBy('order')->paginate(10);
        
        // Get available sections
        $sections = LandingContent::distinct()->pluck('section')->sort();
        
        return view('admin.content.index', compact('contents', 'sections'));
    }
    
    public function create()
    {
        return view('admin.content.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'data' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);
        
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('landing-content', 'public');
        }
        
        LandingContent::create([
            'section' => $request->section,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image' => $image,
            'data' => $request->data,
            'order' => $request->order ?? 0,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.content.index')
                        ->with('success', 'Konten landing page berhasil ditambahkan.');
    }
    
    public function show(LandingContent $landingContent)
    {
        return view('admin.content.show', compact('landingContent'));
    }
    
    public function edit(LandingContent $landingContent)
    {
        return view('admin.content.edit', compact('landingContent'));
    }
    
    public function update(Request $request, LandingContent $landingContent)
    {
        $request->validate([
            'section' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'data' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);
        
        $image = $landingContent->image;
        
        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($image) {
                Storage::disk('public')->delete($image);
            }
            $image = $request->file('image')->store('landing-content', 'public');
        }
        
        // Handle image removal
        if ($request->filled('remove_image') && $image) {
            Storage::disk('public')->delete($image);
            $image = null;
        }
        
        $landingContent->update([
            'section' => $request->section,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image' => $image,
            'data' => $request->data,
            'order' => $request->order ?? 0,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.content.index')
                        ->with('success', 'Konten landing page berhasil diperbarui.');
    }
    
    public function destroy(LandingContent $landingContent)
    {
        // Delete associated image
        if ($landingContent->image) {
            Storage::disk('public')->delete($landingContent->image);
        }
        
        $landingContent->delete();
        
        return redirect()->route('admin.content.index')
                        ->with('success', 'Konten landing page berhasil dihapus.');
    }
    
    public function toggleStatus(Request $request, LandingContent $landingContent)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        
        $landingContent->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Status konten berhasil diperbarui.',
            'status' => $landingContent->status
        ]);
    }
}
