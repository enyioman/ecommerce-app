

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $role->created_at->format('D d, M, Y') !!}</p>
</div>


@include('users.table')

