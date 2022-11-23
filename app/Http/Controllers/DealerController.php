<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dealer\StoreDealerRequest;
use App\Http\Requests\Dealer\UpdateDealerRequest;
use App\Models\Dealer;
use App\Transformers\DealerTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class DealerController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::eloquent(Dealer::query())
                ->setTransformer(new DealerTransformer)
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('mobile')
                    ->title('Mobile')
                    ->addClass('text-center'),

                Column::make('address')
                    ->title('Address')
                    ->addClass('text-center'),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center'),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center'),
            ])
            ->parameters([
                'pageLength'   => 25,
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                }',
            ]);

        return view('dealers.index', compact('html'));
    }

    public function create()
    {
        $district = DB::table('districts')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Select One', '');
        return view('dealers.create', compact('district'));
    }

    public function store(StoreDealerRequest $request)
    {
        try {
            // Insert data into database.
            Dealer::create($request->validated());

            return redirect()
                ->route('dealers.index')
                ->with('flash_success', "Dealer created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'error'   => [$th->getMessage()],
            ]);
        }
    }

    public function edit($id)
    {
        $dealer   = Dealer::findOrFail($id);
        $district = DB::table('districts')->pluck('name', 'id')->prepend('Select One', '');
        $upazilas = DB::table('upazilas')->where('district_id', $dealer->district_id)->pluck('name', 'id')->prepend('Select One', '');
        return view('dealers.edit', compact('dealer', 'district', 'upazilas'));
    }

    public function update(UpdateDealerRequest $request, $id)
    {
        try {
            $dealer = Dealer::findOrFail($id);

            $dealer->save();

            return redirect()->route('dealers.index')
                ->with('flash_success', "Dealer updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error'   => [$th->getMessage()],
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $dealer = Dealer::findOrFail($id);

            $dealer->delete();

            return redirect()->route("dealers.index")
                ->with('flash_success', "Dealer deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error'   => [$th->getMessage()],
            ]);
        }
    }
}