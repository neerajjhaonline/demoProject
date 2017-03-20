@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Edit User Access</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('userAccess.update',$recId->id) }}">
                   
                        {{ csrf_field() }}

                        {{ method_field('PATCH') }}

                        <div class="form-group{{ $errors->has('userAccess_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">User Access Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $recId->name or old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('loginId') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">window Login ID</label>
                            <div class="col-md-6">
                            <input id="loginId" type="text" class="form-control" name="loginId" value="{{  $recId->loginId or old('loginId') }}">
                                
                                @if ($errors->has('loginId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('loginId') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $recId->email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                         <div class="form-group {{ $errors->has('access_id') ? ' has-error' : '' }}">
                            <label for="access_id" class="col-md-4 control-label">Access</label>
                            <div class="col-md-6">
                                <select name="access_id" class="form-control">
                                  <option>Select</option>
                                  @foreach(App\Model\Access::all() as $access)
                                    <option value="{{$access->id}}" @if($recId->access_id == $access->id) selected @endif> {{$access->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('access_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('access_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Edit
                                </button>
                                <a href="{{ route('userAccess.index') }}" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
