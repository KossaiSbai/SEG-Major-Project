@if (session('status-warning'))
    <div class="alert alert-warning">
        {{ session('status-warning') }}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@endif
@if (session('status-success'))
    <div class="alert alert-success">
        {{ session('status-success') }}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@endif
@if (session('status-error'))
    <div class="alert alert-danger">
        {{ session('status-error') }}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@endif