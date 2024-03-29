<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Captain;
use App\Models\Vehicle;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\Category;
use App\Models\Location;
use Illuminate\View\View;
use App\Models\SenderData;
use Illuminate\Http\Request;
use App\Models\ReceiverData;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Requests\ShipmentUpdateRequest;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Shipment::class);

        $search = $request->get('search', '');

        $shipments = Shipment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.shipments.index', compact('shipments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Shipment::class);

        $captains = Captain::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $vehicles = Vehicle::pluck('name', 'id');
        $addresses = Address::pluck('address', 'id');
        $allReceiverData = ReceiverData::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        $allSenderData = SenderData::pluck('name', 'id');

        return view(
            'app.shipments.create',
            compact(
                'captains',
                'users',
                'categories',
                'vehicles',
                'addresses',
                'allReceiverData',
                'locations',
                'allSenderData'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Shipment::class);

        $validated = $request->validated();

        $shipment = Shipment::create($validated);

        return redirect()
            ->route('shipments.edit', $shipment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Shipment $shipment): View
    {
        $this->authorize('view', $shipment);

        return view('app.shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Shipment $shipment): View
    {
        $this->authorize('update', $shipment);

        $captains = Captain::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $vehicles = Vehicle::pluck('name', 'id');
        $addresses = Address::pluck('address', 'id');
        $allReceiverData = ReceiverData::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        $allSenderData = SenderData::pluck('name', 'id');

        return view(
            'app.shipments.edit',
            compact(
                'shipment',
                'captains',
                'users',
                'categories',
                'vehicles',
                'addresses',
                'allReceiverData',
                'locations',
                'allSenderData'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShipmentUpdateRequest $request,
        Shipment $shipment
    ): RedirectResponse {
        $this->authorize('update', $shipment);

        $validated = $request->validated();

        $shipment->update($validated);

        return redirect()
            ->route('shipments.edit', $shipment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Shipment $shipment
    ): RedirectResponse {
        $this->authorize('delete', $shipment);

        $shipment->delete();

        return redirect()
            ->route('shipments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
