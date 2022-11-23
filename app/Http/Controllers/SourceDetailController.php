<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceDetail\StoreSourceDetailRequest;
use App\Http\Requests\SourceDetail\UpdateSourceDetailRequest;
use App\Models\Source;
use App\Models\SourceDetail;
use App\Transformers\SourceDetailTransformer;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class SourceDetailController extends Controller
{
    public function index(Builder $builder, Source $source)
    {
        $sourceDetails = SourceDetail::join('sources', 'sources.id', '=', 'source_details.source_id')
            ->where('source_details.source_id', $source->id)
            ->select('source_details.*', 'sources.name')
            ->get();
        // Get Source Details if it is an ajax request
        if (request()->ajax()) {
            return DataTables::of($sourceDetails)
                ->setTransformer(new SourceDetailTransformer())
                ->toJson();
        }

        // Build columns
        $html = $builder
            ->columns([
                Column::make('source_id')
                    ->title('Source')
                    ->addClass('text-center'),

                Column::make('from')
                    ->title('From')
                    ->addClass('text-center'),

                Column::make('to')
                    ->title('To')
                    ->addClass('text-center'),

                Column::make('value')
                    ->title('Value')
                    ->addClass('text-center'),

                Column::make('is_default')
                    ->title('Default')
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
                'pageLength'   => 25,
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                    handleSearchDatatable();
                }',
            ]);

        return view('source-details.index', compact('html', 'source'));
    }

    public function create(Source $source)
    {
        return view('source-details.create', compact('source'));
    }

    public function store(StoreSourceDetailRequest $request, Source $source)
    {
        try {
            // Save validated data into variable
            $validated = $request->validated();

            // Set source ID into validated data
            $validated['source_id'] = $source->id;

            // Save data into database
            SourceDetail::create($validated);

            return redirect()
                ->route('sources.source-details.index', $source)
                ->with('flash_success', "Source detail created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'error'   => [$th->getMessage()],
            ]);
        }
    }

    public function edit(Source $source, SourceDetail $sourceDetail)
    {
        return view('source-details.edit', compact('sourceDetail', 'source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SourceDetail\UpdateSourceDetailRequest $request
     * @param \App\Models\SourceDetail $sourceDetail
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateSourceDetailRequest $request, $source_id, SourceDetail $sourceDetail)
    {
        try {

            // Update validated data into database
            $sourceDetail->update($request->validated());
            return redirect()->route('sources.source-details.index', [$source_id, $sourceDetail->id])
                ->with('flash_success', "Source detail updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error'   => [$th->getMessage()],
            ]);
        }
    }

    public function destroy(SourceDetail $sourceDetail)
    {
        try {
            // Delete this source detail
            $sourceDetail->delete();

            return redirect()->route('sources.source-details.index')
                ->with('flash_success', "Source detail deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error'   => [$th->getMessage()],
            ]);
        }
    }
}