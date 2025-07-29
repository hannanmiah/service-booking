<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $query = Service::query();

        $query->when(request('search'), function ($query, $search) {
            $query->whereAny(['name', 'description'], 'like', '%' . $search . '%');
        });

        $query->when(request('active'), function ($query) {
            $query->where('status', true);
        });

        $query->when(request('inactive'), function ($query) {
            $query->where('status', false);
        });

        $query->when(request('featured'), function ($query) {
            $query->where('is_featured', true);
        });

        $query->when(request('notFeatured'), function ($query) {
            $query->where('is_featured', false);
        });

        // paginate results
        $services = $query->with('bookings')->latest()->paginate(10);
        // return response
        return ServiceResource::collection($services);
    }

    public function show(Service $service)
    {
        // load relations
        $service->load('bookings');
        // return response
        return ServiceResource::make($service);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // create service
        $service = Service::create($validator->validated());
        // return response
        return response()->json($service, 201);
    }

    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // update service
        $service->update($validator->validated());
        // return response
        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        // delete service
        $service->delete();
        // return response
        return response()->noContent();
    }
}