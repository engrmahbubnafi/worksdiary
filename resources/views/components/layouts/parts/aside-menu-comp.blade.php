<div class="aside-menu flex-column-fluid">
    <!--begin::Aside Menu-->
    @php
        $currentRouteName = Route::currentRouteName();
    @endphp

    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
        data-kt-scroll-offset="0">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
            id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
            {{-- class="here show" for parent menu active --}}

            @foreach (config('admin_menu') as $menu)
                <x-menu-module-comp :title="$menu->module">
                    @foreach ($menu->groups as $item)
                        @if ($item->children && $item->children->count())
                            <x-menu-group-comp :titleName="$item->title"
                                class="{{ Str::checkMenuActive($currentRouteName,$item->children->pluck('route_name')->merge($item->route_name)->toArray(),true) }}">
                                @slot('icon')
                                    {!! $item->icon !!}
                                @endslot

                                @foreach ($item->children as $child)
                                    @if ($child->permission)
                                        @if (Str::isMenuRender($child->permission, $menu_list))
                                            <div class="menu-item">
                                                <a class="menu-link {{ Str::checkMenuActive($currentRouteName, [$child->route_name, $child->params]) }}"
                                                    href="{{ route($child->route_name, $child->params) }}">
                                                    @if ($child->icon)
                                                        {!! $child->icon !!}
                                                    @else
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                    @endif
                                                    <span class="menu-title">{{ $child->title }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="menu-item">
                                            <a class="menu-link {{ Str::checkMenuActive($currentRouteName, [$child->route_name, $child->params]) }}"
                                                href="{{ route($child->route_name, $child->params) }}">
                                                @if ($child->icon)
                                                    {!! $child->icon !!}
                                                @else
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                @endif
                                                <span class="menu-title">{{ $child->title }}</span>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </x-menu-group-comp>
                        @else
                            @if ($item->permission)
                                @if (Str::isMenuRender($item->permission, $menu_list))
                                    <div class="menu-item">
                                        <a class="menu-link {{ Str::checkMenuActive($currentRouteName, [$item->route_name, $item->params]) }}"
                                            href="{{ route($item->route_name, $item->params) }}">
                                            <span class="menu-icon">
                                                @if ($icon)
                                                    @if(is_file($icon))
                                                        <span class="svg-icon svg-icon-2">
                                                            {!! file_get_contents($icon) !!}
                                                        </span>
                                                    @else 
                                                        {!! $icon !!}
                                                    @endif                    
                                                @else
                                                    <span class="svg-icon svg-icon-2">
                                                        {!! file_get_contents('svg/dashboard.svg') !!}
                                                    </span>
                                                @endif               
                                            </span>
                                            <span class="menu-title">{{ $item->title }}</span>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="menu-item">
                                    <a class="menu-link {{ Str::checkMenuActive($currentRouteName, [$item->route_name, $item->params]) }}"
                                        href="{{ route($item->route_name, $item->params) }}">
                                        <span class="menu-icon">                                            
                                            @if ($item->icon)
                                                @if(is_file($item->icon))
                                                    <span class="svg-icon svg-icon-2">
                                                        {!! file_get_contents($item->icon) !!}
                                                    </span>
                                                @else 
                                                    {!! $item->icon !!}
                                                @endif                    
                                            @else
                                                <span class="svg-icon svg-icon-2">
                                                    {!! file_get_contents('svg/dashboard.svg') !!}
                                                </span>
                                            @endif
                                        </span>
                                        <span class="menu-title">{{ $item->title }}</span>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </x-menu-module-comp>
            @endforeach
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Aside Menu-->
</div>
