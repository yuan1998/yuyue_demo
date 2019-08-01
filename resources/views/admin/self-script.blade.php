@if(Session::has('self-script'))
    @php
    $script_dy     = Session::get('self-script');
    @endphp
    <script>
        $(function () {
            alert('aload');
            {!! $script_dy !!}
        });
    </script>
@endif
