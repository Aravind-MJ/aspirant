@if(Sentinel::check())
    <?php
    $user = Sentinel::getUser();
    ?>
@endif

@if($user->inRole('superadmin')||$user->inRole('admins'))
{!! Form::open(['route' => ['mark.update','update'],'method' => "PATCH"]) !!}
<input type="text" name="exam_id" value="" class="exam_id" hidden>
<input type="text" name="batch_id" value="{{$batch_id}}" class="batch_id" hidden>
    <div class="btn btn-warning pull-right" id="edit_marks" style="width: 200px;"><span class="fa fa-edit"></span> Enable Mark Edit</div>
    <div class="btn btn-danger pull-right" id="delete_marks" style="clear: right; width: 200px;"><span class="fa fa-times"></span> Delete Mark</div>
    <script>
        $('#edit_marks').click(function(){
            if ($('.mark-container').attr('readonly')) {
                    $('.mark-container').removeAttr('readonly');
                    $('.mark_table').append('<tr class="table_footer"><td colspan="2"><input href="" type="submit" value="Edit Mark" class="btn btn-primary"></td></tr>');
                    $('#edit_marks').html('<span class="fa fa-times"></span> Disable Mark Edit');
                } else {
                    $('.mark-container').attr('readonly', 'readonly');
                    $('.table_footer').remove();
                    $('#edit_marks').html('<span class="fa fa-edit"></span> Enable Mark Edit');
                }
        });

        $('#delete_marks').click(function(){
            var exam_id = $('.exam-id').val();
            var html = '<input name="_method" value="DELETE">' +
                       '<input name="_token" value="{{csrf_token()}}">' +
                       '<input name="exam_id" value="'+exam_id+'" class="exam_id">' +
                       '<input name="batch_id" value="{{$batch_id}}" class="batch_id">';
            var con = confirm('Are you sure you want to delete?');
            if(con){
                $('<form>',{
                    id:'delete_marks',
                    html:html,
                    action:'{{url('mark/delete')}}',
                    method:'post'
                }).appendTo(document.body).submit();
            }
        });
    </script>
@endif
<table class="table table-striped text-center mark_table" style="width: 50%; margin: auto; border: 1px solid #000; table-layout: fixed;">
    <thead>
        <tr>
            <th>Name of Student</th>
            <th>Marks Obtained</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($students as $id => $student){
        ?>
        <tr>
            <td><?=$student['name']?></td>
            <td>
                <div class="form-group">
                <input type="text" pattern="[0-9]{0,3}" name="markof[<?=$id?>]" class="form-control mark-container" value="<?=$student['mark']?>" readonly>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
{!! Form::close() !!}
