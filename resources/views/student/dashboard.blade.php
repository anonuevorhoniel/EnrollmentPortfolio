@extends('student/layout')
@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-9">
    <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%; margin-right: -3%">
        <h5 class="col-12"  style=" text-align:left; padding: 2px; border-radius: 10px">Student/Profile</h5>

        @if ($errors->any())
@foreach ($errors->all() as $error)
<ul class="alert alert-danger" style="margin-top: -1%">{{$error}}</ul>
@endforeach
    
@endif
        @if (session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif
    <form action="{{route('create.content')}}" method="POST">
        @csrf
        <div class="form-group">
            <div class="updateprofile"><h3>Update Profile</h3></div>
            <div class="alert alert-success verifieddiv">Verified</div><br>
        <div class="row">
            <div class="col-6">
                <label for="">Name</label>
                <input type="text" class="form-control inp" name="name" id="" value="{{ isset($data) ? $data->name : null }}">
            </div>
            <div class="col-6">
                <label for="">Lastname</label>
                <input type="text" class="form-control inp" name="lastname" id="" value="{{isset($data) ? $data->lastname : null}}">
            </div>
        </div><br>
        <div class="row">
            <div class="col-2">
                <label for="">Age</label>
                <input type="number"  class="form-control inp" name="age" id="" value="{{isset($data) ? $data->age : null}}">
            </div>
            <div class="col-10">
                <label for="">Address</label>
                <input type="text" class="form-control inp" name="address" id="" value="{{isset($data) ? $data->address : null}}">
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <label for="">Religion</label>
                <input type="text" class="form-control inp" name="religion" id="" value="{{isset($data) ? $data->religion : null}}">
            </div>
            <div class="col-5">
                <label for="">Gender</label>
                <input type="text" class="form-control inp" name="gender" id="" value="{{isset($data) ? $data->gender : null}}">
            </div>
        </div><br><br>
        <div class="row">
            <div class="col-12"><button style="width: 30%" class="btn btn-success subsub">Submit</button></div>
        </div>
        </div>
    </form>
    </div>
</div>
<div class="col-3">
    <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; margin-left: 2%; border-radius: 7px; padding-bottom: 7%;">
        <br><img src="{{asset('profile.jpg')}}" alt="" style="width: 40%; height: 40%; border-radius: 100%"><br><br>
        <div class="row">
         <div class="col-12">
             <button class="btn btn-primary">Edit Picture</button>
         </div>
        </div>
        <div class="row">
         <div class="col-12" >
             <br>
         <p><b><a href="/dashboard" style="text-decoration: none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block" disabled>Profile</button></a></b></p>
     </div>
        </div>
        @if($info)
        <div class="row">
         <div class="col-12" style="margin-top: -2%; ">
         <a href="/subjects" style="text-decoration:none"><p><button style="border-left: 1px solid blue"  class="btn btn-light btn-block">Subjects</button></p></a>
     </div>
     </div>
     @else
     <div class="row">
        <div class="col-12" style="margin-top: -2%; ">
        <a href="/subjects" style="text-decoration:none"><p><button disabled style="border-left: 1px solid blue"  class="btn btn-light btn-block">Subjects</button></p></a>
    </div>
    </div>
    @endif
    @if($subjectscheck && $subjectscheck->count() > 0)
     <div class="row">
         <div class="col-12" style="margin-top: -2%; ">
         <p><a href="/review" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Review Subjects</button></a></p>
     </div>
     </div>
@else
<div class="row">
    <div class="col-12" style="margin-top: -2%; ">
    <p><a href="/review" style="text-decoration:none"><button disabled style="border-left: 1px solid blue" class="btn btn-light btn-block">Review Subjects</button></a></p>
</div>
</div>
@endif
@if($verified)
     <div class="row">
         <div class="col-12" style="margin-top: -2%;">
         <p><a href="/schedule" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Schedule</button></a></p>
     </div>
     </div>
     @else
     <div class="row">
        <div class="col-12" style="margin-top: -2%;">
        <p><a href="/schedule" style="text-decoration:none"><button disabled style="border-left: 1px solid blue" class="btn btn-light btn-block">Schedule</button></a></p>
    </div>
    </div>
    @endif
         </div>
   
    </div>
</div>
</div>
</center>
<script>
    $(function()
{
    $('.verifieddiv').hide();
    $.ajax({
        type: "GET",
        url: "/checkprofilever",
        success: function (response) {
            if(response.verified)
            {
                $('.subsub').prop('disabled', true)
                $('.inp').prop('disabled', true)
                $('.updateprofile').hide();
                $('.verifieddiv').show();
            }
        }
    });
})
  
</script>
<style>
    .inp
    {
        border-color: black;
    }
</style>
@endsection
