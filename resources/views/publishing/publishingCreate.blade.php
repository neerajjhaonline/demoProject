@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Create Publishing</div>
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

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('publishing.store') }}" autocomplete="off" id="publishing">
                        {{ csrf_field() }}
                        
                        <input type="hidden" name="indexing_id" value="{{$indexing->id or ''}}">
                        <input type="hidden" name="priorityHrs" value="{{$indexing->tat->tat_time or ''}}">
                        <?php date_default_timezone_set('Asia/Kolkata'); ?>

                        <input type="hidden" name="publish_start_dt" value="{{date('Y-m-d H:i:s')}}">
                        
                        <div class="form-group{{ $errors->has('mail_received_dt') ? ' has-error' : '' }}">
                           <label for="mail_received_dt" class="col-md-4 control-label">Mail Received Date & Time </label>
                          <div class="col-md-6">
                              <div id="datetimepicker2" class="input-group date">
                                <input name="mail_received_dt" data-format="MM/dd/yyyy HH:mm:ss PP" type="text" class="form-control" value="{{$indexing->mail_received_dt}}"></input>
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
                            <input type="text" class="form-control" name="request_no" value="{{ $indexing->request_no or old('request_no') }}" readonly>
                                
                                @if ($errors->has('request_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('request_no') }}</strong>
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
                                    <option value="{{$rq->id}}" {{($rq->id == $indexing->req_type_id || $rq->id == old('req_type_id')?'selected':'')}}>{{$rq->name}}</option>
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
                                    <option value="{{$ct->id}}" {{($ct->id == $indexing->cont_type_id ||  $ct->id == old('cont_type_id')?'selected':'')}}>{{$ct->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('cont_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cont_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('user_id') ? ' has-error' : '' }}">
                            <label for="user_id" class="col-md-4 control-label">User Name</label>
                            <div class="col-md-6">
                                <select name="user_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\UserAccess::all() as $access)
                                    <option value="{{$access->id}}" {{($access->id == Session::get('userId') ||  $access->id == old('user_id')?'selected':'')}}>{{$access->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                            <label for="status_id" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                                <select name="status_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\Status::all() as $status)
                                    <option value="{{$status->id}}" {{($status->id == old('status_id') || strtoupper($status->status_name) === 'IN PROCESS' ?'selected':'')}} >{{$status->status_name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('status_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('total_lane') ? ' has-error' : '' }}">
                            <label for="cust_name" class="col-md-4 control-label">Total Lanes</label>

                            <div class="col-md-6">
                                <input id="total_lane" type="number" class="form-control" name="total_lane" value="{{ old('total_lane') }}" min=1>

                                @if ($errors->has('total_lane'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('total_lane') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('no_of_lane') ? ' has-error' : '' }}">
                            <label for="no_of_lane" class="col-md-4 control-label">No. of Inlands</label>

                            <div class="col-md-6">
                                <input id="no_of_lane" type="number" class="form-control" name="no_of_lane" value="{{ old('no_of_lane') }}" min=1>

                                @if ($errors->has('no_of_lane'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no_of_lane') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mode_id') ? ' has-error' : '' }}">
                            <label for="mode_id" class="col-md-4 control-label">Modes</label>
                            <div class="col-md-6 row">
                                    <?php $k = 0;?>
                                    @foreach(App\Model\Mode::all() as $mode)
                                    <div class="col-md-6">    
                                        <div class="input-group">
                                          <span class="input-group-addon">
                                            <input type="checkbox" value="{{$mode->id}}" name="mode_id[]" {{(count(old('mode_id'))>0 && in_array($mode->id,old('mode_id'))?'checked':'')}} >
                                          </span>
                                            <label class="form-control">{{$mode->name}}</label>
                                        </div><!-- /input-group -->
                                    </div>
                                    <?php $k++ ?>
                                   @endforeach
                                

                                @if ($errors->has('mode_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mode_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('region_id') ? ' has-error' : '' }}">
                            <label for="access" class="col-md-4 control-label">Region</label>
                            <div class="col-md-6">
                                <select name="region_id" class="form-control">
                                  <option>Select</option>
                                  @foreach(App\Model\Region::all() as $region)
                                    <option value="{{$region->id}}" {{($indexing->region_id == $region->id|| $region->id == old('region_id')?'selected':'')}} >{{$region->region_abbr}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('region_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('commodity_id') ? ' has-error' : '' }}">
                            <label for="commodity_id" class="col-md-4 control-label">Commodity</label>
                            <div class="col-md-6">
                                <select name="commodity_id" class="form-control">
                                  <option value=null>Select</option>
                                  @foreach(App\Model\Commodity::where('type','Acceptable')->get() as $com)
                                    <option value="{{$com->id}}" {{($com->id == old('commodity_id') ?'selected':'')}} >{{$com->commodity_name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('commodity_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('commodity_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        
                        

                        <div class="form-group {{ $errors->has('rfiType_id') ? ' has-error' : '' }}">
                            <label for="access" class="col-md-4 control-label">RFI Type</label>
                            <div class="col-md-6">
                                <select name="rfiType_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\RfiType::all() as $rfi)
                                    <option value="{{$rfi->id}}" {{($rfi->id == old('rfiType_id')?'selected':'')}} >{{$rfi->rfiType_name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('region_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('rfi_description') ? ' has-error' : '' }}">
                            <label for="rfi_description" class="col-md-4 control-label">RFI Description</label>

                            <div class="col-md-6">
                                <textarea id="rfi_description" class="form-control" name="rfi_description">{{old('rfi_description')}}</textarea>

                                @if ($errors->has('rfi_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rfi_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('query_raised_by') ? ' has-error' : '' }}">
                            <label for="query_raised_by" class="col-md-4 control-label">Query Raised By</label>
                            <div class="col-md-6">
                                <select name="query_raised_by" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\UserAccess::all() as $access)
                                    <option value="{{$access->id}}" {{($access->id == Session::get('userId') || $access->id == old('error_cat_id')?'selected':'')}}>{{$access->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('query_raised_by'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('query_raised_by') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                 @if($indexing->requestType->name === 'COR')
                    <div id="correctionBlock"><!-- if Indexing is COR then correction ====== this block starts here -->
                        
                        <div class="form-group {{ $errors->has('error_cat_id') ? ' has-error' : '' }}">
                            <label for="error_cat_id" class="col-md-4 control-label">Error type</label>
                            <div class="col-md-6">
                                <select name="error_cat_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\ErrorCat::all() as $errCat)
                                    <option value="{{$errCat->id}}" {{($errCat->id == old('error_cat_id')?'selected':'')}} >{{$errCat->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('error_cat_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('error_cat_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group {{ $errors->has('error_type_id') ? ' has-error' : '' }}">
                            <label for="error_type_id" class="col-md-4 control-label">Error description</label>
                            <div class="col-md-6">
                                <select name="error_type_id" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\ErrorType::all() as $errType)
                                    <option value="{{$errType->id}}" {{($errType->id == old('error_type_id')?'selected':'')}} >{{$errType->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('error_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('error_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('root_cause') ? ' has-error' : '' }}">
                            <label for="root_cause" class="col-md-4 control-label">Root Cause Analysis</label>

                            <div class="col-md-6">
                                <textarea id="root_cause" class="form-control" name="root_cause">{{old('root_cause')}}</textarea>

                                @if ($errors->has('root_cause'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('root_cause') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('correction') ? ' has-error' : '' }}">
                            <label for="correction" class="col-md-4 control-label">Correction</label>

                            <div class="col-md-6">
                                <textarea id="correction" class="form-control" name="correction">{{old('correction')}}</textarea>

                                @if ($errors->has('correction'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('correction') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('corrective_action') ? ' has-error' : '' }}">
                            <label for="corrective_action" class="col-md-4 control-label">Corrective Action</label>

                            <div class="col-md-6">
                                <textarea id="corrective_action" class="form-control" name="corrective_action">{{old('corrective_action')}}</textarea>

                                @if ($errors->has('corrective_action'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('corrective_action') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('preventive_action') ? ' has-error' : '' }}">
                            <label for="preventive_action" class="col-md-4 control-label">Preventive Action</label>

                            <div class="col-md-6">
                                <textarea id="preventive_action" class="form-control" name="preventive_action">{{old('preventive_action')}}</textarea>

                                @if ($errors->has('preventive_action'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('preventive_action') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('proposed_comp_dt') ? ' has-error' : '' }}">
                           <label for="proposed_comp_dt" class="col-md-4 control-label">Proposed Completion Date & Time </label>
                          <div class="col-md-6">
                              <div class="input-group date">
                                <input name="proposed_comp_dt" data-format="MM/dd/yyyy HH:mm:ss PP" type="text" class="form-control" id="proposed_comp_dt"></input>
                                <span class="input-group-addon add-on">
                                  <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                  </i>
                                </span>
                              </div>
                              @if ($errors->has('proposed_comp_dt'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('proposed_comp_dt') }}</strong>
                                    </span>
                              @endif
                          </div>
                        </div>

                        <div class="form-group{{ $errors->has('proposed_act_dt') ? ' has-error' : '' }}">
                           <label for="proposed_act_dt" class="col-md-4 control-label">Actual Completion Date & Time </label>
                          <div class="col-md-6">
                              <div class="input-group date">
                                <input name="proposed_act_dt" data-format="MM/dd/yyyy HH:mm:ss PP" type="text" class="form-control" id="proposed_act_dt"></input>
                                <span class="input-group-addon add-on">
                                  <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                  </i>
                                </span>
                              </div>
                              @if ($errors->has('proposed_act_dt'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('proposed_act_dt') }}</strong>
                                    </span>
                              @endif
                          </div>
                        </div>    

                        <div class="form-group {{ $errors->has('error_done_by') ? ' has-error' : '' }}">
                            <label for="error_done_by" class="col-md-4 control-label">Error Done By</label>
                            <div class="col-md-6">
                                <select name="error_done_by" class="form-control">
                                  <option value="">Select</option>
                                  @foreach(App\Model\UserAccess::all() as $access)
                                    <option value="{{$access->id}}">{{$access->name}}</option>
                                  @endforeach  
                                </select>
                                @if ($errors->has('error_done_by'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('error_done_by') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                    </div><!-- if Indexing is COR then correction ====== this block ends here -->
                @endif

                    <div class="form-group{{ $errors->has('oot') ? ' has-error' : '' }}">
                            <label for="tat" class="col-md-4 control-label">Out of TAT</label>

                            <div class="col-md-6">
                                
                                <input type="checkbox" value="1" name="oot" {{ (old('oot') == '1' ? 'checked':'')}} >

                                @if ($errors->has('oot'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oot') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('oot_remarkcomment') ? ' has-error' : '' }}">
                            <label for="oot_remark" class="col-md-4 control-label">OOT remark</label>

                            <div class="col-md-6">
                                <input id="oot_remark" type="type" class="form-control" name="oot_remark" value="{{ old('oot_remark') }}">

                                @if ($errors->has('oot_remark'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oot_remark') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                            <label for="comment" class="col-md-4 control-label">Comment</label>

                            <div class="col-md-6">
                                <input id="ootcomment_commentremark" type="type" class="form-control" name="comment" value="{{ old('comment') }}">

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Save
                                </button>
                                <a href="{{ route('publishing.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
