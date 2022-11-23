<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <x-layouts.parts.aside-mobile-toggle-comp></x-layouts.parts.aside-mobile-toggle-comp>
        <!--end::Aside mobile toggle-->

        <!--begin::Mobile logo-->
        <x-layouts.parts.mobile-logo-comp></x-layouts.parts.mobile-logo-comp>
        <!--end::Mobile logo-->

        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Header Menu-->
            @if (Layout::getConfig('header_menu'))
                <x-layouts.parts.header-menu-comp></x-layouts.parts.header-menu-comp>
            @endif
            <!--end::Header Menu-->

            <!--begin::Header Toolbar-->
            <x-layouts.parts.header-toolbar-comp >
            </x-layouts.parts.header-toolbar-comp>
            <!--end::Header Toolbar-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
