<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\StoreFormRequest;
use App\Http\Requests\Form\UpdateFormRequest;
use App\Models\Company;
use App\Models\Field;
use App\Models\Form;
use App\Transformers\FormTransformer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, int $companyId = null)
    {
        // Set user's company ID if $companyId is null.
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Get all form data if it's an ajax request
        if (request()->ajax()) {
            return DataTables::of(Form::formList(auth()->user()->id, $companyId))
                ->setTransformer(new FormTransformer)
                ->toJson();
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName:'forms.index');

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('unit_type')
                    ->title('Unit Type')
                    ->addClass('text-center'),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center')
                    ->searchable(false),

                /**
             * Nafi: The plan is to make a switch for Skippable column. Currently, the work is incomplete, so, commenting for now.
             */
                // Column::make('is_skippable')
                //     ->title('Skippable')
                //     ->addClass('text-center'),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center')
                    ->orderable(false)
                    ->searchable(false),
            ])
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                    KTMenu.createInstances();
                    handleSearchDatatable();
                }',
            ]);

        return view('forms.index', compact('html', 'lists', 'companyId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function create(int $companyId = null)
    {
        // Set user's company ID if $companyId is null.
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName:'forms.create');

        $currentCompany = $lists->where('id', $companyId)->first();

        // Get unit types by user's department.
        $unitTypes = app('authUnitTypesAll');

        return view('forms.create', compact('companyId', 'currentCompany', 'lists', 'unitTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Form\StoreFormRequest $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request, Company $company)
    {
        try {
            // Store validated data into variable.
            $data = $request->validated();

            // Set this company ID.
            $data['company_id'] = $company->id;

            // Save validated data
            Form::create($data);

            return redirect()->route('forms.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', 'Form stored successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param \App\Models\Company $company
     * @param \App\Models\Form $form
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Form $form)
    {
        $fields = Field::leftJoin('field_groups', 'field_groups.id', '=', 'fields.field_group_id')
            ->where('fields.form_id', $form->id)
            ->select(
                'fields.id',
                'fields.name',
                'field_groups.name as group_name'
            )
            ->orderBy('fields.sequence')
            ->get()
            ->groupBy('group_name');

        return view('forms.show', compact('form', 'fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $companyId
     * @param  Form $form
     * @return \Illuminate\Http\Response
     */
    public function edit(int $companyId, Form $form)
    {
        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Get only the companies the user has access to.
        $companiesObj = app('authCompanies');

        // Get selected company's ID.
        $currentCompany = $companiesObj->get($companyId);

        // Get unit types by user's department.
        $unitTypes = app('authUnitTypesAll');

        return view('forms.edit', compact('form', 'companyId', 'currentCompany', 'unitTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Form\UpdateFormRequest  $request
     * @param \App\Models\Company $company
     * @param  Form $form
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, Company $company, Form $form)
    {
        try {
            // Make 'Is Skippable' false if there is no input for is_skippable in $request
            if (!request()->has("is_skippable")) {
                $form->is_skippable = false;
            }

            $data = $request->validated();

            $data['company_id'] = $company->id;

            // Update validated data
            $form->update($data);

            return redirect()->route('forms.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', 'Form updated successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with updating data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @param  Form $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Form $form)
    {
        // Get data used message if this form's field is used
        $message = $this->checkIfUsed(
            $form->id,
            'field_id',
            'VisitFormDetail',
            "Information of this form is used. Do you still want to delete it?"
        );

        // If there is any message, show it and return back
        if ($message) {
            return $message;
        }

        // Otherwise, try to delete the form
        try {
            // Delete this form
            $form->delete();

            return redirect()->route('forms.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', 'Form deleted successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with deleting form!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    public function formClone(Form $form)
    {
        $forms = $form->load('fields.group');

        dd($forms);
    }
}
