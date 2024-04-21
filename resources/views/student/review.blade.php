@extends('student/layout')

@section('title')
    <title>Subjects</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-9">
    <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%; margin-right: -3%; overflow-x: auto">
      <h5 class="col-12"  style=" text-align:left; padding: 2px; border-radius: 10px">Student/Review Subjects</h5>
      <br>
      
           
    <div class="alert alert-danger remove"><button type="button" class="close" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>Removed</div>
    <div class="alert alert-warning verifying">ⓘ For Verficiation</div>
    <div class="alert alert-danger denied">Verification Denied</div>
    <div class="alert alert-success verified  ">Verified</div>

        <table class="table table-bordered">
            <thead>
              <tr>					
                <th scope="col">Subject Name</th>
                <th scope="col">Schedule/Time</th>
                <th scope="col">Points</th>
                <th scope="col">Year Level</th>
                <th scope="col">Course</th>
                <th scope="col" class="action" colspan="2">Action</th>

              </tr>
            </thead>
            <tbody>
                @if($subjects->count() > 0)
                @foreach ($subjects as $subject)
              <tr>
                <td>{{$subject->subject_name}}</td>
                <td>{{$subject->schedule}}</td>
                <td>{{$subject->points}}</td>
                <td>{{$subject->year_level}}</td>
                <td>{{$subject->course}}</td>
                <td class="btn btn-success editbtn" 
                data-toggle="modal"
                data-target="#exampleModal"
                data-id="{{$subject->id}}"
                data-sub="{{$subject->subject_name}}"
                data-schedule ="{{$subject->schedule}}"
                data-points ="{{$subject->points}}"
                data-year = "{{$subject->year_level}}"
                data-course ="{{$subject->course}}"
                >Edit</td>
                <td class="btn btn-danger deletebtn" data-id="{{$subject->id}}" data-sub="{{$subject->subject_name}}">Delete</td>
              </tr>
              @endforeach
              @else
              <td colspan="6" style="text-align: center">NO SUBJECTS YET</td>
              @endif
            </tbody>
          </table>
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
     <p><b><a href="/dashboard" style="text-decoration: none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Profile</button></a></b></p>
 </div>
    </div>
    <div class="row">
     <div class="col-12" style="margin-top: -2%; ">
     <a href="/subjects" style="text-decoration:none"><p><button style="border-left: 1px solid blue"  class="btn btn-light btn-block">Subjects</button></p></a>
 </div>
 </div>
 <div class="row">
     <div class="col-12" style="margin-top: -2%; ">
     <p><a href="/review" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block" disabled>Review Subjects</button></a></p>
 </div>
 </div>
 <div class="row">
     <div class="col-12" style="margin-top: -2%;">
     <p><a href="/schedule" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Schedule</button></a></p>
 </div>
 </div>
     </div>
   
    </div>
</div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Subject Name</label>
                            <input type="email" class="form-control subject" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                          </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Schedule</label>
                            <input type="email" class="form-control schedule" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                          </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Points</label>
                            <input type="email" class="form-control points" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                          </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Year Level</label>
                            <input type="email" class="form-control year" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Course</label>
                            <input disabled type="email" class="form-control course" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                          </div>
                    </div>
                </div>
                          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
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
  $(function()
{
  $('.verifying').hide();
  $('.denied').hide();
  $('.verified').hide();
  $.ajax({
  type: "GET",
  url: "/checkverification",
  success: function (response) {
    if(response.verified)
    {
      $('.verified').show();
      $('.verifying').hide();
      $('.denied').hide();
      $('.deletebtn').hide();
      $('.action').hide();
    }
    if(response.unverified)
    {
      $('.verifying').show();
      $('.verified').hide();
      $('.denied').hide();
    }
    if(response.notverified)
    {
      $('.verifying').hide();
      $('.verified').hide();
      $('.denied').show();
    }
  }
});
    $('.remove').hide();
    $('.editbtn').hide();
$('.editbtn').on('click', function () {
  $id =  $(this).data('id');
  $subject =  $(this).data('sub');
  $schedule =  $(this).data('schedule');
  $points =  $(this).data('points');
  $year =  $(this).data('year');
  $course =  $(this).data('course');
var data = {
    'id' : $id,
    'subject' : $subject,
    'schedule' : $schedule,
    'points' : $points,
    'year' : $year,
    'course' : $course
}
$('.subject').val($subject);
$('.schedule').val($schedule);
$('.points').val($points);
$('.subject').val($subject);
$('.year').val($year);
$('.course').val($course);
console.log(data);
});

$('.deletebtn').on('click', function () {
    $id =  $(this).data('id');
    $subject =  $(this).data('sub');
    $row = $(this).closest('tr');
    if(confirm('Do you want to delete ' +  $subject + "?"))
    {
        $.ajax({
            type: "DELETE",
            url: "/deletesubject/" + $id,
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            success: function (response) {
                $('.remove').show();
        $row.remove();
            }
        });
    
    }
    else
    {

    }
});
$(document).on('click', '.close', function() {
    $(this).closest('div').hide();
});
})
</script>
@endsection
