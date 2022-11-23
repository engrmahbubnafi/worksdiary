@if (isset($slot) && !empty($slot->toHtml()))
    <div data-kt-menu-trigger="click" {{ $attributes->merge(['class' => 'menu-item menu-accordion']) }}>
        <span class="menu-link">
            <span class="menu-icon">
                @if (isset($icon) && !empty($icon->toHtml()))
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

            <span class="menu-title">
                @if (isset($titleName))
                    {!! $titleName !!}
                @else
                    Default
                @endif
            </span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            {!! $slot !!}
        </div>
    </div>
@endif
