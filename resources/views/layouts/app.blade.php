<!DOCTYPE html>
<!--
Author: BlueBees AI
Website: https://www.bluebees.ai
Contact: support@bluebees.ai
-->
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">

    <title>{{ $title ?? 'Dashboard' }}</title>

    {{-- Meta Component --}}
    <x-meta-comp></x-meta-comp>

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

    <!--begin::Fonts-->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> --}}
    <!--end::Fonts-->

    <!--begin::Page Vendor Stylesheets(used by this page)-->
    @stack('package_styles')
    <!--end::Page Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        .aside-menu .menu-item .menu-icon {
            justify-content: center;
        }

        .nav-line-tabs .nav-item .nav-link.active,
        .nav-line-tabs .nav-item .nav-link:hover:not(.disabled),
        .nav-line-tabs .nav-item.show .nav-link {
            font-weight: 500;
            color: black;
        }
    </style>

    @stack('styles')
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="{{ Layout::printBodyClasses() }}" style="{{ Layout::printBodyCssVariables() }}">

    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-column-fluid flex-row">
            <!--begin::Aside-->
            <x-layouts.aside-comp></x-layouts.aside-comp>
            <!--end::Aside-->

            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <x-layouts.header-comp></x-layouts.header-comp>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <!--begin::Subheader-->
                    @if (Layout::getConfig('subheader.enable'))
                        {{ $subheader ?? '' }}
                    @endif
                    <!--end::Subheader-->

                    <div class="container-xxl">
                        <!--for validation error start-->
                        @foreach (['danger', 'warning', 'success', 'info'] as $type)
                            @if ($message = session('flash_' . $type))
                                <x-alert :type="$type" :message="$message"></x-alert>
                            @endif
                        @endforeach

                        {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
                    </div>

                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        {{ $slot }}
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                <x-layouts.footer-comp></x-layouts.footer-comp>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

    <!--end::Root-->

    <!--begin::Drawers-->
    @if (Layout::getConfig('header_drawer.activities'))
        <!--begin::Activities drawer-->
        <x-drawers.activities-drawer-comp></x-drawers.activities-drawer-comp>
        <!--end::Activities drawer-->
    @endif

    @if (Layout::getConfig('header_drawer.chat'))
        <!--begin::Chat drawer-->
        <x-drawers.chat-drawer-comp></x-drawers.chat-drawer-comp>
        <!--end::Chat drawer-->
    @endif
    <!--end::Drawers-->

    <!--end::Main-->

    <!--begin::Engage drawers-->

    @if (Layout::getConfig('sticky_drawer.demo'))
        <!--begin::Demos drawer-->
        <x-drawers.demos-drawer-comp></x-drawers.demos-drawer-comp>
        <!--end::Demos drawer-->
    @endif

    @if (Layout::getConfig('sticky_drawer.help'))
        <!--begin::Help drawer-->
        <x-drawers.help-drawer-comp></x-drawers.help-drawer-comp>
        <!--end::Help drawer-->
        <!--end::Engage drawers-->
    @endif

    <!--begin::Sticky Drawer Btn-->
    <x-layouts.sticky-drwer-btn-comp>

        @if (Layout::getConfig('sticky_drawer.demo'))
            <!--begin::Demos drawer toggle-->
            <button id="kt_engage_demos_toggle"
                class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 fs-6 rounded-top-0 px-4 shadow-sm"
                title="Check out 22 more demos" data-bs-toggle="tooltip" data-bs-placement="left"
                data-bs-dismiss="click" data-bs-trigger="hover">
                <span id="kt_engage_demos_label">Demos</span>
            </button>
            <!--end::Demos drawer toggle-->
        @endif

        @if (Layout::getConfig('sticky_drawer.help'))
            <!--begin::Help drawer toggle-->
            <button id="kt_help_toggle"
                class="engage-help-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 rounded-top-0 px-5 shadow-sm"
                title="Learn &amp; Get Inspired" data-bs-toggle="tooltip" data-bs-placement="left"
                data-bs-dismiss="click" data-bs-trigger="hover">Help</button>
            <!--end::Help drawer toggle-->
        @endif

        <!--begin::Purchase link-->
        {{-- <a href="https://1.envato.market/EA4JP" target="_blank"
            class="engage-purchase-link btn btn-color-gray-700 bg-body btn-active-color-gray-900' btn-flex h-35px px-5 shadow-sm rounded-top-0">Buy
            now</a> --}}
        <!--end::Purchase link-->
    </x-layouts.sticky-drwer-btn-comp>
    <!--end::Sticky Drawer Btn-->

    <!--begin::Scrolltop-->
    @include('common.scrolltop')
    <!--end::Scrolltop-->

    <!--begin::Modals-->
    @if (Layout::getConfig('modal.upgrade_plan'))
        <!--begin::Modal - Upgrade plan-->
        <x-modals.upgrade-plan-modal-comp></x-modals.upgrade-plan-modal-comp>
        <!--end::Modal - Upgrade plan-->
    @endif

    @if (Layout::getConfig('modal.create_app'))
        <!--begin::Modal - Create App-->
        <x-modals.create-app-modal-comp></x-modals.create-app-modal-comp>
        <!--end::Modal - Create App-->
    @endif

    @if (Layout::getConfig('modal.invite_friends'))
        <!--begin::Modal - Invite Friends-->
        <x-modals.invite-friends-modal-comp></x-modals.invite-friends-modal-comp>
        <!--end::Modal - Invite Friend-->
    @endif

    @if (Layout::getConfig('modal.user_search'))
        <!--begin::Modal - Users Search-->
        <x-modals.user-search-modal-comp></x-modals.user-search-modal-comp>
        <!--end::Modal - Users Search-->
    @endif
    <!--end::Modals-->

    <!-- JavaScript Start -->
    {{-- Set host URL. --}}
    <script>
        var hostUrl = "assets/";
    </script>

    <!-- Global Javascript Bundle (used by all pages) Start -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Global Javascript Bundle End -->

    <script>
        window.select2Alpine = function() {
            var alpineObj = this;

            var select2Arr = $("select[data-control='select2']");

            if (select2Arr && select2Arr.length) {
                select2Arr.each(function(i, obj) {
                    let model = obj.getAttribute('x-model');
                    let func = obj.getAttribute('x-on:change');

                    if (model) {
                        let modelArr = model.split(".");
                        let fnArr = func?.replace(/ *\([^)]*\) */g, "").split(",") ?? [];

                        if (modelArr.length > 1) {
                            alpineObj.$store.local.select2[modelArr[0]] = {};

                            alpineObj.$store.local.select2[modelArr[0]][modelArr[1]] = $(obj).select2();

                            alpineObj.$store.local.select2[modelArr[0]][modelArr[1]].on("select2:select", (
                                event) => {
                                alpineObj[modelArr[0]][modelArr[1]] = event.target.value;
                            });

                            alpineObj.$watch(modelArr[0] + '.' + modelArr[1], (value) => {
                                alpineObj.$store.local.select2[modelArr[0]][modelArr[1]].val(value)
                                    .trigger("change");
                                if (fnArr.length) {
                                    fnArr.forEach(func => {
                                        alpineObj[func]()
                                    });
                                }
                            });

                        } else {
                            alpineObj.$store.local.select2[modelArr[0]] = $(obj).select2();

                            alpineObj.$store.local.select2[modelArr[0]].on("select2:select", (event) => {
                                alpineObj[modelArr[0]] = event.target.value;
                            });

                            alpineObj.$watch(modelArr[0], (value) => {
                                alpineObj.$store.local.select2[modelArr[0]].val(value).trigger(
                                    "change");
                                if (fnArr.length) {
                                    fnArr.forEach(func => {
                                        alpineObj[func]()
                                    });
                                }
                            });
                        }
                    }

                });
            }
        };
    </script>

    <!-- Custom Javascript (used by that page only) Start-->
    @stack('scripts')
    <!-- Custom Javascript (used by that page only) End -->

    {{-- Start Apline JS. --}}
    <script>
        Alpine.store('local', {
            unitId: 0,
            dealerId: 0,
            asDealer: 0,
            select2: {}
        });
        Alpine.start();
    </script>
    <!-- JavaScript End -->
</body>

</html>
