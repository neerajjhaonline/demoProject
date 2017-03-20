@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Create Commodity</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('commodity.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">Commodity Category</label>
                            <div class="col-md-6">
                                <select name="type" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Acceptable" {{(old('type') === 'Acceptable' ? 'selected':'')}}>Acceptable</option>
                                  <option value="Not Acceptable" {{(old('type') === 'Not Acceptable' ? 'selected':'')}}>Not Acceptable</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('commodity_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Commodity Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="commodity_name" value="{{ old('commodity_name') }}">
                                
                                @if ($errors->has('commodity_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('commodity_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}">
                                
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
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
