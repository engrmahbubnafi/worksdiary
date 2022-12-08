<x-app-layout>

    @slot('title')
        Roles List
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Roles List
            @slot('actions')
                {!! Html::decode(link_to_route('roles.create', '<i class="fa fa-plus"></i> New Role', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body py-4">
                <table class="table-row-dashed fs-6 gy-5 table align-middle" id="kt_table_users">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Role</th>
                            <th class="min-w-125px">Created</th>
                            <th class="min-w-125px">Updated</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($roles as $data)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-50px me-3 overflow-hidden">
                                        <a href="../../apps/user-management/users/view.html">
                                            <div class="symbol-label">
                                                <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith"
                                                    class="w-100" />
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="../../apps/user-management/users/view.html"
                                            class="text-hover-primary mb-1 text-gray-800">{{ $data->name }}</a>
                                        <span>{{ $data->description }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="badge badge-light fw-bolder">{{ $data->created_at }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light fw-bolder">{{ $data->updated_at }}</div>
                                </td>
                                <td>
                                    {{ Str::ucfirst($data->status) }}
                                </td>
                                <td class="text-end">
                                    @if ($data->is_editable || $data->is_deletable)
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>

                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            @if ($data->is_editable)
                                                <div class="menu-item px-3">
                                                    {!! Html::decode(link_to_route('roles.edit', 'Edit', [$data->id], ['class' => 'menu-link px-3'])) !!}
                                                </div>
                                                <div class="menu-item px-3">
                                                    {!! Html::decode(link_to_route('roles.clone', 'Clone', [$data->id], ['class' => 'menu-link px-3'])) !!}
                                                </div>
                                            @endif

                                            @if ($data->is_deletable)
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3" href="javascript:void(0)"
                                                        data-bs-toggle="modal" data-bs-target="#myModal"
                                                        onClick="callModal('{{ $data->id }}')">
                                                        Delete
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select another role to accomodate the users of this role.</h4>
                </div>

                {{ Form::open(['route' => ['roles.destroy', 'remove-id'], 'method' => 'DELETE', 'id' => 'del-form']) }}

                <div class="modal-body" id="myModalBody">
                    @if ($deletableRoles->count())
                        {{ Form::select('role_id', [], null, ['class' => 'form-control', 'id' => 'selectBox']) }}
                    @endif
                </div>

                <div class="modal-footer">
                    {{ Form::submit('Confirm Delete', ['class' => 'btn btn-primary']) }}
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

        <script>
            function callModal(selector) {
                let options = @json($deletableRoles);
                delete options[selector];

                let fromAction = document.getElementById("del-form").action;
                fromAction = fromAction.slice(0, fromAction.lastIndexOf('/'));
                fromAction = fromAction + '/' + selector;

                document.getElementById("del-form").action = fromAction;

                let dropdown = document.getElementById('selectBox');

                if (Object.keys(options).length > 0) {
                    dropdown.innerHTML = '';
                    Object.keys(options).forEach(function(key) {
                        option = document.createElement('option');
                        option.text = options[key];
                        option.value = key;
                        dropdown.add(option);
                    });
                } else {
                    document.getElementById('myModalBody').innerHTML = 'No role found for assigning!';
                }
            }
        </script>
    @endpush
</x-app-layout>
