
@section('supercontent')




    <div id="fltrSrch">
        @yield('dropdown')
        <div class="search">
            <input type="text" placeholder="Search.." id="search">
        </div>

    </div>
        @yield ('content')


<script>
    $(document).ready(function(){
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#bloodtable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>


    @endsection
