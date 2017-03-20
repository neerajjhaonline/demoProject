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
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('indexing.update',$recId->id) }}" id="indexingEdit">
                   
                        {{ csrf_field() }}

                        {{ method_field('PATCH') }}

                        <input type="hidden" value="{{
                        \App\Model\RequestNumber::create()->id}}" name=requestNumberID id="requestNumberID">
                        <div class="form-group{{ $errors->has('mail_received_dt') ? ' has-error' : '' }}">
                           <label for="mail_received_dt" class="col-md-4 control-label">Mail Received Date & Time </label>
                          <div class="col-md-6">
                              <div id="datetimepicker2" class="input-group date">
                                <input name="mail_received_dt" data-format="MM/dd/yyyy HH:mm:ss PP" type="text" class="form-control" id="mail_received_dt_edit" data-url="{{url('reqNum')}}" value="{{$recId->mail_received_dt}}"></input>
                                <span class="input-group-addon add-on">
                                  <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                  </i>
                                </span>
                              </div>
                              @if ($errors->has('mail_received_dt'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mail_received_dt') }}</strong>
                                    </span>
                                @endif
                          </div>
                        </div>


                        <div class="form-group{{ $errors->has('request_no') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Request Number</label>
                            <div class="col-md-6">
                            <input id="request_no" type="text" class="form-control" name="request_no" value="{{ $recId->request_no or old('request_no') }}" readonly>
                                
                                @if ($errors->has('request_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('request_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cust_name') ? ' has-error' : '' }}">
                            <label for="cust_name" class="col-md-4 control-label">Customer Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="cust_name" value="{{ $recId->cust_name or old('cust_name') }}" style="text-transform: uppercase;" onkeydown="upperCaseF(this);">

                                @if ($errors->has('cust_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cust_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                         <div class="form-group {{ $errors->has('priority_id') ? ' has-error' : '' }}">
                            <label for="priority_id" class="col-md-4 control-label">Priority</label>
                            <div class="col-md-6">
                                <select name="priority_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\PriorityType::all() as $pt)
                                    <option value="{{$pt->id}}" {{($pt->id == $recId->priority_id || $pt->id == old('priority_id')?'selected':'')}}>{{$pt->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('priority_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('region_id') ? ' has-error' : '' }}">
                            <label for="access" class="col-md-4 control-label">Region</label>
                            <div class="col-md-6">
                                <select name="region_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\Region::all() as $region)
                                    <option value="{{$region->id}}" {{($region->id == $recId->region_id || $region->id == old('region_id')?'selected':'')}} >{{$region->region_abbr}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('region_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('req_type_id') ? ' has-error' : '' }}">
                            <label for="access" class="col-md-4 control-label">Request Type</label>
                            <div class="col-md-6">
                                <select name="req_type_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\RequestType::all() as $rq)
                                    <option value="{{$rq->id}}" {{($rq->id == $recId->req_type_id || $rq->id == old('req_type_id')?'selected':'')}}>{{$rq->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('req_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('req_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('cont_type_id') ? ' has-error' : '' }}">
                            <label for="cont_type_id" class="col-md-4 control-label">Container Type</label>
                            <div class="col-md-6">
                                <select name="cont_type_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\ContainerType::all() as $ct)
                                    <option value="{{$ct->id}}" {{($ct->id == $recId->cont_type_id || $ct->id == old('cont_type_id')?'selected':'')}}>{{$ct->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('cont_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cont_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('office_id') ? ' has-error' : '' }}">
                            <label for="office_id" class="col-md-4 control-label">Office</label>
                            <div class="col-md-6">
                                <select name="office_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\Office::all() as $off)
                                    <option value="{{$off->id}}" {{($off->id == $recId->office_id || $off->id == old('office_id')?'selected':'')}}>{{$off->office_name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('office_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('office_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(Session::get('userAccess') == 'admin')
                        <div class="form-group {{ $errors->has('indexed_by') ? ' has-error' : '' }}">
                            <label for="indexed_by" class="col-md-4 control-label">Indexed By</label>
                            <div class="col-md-6">
                                <select name="indexed_by" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\UserAccess::all() as $user)
                                    <option value="{{$user->id}}" {{($user->id == $recId->indexed_by || $user->id == old('indexed_by')?'selected':'')}}>{{$user->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('indexed_by'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('indexed_by') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Save
                                </button>
                                <a href="{{ route('indexing.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
