@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User</div>
                <div class="panel-body">
                    {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}
                        {{ method_field('PUT') }}

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'Email address', ['class' =>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            {!! Form::label('phone', 'Phone number', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('phone') }}</small>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            {!! Form::label('role', 'User Role', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::select('role', [0 => 'Registered - No access', 1 => 'User - Can control units', 2 => 'Manager - Can modify units and users', 3 => 'Owner - Can create managers'], null, ['placeholder' => 'Pick a role...', 'class' => 'form-control', 'name' => 'role', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('role') }}</small>
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Save', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
                                <a href="{{ route('user.index') }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

@endpush


@push('scripts')

@endpush
