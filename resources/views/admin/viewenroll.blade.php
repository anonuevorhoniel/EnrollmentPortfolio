@extends('admin/layout')
@section('title')
    <title>Admin Dashboard</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2%;" >
    <div class="col-12">
        <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%;">
            @if ($errors->any())
    @foreach ($errors->all() as $error)
    <ul class="alert alert-danger" style="margin-top: -1%">{{$error}}</ul>
    @endforeach
        
    @endif
      
    <h5 class="col-12"  style=" text-align:left; padding: 2px; border-radius: 10px">Admin/View Enrollees</h5>
            <br>
    <br>
   
           <div class="row">
            <div class="col-12"  style="">
             
              <h5><b>Pending Students</b></h5> 
              {{ $users->appends(['accepted' => $accepted->currentPage()])->links(); }}
              <div  style="text-align:right">
                <input type="text" name="" class="form-control searchbtn" placeholder="Search" id="">
              </div>
              <br>
              <table class="table table-bordered table-striped table-hover pendingtable"> 
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Lastname</th>
                    <th colspan="3" style="width: 10%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- pending table -->
                  @if($users->count() < 1)
                    <tr ><td colspan="4" class="pendingnostudents"  style="text-align: center">No Students Yet</td></tr>
                    @else
                  @foreach ($users as $user)
                  <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->lastname}}</td>
              
                    <td><button  class="btn btn-primary views" data-toggle="modal" data-target="#exampleModal"  data-user_id="{{$user->user_id}}" data-id="{{$user->id}}">View</button></td>
                    <td><button  class="btn btn-success acceptbtn" data-user_id="{{$user->user_id}}" data-id="{{$user->id}}" data-name="{{$user->name}}" data-lastname="{{$user->lastname}}">Accept</button></td>
                    <td> <button class="btn btn-danger removestudent"  data-user_id="{{$user->user_id}}" data-id="{{$user->id}}">Remove</button></td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
              {{  $users->appends(['accepted' => $accepted->currentPage()])->links(); }}
            </div>
            
            <div class="col-12" ><br><br>
              <h5><b>Accepted Enrollees </b></h5><br>
              {{  $accepted->appends(['users' => $users->currentPage()])->links(); }}
              <input type="text" name="" class="form-control searchbtnaccept" placeholder="Search" id=""><br>
              <table class="table table-bordered table-hover table-striped accepttable"> 
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Lastname</th>
                    <th colspan="3" style="width: 10%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- accepted table -->
                  @if($accepted->count() < 1)
                  
                    <tr id="nostud"><td colspan="4" style="text-align: center">No Students</td></tr>
                  
                  @else
                  @foreach ($accepted as $user)
                  <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->lastname}}</td>
                    <td><button  class="btn btn-primary views" data-toggle="modal" data-target="#exampleModal"  data-user_id="{{$user->student_id}}" data-id="{{$user->id}}">View</button></td>
                    <td> <button class="btn btn-warning pending" data-user_id = "{{$user->student_id}}"  data-id="{{$user->id}}">Pending</button></td>
                    <td> <button class="btn btn-danger deleteacceptstudent" data-user_id = "{{$user->student_id}}"  data-id="{{$user->id}}">Delete Student</button></td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
              {{  $accepted->appends(['users' => $users->currentPage()])->links(); }}
            </div>
           </div>
          
        </div>
</div>

</div>
</div>
</center>

<!-- Modal ng view subjects -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Subjects</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">   <label for="">Receipt: </label>
            <a href="" class="pdfdivs"></a></div>
        </div>
     
      <table class="table table-bordered" id="subjectTable">
        <thead>
          <th>Subject Name</th>
          <th>Year Level</th>
          <th>Schedule</th>
          <th>Points</th>
          <th>Course</th>
          <th>Professor</th>
        </thead>
        <tbody>
          @if($subjects != null)
            @foreach($subjects as $subject)
            <tr>
              <td>{{$subject->subject_name}}</td>
              <td>{{$subject ? $subject->year_level : '' }}</td>
              <td>{{$subject ? $subject->schedule : ''  }}</td>
              <td>{{ $subject ? $subject->points : ''  }}</td>
              <td>{{ $subject ? $subject->course : '' }}</td>
              <td>{{ $subject ? $subject->professor : '' }}</td>
            </tr>
          @endforeach
          @else
          <tr><td colspan="4" style="text-align: center">No Subjects</td></tr>
          @endif
      
        </tbody>
      </table>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<style>
    .inp
    {
        border-color: black;
    }
