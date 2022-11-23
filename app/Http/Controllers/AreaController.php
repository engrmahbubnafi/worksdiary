<?php

namespace App\Http\Controllers;

use App\Http\Requests\Area\StoreAreaRequest;
use App\Http\Requests\Area\UpdateAreaRequest;
use App\Models\Area;
use App\Models\Company;
use App\Models\Zone;
use App\Transformers\AreaTransformer;
use Illuminate\Support\Collection;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class AreaController extends Controller
{
    public function index(Builder $builder, Company $company, Zone $zone)
    {

        $result = $this->checkValidity($company->id);

        if ($result) {
            return $result;
        }

        // Get areas if ajax request
        $areas = Area::join('zones', 'zones.id', '=', 'areas.zone_id')
            ->select('areas.*', 'zones.name as zone_name')
            ->where('zone_id', $zone->id)
            ->get();

        if (request()->ajax()) {
            return DataTables::of($areas)
                ->setTransformer(new AreaTransformer($company->id))
                ->toJson();
        }

        // Build columns
        $html = $builder
            ->columns([
                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('zone')
                    ->title('Zone')
                    ->addClass('text-center'),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center'),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center'),
            ])
            ->parameters([
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                }',
            ]);

        return view('areas.index', compact('html', 'company', 'zone'));
    }

    public function create(Company $company, Zone $zone)
    {

        $result = $this->checkValidity($company->id);

        if ($result) {
            return $result;
        }

        return view('areas.create', compact('company', 'zone'));
    }

    public function store(StoreAreaRequest $request, Company $company, Zone $zone)
    {
        try {
            $validated = $request->validated();
            $validated['zone_id'] = $zone->id;

            // Store validated data
            Area::create($validated);

            return redirect()
                ->route('companies.zones.areas.index', [$company->id, $zone->id])
                ->with('flash_success', "Area created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing area!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function edit(Company $company, Zone $zone, Area $area)
    {
        $result = $this->checkValidity($company->id);

        if ($result) {
            return $result;
        }
        return view('areas.edit', compact('company', 'zone', 'area'));
    }

    public function update(UpdateAreaRequest $request, Company $company, Zone $zone, Area $area)
    {
        try {
            $validated = $request->validated();
            $validated['zone_id'] = $zone->id;

            // Update validated data
            $area->update($validated);

            return redirect()->route('companies.zones.areas.index', [$company->id, $zone->id])
                ->with('flash_success', "Area updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating Area!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function destroy(Company $company, Zone $zone, Area $area)
    {
        try {
            // Delete this area
            $area->delete();

            return redirect()->route('companies.zones.areas.index', [$company->id, $zone->id])
                ->with('flash_success', "Area deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting Area!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Ajax: get areas list by zone id
     *
     * @param int $zoneId
     * @return \Illuminate\Support\Collection
     */
    public function getAreasByZone($zoneId): Collection
    {
        $areas = Area::getAreasByZone($zoneId);
        return $areas->pluck('name', 'id');
    }
}
