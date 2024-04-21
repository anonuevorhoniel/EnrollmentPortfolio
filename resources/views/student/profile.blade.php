@extends('student/layout')
@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-12">
    <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%;">
        <h3>Profile</h3>
        <img src="" style="width: 10%; height: 10%; border-radius: 100px" alt="No Picture yet"><br>
        <input type="file" name="" class="picinput" id="">
        <button class="btn btn-primary picturebtn">Add/Update Picture</button>
        <div class="filename"></div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" value="{{$users->name}}" class="form-control" name="" id="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" value="{{$users->email}}" class="form-control" name="" id="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password"  class="form-control" name="" id="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="text" class="form-control" name="" id="">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-success">Update</button>
            </div>
        </div>
<div class="row">
    <div class="col-4">Created At: {{$users->created_at}}</div>
</div>
<div class="row">
    <div class="col-4">Updated At: {{$users->updated_at}}</div>
</div>
    </div>
    </div>
</div>
</center>
<script>
$(function()
{
    $('.picinput').hide();
    $(document).on('click', '.picturebtn', function()
     {
     $('.picinput').click();
     });
     $(document).on('change', '.picinput', function()
    {
      var file = this.files[0];
    $('.filename').text(file.name);
    });
});
</script>
@endsection
