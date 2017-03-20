@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Create Status Category</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('statusCat.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('statusCat_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Status Category Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="statusCat_name" value="{{ old('statusCat_name') }}">
                                
                                @if ($errors->has('statusCat_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('statusCat_name') }}</strong>
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
