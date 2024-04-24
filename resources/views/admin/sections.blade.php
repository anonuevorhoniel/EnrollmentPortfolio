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
    <h5 class="col-12"  style=" text-align:left; padding: 2px; border-radius: 10px">Admin/Sections</h5>
   <div><!--Add Section section-->
    <div class="input-group mb-3" style="width: 80%">
        <select name="" class="form-control courseselect" style="width: 20%" id="">
            <option value="" selected disabled>Select Course</option>
            @if($courses->count() > 0)
            @foreach ($courses as $course)
            <option value="{{$course->courses}}">{{$course->courses}}</option>
            @endforeach
            @else
            <option value="">No Courses</option>
            @endif
        </select>
        <select name="" id="" class="form-control selectyear">
            <option value="">Select Year Level</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>

        </select>
        <input type="text" name="" placeholder="Section to be Added" class="form-control addsection" style="width: 20%"  id="">   
        <div class="input-group-append">
          <button class="btn btn-outline-success addbtn" type="button">+ Add Section/s</button>
        </div>
      </div>    
      <!--CHECKBOXES-->
      <label for="">Check 20</label>
      <input type="checkbox" name="" id="">
      <label for=""  style="margin-left: 5%">Check 30</label>
      <input type="checkbox" name="" id="">
      <label for=""  style="margin-left: 5%">Check 50</label>
      <input type="checkbox" name="" id="">

      <ul class="alert alert-success added">Section Added</ul>
  <table class="table table-bordered table-hover table-striped tablesection">
    <thead>
        <th></th>
        <th>Name</th>
        <th>Lastname</th>
        <th>Course</th>
        <th>Year Level</th>
       
    </thead>
    <tbody>
        @if($accept->count() > 0)
        @foreach ($accept as $accepted)
            <tr class="rows"><td><input type="checkbox" class="checkdata"
                data-user_id="{{$accepted->student_id}}"
                data-name="{{$accepted->name}}"
                data-lastname="{{$accepted->lastname}}"
                data-course="{{$accepted->course}}"
                data-year="{{$accepted->year_level}}"
                name="" id=""></td><td>{{$accepted->name}}</td><td>{{$accepted->lastname}}</td><td>{{$accepted->course}}</td>
            <td>{{$accepted->year_level}}</td></tr>
        @endforeach
        @else
        <tr><td colspan="5" style="text-align: center">No Students</td></tr>
        @endif
    </tbody>
  </table>
</div>
<!--End of Add Section section-->
<br>

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
    $('.save').hide();
$(function()
{
    $('.added').hide();
    $(document).on('click','.rows', function()
{
$checking = $(this).find('input[type="checkbox"]');
$checking.prop('checked', function(x, y){
return !y;
});
var name = $($checking).data('name');
var lastname = $($checking).data('lastname');
var course = $($checking).data('course');
var year = $($checking).data('year');

var data = {
    'name' : name,
    'lastname' : lastname,
    'course' : course,
    'year' : year
}

});

$('.courseselect').on('change', function (){
  
    $selectyear = $('.selectyear').val();
   $value = $(this).val();
   $.ajax({
    type: "GET",
    url: "/getcourses",
    data: {'courses' : $value,
            'year' : $selectyear
        },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
   $('.tablesection tbody').empty();

        if(response.length > 0)
       { response.forEach(course => { //forEach(function(course)) talaga dapat yan baka malito ako
            $('.tablesection tbody').append('<tr class="rows"><td><input type="checkbox" class="checkdata" data-user_id="'+ course.student_id +'"' + 
             'data-name="'+course.name+'" data-lastname = "'+ course.lastname+'" data-course="'+ course.course +'" data-year="'+course.year_level+'" name="" id=""></td><td>' + course.name + '</td><td>' + course.lastname +
            '</td><td>' + course.course + '</td><td>'+course.year_level +'</tr>'
            );
        });
    }
    else
    {
        $('.tablesection tbody').append('<tr class="rows"><td colspan="5" style="text-align: center">No Students</td></tr>')
    }
    }
   });
});

$('.selectyear').on('change', function(){
    $year = $(this).val();
    $course = $('.courseselect').val();
    var data = {
        'year' : $year,
        'course' : $course
    }
    $.ajax({
        type: "GET",
        url: "/getyear",
        data: data,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success: function (response) {
            $('.tablesection tbody').empty();
            if(response.length > 0)
       { response.forEach(course => { //forEach(function(course)) talaga dapat yan baka malito ako
            $('.tablesection tbody').append('<tr class="rows"><td><input type="checkbox" class="checkdata" data-user_id="'+ course.student_id +'"' + 
             'data-name="'+course.name+'" data-lastname = "'+ course.lastname+'" data-course="'+ course.course +'" data-year="'+course.year_level+'" name="" id=""></td><td>' + course.name + '</td><td>' + course.lastname +
            '</td><td>' + course.course + '</td><td>'+course.year_level +'</tr>'
            );
        });
    }
    else
    {
        $('.tablesection tbody').append('<tr><td colspan="5" style="text-align: center">No Students</td></tr>')
    }
        }
    });
})
$(document).on('click','.addbtn', function()
{
    if(confirm('Proceed to Add?'))
    {
        $('.checkdata:checked').each(function(){
    $checking = $(this);
    var id = $($checking).data('user_id');
    var name = $($checking).data('name');
    var lastname = $($checking).data('lastname');
    var course = $($checking).data('course');
    var year = $($checking).data('year');
    var section = $('.addsection').val()
    var data = {
        'id' : id,
        'section' : section,
        'name' : name,
        'lastname' : lastname,
        'course' : course,
        'year' : year
                }

   $.ajax({
        type: "POST",
        url: "/savesection/"+id,
        data: data,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        dataType: "json",
        success: function (response) {
            console.log(response.message);
            $checking.closest('tr').remove();
            $('.added').show();
            $('.addsection').attr('placeholder', 'Section to be added').css(
                {
                    'border-color' : 'lightgrey',
                });
        },
        error: function (response) {
            $('.addsection').attr('placeholder', 'Please enter this field').css(
                {
                    'border-color' : 'red',
                });
            $('.addbtn').css({'border-left' : 'red'});
           
        }
    });
        });
    }
})
});
</script>
@endsection 
