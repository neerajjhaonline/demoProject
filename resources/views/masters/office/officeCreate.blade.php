@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Create Office</div>
                <div class="panel-body">
                    @if(session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        {{session()->get('message')}}
                    </div>
                    @endif
                    @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{session()->get('error')}}
                    </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('office.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('office_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Office Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="office_name" value="{{ old('office_name') }}">

                                @if ($errors->has('office_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('office_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('office_address') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Office Address</label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control" name="office_address">{{ old('office_address') }}</textarea> 
                                @if ($errors->has('office_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('office_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Save
                                </button>
                                <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
