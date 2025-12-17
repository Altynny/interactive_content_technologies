<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceType;
use Illuminate\Validation\Rule;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = ServiceType::all();

        if ($request->wantsJson()) {
            return response()->json($types);
        }

        return view('service_types.index', compact('types'));
    }

    public function create()
    {
        return view('service_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:service_types,slug',
            'description' => 'nullable|string',
        ]);

        $type = ServiceType::create($data);

        if ($request->wantsJson()) {
            return response()->json($type, 201);
        }

        return redirect()->route('service-types.index')->with('success', 'Тип услуги создан.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ServiceType $service_type)
    {
        $type = $service_type->load('listings');

        if ($request->wantsJson()) {
            return response()->json($type);
        }

        return view('service_types.show', ['type' => $type]);
    }

    public function edit(ServiceType $service_type)
    {
        $type = $service_type;
        return view('service_types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceType $service_type)
    {
        $type = $service_type;

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => [
                'sometimes', 'string', 'max:255',
                Rule::unique('service_types', 'slug')->ignore($type->id),
            ],
            'description' => 'nullable|string',
        ]);

        $type->update($data);

        if ($request->wantsJson()) {
            return response()->json($type);
        }

        return redirect()->route('service-types.index')->with('success', 'Тип услуги обновлён.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ServiceType $service_type)
    {
        $type = $service_type;
        $type->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'deleted']);
        }

        return redirect()->route('service-types.index')->with('success', 'Тип услуги удалён.');
    }
}
