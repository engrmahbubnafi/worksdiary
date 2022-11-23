<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\AllPrivateMethodsForFieldController;
use App\Http\Requests\Field\StoreFieldRequest;
use App\Http\Requests\Field\UpdateFieldRequest;
use App\Models\Field;
use App\Models\Form;
use Illuminate\Support\Facades\App;
use Throwable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class FieldController extends Controller
{
    use AllPrivateMethodsForFieldController;
    /**
     * Display a listing of the resource.
     *
     * @param \Yajra\DataTables\Html\Builder $builder
     * @param App\Models\Form $form
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Form $form)
    {
        // Get field data if it's an ajax request
        if (request()->ajax()) {
            return $this->getFieldData($form->id);
        }

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->title('ID')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('field_group_name')
                    ->title('Field Group')
                    ->addClass('text-center'),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('length')
                    ->title('Length')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('reference_value')
                    ->title('Reference Value')
                    ->addClass('text-center'),

                Column::make('compare_value')
                    ->title('Compare Value')
                    ->addClass('text-center'),

                Column::make('is_required')
                    ->title('Required')
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

        // Get company ID.
        (int) $companyId = $form->company_id;

        // Get form ID to pass to view
        (int) $formId = $form->id;

        // Get form name to show in listing headline
        (object) $formName = Form::where('id', $form->id)->pluck('name')->first();

        return view('fields.index', compact('html', 'companyId', 'formId', 'formName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($formId)
    {
        // Get $forms, $fieldGroup & $fieldType from data function
        $data = $this->data($formId);

        // Insert current form ID into $data
        $data['formId'] = $formId;

        // Get form name for showing in form headline
        $data['formName'] = Form::where('id', $formId)->pluck('name')->first();

        // Get reference values according to form ID
        $data['referenceValues'] = $this->getReferenceValues($formId);

        // Get company ID & unit type ID according to form ID
        $formObject = Form::where('id', $formId)
            ->select('id', 'company_id', 'unit_type_id')
            ->first();

        $data['companyId'] = $formObject->company_id;

        // Get compare values according to form company ID & unit type ID
        $data['compareValues'] = $this->getCompareValues($formObject->company_id, $formObject->unit_type_id);

        return view('fields.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Field\StoreFieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFieldRequest $request, $formId)
    {
        try {
            // Keep validated data in $data
            $data = $request->validated();

            // Process if "is_formula" checkbox is checked
            if (request()->has("is_formula") && isset($data['formula'])) {
                $data['reference_value'] = json_encode($data['formula']);
                unset($data['formula']);
            }

            // Set form ID into $data
            $data['form_id'] = $formId;

            // Store $data into database
            Field::create($data);

            return redirect()->route('forms.fields.index', $formId)
                ->with('flash_success', 'Field stored successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $formId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($formId, $id)
    {
        // Get this field
        $field = Field::findOrFail($id);

        // Get $forms, $fieldGroup & $fieldType from data function
        $data = $this->data($formId);

        // Set $field into $data
        $data['field'] = $field;

        // Set current form ID into $data
        $data['formId'] = $formId;

        // Get form name for showing in form headline
        $data['formName'] = Form::where('id', $formId)->pluck('name')->first();

        // Get reference values according to form and field ID
        $data['referenceValues'] = $this->getReferenceValues($formId, $id);

        // Get company ID & unit type ID according to form ID
        $formObject = Form::where('id', $formId)
            ->select('id', 'company_id', 'unit_type_id')
            ->first();

        // Get compare values according to form company ID & unit type ID
        $data['compareValues'] = $this->getCompareValues($formObject->company_id, $formObject->unit_type_id);

        return view('fields.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldRequest $request, $formId, $id)
    {
        try {
            // Get this field
            $field = Field::findOrFail($id);

            // Keep validated data in $data
            $data = $request->validated();

            // Process if "is_required" checkbox is checked
            if (!request()->has("is_required")) {
                $data['is_required'] = false;
            }

            // Process if "is_reportable" checkbox is checked
            if (!request()->has("is_reportable")) {
                $data['is_reportable'] = false;
            }

            // Process if "is_formula" checkbox is checked
            if (request()->has("is_formula") && isset($data['formula'])) {
                $data['reference_value'] = json_encode($data['formula']);
                unset($data['formula']);
            } else {
                $data['is_formula'] = false;
            }

            // Update validated data into database
            $field->update($data);

            return redirect()->route('forms.fields.index', $formId)
                ->with('flash_success', 'Field updated successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($formId, $id)
    {
        try {
            // Get this field
            $field = Field::findOrFail($id);

            // Delete this field
            $field->delete();

            return redirect()->route('forms.fields.index', $formId)
                ->with('flash_success', 'Field deleted successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with deleting form!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }
}
