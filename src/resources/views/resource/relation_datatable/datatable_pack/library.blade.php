@if (app()->getLocale() == 'ar')
    <link rel="stylesheet" type="text/css"
        href="{{ url('dashboard/assets/dash/libs/datatable/css/dataTables.bootstrap5-rtl.css') }}">
@else
    <link rel="stylesheet" type="text/css"
        href="{{ url('dashboard/assets/dash/libs/datatable/css/dataTables.bootstrap5.css') }}">
@endif

<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/dataTables.bootstrap5.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/dataTables.buttons.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.bootstrap5.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/jszip.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/pdfmake/pdfmake.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/pdfmake/vfs_fonts.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.html5.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.print.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.colVis.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/dataTables.responsive.min.js"></script>
<script src="{{ url('dashboard/assets/dash') }}/libs/datatable/responsive.bootstrap5.min.js"></script>