</style>
<script>
  $(function (){
    $(document).on('click', '.deleteacceptstudent', function(){
      var btn = $(this);
      if(confirm('Do you want to delete this student?'))
      {
      var user_id =  $(this).data('user_id');
       var id = $(this).data('id');
      
        $.ajax({
          type: "DELETE",
          headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
          url: "/deleteacceptstudent/" + user_id,
          success: function (response) {
              btn.closest('tr').remove();
          }
        });
      }
    })
    $(document).on('click','.acceptbtn', function () {
      var btn = $(this);
      if(confirm("Do you want to accept this?"))
   {   
    var id = $(this).data('id');
    var user_id = $(this).data('user_id');
    var name = $(this).data('name');
   var lastname = $(this).data('lastname');
    $.ajax({
      type: "POST",
      url: "/acceptstudent/" + id + "/" + user_id,
      data: {},
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
      dataType: "json",
      success: function (response) {
        $('#nostud').hide();
        btn.closest('tr').remove();
        $('.accepttable tbody').append("<tr><td>" + name +"</td><td>"+ lastname + "</td><td><button  class='btn btn-primary views' data-toggle='modal' data-target='#exampleModal'  data-user_id='" + user_id +"''>View</button></td><td> <button class='btn btn-warning pending' data-name='"+name+"' data-lastname='"+lastname+"' data-user_id='"+ user_id+"'  data-id='"+response.id+"'>Pending</button></td> <td> <button class='btn btn-danger pending' data-user_id = '"+user_id+"'>Delete Student</button></td></tr>");
        
      },
      error: function (response) {
        console.log(response);
      }
    });}
    else
    {
      
    }
    });
  $(document).on('click','.views', function () {
  var user_id =  $(this).data('user_id');
    console.log(user_id);
    $.ajax({
      type: "GET",
      url: "/viewstudentsub/" + user_id,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
            if (response.success) {
                var subjects = response.subjects;
                var pdffile = response.idpdf;
                $('#subjectTable tbody').empty();
                subjects.forEach(function (subject) {
                    $('#subjectTable tbody').append('<tr><td>' + subject.subject_name + '</td><td>' + subject.year_level + '</td><td>'+subject.schedule+'</td><td>'+subject.points+'</td><td>' + subject.course + '</td><td>'+ subject.professor  +'</td></tr>');
                });
                if(pdffile)
                {
                  $('.pdfdivs').text(pdffile.original_name);
                $('.pdfdivs').attr('href', pdffile.path + pdffile.filename);
                }
               else
               {
                $('.pdfdivs').text('No File');
               }
              
            } else {
                alert('Failed to retrieve subjects');
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert('Failed to fetch subjects');
        }
    });
});
$(document).on('click','.pending', function()
{ 
 var id = $(this).data('id');
 var user_id = $(this).data('user_id');
 var btn =  $(this);
  console.log(id);
  $rows = btn.closest('tr');
  var name = $rows.find('td:eq(0)').text();
  var lastname = $rows.find('td:eq(1)').text();
  if(confirm('Do you want to send it to pending?'))
  {
    $.ajax({
    type: "DELETE",
    url: "/deleteaccept/"+user_id,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      $('.pendingnostudents').hide();
      btn.closest('tr').remove();
      $('.pendingtable tbody').prepend("<tr><td>"+ name +"</td><td>"+ lastname +"</td><td><button  class='btn btn-primary views' data-toggle='modal' data-target='#exampleModal'  data-user_id='"+ user_id + "''>View</button>" +
"<td><button  class='btn btn-success acceptbtn' data-user_id='"+user_id+"' data-id='"+id+"' data-name='"+name+"' data-lastname='"+lastname+"'>Accept</button></td>" + 
"<td> <button class='btn btn-danger removestudent'  data-user_id='"+user_id+"' data-id='"+id+"'>Remove</button></td></tr>");

    }
  });
  }
 
})
$(document).on('click','.removestudent', function () {
 if(confirm('Do you want to remove this student?'))
 {
  var tr = $(this);
 var id = $(this).data('id');
 var user_id = $(this).data('user_id');
 $.ajax({
  type: "DELETE",
  url: "/deletestudent/" + user_id,
  headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  success: function (response) {
    tr.closest('tr').remove();
  }
 });
 }
});
//pending students table search
$(document).on('input', '.searchbtn', function()
{
 var value = $(this).val();

  $.ajax({
    type: "GET",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "/searchdisplay",
    data: {'value' : value},
    success: function (response) {
      $('.pendingtable tbody').empty();
      if(response.length > 0)
    {  response.forEach(function(users)
    {
      $('.pendingtable tbody').append("<tr><td>"+ users.name + "</td><td>" +users.lastname + "  <td><button  class='btn btn-primary views' data-toggle='modal' data-target='#exampleModal'  data-user_id='"+ users.user_id + "'>View</button>"+ 
        "<td><button  class='btn btn-success acceptbtn' data-user_id='"+users.user_id+"' data-id='"+users.id+"' data-name='"+users.name+"' data-lastname='"+users.lastname+"'>Accept</button>" +
          "<td> <button class='btn btn-danger removestudent'  data-user_id='"+users.user_id+"' data-id='"+users.id+"'>Remove</button></td>" +
          "</td></tr>");
    })}
    else
    {
      $('.pendingtable tbody').append("<tr><td colspan='5' style='text-align:center'>No Records</td></tr>")

    }
    }
  });
});
//accepted students table search
$(document).on('input', '.searchbtnaccept', function()
{
 var value = $(this).val();

  $.ajax({
    type: "GET",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "/searchdisplayaccept",
    data: {'value' : value},
    success: function (response) {
     
      $('.accepttable tbody').empty();
      if(response.length > 0)

      {response.forEach(function(users)
    {
      
      $('.accepttable tbody').append("<tr><td>"+ users.name + "</td><td>" +users.lastname + "  <td><button  class='btn btn-primary views' data-toggle='modal' data-target='#exampleModal'  data-user_id='"+ users.student_id + "'>View</button>"+ 
        "<td> <button class='btn btn-warning pending' data-name='"+users.name+"' data-lastname='"+users.lastname+"' data-user_id='"+ users.student_id+"'  data-id='"+users.id+"'>Pending</button></td>" +
        "<td> <button class='btn btn-danger pending' data-user_id = '"+users.student_id+"'>Delete Student</button></td></tr>" +
          "</td></tr>");
        
    });  }
    else
          {
            $('.accepttable tbody').append("<tr><td colspan='5' style='text-align:center'>No Records</td></tr>")
          }
    }
  });
});
  });
</script>
@endsection
