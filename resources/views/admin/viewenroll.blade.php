@extends('admin/layout')
@section('title')
    <title>Admin Dashboard</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-12">
        <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%;">
            @if ($errors->any())
    @foreach ($errors->all() as $error)
    <ul class="alert alert-danger" style="margin-top: -1%">{{$error}}</ul>
    @endforeach
        
    @endif
    <br>      
    <h3>View Enrollees</h3>
            <br>
    <br>
   
           <div class="row">
            <div class="col-6">
              <h5>Pending Employees</h5><br>
              <table class="table table-bordered ">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Subject</th>
                    <th colspan="3" style="width: 10%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td><button  class="btn btn-primary">View</button></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->address}}</td>
                    <td><button  class="btn btn-success acceptbtn">Accept</button></td>
                    <td><button class="btn btn-warning">Edit</button></td>
                    <td> <button class="btn btn-danger">Remove</button></td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
            
           </div>
          
        </div>
</div>

</div>
</div>
</center>
<style>
    .inp
    {
        border-color: black;
    }
</style>
<script>
  $(function (){
    $('.acceptbtn').on('click', function () {
      $.ajax({
        type: "POST",
        url: "/acceptstudent",
        success: function (response) {
          
        }
      });
    });
  })
</script>
@endsection
