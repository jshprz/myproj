@if(Session::has('flashSuccess'))
    <div class="alert alert-success fade-alert" role="alert">
    <strong><center>{{ Session::get('flashSuccess') }}</center></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('flashError'))
    <div class="alert alert-secondary fade-alert" role="alert">
    <strong><center>{{ Session::get('flashError') }}</center></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif