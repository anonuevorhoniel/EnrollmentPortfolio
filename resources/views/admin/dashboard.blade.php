@extends('admin/layout')
@section('title')
    <title>Admin Dashboard</title>
@endsection
@include('sweetalert::alert')

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
    @if ($message = session('success'))
    <ul class="alert alert-success" style="margin-top: -1%">{{$message}}</ul>
    @endif
    
    <h3>Add Subjects</h3>
   <!-- <form method="POST" action="{{route('addSubjects')}}"> -->
     
        <div class="row">
            <div class="col-4">  
                <div class="form-group">
                <label for="exampleInputEmail1">Subject Name</label>
                <input type="text" name="subj_name" class="form-control subject" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
              </div>
            </div>
            <div class="col-4">  
                <div class="form-group">
                <label for="exampleInputEmail1">Schedule/Time</label>
                <input type="text" name="schedule" class="form-control schedule" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
              </div>
            </div>
            <div class="col-4">  
                <div class="form-group">
                <label for="exampleInputEmail1">Year</label>
                <select name="year_lvl" id="year_lvl" class="custom-select year">
                  <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                    <option value="Continuer">Continuer</option>
                </select>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleInputPassword1">Points</label>
                    <input type="number" class="form-control points" name="points" id="exampleInputPassword1" placeholder="">
                  </div>
                 
            </div>
            <div class="col-4">
              <div class="form-group">
                  <label for="exampleInputPassword1">Course</label>
                  <select  class="form-control course" name="course" id="exampleInputPassword1" placeholder="">
                    @if($course->count() < 1) 
                    <option value="">No Courses Yet</option>
                   @else
                   @foreach ($course as $item)
                   <option value="{{$item->courses}}">{{$item->courses}}</option>
                   @endforeach
                   @endif
                  </select>
                </div>
            </div>
        </div>
       
        <button class="btn btn-primary" id="sub">Submit</button>
    
            <br>
    <br>
   
           @if ($data->count() < 1)
           <h4>No Data</h4>
           @else

          
          <div class="alert alert-danger deletediv">Successfully Delete</div>
          <div class="alert alert-success addeddiv">Successfully Added</div>
          <div class="alert alert-warning updatediv">Successfully Updated</div>
          {{$data->links()}}
            <table class="table table-bordered tablesubject">
                <thead>
                  <tr>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Schedule/Time</th>
                    <th scope="col">Points</th>
                    <th scope="col">Year Level</th>
                    <th scope="col">Course</th>
                    <th colspan="2">Actions</th>
                  </tr>
                </thead>
                @endif
                <tbody>
                 @foreach ($data as $item)
                 <tr>
                  <td>{{$item->subj_name}}</td>
                  <td>{{$item->schedule}}</td>
                  <td>{{$item->points}}</td>
                  <td>{{$item->year_lvl}}</td>
                  <td>{{$item->course}}</td>
                  <td><button class="btn btn-warning edit" id="editmodal"
                    data-id = "{{$item->id}}"
                    data-name = "{{$item->subj_name}}"
                    data-sched = "{{$item->schedule}}"
                    data-sub = "{{$item->subj_name}}"
                    data-points = "{{$item->points}}"
                    data-year = "{{$item->year_lvl}}"
                    data-course = "{{$item->course}}"
                    data-toggle="modal" data-target="#exampleModal">Edit</button></td>
                  <td> <button class="btn btn-danger deleteBtn" data-id="{{$item->id}}">Delete</button></td>
                </tr>
                 @endforeach
                
                </tbody>
              </table>
          

  
  <!-- Modal Edit -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <div class="row">
                <div class="col-6">
                        <label for="">Subject Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="col-6">
                    <label for="">Schedule</label>
                    <input type="text" class="form-control sched" name="sched" id="sched">
            </div>
            </div>
            <div class="row">
                <div class="col-6"><br>
                        <label for="">Points</label>
                        <input type="text" class="form-control points" name="points" id="points">
                </div>
                <div class="col-6"><br>
                    <label for="">Year Level</label>
                    <select name="year_lvl" id="year_lvl" class="custom-select year">
                        <option value="1st Year">1st Year</option>
                          <option value="2nd Year">2nd Year</option>
                          <option value="3rd Year">3rd Year</option>
                          <option value="4th Year">4th Year</option>
                          <option value="Continuer">Continuer</option>
                      </select>
            </div>
            </div>
            <br>
            <div class="row">
              <div class="col-12">
                <label for="">Course</label>
                <select type="text" name="" id="course" class="form-control course">
                  @foreach ($course as $item)
                  <option value="{{$item->courses}}">{{$item->courses}}</option>
                  @endforeach
                </select>
              </div>
            </div>
       
        </div>  
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="savec">Save changes</button>
        </div>
      </div>
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
  $('.deletediv').hide();
  $('.updatediv').hide();
  $('.addeddiv').hide();
