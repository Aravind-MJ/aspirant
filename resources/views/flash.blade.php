@if (isset($flash_message))
<div class="alert alert-{{$type}}">
    {!!$flash_message!!}
    <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
</div>
@endif
@if (session()->has('flash_message'))
    @include('session_flash')
@endif
@if($errors->has())
    <div class="alert alert-info">
    <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
        <ol>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ol>
    </div>
@endif