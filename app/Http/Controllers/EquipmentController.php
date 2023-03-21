<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\StoreEquipment;
use App\Http\Requests\Equipment\UpdateRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\Equipment\EquipmentResource;
use App\Http\Resources\ResponseResource;
use App\Models\Equipment;
use App\UseCases\EquipmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EquipmentController extends Controller
{
    private EquipmentService $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ListRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(ListRequest $request): AnonymousResourceCollection
    {
        return Equipment::filter($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEquipment $request
     * @return ResponseResource
     */
    public function store(StoreEquipment $request): ResponseResource
    {
        [$success, $errors] = $this->service->getData($request);

        return $this->service->doAnswer($success, $errors);
    }

    /**
     * Display the specified resource.
     *
     * @param Equipment $equipment
     * @return EquipmentResource
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return new EquipmentResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Equipment $equipment
     * @return EquipmentResource
     */
    public function update(UpdateRequest $request, Equipment $equipment): EquipmentResource
    {
        $equipment->fill($request->all());
        $equipment->save();

        return new EquipmentResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return Response
     */
    public function destroy(Equipment $equipment): Response
    {
        $equipment->delete();

        return response(null, 204);
    }
}
