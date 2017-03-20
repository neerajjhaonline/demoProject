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
                        <table class="table table-responsive table-striped table-bordered table-hover no-margin" id="auditing_queue" >
                          <thead>
                            <tr  class="ciraHeader">
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
                             <th>Auditor</th>
                             <th>Audit Status</th>
                             <th>Audit start time</th>
                             <th>Audit end time</th>
                             <th>TAT Pending Hrs</th>
                             <th>OOT Remarks</th>
                             <th>Actual TAT</th>
                             <th>Comments</th>
                             <!-- <th style="width:5%; text-align:center">Action</th> -->
                           </tr>
                         </thead>
                         <tbody>
                         <?php $i=1; ?>
                         @foreach($auditings as $auditing)

                         <?php 
                                if(strtotime($auditing->publishingTat) > 0){
                                    $tat = calculateActualTat($auditing->publishingTat);
                                    $aTat = $auditing->publishingTat;
                                }
                                else{
                                    $tat = calculateActualTat($auditing->auditTat);
                                    $aTat = $auditing->auditTat;   
                                }

                         ?>
                           <tr @if($tat['h'] <= 3) class="danger" @endif>
                             <td>{{$i++}}</td>     
                             <td>{{date('W',strtotime($auditing->mail_received_dt))}}</td>
                             <td>
                               @if(in_array(Session::get('userAccess'),array('admin','superadmin','auditor'))  && $auditing->auditingId)
                                  <a href="{{route('auditing.edit',$auditing->auditingId)}}" class="btn btn-xs btn-danger">  
                                  {{$auditing->request_no or 'NA'}}
                                  </a>
                                @elseif(in_array(Session::get('userAccess'),array('admin','superadmin','user'))  && $auditing->processQueueID)
                                  <a href="{{route('publishing.edit',$auditing->processQueueID)}}" class="btn btn-xs btn-danger">
                                  {{$auditing->request_no or 'NA'}}
                                  </a>
                                @else
                                   {{$auditing->request_no or 'NA'}}    
                                @endif  
                             </td>
                             <td>{{$auditing->mail_received_dt  or 'NA'}}</td>
                             <td>{{$auditing->region or 'NA'}}</td>                     
                             <td>{{$auditing->container or 'NA'}}</td>                     
                             <td>{{$auditing->priority or 'NA'}}</td>
                             <td>{{$auditing->queryBy or 'NA'}}</td>
                             <td>{{$auditing->rfiName or 'NA'}}</td>
                             <td>{{$auditing->cust_name  or 'NA'}}</td> 
                             <td>{{$auditing->publishBy or 'NA'}}</td>
                             <td>{{$auditing->publishStatus or 'NA'}}</td>    
                             <td>{{$auditing->auditorName or 'NA'}}</td>
                             <td>{{$auditing->auditStatus or 'NA'}}</td>    
                             <td>{{$auditing->audit_start_dt or 'NA'}}</td>
                             <td>{{$auditing->audit_end_dt or 'NA'}}</td>
                             <td>{{$tat['h']}}:{{$tat['m']}}</td>
                             <td>{{$auditing->auditingRemark or $auditing->publishingRemark}}</td>
                             <td>{{$aTat or 'NA'}}</td>
                             <td>{{$auditing->auditingComment or $auditing->publishingComment}}</td>    
                             <!-- <td>
                                @if($auditing->auditingId)
                                <a href="{{route('auditing.edit',$auditing->auditingId)}}" class="btn btn-xs btn-danger">APF</a>
                                @elseif($auditing->processQueueID)
                                <a href="{{route('auditing.show',$auditing->processQueueID)}}" class="btn btn-xs btn-danger">UPF</a>
                                @endif
                             
                              @if($auditing->auditingId)
                                <button class="btn btn-xs btn-danger delete_po" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-url="{{route('auditing.destroy',$auditing->auditingId)}}">
                                <i class="fa fa-trash-o" style="font-size:18px"></i>
                                </button>
                               @elseif($auditing->processQueueID)
                               <button class="btn btn-xs btn-danger delete_po" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-url="{{route('auditing.destroy',$auditing->processQueueID)}}">
                                <i class="fa fa-trash-o" style="font-size:18px"></i>
                                </button>
                              @endif
                             </td> -->
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
           