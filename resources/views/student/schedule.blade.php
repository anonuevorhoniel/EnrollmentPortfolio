@extends('student/layout')

@section('title')
    <title>Subjects</title>
@endsection

@section('content')
<center>
<div class="row" style="padding: 2% " >
    <div class="col-9">
    <div style="padding: 2%; background-color: white; box-shadow: 3px 3px 9px #888888; border-radius: 7px; padding-bottom: 4%; margin-right: -3%">
        @if($schoolyear)
        <p> School Year: <b>{{$schoolyear->school_year}}</b>
         @else
         <p> School Year: <b>No School Year</b>
            @endif
            @if($year)
            <br> Year Level: <b>{{$year->year_level}}</b></p>
            @else
            <br> Year Level: <b>Year Level not set</b></p>
            @endif
     <table class="table table-bordered table-striped table-hover">
        <thead>
            <th>Subject Name</th>
            <th>Schedule & Time</th>
            <th>Professor</th>
            <th>Points</th>

        </thead>
        <tbody>
            @if ($subjects->count() > 0)
            @foreach ($subjects as $subject)
            <tr>
                <td>{{$subject->subject_name}}</td>
                <td>{{$subject->schedule}}</td>
                <td>Prof. Hello World</td>
                <td>{{$subject->points}}</td>

            </tr>
            @endforeach
           
            @else
            <tr><td style="text-align: center" colspan="4">No Subjects Yet</td></tr>
            @endif
           
        </tbody>
     </table>
</div>
</div>
<div class="col-3" style="overflow-y:auto; overflow-x:auto">
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
        <p><a href="/review" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block">Review Subjects</button></a></p>
    </div>
    </div>
    <div class="row">
        <div class="col-12" style="margin-top: -2%;">
        <p><a href="" style="text-decoration:none"><button style="border-left: 1px solid blue" class="btn btn-light btn-block" disabled>Schedule</button></a></p>
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

@endsection
