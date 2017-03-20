@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Edit Holiday</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('holiday.update',$holidayData->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Holiday Name</label>
                             <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $holidayData->name or old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('holiday_date') ? ' has-error' : '' }}">
                            <label for="holiday_date" class="col-md-4 control-label">Holiday Date</label>
                            <div class="col-md-6">
                               <input id="holiday_date" type="text" class="form-control datepicker" name="holiday_date" value="{{ date('d-m-Y',strtotime($holidayData->holiday_date))}}">
                                @if ($errors->has('holiday_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('holiday_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('office_id') ? ' has-error' : '' }}">
                            <label for="office_id" class="col-md-4 control-label">Office</label>
                            <div class="col-md-6">
                                <select name="office_id" class="form-control">
                                  <option value="">Select</option> 
                                  @foreach(App\Model\Office::all() as $office)
                                    @if($office->id==$holidayData->office_id)
                                      <option value="{{$office->id}}" selected>{{$office->office_name}}</option>
                                    @else
                                      <option value="{{$office->id}}">{{$office->office_name}}</option>
                                    @endif
                                  @endforeach 
                                </select>
                                @if ($errors->has('office_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('office_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Update
                                </button>
                                <a href="{{ route('holiday.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
