{!! Form::model($device, ['route' => ['device.update', $device->id], 'method' => 'put', 'class' => 'form-horizontal', 'id' => 'form_edit_device']) !!}
	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" id="form_group_device_name">
		{!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'input_device_name']) !!}
			<small class="text-danger" id="error_device_name">{{ $errors->first('name') }}</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('site') ? ' has-error' : '' }} {{ $errors->has('new_site_name') ? ' has-error' : '' }}" id="form_group_site">
		{!! Form::label('site', 'Site', ['class' =>'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			@if ($sites)
				<select class="form-control" name="site" id="site">
					@if (!$locations)
						<option value="-1">Choose a site</option>
					@endif
					@foreach($sites as $site)
						<option value="{{ $site->id }}">{{ $site->name }}</option>
					@endforeach
					<option value="">Create new site</option>
				</select>
			@endif
			<input class="form-control" style="display: none" name="new_site_name" placeholder="eg: Sixth Street Greenhouse" id="new_site_name">
			<small class="text-danger" id="error_site">{{ $errors->first('site') }}{{ $errors->first('new_site_name') }}</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }} {{ $errors->has('new_location_name') ? ' has-error' : '' }}" id="form_group_location">
		{!! Form::label('location', 'Location', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			<select class="form-control" name="location" id="location">
				@if ($locations)
					@foreach($locations as $location)
						<option value="{{ $location->id }}">{{ $location->name }}</option>
					@endforeach
					<option value="">Create new location</option>
				@else
					<option value="">Choose a site first</option>
				@endif
			</select>
			<input class="form-control" style="display: none" name="new_location_name" placeholder="eg: Green House 1A" id="new_location_name">
			<small class="text-danger" id="error_location">{{ $errors->first('location') }}{{ $errors->first('new_location_name') }}</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('open_time') ? ' has-error' : '' }}" id="form_group_open_time">
		{!! Form::label('open_time', 'Open Time', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			<input class="form-control" required="required" name="open_time" type="time" value="{{ $device->open_time }}" id="open_time">
			<small class="text-danger" id="error_open_time">{{ $errors->first('open_time') }}</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('close_time') ? ' has-error' : '' }}" id="form_group_close_time">
		{!! Form::label('close_time', 'Close Time', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			<input class="form-control" required="required" name="close_time" type="time" value="{{ $device->close_time }}" id="close_time">
			<small class="text-danger" id="error_close_time">{{ $errors->first('close_time') }}</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('update_rate') ? ' has-error' : '' }}" id="form_group_update_rate">
		{!! Form::label('update_rate', 'Update Rate', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			{!! Form::number('update_rate', null, ['class' => 'form-control', 'required' => 'required']) !!}
			<small class="text-danger" id="error_update_rate">{{ $errors->first('update_rate') }}</small>
			<small class="text-info">Interval the device posts and gets configuration data in seconds.</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('image_rate') ? ' has-error' : '' }}" id="form_group_image_rate">
		{!! Form::label('image_rate', 'Image Rate', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			{!! Form::number('image_rate', null, ['class' => 'form-control', 'required' => 'required']) !!}
			<small class="text-danger" id="error_image_rate">{{ $errors->first('image_rate') }}</small>
			<small class="text-info">Interval the device posts images in seconds.</small>
		</div>
	</div>

	<div class="form-group{{ $errors->has('sensor_rate') ? ' has-error' : '' }}" id="form_group_sensor_rate">
		{!! Form::label('sensor_rate', 'Sensor Rate', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			{!! Form::number('sensor_rate', null, ['class' => 'form-control', 'required' => 'required']) !!}
			<small class="text-danger" id="error_sensor_rate">{{ $errors->first('sensor_rate') }}</small>
			<small class="text-info">Interval the device posts sensor data in seconds.</small>
		</div>
	</div>

	<div class="form-group" id="form_group_view_buttons_div">
		<div class="col-md-6 col-md-offset-4">
			{!! Form::button('<i class="glyphicon glyphicon-ok"></i> Save', array('type' => 'submit', 'class' => 'btn btn-info pull-right')) !!}
			<a href="{{ route('device.index') }}" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
		</div>
	</div>
{!! Form::close() !!}