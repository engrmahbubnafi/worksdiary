@props(['html', 'id'])

<div id="kt_content_container" class="container-xxl">
    <div class="card">

        {{ $slot }}

        <div class="card-body py-4 table-responsive">
            {!! $html->table(['class' => 'table-row-dashed fs-6 gy-5 table align-middle responsive nowrap']) !!}
        </div>

    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <style>
        .table th{
            font-weight: bold;
        }
    </style>
@endpush

@push('scripts')

    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {!! $html->scripts() !!}
@endpush
