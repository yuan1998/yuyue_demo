@if(Session::has('self-script'))
    @php
    $script_dy     = Session::get('self-script');
    @endphp
    <script>
        $(function () {
            {!! $script_dy !!}
        });
    </script>
@endif
