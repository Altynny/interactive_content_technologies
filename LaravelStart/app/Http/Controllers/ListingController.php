<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\ServiceType;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Listing::query()->with(['user', 'serviceType', 'tags', 'images']);

        if ($request->filled('active')) {
            if ($request->boolean('active')) $query->active();
            else $query->where('is_active', false);
        }

        if ($request->filled('type')) {
            $query->byType($request->get('type'));
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceBetween($request->get('min_price'), $request->get('max_price'));
        }

        if ($request->filled('q')) {
            $query->search($request->get('q'));
        }

        $perPage = $request->get('per_page', 10);
        $listings = $query->paginate($perPage)->appends($request->query());

        if ($request->wantsJson()) {
            return ListingResource::collection($listings)
                ->additional(['meta' => ['total' => $listings->total()]]);
        }

        return view('listings.index', [
            'listings' => $listings,
            'serviceTypes' => ServiceType::all(),
            'filter' => $request->only(['active','type','min_price','max_price','q']),
        ]);
    }

    public function create()
    {
        $serviceTypes = ServiceType::all();
        $users = User::all();
        return view('listings.create', compact('serviceTypes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        $data = $request->validated();

        if (empty($data['tags']) && $request->filled('tags_input')) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $request->input('tags_input'))));
        }

        $listing = Listing::create([
            'user_id' => $data['user_id'],
            'service_type_id' => $data['service_type_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'currency' => $data['currency'] ?? 'RUB',
            'is_active' => $data['is_active'] ?? true,
        ]);
        
        if (!empty($data['tags']) && is_array($data['tags'])) {
            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $listing->tags()->sync($tagIds);
        }

        // handle uploaded files
        if ($request->hasFile('images_files')) {
            foreach ($request->file('images_files') as $file) {
                if (!$file->isValid()) continue;
                $stored = $file->store('listings', 'public');
                $listing->images()->create([
                    'path' => '/storage/' . $stored,
                    'alt' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                ]);
            }
        }

        $listing->load(['user','serviceType','tags','images']);

        if ($request->wantsJson()) {
            return (new ListingResource($listing))->response()->setStatusCode(201);
        }

        return redirect()->route('listings.show', $listing->id)
                         ->with('success', 'Объявление успешно создано.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $listing = Listing::with(['user','serviceType','tags','images'])->findOrFail($id);

        if ($request->wantsJson()) {
            return new ListingResource($listing);
        }

        return view('listings.show', compact('listing'));
    }

    public function edit($id)
    {
        $listing = Listing::with(['tags','images'])->findOrFail($id);
        $serviceTypes = ServiceType::all();
        $users = User::all();

        return view('listings.edit', compact('listing','serviceTypes','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, string $id)
    {
        $listing = Listing::findOrFail($id);
        $data = $request->validated();

        if (!isset($data['tags']) && $request->filled('tags_input')) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $request->input('tags_input'))));
        }

        $listing->update($data);

        if (isset($data['tags'])) {
            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $listing->tags()->sync($tagIds);
        }

        // delete selected existing images
        if (!empty($data['delete_images']) && is_array($data['delete_images'])) {
            $toDelete = $listing->images()->whereIn('id', $data['delete_images'])->get();
            foreach ($toDelete as $img) {
                // remove file
                $relative = preg_replace('#^/storage/#', '', $img->path);
                if ($relative) Storage::disk('public')->delete($relative);
                $img->delete();
            }
        }

        // handle uploaded new files
        if ($request->hasFile('images_files')) {
            foreach ($request->file('images_files') as $file) {
                if (!$file->isValid()) continue;
                $stored = $file->store('listings', 'public');
                $listing->images()->create([
                    'path' => '/storage/' . $stored,
                    'alt' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                ]);
            }
        }

        $listing->load(['user','serviceType','tags','images']);

        if ($request->wantsJson()) {
            return new ListingResource($listing);
        }

        return redirect()->route('listings.show', $listing->id)
                         ->with('success', 'Объявление обновлено.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Listing soft-deleted'], 200);
        }

        return redirect()->route('listings.index')->with('success', 'Объявление удалено.');
    }

    public function restore($id)
    {
        $listing = Listing::withTrashed()->findOrFail($id);
        $listing->restore();

        if ($request->wantsJson()) {
            return new ListingResource($listing);
        }

        return redirect()->route('listings.show', $listing->id)->with('success', 'Объявление восстановлено.');
    }
}
