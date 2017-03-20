@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">
                        All User Accesss
                        <a href="{{ route('userAccess.create') }}" class="btn btn-primary pull-right">Create</a>    
                   
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
                             <th>Serial No.</th>     
                             <th>User Access Name</th>
                             <th>Window Login ID</th>
                             <th>Access</th>                     
                             <th>Email</th>
                             <th colspan="2" style="width:10%; text-align: center">Action</th>
                           </tr>
                         </thead>
                         <tbody>
                         <?php $i=1; ?>
                         @foreach(\App\Model\UserAccess::paginate(15) as $userAccess)
                           <tr>
                             <td>{{$i++}}</td>     
                             <td>{{$userAccess->name}}</td>
                             <td>{{$userAccess->loginId}}</td>                     
                             <td>{{$userAccess->access->name}}</td>                     
                             <td>{{$userAccess->email}}</td>                     
                             <td><a href="{{route('userAccess.edit',$userAccess->id)}}" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i></a></td>
                             <td>
                                <button class="btn btn-xs btn-danger delete_po" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-url="{{route('userAccess.destroy',$userAccess->id)}}">
                                <i class="fa fa fa-trash-o" ></i>
                                </button>
                             </td>
                           </tr>
                         @endforeach
                         </tbody>
                      </table>
                   </div>
                    {!! \App\Model\UserAccess::paginate(15)->render() !!} 
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

           