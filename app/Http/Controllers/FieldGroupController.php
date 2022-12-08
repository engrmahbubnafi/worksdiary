<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Http\Requests\FieldGroup\UpdateFieldGroupRequest;
use App\Models\FieldGroup;
use App\Models\Form;
use App\Transformers\FieldGroupTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class FieldGroupController extends Controller
{
    /**
     * Get field groups according to selected form.
     *
     * @param int $formId
     */
    private function getFieldGroups(int $formId)
    {
        $fieldGroups = FieldGroup::where('form_id', $formId)
            ->get();

        return DataTables::of($fieldGroups)
            ->setTransformer(new FieldGroupTransformer)
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Yajra\DataTables\Html\Builder $builder
     * @param \App\Models\Form $form
     */
    public function index(Builder $builder, Form $form)
    {
        // Get field group if it's an ajax request
        if (request()->ajax()) {
            return $this->getFieldGroups($form->id);
        }

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center')
                    ->searchable(true),

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
                }',
            ]);

        return view('field-groups.index', compact('html', 'form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($formId)
    {
        // Pass forms' names to dropdown menu.
        $forms = Form::where('status', Status::Active)->pluck('name', 'id');

        return view('field-groups.create', compact('forms', 'formId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\FieldGroup\StoreFieldGroupRequest $request
     * @param int $formId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $formId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'groups')
                ->withInput();
        }

        $validated = $validator->validated();

        // Set form ID into validated data
        $validated['form_id'] = $formId;

        //$validated = $validator->safe()->except(['is_dealer']);

        try {
            // Save validated data
            FieldGroup::create($validated);

            return back()->with('flash_success', 'Field group stored successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with storing data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form, FieldGroup $fieldGroup)
    {
        $fieldGroup = FieldGroup::join('forms', 'forms.id', 'field_groups.form_id')
            ->select(
                'field_groups.*',
                'forms.name as form_name',
            )
            ->where('field_groups.id', $fieldGroup->id)
            ->where('field_groups.form_id', $form->id)
            ->first();

        // dd($fieldGroup);

        return view('field-groups.edit', compact('fieldGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\FieldGroup\UpdateFieldGroupRequest $request
     * @param FieldGroup $fieldGroup
     * @param int $formId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateFieldGroupRequest $request, Form $form, FieldGroup $fieldGroup)
    {
        $validated = $request->validated();

        $fieldGroup = FieldGroup::where('id', $fieldGroup->id)
            ->where('form_id', $form->id)
            ->first();

        try {
            // Update this data
            $fieldGroup->update($validated);

            return redirect()->route('forms.field-groups.index', [$form->id])
                ->with('flash_success', 'Field group updated successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with storing data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FieldGroup $fieldGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(FieldGroup $fieldGroup)
    {
        try {
            //  Delete this field group
            $fieldGroup->delete();

            return redirect()->route('field-groups.index')
                ->with('flash_success', 'Field group deleted successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }
}
