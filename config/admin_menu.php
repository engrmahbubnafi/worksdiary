<?php

use App\Models\EmptyObj;

return collect([
    // Dashboard Menu
    (new EmptyObj)->setRawAttributes([
        'module' => null,
        'groups' => collect([
            (new EmptyObj)->setRawAttributes([
                'title' => 'Dashboard',
                'route_name' => 'dashboard',
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([])
            ]),
        ]),
    ]),

    // Visit Module
    (new EmptyObj)->setRawAttributes([
        'module' => "Visit Module",
        'groups' => collect([
            // Visit Objectives Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Visit Objectives',
                'route_name' => ['visit-objectives.index', 'visit-objectives.create', 'visit-objectives.edit'],
                'params' => [],
                'permission' => null,
                'icon' => 'svg/dashboard.svg',
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'visit-objectives.index',
                        'params' => [],
                        'permission' => 'VisitObjectiveController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'visit-objectives.create',
                        'params' => [],
                        'permission' => 'VisitObjectiveController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),

            // Visit Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Visits',
                'route_name' => ['visits.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'visits.index',
                        'params' => [],
                        'permission' => 'VisitController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'visits.create',
                        'params' => [],
                        'permission' => 'VisitController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),

            // Emergency Task Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Emergency Tasks',
                'route_name' => ['emergency.visits.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'emergency.visits.index',
                        'params' => [],
                        'permission' => 'EmergencyVisitController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'emergency.visits.create',
                        'params' => [],
                        'permission' => 'EmergencyVisitController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),
        ]),
    ]),

    // User Module
    (new EmptyObj)->setRawAttributes([
        'module' => "User Module",
        'groups' => collect([
            // User Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Users',
                'route_name' => ['users.edit', 'users.create', 'users.select_company'],
                'params' => [],
                'permission' => null,
                'icon' => 'svg/dashboard.svg',
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'users.index',
                        'params' => [],
                        'permission' => 'UserController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'users.create',
                        'params' => [],
                        'permission' => 'UserController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),

            // Role Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Roles',
                'route_name' => ['roles.edit'],
                'params' => [],
                'permission' => null,
                'icon' => '<i class="fa fa-user"></i>',
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'roles.index',
                        'params' => [],
                        'permission' => 'RoleController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'roles.create',
                        'params' => [],
                        'permission' => 'RoleController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),
        ]),
    ]),

    // Configuration Module
    (new EmptyObj)->setRawAttributes([
        'module' => "Configurations",
        'groups' => collect([
            // Company Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Companies',
                'route_name' => ['companies.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'companies.index',
                        'params' => [],
                        'permission' => 'CompanyController@index',
                        'icon' => null,
                        'children' => collect([])
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'companies.create',
                        'params' => [],
                        'permission' => 'CompanyController@create',
                        'icon' => null,
                        'children' => collect([])
                    ]),
                ]),
            ]),

            // Department Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Departments',
                'route_name' => ['departments.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'departments.index',
                        'params' => [],
                        'permission' => 'DepartmentController@index',
                        'icon' => null,
                        'children' => collect([])
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'departments.create',
                        'params' => [],
                        'permission' => 'DepartmentController@create',
                        'icon' => null,
                        'children' => collect([])
                    ]),
                ]),
            ]),

            // Designation Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Designations',
                'route_name' => ['designations.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'designations.index',
                        'params' => [],
                        'permission' => 'DesignationController@index',
                        'icon' => null,
                        'children' => collect([])
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'designations.create',
                        'params' => [],
                        'permission' => 'DesignationController@create',
                        'icon' => null,
                        'children' => collect([])
                    ]),
                ]),
            ]),

            // Unit Type Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Unit Type',
                'route_name' => ['unit-types.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'unit-types.index',
                        'params' => [],
                        'permission' => 'UnitTypeController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'unit-types.create',
                        'params' => [],
                        'permission' => 'UnitTypeController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),

            // Zone Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Zones',
                'route_name' => ['zones.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'zones.index',
                        'params' => [],
                        'permission' => 'ZoneController@index',
                        'icon' => null,
                        'children' => collect([])
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'zones.create',
                        'params' => [],
                        'permission' => 'ZoneController@create',
                        'icon' => null,
                        'children' => collect([])
                    ]),
                ]),
            ]),

            // Source Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Sources',
                'route_name' => ['sources.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'sources.index',
                        'params' => [],
                        'permission' => 'SourceController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'sources.create',
                        'params' => [],
                        'permission' => 'SourceController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),

            // Unit Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Units',
                'route_name' => ['units.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'units.index',
                        'params' => [],
                        'permission' => 'UnitController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'units.create',
                        'params' => [],
                        'permission' => 'UnitController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),

            // Form Menu
            (new EmptyObj)->setRawAttributes([
                'title' => 'Forms',
                'route_name' => ['forms.edit'],
                'params' => [],
                'permission' => null,
                'icon' => null,
                'children' => collect([
                    (new EmptyObj)->setRawAttributes([
                        'title' => 'List',
                        'route_name' => 'forms.index',
                        'params' => [],
                        'permission' => 'FormController@index',
                        'icon' => null,
                        'children' => collect([]),
                    ]),

                    (new EmptyObj)->setRawAttributes([
                        'title' => 'Create',
                        'route_name' => 'forms.create',
                        'params' => [],
                        'permission' => 'FormController@create',
                        'icon' => null,
                        'children' => collect([]),
                    ]),
                ]),
            ]),
        ]),
    ]),
]);
