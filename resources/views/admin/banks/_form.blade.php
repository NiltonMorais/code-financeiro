@include('errors._error_field')
<?php  $errorClass = $errors->first('name') ? ['class'=>'validate invalid'] : []; ?>
<div class="row">
    <div class="input-field">
        {!! Form::text('name', null, $errorClass) !!}
        {!! Form::label('name','Nome',['data-error' => $errors->first('name')]) !!}
    </div>
    <div class="input-field file-field">
        <div class="btn">
            <span>Logo</span>
            {!! Form::file('logo') !!}
        </div>
        <div class="file-path-wrapper">
            <input type="text" class="file-path"/>
        </div>
    </div>
</div>