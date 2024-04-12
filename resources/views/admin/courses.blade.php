@extends('admin/layout')
@section('title')
    <title>Admin Dashboard</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-12">
        <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%;">
 <br><h3>Add Course</h3>
<br>
        <input type="text" style="border: 1px solid black; width: 50%" class="form-control addCourse" name="" id=""><br>
    <button class="btn btn-success addCourseBtn">Add Course</button>
<br>
<table class="table table-bordered ">
    <thead>
      <tr>
      
        <th scope="col" >Course</th>
        <th style="width: 20%" colspan="2">Actions</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($data as $item)

      <tr>
        <td>{{$item->courses}}</td>
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
</center>

<style>
    .inp
    {
        border-color: black;
    }
</style>
<script>
$(function() {
$('.addCourseBtn').on('click', function (){
   $course = $('.addCourse').val();
   $.ajax({
    type: "POST",
    url: "/addcourse",
    data: {'courses' : $course},
    dataType: "json", 
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
        console.log(response);
    },
    error: function(response)
    {
        console.log(response);
    }
   });
});
})
</script>
@endsection
