@if(Sentinel::check())
    <?php
    $user = Sentinel::getUser();
    ?>
@endif

@if($user->inRole('superadmin')||$user->inRole('admins'))
{!! Form::open(['route' => ['mark.update','update'],'method' => "PATCH"]) !!}
<input type="text" name="exam_id" value="" class="exam_id" hidden>
<input type="text" name="batch_id" value="{{$batch_id}}" class="batch_id" hidden>
    <div class="btn btn-warning pull-right" id="edit_marks"><span class="fa fa-edit"></span> Enable Mark Edit</div>
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