//get muna nasa data ng  button
    $id = $('.edit').data('id');

 $(document).on('click', '.edit',  function () {
$id = $(this).data('id');
$name = $(this).data('name');
$sched = $(this).data('sched');
$points = $(this).data('points');
$year = $(this).data('year');
$course = $(this).data('course');

$('.name').val($name);
$('#name').val($name);
$('#sched').val($sched);
$('#points').val($points);
$('.year').val($year);
$(".course").val($course)
});
$("#savec").on('click', function () {
    var name = $('#name').val();
    var sched = $('#sched').val();
    var points = $('#points').val();
    var year = $('.year').val(); 
    var course = $('#course').val();
    var data = {
        'id' : $id,
        'name' : name,
        'sched' : sched,
        'points' : points,
        'year' : year,
        'course' : course
    }
    console.log(data);
    $.ajax({
        type: "PUT",
        url: "/updatedata/" + $id,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            var $tableRow = $('button[data-id="' + $id + '"]').closest('tr');
            $tableRow.find('td:eq(0)').text(name);
            $tableRow.find('td:eq(1)').text(sched);
            $tableRow.find('td:eq(2)').text(points);
            $tableRow.find('td:eq(3)').text(year);
            $tableRow.find('td:eq(4)').text(course);
    $('#name').val(name);
    $('#sched').val(sched);
    $('#points').val(points);
    $('.year').val(year); 
    $('#course').val(course);
    var editBtn = $("button[data-id='"+ $id +"']");
    editBtn.data('name', name);
    editBtn.data('sched', sched);
    editBtn.data('points', points);
    editBtn.data('year', year);
    editBtn.data('course', course);
        },
        error: function (response) { 
            console.log(response);
        }
    });
});

$(document).on('click', '.deleteBtn', function (){
 var btn = $(this);
if(confirm('Do you want to delete this?'))
{
 $id = $(this).data('id');
  $.ajax({
    type: "DELETE",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    url: "/delete/" + $id,
    success: function (response) {
      console.log(response);
      btn.closest('tr').remove();
    }
  });
}
})
$("#sub").on('click', function () {
  var subject = $('.subject').val();
  var schedule = $('.schedule').val();
  var year = $('.year').val();
  var points = $('.points').val();
  var course = $('.course').val();

  var data = {
    'subj_name' : subject,
    'schedule' : schedule,
    'year_lvl' : year,
    'points' : points,
    'course' : course
  }
  console.log(data);
  $.ajax({
    type: "POST",
    url: "/addedsub",
    data: data,
    dataType: "json",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    success: function (response) {
      console.log(response.id);
      console.log(response.subject);
      console.log(response.schedule);
      console.log(response.points);
      console.log(response.year);
      console.log(response.course);
      $('.tablesubject tbody').prepend("<tr><td>"+ subject + "</td><td>"+ schedule + "</td><td>" + year + "</td><td>" + points + "</td><td>"+ course
        + "<td><button class='btn btn-warning edit' id='editmodal' data-id = '"+ response.id + "'" +
    "data-sched = '"+ response.schedule + "'" +
    "data-name = '"+ response.subject + "'" +
    "data-points = '"+ response.points + "'" +
    "data-year = '"+ response.year + "'" +
    "data-course = '"+ response.course + "'" +
    "data-toggle='modal' data-target='#exampleModal'>Edit</button></td>" + 
    "<td> <button class='btn btn-danger deleteBtn' data-id='"+ response.id+"'>Delete</button>" +
    "</td></tr>");
    }
  });
});
})
</script>
@endsection 
