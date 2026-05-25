<?php

namespace App\Http\Controllers;

use App\Http\Resources\ViewHistoryResource;
use App\Models\ViewHistory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ViewHistoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', ViewHistory::class);

        $viewHistories = ViewHistory::with('user')->latest()->paginate(10);

        return ViewHistoryResource::collection($viewHistories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ViewHistory::class);

        $viewHistory = ViewHistory::create($request->validated());

        return new ViewHistoryResource($viewHistory);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view', ViewHistory::class);

        $viewHistory = ViewHistory::with('user')->findOrFail($id);

        return new ViewHistoryResource($viewHistory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', ViewHistory::class);

        $viewHistory = ViewHistory::findOrFail($id);
        $viewHistory->update($request->validated());

        return new ViewHistoryResource($viewHistory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', ViewHistory::class);

        $viewHistory = ViewHistory::findOrFail($id);
        $viewHistory->delete();

        return response()->noContent();
    }
}
