<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreViewHistoryRequest;
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
    public function store(StoreViewHistoryRequest $request)
    {
        $this->authorize('create', ViewHistory::class);

        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        $viewHistory = ViewHistory::create($data);

        return new ViewHistoryResource($viewHistory);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $viewHistory = ViewHistory::with('user')->findOrFail($id);
        $this->authorize('view', $viewHistory);

        return new ViewHistoryResource($viewHistory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreViewHistoryRequest $request, string $id)
    {
        $viewHistory = ViewHistory::findOrFail($id);
        $this->authorize('update', $viewHistory);

        $data = $request->validated();

        $viewHistory->update($data);

        return new ViewHistoryResource($viewHistory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $viewHistory = ViewHistory::findOrFail($id);

        $this->authorize('delete', $viewHistory);

        $viewHistory->delete();

        return response()->noContent();
    }
}
