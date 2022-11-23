<x-app-layout>
    @slot('title')
        Select Company
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Select Company
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15" x-data="alObject">
                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::select('company_id', $companies, null, [
                            'class' => 'form-select form-select-solid',
                            'data-hide-search' => 'true',
                            'x-model' => 'company_id',
                            'x-on:change' => 'link',
                            'placeholder' => 'Select a Company',
                            'required' => 'required',
                        ]) }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <template x-if="link">
                            <a :href="link" class="btn btn-primary">
                                Select Company
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('alObject', () => ({
                    company_id: '',
                    route: "{{ route($routeName, 'companyId') }}",
                    link() {
                        if (this.company_id.length) {
                            return this.route.replace('companyId', this.company_id);
                        }
                        return false;
                    }
                }));
            })
        </script>
    @endpush
</x-app-layout>
