@if(($lists->count() > 1) || (isset($slot) && $slot->toHtml()))
    <div class="card">
        <div class="card-header">
            @if($lists->count() > 1 && $lists->count() <= $maxLimitForTab)
                <div class="card-title">
                    <!--begin::Tabs-->
                    <ul 
                        class="nav nav-stretch nav-line-tabs fw-semibold fs-6 border-transparent flex-nowrap" 
                        role="tablist" 
                        id="kt_layout_builder_tabs"
                    >
                        @foreach ($lists as $list)
                            <li 
                                class="nav-item" 
                                role="presentation"
                            >
                                <a
                                    class="nav-link {{ Str::checkMenuActive($currentRouteName, [$list->route_name,$getParams($list->params)])}}"
                                    @if($isTabable) data-bs-toggle="tab"  role="tab" @endif
                                    href="{{ $commonParam && $isComonParamAddedToRoute ? route($list->route_name, [$commonParam,$list->params]):route($list->route_name, $list->params) }}"
                                    aria-selected="true"
                                >       
                                    {{ $list->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <!--end::Tabs-->
                </div>
            @elseif($lists->count() > $maxLimitForTab)
                <div class="card-title">  
                    <select 
                        id="companySelect"
                        class="form-select form-select-solid w-200px"

                        data-control="select2"  
                        placeholder = "Select company"
                    >
                        @foreach ($lists as $list)
                            <option 
                                @if(Str::checkMenuActive($currentRouteName, [$list->route_name,$getParams($list->params)])=='active') selected @endif 
                                value="{{ $commonParam && $isComonParamAddedToRoute ? route($list->route_name, [$commonParam,$list->params]):route($list->route_name, $list->params) }}"
                            >
                                {{ $list->title }}
                            </option>                        
                        @endforeach
                    </select>
                </div>
            @endif

            @if (isset($slot) && !empty($slot->toHtml()))
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end flex-row-fluid gap-2 flex-wrap" data-kt-user-table-toolbar="base">
                        {!! $slot !!}
                    </div>
                    <!--end::Toolbar-->
                </div>
            @endif
          
        </div>
    </div>
    @push('scripts')
        <script>
            $('#companySelect').on('select2:select', function(e){
                window.location.href = e.currentTarget.value;
            });
        </script>
    @endpush
@endif
