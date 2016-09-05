
{!! Form::open(['route' => 'mark.store']) !!}
<input type="text" name="exam_id" value="" class="exam_id" hidden>
<table class="table table-striped text-center" style="width: 50%; margin: auto; border: 1px solid #000; table-layout: fixed;">
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
                <input type="text" pattern="[0-9]{0,3}" name="markof[<?=$id?>]" class="form-control">
                </div>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="2">{!! Form::submit('Submit',array('class'=>'btn btn-primary')) !!}</td>
        </tr>
    </tbody>
</table>
{!! Form::close() !!}
