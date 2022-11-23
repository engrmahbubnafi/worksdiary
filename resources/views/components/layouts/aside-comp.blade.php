<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    @if (Layout::getConfig('aside.brand'))
        <x-layouts.parts.brand-comp></x-layouts.parts.brand-comp>
    @endif
    <!--end::Brand-->

    <!--begin::Aside menu-->
    @if (Layout::getConfig('aside.menu'))
        <x-layouts.parts.aside-menu-comp></x-layouts.parts.aside-menu-comp>
    @endif
    <!--end::Aside menu-->

    <!--begin::Footer-->
    @if (Layout::getConfig('aside.footer'))
        <x-layouts.parts.aside-footer-comp></x-layouts.parts.aside-footer-comp>
    @endif
    <!--end::Footer-->
</div>
