@extends('student/layout')

@section('title')
    <title>Subjects</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-9">
    <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%; margin-right: -3%">
        @if ($errors->any())
@foreach ($errors->all() as $error)
<ul class="alert alert-danger" style="margin-top: -1%">{{$error}}</ul>
@endforeach
    
@endif
<br>                  <div class="alert alert-success verified">Verified</div>

        <div class="row">
            <div class="col-7"><select name="" class="custom-select course" id="" style="width: 104.5%">
                @if ($courses !== null)
                @foreach ($courses as $item)
                    <option value="{{$item->courses}}" selected>{{$item->courses}}</option>
                @endforeach
                @else
                {
                    <option value="">No Courses</option>
                }
                @endif
            </select></div>
            <div class="col-3">
                <select name="" class="custom-select inp_year" id="" >
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <form action=""><button class="btn btn-success coursesub">Submit</button></form>
                
            </div>
        </div>
        <hr style="border: 1px solid black">
        <div class="mb-3">
            <div class="mb-3">
                <div class="receiptdisplay"></div><br>
                <button class="btn btn-primary addbtnreceipt">Add Receipt</button>
                <input class="form-control inputreceipt" type="file" style="display: none" name="forms" id="formFile">
                <button class="btn btn-primary receiptbtn">Submit</button>
                @if($pdfs)
                <div class="pdfsdiv">{{$pdfs->original_name}}</div>
                @else
                @endif
                <div class="errorsa"></div>
            </div>
            

          </div>
      <!--ditoooooooo-->
     <hr style="border: 1px solid black">
          <div class="subjectohide">
<div class="row">
<div class="col-12"> <h3>Select Subjects</h3></div>

<div class="col-12" ><button class="btn btn-warning addSub"> + Add Subjects</button> </div><br><br>

</div>
       <div class="alert alert-danger" id="exists">Subject selected already exists</div>
       <div class="alert alert-success" id="success">Subject/s Added</div>
        <table class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">Subject Name</th>
                <th scope="col">Schedule/Time</th>
                <th scope="col">Points</th>
                <th scope="col">Year Level</th>
                <th scope="col">Course</th>
              </tr>
            </thead>
            <tbody>
                @if($subjects != null)
                @foreach ($subjects as $subject)
                    <tr>
                        <th scope="row"><input type="checkbox" class="checks"
                            data-id="{{$subject->id}}"
                            data-sub="{{$subject->subj_name}}"
                            data-schedule="{{$subject->schedule}}"
                            data-points="{{$subject->points}}"
                            data-year="{{$subject->year_lvl}}"
                            data-course="{{$subject->course}}"
                            name="subjects[]"
                            id="subject_{{$subject->id}}"></th>
                        <td>{{$subject->subj_name}}</td>
                        <td>{{$subject->schedule}}</td>
                        <td>{{$subject->points}}</td>
                        <td>{{$subject->year_lvl}}</td>
                        <td>{{$subject->course}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No subjects found</td>
                </tr>
            @endif
            
             
             
            </tbody>
          </table>
    </div>
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
        <a href="" style="text-decoration:none"><p><button style="border-left: 1px solid blue" disabled class="btn btn-light btn-block">Subjects</button></p></a>
    </div>
    </div>
    <div class="row">
        <div class="col-12" style="margin-top: -2%; ">
        <p><a href="/review" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Review Subjects</button></a></p>
    </div>
    </div>
    <div class="row">
        <div class="col-12" style="margin-top: -2%; ">
        <p><a href="" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Cashier's Receipt</button></a></p>
    </div>
    </div>
    <div class="row">
        <div class="col-12" style="margin-top: -2%;">
        <p><a href="" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block ">Schedule</button></a></p>
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
    $('.receiptbtn').hide();
    $('.verified').hide();
    $('#exists').hide();
    $('#success').hide();
    $('.addSub').on('click', function () {
        $('.checks:checked').each(function() {
    var id = $(this).data('id');
    var sub = $(this).data('sub');
    var schedule = $(this).data('schedule');
    var points = $(this).data('points');
    var year = $(this).data('year');
    var course = $(this).data('course');
    var data = {
                'subj_name' : sub,
                'schedule' : schedule,
                'points' : points,
                'year_level' : year,
                'course' : course
                }
    console.log(data);
    $.ajax({
        type: "POST",
        url: "/savesubject",
        data: data,
        dataType: "json",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            $('#exists').hide();
            $('#success').show();
        },
        error: function(xhr, status, error) {
            $('#success').hide();
            $('#exists').show();
        }
    });
});
    });
    $('.coursesub').on('click', function () {
       var course = $('.course').val();
       var year = $('.inp_year').val();
       var data = { 'course' : course, 'year_level' : year}
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/courseyear",
            data: data,
            dataType: "json",
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            success: function (response) {
                console.log(response);
            },
            error:function()
            {
                console.log(response);
            }
        });
    });
    $('.addbtnreceipt').on('click', function() {
    $('.inputreceipt').click();
});
$(document).on('change', '.inputreceipt', function() {
    $('.receiptbtn').show();
    var file = this.files[0];
$('.pdfsdiv').text(file.name);
});
    $('.receiptbtn').on('click', function() {
    var inputfile = $('.inputreceipt')[0];
    var file = inputfile.files[0];
    var formData = new FormData();
    formData.append('forms', file);
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/uploadpdf",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            alert('success');
        },
        error: function(response) {
            console.log(response.error);
        }
    });
});

   });
$('.inp_year').val('{{$year}}');

$.ajax({
    type: "GET",
    url: "/checksubverified",
    success: function (response) {
        if(response.verified)
        {
            $('.coursesub').prop('disabled', true);
            $('.addbtnreceipt').prop('disabled', true);
            $('.addSub').prop('disabled', true);
            $('.verified').show();
        }
    }
});
</script>
@endsection
