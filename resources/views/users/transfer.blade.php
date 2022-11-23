<div class="modal fade" tabindex="-1" id="transfer_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Transfer this user to another company</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
            </div>

            <div class="modal-body">
                {{ Form::select('company_id', $companies, null, [
                    'class' => 'form-select form-select-solid' . ($errors->has('company_id') ? ' is-invalid' : null),
                    'placeholder' => 'Select Role',
                    'data-control' => 'select2',
                    'required' => 'required',
                ]) }}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
