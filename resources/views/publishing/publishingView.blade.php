@extends('layouts.master')
 @section('styles')
       <link rel="stylesheet" href="{{ asset ('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css') }}">
    @endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                       <div class="col-md-8"> 
                        <b>ALL Publishing</b>
                       </div>
                       <!-- <div class="col-md-4">
                          <div class="form-group">
                            <label for="status_id" class="col-md-2 control-label">Data</label>
                            <div class="col-md-6">
                                <select name="status_id" class="form-control">
                                  <option value="">Select Data</option>
                                    <option value="Live Data">Live Data</option>
                                    <option value="All Data">All Data</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                     <div class="clearfix"></div>
                </div>
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
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped table-bordered table-hover no-margin" id="publishing_queue" >
                          <thead>
                            <tr class="ciraHeader">
                             <th style="width:1%">Sr. No.</th>     
                             <th>Week</th>
                             <th>Request No.</th>
                             <th>Request received Date & Time</th>
                             <th>Region</th>
                             <th>Container Type</th>
                             <th>Priority</th>
                             <th>RFI Raised By</th>                     
                             <th>RFI Type</th>
                             <th>Account Name</th>
                             <th>Publisher</th>
                             <th>Publish Status</th>
                             <th>Publish start time</th>
                             <th>Publish end time</th>
                             <th>TAT Pending Hrs</th>
                             <th>OOT Remarks</th>
                             <th>Actual TAT</th>
                             <th>Comments</th>
                             @if(Session::get('userAccess') === 'admin' && $publishing->processQueueID)
                             <th style="width:5%; text-align:center">Action</th>
                             @endif
                           </tr>
                         </thead>
                         <tbody>
                         <?php $i=1; ?>
                         @foreach($publishings as $publishing)

                         <?php 
                                if(strtotime($publishing->tat) > 0){
                                    $tat = calculateActualTat($publishing->tat);
                                    $aTat = $publishing->tat;
                                }
                                else{
                                    $tat = calculateActualTat($publishing->tat_after_index);
                                    $aTat = $publishing->tat_after_index;   
                                }

                         ?>
                           <tr @if($tat['h'] <= 3) class="danger" @endif>
                             <td>{{$i++}}</td>     
                             <td>{{date('W',strtotime($publishing->mail_received_dt))}}</td>
                             <td>
                                @if((Session::get('userAccess') === 'admin' || Session::get('userAccess') === 'superadmin') && $publishing->processQueueID)
                                  <a href="{{route('publishing.edit',$publishing->processQueueID)}}" class="btn btn-xs btn-danger abc" >{{$publishing->request_no or 'NA'}}</a>
                                @elseif(!$publishing->processQueueID)  
                                  <a href="{{route('publishing.show',$publishing->id)}}" class="btn btn-xs btn-danger">{{$publishing->request_no or 'NA'}}</a>
                                @else
                                   {{$publishing->request_no or 'NA'}} 
                                @endif  
                             </td>
                             <td>{{$publishing->mail_received_dt  or 'NA'}}</td>
                             <td>{{$publishing->region->name or 'NA'}}</td>                     
                             <td>{{$publishing->containerType->name or 'NA'}}</td>                     
                             <td>{{$publishing->priority->name or 'NA'}}</td>
                             <td>{{$publishing->queryBy or 'NA'}}</td>
                             <td>{{$publishing->rfiName or 'NA'}}</td>
                             <td>{{$publishing->cust_name  or 'NA'}}</td> 
                             <td>{{$publishing->publishBy or 'NA'}}</td>
                             <td>{{$publishing->status_name or 'NA'}}</td>    
                             <td>{{$publishing->publish_start_dt or 'NA'}}</td>
                             <td>{{$publishing->publish_end_dt or 'NA'}}</td>
                             <td>{{$tat['h']}}:{{$tat['m']}}</td>
                             <td>{{$publishing->oot_remark or 'NA'}}</td>
                             <td>{{$aTat or 'NA'}}</td>
                             <td>{{$publishing->comment or 'NA'}}</td>    
                             @if(Session::get('userAccess') === 'admin' && $publishing->processQueueID) 
                             <td>
                                <button class="btn btn-xs btn-danger delete_po" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-url="{{route('publishing.destroy',$publishing->processQueueID)}}">
                                <i class="fa fa-trash-o" style="font-size:18px"></i>
                                </button>
                             </td>
                             @endif 
                           </tr>
                         @endforeach
                         </tbody>
                      </table>
                   </div>
                   
                </div>
                <div class="panel-footer">
                  <span class="label label-danger">Note: TAT remaining 3 hrs. are in red color background</span> 
                </div>
                
            </div>                    
        </div>
    </div>
</div>

@endsection


<!-- modal start  -->
 <form action="" method="post" id="confirm">
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Delete Parmanently</h4>
      </div>
     
         {{ csrf_field() }}
         {{ method_field('DELETE') }}
          <div class="modal-body">
            <p>Are you sure you want to delete this?</p>
          </div>
      
      <div class="modal-footer">
      <input type="hidden" class="route_url">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-default">Delete</a>
      </div>
    </div>
   </div>
  </div>
  </form>
<!-- modal end -->
@section('script')
   <script src="{{ asset ('/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset ('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
   <script>
       $(function () {
          $("#publishing_queue").DataTable();
       });
   </script>
@endsection<!-- modal end -->
           