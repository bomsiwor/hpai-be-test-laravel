<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(protected Role $model)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->model->select(['id','name'])->get();

        return $this->successResponse("Get all roles", $result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $result = $this->model->create($request->validated());

        return $this->successResponse(data: new RoleResource($result), code:201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
