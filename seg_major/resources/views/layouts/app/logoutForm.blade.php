
<form method="post" action="{{route('logout')}}" id="logoutForm">
    @csrf
    <button type="submit" class="logout"  id="right-panel-link" style="width:10%" href="#right-panel">Log Out</button>
</form>