@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Create Status</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('status.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('statusCatId') ? ' has-error' : '' }}">
                            <label for="statusCat_id" class="col-md-4 control-label">Status Category</label>
                            <div class="col-md-6">
                                <select name="statusCatId" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\StatusCat::all() as $pt)
                                    <option value="{{$pt->id}}" {{($pt->id == old('statusCatId')?'selected':'')}}>{{$pt->statusCat_name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('statusCatId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('statusCatId') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Status Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="status_name" value="{{ old('status_name') }}" onkeydown="upperCaseF(this);">
                                
                                @if ($errors->has('status_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status_name') }}</strong>
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
