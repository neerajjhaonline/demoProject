@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Create RFI Type</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('rfiType.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('rfiType_name') ? ' has-error' : '' }}">
                            <label for="rfiType_name" class="col-md-4 control-label">RFI Type Name</label>

                            <div class="col-md-6">
                                <input id="rfiType_name" type="text" class="form-control" name="rfiType_name" value="{{ old('rfiType_name') }}">

                                @if ($errors->has('rfiType_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rfiType_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Save
                                </button>
                                <a href="{{ route('rfiType.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
