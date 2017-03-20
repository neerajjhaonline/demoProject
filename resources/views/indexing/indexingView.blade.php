@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                        <b>ALL INDEXING</b>
                        <a accesskey="N" href="{{ route('indexing.create') }}" class="btn btn-primary pull-right" id="indexingCreate">Create</a>    
                   
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
                        <table class="table table-responsive table-striped table-bordered table-hover no-margin">
                          <thead>
                            <tr>
                             <th style="width:1%">Sr. No.</th>     
                             <th>Mail received Date & Time</th>
                             <th style="width:5%">Deadline/Time Remaining({{timeZone}})</th>
                             <th>Request No.</RP></th>
                             <th>Customer Name</th>
                             <th>Priority</th>                     
                             <th>Region</th>
                             <th>Office</th>
                             <th>Request Type</th>
                             <th>Container Type</th>
                             <th colspan="2" style="width:5%; text-align:center">Action</th>
                           </tr>
                         </thead>
                         <tbody>
                         <?php $i=1; ?>
                         @foreach($indexings as $indexing)

                         <?php 
                                
                                $tat = calculateActualTat($indexing->tat_after_index);

                          ?>


                           <tr @if($tat['h'] <= 3) class="danger" @endif>
                             <td>{{$i++}}</td>     
                             <td>{{$indexing->mail_received_dt}}</td>
                             <td>{{$indexing->tat_after_index}} / {{$tat['h']}}:{{$tat['m']}}</td>
                             <td>{{$indexing->request_no}}</td>
                             <td>{{$indexing->cust_name}}</td>                     
                             <td>{{$indexing->priority->name}}</td>                     
                             <td>{{$indexing->region->name}}</td>
                             <td>{{$indexing->office->office_name}}</td>
                             <td>{{$indexing->requestType->name}}</td>
                             <td>{{$indexing->containerType->name}}</td>                     
                             <td><a href="{{route('indexing.edit',$indexing->id)}}" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i></a></td>
                             <td>
                                <button class="btn btn-xs btn-danger delete_po" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-url="{{route('indexing.destroy',$indexing->id)}}">
                                <i class="fa fa fa-trash-o" ></i>
                                </button>
                             </td>
                           </tr>
                         @endforeach
                         </tbody>
                      </table>
                   </div>
                    {!! $indexings->render() !!}
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

           