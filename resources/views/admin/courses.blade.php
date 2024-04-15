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
    <button class="btn btn-success addCourseBtn">Add Course</button><br>
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
        <td><button class="btn btn-warning editbtn" data-target="#exampleModal" data-toggle="modal" data-id="{{$item->id}}" data-course="{{$item->courses}}">Edit</button></td>
        <td> <button class="btn btn-danger">Remove</button></td>
      </tr>
            
      @endforeach
      
    </tbody>
  </table>
        </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <label for="">Course</label>
       <input type="text" class="form-control courseinp" name="" id="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary savebtn" data-dismiss="modal">Save changes</button>
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
$(function() {
  var id;
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
$('.editbtn').on('click', function(){
id = $(this).data('id');
 var course = $(this).data('course');
  $('.courseinp').val(course);
});

$('.savebtn').on('click', function () {
 var course = $('.courseinp').val();
 $.ajax({
  type: "PUT",
  url: "/editcourse/" + id,
  data: {'course' : course},
  dataType: "json",
  headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  success: function (response) {
    
    alert('success');
  }
 });
});
})
</script>
@endsection
