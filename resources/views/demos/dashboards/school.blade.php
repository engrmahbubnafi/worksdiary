<x-app-layout>
    <x-slot name="subheader">
        <x-subheader-comp>
            School Dashboard
            <!--begin::Separator-->
            <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
            <!--end::Separator-->
            <!--begin::Description-->
            <span class="text-muted fs-7 fw-bold mt-2"></span>
            <!--end::Description-->
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-xl-8">
                <!--begin::Tables widget 8-->
                <div class="card h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header position-relative py-0 border-bottom-2">
                        <!--begin::Nav-->
                        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3">
                            <!--begin::Nav item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Nav link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="tab"
                                    href="#kt_table_widget_7_tab_content_1">
                                    <!--begin::Title-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Monday</span>
                                    <!--end::Title-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Nav link-->
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Nav link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="tab"
                                    href="#kt_table_widget_7_tab_content_2">
                                    <!--begin::Title-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Tuesday</span>
                                    <!--end::Title-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Nav link-->
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Nav link-->
                                <a class="nav-link btn btn-color-muted px-0 show active" data-bs-toggle="tab"
                                    href="#kt_table_widget_7_tab_content_3">
                                    <!--begin::Title-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Wednesday</span>
                                    <!--end::Title-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Nav link-->
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Nav link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="tab"
                                    href="#kt_table_widget_7_tab_content_4">
                                    <!--begin::Title-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Thursday</span>
                                    <!--end::Title-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Nav link-->
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Nav link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="tab"
                                    href="#kt_table_widget_7_tab_content_5">
                                    <!--begin::Title-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Friday</span>
                                    <!--end::Title-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Nav link-->
                            </li>
                            <!--end::Nav item-->
                        </ul>
                        <!--end::Nav-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                class="btn btn-sm btn-light d-flex align-items-center px-4">
                                <!--begin::Display range-->
                                <div class="text-gray-600 fw-bolder">Loading date range...</div>
                                <!--end::Display range-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-1 ms-2 me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                            fill="currentColor" />
                                        <path
                                            d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                            fill="currentColor" />
                                        <path
                                            d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Tab Content (ishlamayabdi)-->
                        <div class="tab-content mb-2">
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_table_widget_7_tab_content_1">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-150px p-0"></th>
                                                <th class="min-w-200px p-0"></th>
                                                <th class="min-w-100px p-0"></th>
                                                <th class="min-w-80px p-0"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">11:43-09:43am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 1:
                                                    <span class="text-gray-800">French class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">5</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 205min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">09:40-11:20am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 2:
                                                    <span class="text-gray-800">Physics class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">13</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 25min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">10:35-43:09am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 3:
                                                    <span class="text-gray-800">Chemistry class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Court:
                                                    <span class="text-gray-800">Main</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 15min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">15:30-12:23pm</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 4:
                                                    <span class="text-gray-800">Biology class</span>
                                                    <!--begin::Icon-->
                                                    <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Held by Dr. Ana">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                        <span class="svg-icon svg-icon-1 svg-icon-warning">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.3" x="2" y="2"
                                                                    width="20" height="20" rx="10"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="14" width="7"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 14)"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="17" width="2"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 17)"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <!--end::Icon-->
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">23</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_table_widget_7_tab_content_2">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-150px p-0"></th>
                                                <th class="min-w-200px p-0"></th>
                                                <th class="min-w-100px p-0"></th>
                                                <th class="min-w-80px p-0"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">09:15-12:23am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 1:
                                                    <span class="text-gray-800">Geography class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">45</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 20min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">08:30-09:30am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 2:
                                                    <span class="text-gray-800">English class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">9</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 20min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">11:15-12:13am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 3:
                                                    <span class="text-gray-800">Sports class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Court:
                                                    <span class="text-gray-800">Main</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 25min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">14:10-15:35pm</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 4:
                                                    <span class="text-gray-800">Picture class</span>
                                                    <!--begin::Icon-->
                                                    <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Held by Dr. Lebron">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                        <span class="svg-icon svg-icon-1 svg-icon-warning">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.3" x="2" y="2"
                                                                    width="20" height="20" rx="10"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="14" width="7"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 14)"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="17" width="2"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 17)"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <!--end::Icon-->
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">12</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_content_3">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-150px p-0"></th>
                                                <th class="min-w-200px p-0"></th>
                                                <th class="min-w-100px p-0"></th>
                                                <th class="min-w-80px p-0"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">08:30-09:12am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 1:
                                                    <span class="text-gray-800">Math class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">45</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 15min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">09:30-10:50am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 2:
                                                    <span class="text-gray-800">History class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">12</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 20min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">10:35-11:20am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 3:
                                                    <span class="text-gray-800">Sports class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Court:
                                                    <span class="text-gray-800">Main</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 15min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">12:40-13:25pm</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 4:
                                                    <span class="text-gray-800">Chemistry class</span>
                                                    <!--begin::Icon-->
                                                    <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Held by Dr. Natali">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                        <span class="svg-icon svg-icon-1 svg-icon-warning">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.3" x="2" y="2"
                                                                    width="20" height="20" rx="10"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="14" width="7"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 14)"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="17" width="2"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 17)"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <!--end::Icon-->
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">19</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_table_widget_7_tab_content_4">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-150px p-0"></th>
                                                <th class="min-w-200px p-0"></th>
                                                <th class="min-w-100px p-0"></th>
                                                <th class="min-w-80px p-0"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">11:25-14:13am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 1:
                                                    <span class="text-gray-800">Geography class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">15</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 25min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">08:30-09:30am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 2:
                                                    <span class="text-gray-800">English class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">9</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 20min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">11:15-12:13am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 3:
                                                    <span class="text-gray-800">Sports class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Court:
                                                    <span class="text-gray-800">Main</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 25min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">14:10-15:35pm</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 4:
                                                    <span class="text-gray-800">Picture class</span>
                                                    <!--begin::Icon-->
                                                    <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Held by Dr. Kevin">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                        <span class="svg-icon svg-icon-1 svg-icon-warning">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.3" x="2" y="2"
                                                                    width="20" height="20" rx="10"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="14" width="7"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 14)"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="17" width="2"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 17)"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <!--end::Icon-->
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">12</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_table_widget_7_tab_content_5">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="min-w-150px p-0"></th>
                                                <th class="min-w-200px p-0"></th>
                                                <th class="min-w-100px p-0"></th>
                                                <th class="min-w-80px p-0"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">11:43-09:43am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 1:
                                                    <span class="text-gray-800">French class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">5</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 205min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">09:40-11:20am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 2:
                                                    <span class="text-gray-800">Physics class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">13</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 25min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">10:35-43:09am</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 3:
                                                    <span class="text-gray-800">Chemistry class</span>
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Court:
                                                    <span class="text-gray-800">Main</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-light rounded text-gray-600 fs-8 fw-bolder px-3 py-2"
                                                    colspan="4">Break 15min</td>
                                            </tr>
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800">15:30-12:23pm</td>
                                                <td class="fs-6 fw-bolder text-gray-400">lesson 4:
                                                    <span class="text-gray-800">Biology class</span>
                                                    <!--begin::Icon-->
                                                    <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Held by Dr. Emma">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                        <span class="svg-icon svg-icon-1 svg-icon-warning">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.3" x="2" y="2"
                                                                    width="20" height="20" rx="10"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="14" width="7"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 14)"
                                                                    fill="currentColor" />
                                                                <rect x="11" y="17" width="2"
                                                                    height="2" rx="1"
                                                                    transform="rotate(-90 11 17)"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <!--end::Icon-->
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">Cabinet:
                                                    <span class="text-gray-800">23</span>
                                                </td>
                                                <td class="pe-0 text-end">
                                                    <button class="btn btn-sm btn-light">Skip</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                        </div>
                        <!--end::Tab Content-->
                        <!--begin::Action-->
                        <div class="float-end">
                            <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_create_project">Add Lesson</a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_create_app">Call Sick for Today</a>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::Tables widget 8-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-4">
                <!--begin::Engage widget 3-->
                <div class="card bg-primary h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column pt-13 pb-14">
                        <!--begin::Heading-->
                        <div class="m-0">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-white text-center lh-lg mb-9">How are you feeling today?
                                <span class="fw-boldest">Here we are to Help</span>
                            </h1>
                            <!--end::Title-->
                            <!--begin::Illustration-->
                            <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 mb-lg-12"
                                style="background-image:url('{{ asset("assets/media/svg/illustrations/easy/6.svg") }}')"></div>
                            <!--end::Illustration-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Links-->
                        <div class="text-center">
                            <!--begin::Link-->
                            <a class="btn btn-sm btn-success btn-color-white me-2"
                                data-bs-target="#kt_modal_invite_friends" data-bs-toggle="modal">Psychologist</a>
                            <!--end::Link-->
                            <!--begin::Link-->
                            <a class="btn btn-sm bg-white btn-color-white bg-opacity-20"
                                href="../../demo1/dist/pages/careers/list.html">Nurse</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 3-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-xxl-8">
                <!--begin::Chart widget 22-->
                <div class="card h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header position-relative py-0 border-bottom-2">
                        <!--begin::Nav-->
                        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3">
                            <!--begin::Item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-color-muted active px-0" data-bs-toggle="tab"
                                    id="kt_chart_widgets_22_tab_1" href="#kt_chart_widgets_22_tab_content_1">
                                    <!--begin::Subtitle-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Overview</span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item p-0 ms-0">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="tab"
                                    id="kt_chart_widgets_22_tab_2" href="#kt_chart_widgets_22_tab_content_2">
                                    <!--begin::Subtitle-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Performance</span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Nav-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                class="btn btn-sm btn-light d-flex align-items-center px-4">
                                <!--begin::Display range-->
                                <div class="text-gray-600 fw-bolder">Loading date range...</div>
                                <!--end::Display range-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-1 ms-2 me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                            fill="currentColor" />
                                        <path
                                            d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                            fill="currentColor" />
                                        <path
                                            d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pb-3">
                        <!--begin::Tab Content-->
                        <div class="tab-content">
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade show active" id="kt_chart_widgets_22_tab_content_1">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-wrap flex-md-nowrap">
                                    <!--begin::Items-->
                                    <div class="me-md-5 w-100">
                                        <!--begin::Item-->
                                        <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                            <!--begin::Block-->
                                            <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50px me-4">
                                                    <span class="symbol-label">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen013.svg-->
                                                        <span class="svg-icon svg-icon-2qx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3"
                                                                    d="M20.9 12.9C20.3 12.9 19.9 12.5 19.9 11.9C19.9 11.3 20.3 10.9 20.9 10.9H21.8C21.3 6.2 17.6 2.4 12.9 2V2.9C12.9 3.5 12.5 3.9 11.9 3.9C11.3 3.9 10.9 3.5 10.9 2.9V2C6.19999 2.5 2.4 6.2 2 10.9H2.89999C3.49999 10.9 3.89999 11.3 3.89999 11.9C3.89999 12.5 3.49999 12.9 2.89999 12.9H2C2.5 17.6 6.19999 21.4 10.9 21.8V20.9C10.9 20.3 11.3 19.9 11.9 19.9C12.5 19.9 12.9 20.3 12.9 20.9V21.8C17.6 21.3 21.4 17.6 21.8 12.9H20.9Z"
                                                                    fill="currentColor" />
                                                                <path
                                                                    d="M16.9 10.9H13.6C13.4 10.6 13.2 10.4 12.9 10.2V5.90002C12.9 5.30002 12.5 4.90002 11.9 4.90002C11.3 4.90002 10.9 5.30002 10.9 5.90002V10.2C10.6 10.4 10.4 10.6 10.2 10.9H9.89999C9.29999 10.9 8.89999 11.3 8.89999 11.9C8.89999 12.5 9.29999 12.9 9.89999 12.9H10.2C10.4 13.2 10.6 13.4 10.9 13.6V13.9C10.9 14.5 11.3 14.9 11.9 14.9C12.5 14.9 12.9 14.5 12.9 13.9V13.6C13.2 13.4 13.4 13.2 13.6 12.9H16.9C17.5 12.9 17.9 12.5 17.9 11.9C17.9 11.3 17.5 10.9 16.9 10.9Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="me-2">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Attendance</a>
                                                    <span class="text-gray-400 fw-bolder d-block fs-7">Great, you
                                                        always attending class. keep it up</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Block-->
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center">
                                                <span class="text-dark fw-boldest fs-2x">73</span>
                                                <span class="fw-bold fs-2 text-gray-600 mx-1 pt-1">/</span>
                                                <span class="text-gray-600 fw-bold fs-2 me-3 pt-2">76</span>
                                                <span
                                                    class="badge badge-lg badge-success align-self-center px-2">95%</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                            <!--begin::Block-->
                                            <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50px me-4">
                                                    <span class="symbol-label">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                        <span class="svg-icon svg-icon-2qx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect x="2" y="2" width="9"
                                                                    height="9" rx="2"
                                                                    fill="currentColor" />
                                                                <rect opacity="0.3" x="13" y="2"
                                                                    width="9" height="9" rx="2"
                                                                    fill="currentColor" />
                                                                <rect opacity="0.3" x="13" y="13"
                                                                    width="9" height="9" rx="2"
                                                                    fill="currentColor" />
                                                                <rect opacity="0.3" x="2" y="13"
                                                                    width="9" height="9" rx="2"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="me-2">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Homeworks</a>
                                                    <span class="text-gray-400 fw-bolder d-block fs-7">Don’t forget to
                                                        turn in your task</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Block-->
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center">
                                                <span class="text-dark fw-boldest fs-2x">207</span>
                                                <span class="fw-bold fs-2 text-gray-600 mx-1 pt-1">/</span>
                                                <span class="text-gray-600 fw-bold fs-2 me-3 pt-2">214</span>
                                                <span
                                                    class="badge badge-lg badge-success align-self-center px-2">92%</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                            <!--begin::Block-->
                                            <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50px me-4">
                                                    <span class="symbol-label">
                                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs025.svg-->
                                                        <span class="svg-icon svg-icon-2qx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M16.925 3.90078V8.00077L12.025 10.8008V5.10078L15.525 3.10078C16.125 2.80078 16.925 3.20078 16.925 3.90078ZM2.525 13.5008L6.025 15.5008L10.925 12.7008L6.025 9.90078L2.525 11.9008C1.825 12.3008 1.825 13.2008 2.525 13.5008ZM18.025 19.7008V15.6008L13.125 12.8008V18.5008L16.625 20.5008C17.225 20.8008 18.025 20.4008 18.025 19.7008Z"
                                                                    fill="currentColor" />
                                                                <path opacity="0.3"
                                                                    d="M8.52499 3.10078L12.025 5.10078V10.8008L7.125 8.00077V3.90078C7.125 3.20078 7.92499 2.80078 8.52499 3.10078ZM7.42499 20.5008L10.925 18.5008V12.8008L6.02499 15.6008V19.7008C6.02499 20.4008 6.82499 20.8008 7.42499 20.5008ZM21.525 11.9008L18.025 9.90078L13.125 12.7008L18.025 15.5008L21.525 13.5008C22.225 13.2008 22.225 12.3008 21.525 11.9008Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="me-2">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Tests</a>
                                                    <span class="text-gray-400 fw-bolder d-block fs-7">You take 12
                                                        subjects at this semester</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Block-->
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center">
                                                <span class="text-dark fw-boldest fs-2x">27</span>
                                                <span class="fw-bold fs-2 text-gray-600 mx-1 pt-1">/</span>
                                                <span class="text-gray-600 fw-bold fs-2 me-3 pt-2">38</span>
                                                <span
                                                    class="badge badge-lg badge-warning align-self-center px-2">80%</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Items-->
                                    <!--begin::Container-->
                                    <div
                                        class="d-flex justify-content-between flex-column w-225px w-md-600px mx-auto mx-md-0 pt-3 pb-10">
                                        <!--begin::Title-->
                                        <div class="fs-4 fw-bolder text-gray-900 text-center mb-5">Session Attendance
                                            <br />for Current Academic Year
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Chart-->
                                        <div id="kt_chart_widgets_22_chart_1" class="mx-auto mb-4"></div>
                                        <!--end::Chart-->
                                        <!--begin::Labels-->
                                        <div class="mx-auto">
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-success me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Precent(133)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-primary me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Illness(9)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-info me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Late(2)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-danger me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Absent(3)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Labels-->
                                    </div>
                                    <!--end::Container-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_chart_widgets_22_tab_content_2">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-wrap flex-md-nowrap">
                                    <!--begin::Items-->
                                    <div class="me-md-5 w-100">
                                        <!--begin::Item-->
                                        <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                            <!--begin::Block-->
                                            <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50px me-4">
                                                    <span class="symbol-label">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                        <span class="svg-icon svg-icon-2qx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect x="2" y="2" width="9"
                                                                    height="9" rx="2"
                                                                    fill="currentColor" />
                                                                <rect opacity="0.3" x="13" y="2"
                                                                    width="9" height="9" rx="2"
                                                                    fill="currentColor" />
                                                                <rect opacity="0.3" x="13" y="13"
                                                                    width="9" height="9" rx="2"
                                                                    fill="currentColor" />
                                                                <rect opacity="0.3" x="2" y="13"
                                                                    width="9" height="9" rx="2"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="me-2">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Homeworks</a>
                                                    <span class="text-gray-400 fw-bolder d-block fs-7">Don’t forget to
                                                        turn in your task</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Block-->
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center">
                                                <span class="text-dark fw-boldest fs-2x">423</span>
                                                <span class="fw-bold fs-2 text-gray-600 mx-1 pt-1">/</span>
                                                <span class="text-gray-600 fw-bold fs-2 me-3 pt-2">154</span>
                                                <span
                                                    class="badge badge-lg badge-danger align-self-center px-2">74%</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                            <!--begin::Block-->
                                            <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50px me-4">
                                                    <span class="symbol-label">
                                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs025.svg-->
                                                        <span class="svg-icon svg-icon-2qx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M16.925 3.90078V8.00077L12.025 10.8008V5.10078L15.525 3.10078C16.125 2.80078 16.925 3.20078 16.925 3.90078ZM2.525 13.5008L6.025 15.5008L10.925 12.7008L6.025 9.90078L2.525 11.9008C1.825 12.3008 1.825 13.2008 2.525 13.5008ZM18.025 19.7008V15.6008L13.125 12.8008V18.5008L16.625 20.5008C17.225 20.8008 18.025 20.4008 18.025 19.7008Z"
                                                                    fill="currentColor" />
                                                                <path opacity="0.3"
                                                                    d="M8.52499 3.10078L12.025 5.10078V10.8008L7.125 8.00077V3.90078C7.125 3.20078 7.92499 2.80078 8.52499 3.10078ZM7.42499 20.5008L10.925 18.5008V12.8008L6.02499 15.6008V19.7008C6.02499 20.4008 6.82499 20.8008 7.42499 20.5008ZM21.525 11.9008L18.025 9.90078L13.125 12.7008L18.025 15.5008L21.525 13.5008C22.225 13.2008 22.225 12.3008 21.525 11.9008Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="me-2">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Tests</a>
                                                    <span class="text-gray-400 fw-bolder d-block fs-7">You take 12
                                                        subjects at this semester</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Block-->
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center">
                                                <span class="text-dark fw-boldest fs-2x">43</span>
                                                <span class="fw-bold fs-2 text-gray-600 mx-1 pt-1">/</span>
                                                <span class="text-gray-600 fw-bold fs-2 me-3 pt-2">53</span>
                                                <span
                                                    class="badge badge-lg badge-info align-self-center px-2">65%</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                            <!--begin::Block-->
                                            <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50px me-4">
                                                    <span class="symbol-label">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen013.svg-->
                                                        <span class="svg-icon svg-icon-2qx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3"
                                                                    d="M20.9 12.9C20.3 12.9 19.9 12.5 19.9 11.9C19.9 11.3 20.3 10.9 20.9 10.9H21.8C21.3 6.2 17.6 2.4 12.9 2V2.9C12.9 3.5 12.5 3.9 11.9 3.9C11.3 3.9 10.9 3.5 10.9 2.9V2C6.19999 2.5 2.4 6.2 2 10.9H2.89999C3.49999 10.9 3.89999 11.3 3.89999 11.9C3.89999 12.5 3.49999 12.9 2.89999 12.9H2C2.5 17.6 6.19999 21.4 10.9 21.8V20.9C10.9 20.3 11.3 19.9 11.9 19.9C12.5 19.9 12.9 20.3 12.9 20.9V21.8C17.6 21.3 21.4 17.6 21.8 12.9H20.9Z"
                                                                    fill="currentColor" />
                                                                <path
                                                                    d="M16.9 10.9H13.6C13.4 10.6 13.2 10.4 12.9 10.2V5.90002C12.9 5.30002 12.5 4.90002 11.9 4.90002C11.3 4.90002 10.9 5.30002 10.9 5.90002V10.2C10.6 10.4 10.4 10.6 10.2 10.9H9.89999C9.29999 10.9 8.89999 11.3 8.89999 11.9C8.89999 12.5 9.29999 12.9 9.89999 12.9H10.2C10.4 13.2 10.6 13.4 10.9 13.6V13.9C10.9 14.5 11.3 14.9 11.9 14.9C12.5 14.9 12.9 14.5 12.9 13.9V13.6C13.2 13.4 13.4 13.2 13.6 12.9H16.9C17.5 12.9 17.9 12.5 17.9 11.9C17.9 11.3 17.5 10.9 16.9 10.9Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Section-->
                                                <div class="me-2">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Attendance</a>
                                                    <span class="text-gray-400 fw-bolder d-block fs-7">Great, you
                                                        always attending class. keep it up</span>
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                            <!--end::Block-->
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center">
                                                <span class="text-dark fw-boldest fs-2x">53</span>
                                                <span class="fw-bold fs-2 text-gray-600 mx-1 pt-1">/</span>
                                                <span class="text-gray-600 fw-bold fs-2 me-3 pt-2">94</span>
                                                <span
                                                    class="badge badge-lg badge-primary align-self-center px-2">87%</span>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Items-->
                                    <!--begin::Container-->
                                    <div
                                        class="d-flex justify-content-between flex-column w-225px w-md-600px mx-auto mx-md-0 pt-3 pb-10">
                                        <!--begin::Title-->
                                        <div class="fs-4 fw-bolder text-gray-900 text-center mb-5">Session Attendance
                                            <br />for Current Academic Year
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Chart-->
                                        <div id="kt_chart_widgets_22_chart_2" class="mx-auto mb-4"></div>
                                        <!--end::Chart-->
                                        <!--begin::Labels-->
                                        <div class="mx-auto">
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-success me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Precent(133)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-primary me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Illness(9)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-info me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Late(2)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Bullet-->
                                                <div class="bullet bullet-dot w-8px h-7px bg-danger me-2"></div>
                                                <!--end::Bullet-->
                                                <!--begin::Label-->
                                                <div class="fs-8 fw-bold text-muted">Absent(3)</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Labels-->
                                    </div>
                                    <!--end::Container-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Tap pane-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::Chart widget 22-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-4">
                <!--begin::Slider Widget 3-->
                <div id="kt_sliders_widget_3_slider" class="card card-flush carousel slide h-xl-100"
                    data-bs-ride="carousel" data-bs-interval="5000">
                    <!--begin::Header-->
                    <div class="card-header pt-5 mb-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder text-dark">Academic Performance</span>
                            <span class="text-gray-400 mt-1 fw-bold fs-7">Avg. 72% completed lessons</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end">
                                <a href="#kt_sliders_widget_3_slider"
                                    class="carousel-control-prev position-relative me-5 active" role="button"
                                    data-bs-slide="prev">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen058.svg-->
                                    <span class="svg-icon svg-icon-2x svg-icon-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.3" x="2" y="2" width="20"
                                                height="20" rx="5" fill="currentColor" />
                                            <path
                                                d="M12.0657 12.5657L14.463 14.963C14.7733 15.2733 14.8151 15.7619 14.5621 16.1204C14.2384 16.5789 13.5789 16.6334 13.1844 16.2342L9.69464 12.7029C9.30968 12.3134 9.30968 11.6866 9.69464 11.2971L13.1844 7.76582C13.5789 7.3666 14.2384 7.42107 14.5621 7.87962C14.8151 8.23809 14.7733 8.72669 14.463 9.03696L12.0657 11.4343C11.7533 11.7467 11.7533 12.2533 12.0657 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a href="#kt_sliders_widget_3_slider"
                                    class="carousel-control-next position-relative me-1" role="button"
                                    data-bs-slide="next">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen057.svg-->
                                    <span class="svg-icon svg-icon-2x svg-icon-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.3" x="2" y="2" width="20"
                                                height="20" rx="5" fill="currentColor" />
                                            <path
                                                d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </div>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Carousel-->
                        <div class="carousel-inner">
                            <!--begin::Item-->
                            <div class="carousel-item active show">
                                <!--begin::Title-->
                                <span class="text-gray-800 fw-bolder fs-4 mb-3 px-8">Chemistry</span>
                                <!--end::Title-->
                                <!--begin::Statistics-->
                                <div class="d-flex align-items-center w-100 px-8">
                                    <!--begin::Number-->
                                    <span class="fs-2qx text-gray-800 fw-bolder">6</span>
                                    <!--end::Number-->
                                    <!--begin::Progress-->
                                    <div class="progress h-6px w-100 mx-3 bg-light-primary">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 62%"
                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!--end::Progress-->
                                    <!--begin::Value-->
                                    <span class="text-gray-400 fw-bolder fs-4">62%</span>
                                    <!--end::Value-->
                                </div>
                                <!--end::Statistics-->
                                <!--begin::Chart-->
                                <div id="kt_sliders_widget_3_chart_1" class="min-h-auto ps-4 pe-6"
                                    style="height: 330px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="carousel-item">
                                <!--begin::Title-->
                                <span class="text-gray-800 fw-bolder fs-4 mb-3 px-8">Mathematics</span>
                                <!--end::Title-->
                                <!--begin::Statistics-->
                                <div class="d-flex align-items-center w-100 px-8">
                                    <!--begin::Number-->
                                    <span class="fs-2qx text-gray-800 fw-bolder">4</span>
                                    <!--end::Number-->
                                    <!--begin::Progress-->
                                    <div class="progress h-6px w-100 mx-3 bg-light-danger">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 73%"
                                            aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!--end::Progress-->
                                    <!--begin::Value-->
                                    <span class="text-gray-400 fw-bolder fs-4">73%</span>
                                    <!--end::Value-->
                                </div>
                                <!--end::Statistics-->
                                <!--begin::Chart-->
                                <div id="kt_sliders_widget_3_chart_2" class="min-h-auto ps-4 pe-6"
                                    style="height: 330px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Carousel-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Slider Widget 3-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-xxl-8">
                <!--begin::Timeline widget 2-->
                <div class="card h-xl-100" id="kt_timeline_widget_2_card">
                    <!--begin::Header-->
                    <div class="card-header position-relative py-0 border-bottom-2">
                        <!--begin::Nav-->
                        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3">
                            <!--begin::Item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-color-muted active px-0" data-bs-toggle="pill"
                                    href="#kt_timeline_widget_2_tab_1">
                                    <!--begin::Subtitle-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Today Homeworks</span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item p-0 ms-0 me-8">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="pill"
                                    href="#kt_timeline_widget_2_tab_2">
                                    <!--begin::Subtitle-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Recent</span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="nav-item p-0 ms-0">
                                <!--begin::Link-->
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="pill"
                                    href="#kt_timeline_widget_2_tab_3">
                                    <!--begin::Subtitle-->
                                    <span class="nav-text fw-bold fs-4 mb-3">Future</span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Nav-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Tab Content-->
                        <div class="tab-content">
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade show active" id="kt_timeline_widget_2_tab_1">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 w-10px"></th>
                                                <th class="p-0 w-25px"></th>
                                                <th class="p-0 min-w-400px"></th>
                                                <th class="p-0 min-w-100px"></th>
                                                <th class="p-0 min-w-125px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-success"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div
                                                        class="form-check form-check-custom form-check-success form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" checked="checked"
                                                            data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Book p.
                                                        77-85, read &amp; complete tasks 1-6 on p. 85</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">Physics</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-success">Done</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Workbook
                                                        p. 17, tasks 1-6</a>
                                                    <span
                                                        class="text-gray-400 fw-bolder fs-7 d-block">Mathematics</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-success"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div
                                                        class="form-check form-check-custom form-check-success form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" checked="checked"
                                                            data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Learn
                                                        paragraph p. 99, Exercise 1,2,3Scoping &amp; Estimations</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">Chemistry</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-success">Done</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Write
                                                        essay 1000 words “WW2 results”</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">History</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Internal
                                                        conflicts in Philip Larkin poems, read p 380-515</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">English
                                                        Language</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_timeline_widget_2_tab_2">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 w-10px"></th>
                                                <th class="p-0 w-25px"></th>
                                                <th class="p-0 min-w-400px"></th>
                                                <th class="p-0 min-w-100px"></th>
                                                <th class="p-0 min-w-125px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-success"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div
                                                        class="form-check form-check-custom form-check-success form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" checked="checked"
                                                            data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Book p.
                                                        77-85, read &amp; complete tasks 1-6 on p. 85</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">Physics</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-success">Done</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Workbook
                                                        p. 17, tasks 1-6</a>
                                                    <span
                                                        class="text-gray-400 fw-bolder fs-7 d-block">Mathematics</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-success"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div
                                                        class="form-check form-check-custom form-check-success form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" checked="checked"
                                                            data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Learn
                                                        paragraph p. 99, Exercise 1,2,3Scoping &amp; Estimations</a>
                                                    <span
                                                        class="text-gray-400 fw-bolder fs-7 d-block">Chemistry</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-success">Done</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Write
                                                        essay 1000 words “WW2 results”</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">History</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Tap pane-->
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_timeline_widget_2_tab_3">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr>
                                                <th class="p-0 w-10px"></th>
                                                <th class="p-0 w-25px"></th>
                                                <th class="p-0 min-w-400px"></th>
                                                <th class="p-0 min-w-100px"></th>
                                                <th class="p-0 min-w-125px"></th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Workbook
                                                        p. 17, tasks 1-6</a>
                                                    <span
                                                        class="text-gray-400 fw-bolder fs-7 d-block">Mathematics</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-success"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div
                                                        class="form-check form-check-custom form-check-success form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" checked="checked"
                                                            data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Learn
                                                        paragraph p. 99, Exercise 1,2,3Scoping &amp; Estimations</a>
                                                    <span
                                                        class="text-gray-400 fw-bolder fs-7 d-block">Chemistry</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-success">Done</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Write
                                                        essay 1000 words “WW2 results”</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">History</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span data-kt-element="bullet"
                                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                                </td>
                                                <td class="ps-0">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="" data-kt-element="checkbox" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">Internal
                                                        conflicts in Philip Larkin poems, read p 380-515</a>
                                                    <span class="text-gray-400 fw-bolder fs-7 d-block">English
                                                        Language</span>
                                                </td>
                                                <td class="text-end">
                                                    <span data-kt-element="status"
                                                        class="badge badge-light-primary">In Process</span>
                                                </td>
                                                <td class="text-end">
                                                    <!--begin::Icon-->
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <!--begin::Print-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-printer fs-3"></i>
                                                        </a>
                                                        <!--end::Print-->
                                                        <!--begin::Chat-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm me-3">
                                                            <i class="fonticon-chat fs-3"></i>
                                                        </a>
                                                        <!--end::Chat-->
                                                        <!--begin::Attach-->
                                                        <a href="#"
                                                            class="btn btn-icon btn-color-muted btn-bg-light btn-active-color-primary btn-sm">
                                                            <i class="fonticon-paperclip fs-3"></i>
                                                        </a>
                                                        <!--end::Attach-->
                                                    </div>
                                                    <!--end::Icon-->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Tap pane-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Tables Widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-4">
                <!--begin::List widget 20-->
                <div class="card h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder text-dark">Recommended for you</span>
                            <span class="text-muted mt-1 fw-bold fs-7">8k social visitors</span>
                        </h3>
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-sm btn-light">All Courses</a>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-6">
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label fs-2 fw-bold bg-danger text-inverse-danger">M</div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="../../demo1/dist/pages/user-profile/overview.html"
                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">UI/UX Design</a>
                                    <span class="text-muted fw-bold d-block fs-7">40+ Courses</span>
                                </div>
                                <!--end:Author-->
                                <!--begin::Actions-->
                                <a href="#"
                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13"
                                                height="2" rx="1" transform="rotate(-180 18 13)"
                                                fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Actions-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label fs-2 fw-bold bg-success text-inverse-danger">Q</div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="../../demo1/dist/pages/user-profile/overview.html"
                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">QA Analysis</a>
                                    <span class="text-muted fw-bold d-block fs-7">18 Courses</span>
                                </div>
                                <!--end:Author-->
                                <!--begin::Actions-->
                                <a href="#"
                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13"
                                                height="2" rx="1" transform="rotate(-180 18 13)"
                                                fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Actions-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label fs-2 fw-bold bg-info text-inverse-danger">W</div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="../../demo1/dist/pages/user-profile/overview.html"
                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Web Development</a>
                                    <span class="text-muted fw-bold d-block fs-7">120+ Courses</span>
                                </div>
                                <!--end:Author-->
                                <!--begin::Actions-->
                                <a href="#"
                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13"
                                                height="2" rx="1" transform="rotate(-180 18 13)"
                                                fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Actions-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label fs-2 fw-bold bg-primary text-inverse-danger">M</div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="../../demo1/dist/pages/user-profile/overview.html"
                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Marketing</a>
                                    <span class="text-muted fw-bold d-block fs-7">50+ Courses.</span>
                                </div>
                                <!--end:Author-->
                                <!--begin::Actions-->
                                <a href="#"
                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13"
                                                height="2" rx="1" transform="rotate(-180 18 13)"
                                                fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Actions-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label fs-2 fw-bold bg-warning text-inverse-danger">P</div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="../../demo1/dist/pages/user-profile/overview.html"
                                        class="text-gray-800 text-hover-primary fs-6 fw-bolder">Philosophy</a>
                                    <span class="text-muted fw-bold d-block fs-7">24+ Courses</span>
                                </div>
                                <!--end:Author-->
                                <!--begin::Actions-->
                                <a href="#"
                                    class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13"
                                                height="2" rx="1" transform="rotate(-180 18 13)"
                                                fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Actions-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List widget 20-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>

    @push('package_styles')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/type.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/budget.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/settings.j') }}s"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/team.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/targets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/files.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/complete.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-project/main.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    @endpush
</x-app-layout>
