<?php

namespace App\Http\Controllers;

use App\Http\Requests\Designation\StoreDesignationRequest;
use App\Http\Requests\Designation\UpdateDesignationRequest;
use App\Models\Designation;
use App\Transformers\DesignationTransformer;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class DesignationController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {

            return DataTables::eloquent(Designation::query())
                ->setTransformer(new DesignationTransformer)
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center'),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center')
                    ->orderable(false)
                    ->searchable(false),
            ])
            ->parameters([
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                    handleSearchDatatable();
                }',
            ]);

        return view('designations.index', compact('html'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(StoreDesignationRequest $request)
    {
        try {
            Designation::create($request->validated());

            return redirect()
                ->route('designations.index')
                ->with('flash_success', "Designation created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function edit($id)
    {
        $designation = Designation::findOrFail($id);

        return view('designations.edit', compact('designation'));
    }

    public function update(UpdateDesignationRequest $request, $id)
    {
        try {
            $designation = Designation::findOrFail($id);

            $designation->save();

            return redirect()->route('designations.index')
                ->with('flash_success', "Designation updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $designation = Designation::findOrFail($id);

            $designation->delete();

            return redirect()->route("designations.index")
                ->with('flash_success', "Designation deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }
}
