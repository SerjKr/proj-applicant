<?php

namespace App\Http\Controllers;

use App\Filters\RequestFilter;
use App\Http\Requests\EquipmentType\StoreRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\EquipmentType\ShortResource;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(ListRequest $request, RequestFilter $requestFilter): AnonymousResourceCollection
    {
        if ($requestFilter->isEmpty()) {
            return ShortResource::collection(EquipmentType::paginate(10));
        }

        return ShortResource::collection(EquipmentType::filter($requestFilter)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param EquipmentType $equipmentType
     * @return ShortResource
     */
    public function show(EquipmentType $equipmentType): ShortResource
    {
        return new ShortResource($equipmentType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
