<div class="alert alert-{{ session()->get('type') }}">
    {{ session()->get('flash_message') }}
    <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
</div>