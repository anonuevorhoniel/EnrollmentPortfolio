<?php

namespace App\Http\Controllers;

use App\Models\AcceptedModel;
use App\Models\AdminCourseModel;
use App\Models\CourseYearModel;
use App\Models\Post;
use App\Models\User;
use App\Models\Enroll;
use App\Models\PDFModel;
use App\Models\SchoolYearModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SubjectStudentModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Js;
use League\CommonMark\Node\Block\Document;
use RealRashid\SweetAlert\Facades\Alert;
use Wavey\Sweetalert\Sweetalert;

class EnrollController extends Controller
{
    public function createEnrollment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'age' => 'required|integer',
            'address' => 'required',
            'religion' => 'required',
            'gender' => 'required',
        ]);
        
        $userId = Auth::id();
        $check = Enroll::where('user_id', $userId)->first();
        
        if ($check) {
            $check->update($validatedData);
            return redirect()->route('student.dashboard')->with(['success' => 'Enrollment updated successfully!', 'data' => $check]);
        } else {
            $create = Enroll::create([
                'user_id' => $userId,
                'name' => $validatedData['name'],
                'lastname' => $validatedData['lastname'],
                'age' => $validatedData['age'],
                'address' => $validatedData['address'],
                'religion' => $validatedData['religion'],
                'gender' => $validatedData['gender'],
            ]);
                        
            return redirect()->route('student.dashboard')->with(['success' => 'Enrollment created successfully!', 'data' => $check]);
        }
    }
    
    public function subjects()
    {
        if(Auth::user()->role == 'admin')
        {
         return redirect()->route('view.enrollees');
        }
        else if (!Auth::check())
        {
         return redirect()->route('login');
        }
        else{
           $idpdf = PDFModel::where('user_id', Auth::id())->first();
            $courses = AdminCourseModel::all();
            if ( $filtered = CourseYearModel::where('user_id', Auth::id())->first())
            {
           $subjects = SubjectModel::where('course', 'like', '%' .$filtered->course.'%')
            ->where('year_lvl', 'like', '%' . $filtered->year_level . '%')
            ->get();
            
                return view('student/subjects', ['subjects' => $subjects, 'courses' => $courses, 'year' => $filtered->year_level, 'pdfs' => $idpdf]);

            }   
            else
            {
                return view('student/subjects', ['courses' => $courses, 'year' => null, 'subjects' => null,  'pdfs' => $idpdf]);
            }
        }
       
    }
    public function dashboard(Request $req){
        if(Auth::user()->role == 'admin')
           {
            return redirect()->route('view.enrollees');
           }
           else if (!Auth::check())
           {
            return redirect()->route('login');
           }
           else{
            return view('student/dashboard', ['data' => Enroll::where('user_id', Auth::id())->first()]);
           }
        }
    public function createUsers(Request $req)
    {
      $createUser = $req->validate([
        'role' => 'required',
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required'
       ]);
       $createUser['password'] = Hash::make($createUser['password']);
       User::create($createUser);
       return redirect(route('login'));
        }
    public function login(Request $req)
    {
        $field = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt($field))
        {
            $user = Auth::user();
            if($user->role == 'student')
            {
                return redirect()->intended(route('student.dashboard'));
            }
            else
            {
                return redirect()->intended(route('view.enrollees'));
            }
           
        }
        return redirect(route('login'))->with('error', 'Wrong email or password');
    }
    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }
    
    public function viewUsers()
    {
        if (Auth::user()->role == 'student') {
            return redirect()->route('student.dashboard');
        } elseif (!Auth::check()) {
            return redirect()->route('login');
        } else {
            $accepted = AcceptedModel::paginate(5, ['*'], 'accepted');
            $users = Enroll::whereNotIn('user_id', function($query) {
                $query->select('student_id')->from('accepted');
            })->paginate(5, ['*'],  'users');
    
          
            return view('admin/viewenroll', ['users' => $users,  'subjects' => null, 'accepted' => $accepted]);
        }
    }
    
    public function loginAdmin(Request $req)
    {
       $login = $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt($login))
        {
            return redirect()->intended(route('admmin.dashboard'));
        }
    }
   public function adminDashboard(Request $req)
    {
        if(Auth::user()->role== 'student')
        {
            return redirect()->route('student.dashboard');
        }
        else if(!Auth::check())
        {
            return view('login');
        }
        else
        {
            return view('admin/dashboard', ['data' => SubjectModel::orderBy('created_at', 'desc')->paginate(5), 'course' => AdminCourseModel::paginate(5)]);
        }
        
    }
    public function addSubjects(Request $req)
    {
        $values = $req->validate([
            'subj_name' => 'required',
            'schedule'  => 'required',
            'year_lvl'  => 'required',
            'points'  => 'required',
            'course' => 'required'
        ]);
        
        try {
            $created = SubjectModel::create($values);
            return new JsonResponse(['success' => 'Success', 'id' => $created->id, 'subject' => $created->subj_name, 'schedule' => $created->schedule,
           'year' => $created->year_lvl, 'points' => $created->points, 'course' => $created->course ], 200);
        } catch (\Throwable $th) {
            return new JsonResponse(['error' => 'Error'], 500);        }
           }

        public function editSub(Request $req, $id)
           {
               $subject = SubjectModel::find($id);
               if (!$subject) {
                   return new JsonResponse(['message' => 'Subject not found'], 404);
               }
           
               $subject->subj_name = $req->input('name');
               $subject->schedule = $req->input('sched');
               $subject->points = $req->input('points');
               $subject->year_lvl = $req->input('year');
               $subject->course = $req->input('course');
               $subject->update();
               
               return new JsonResponse(['message' => 'Success', 'subject' =>$req->input('name'), 'schedule' => $req->input('sched'),
            'points' => $req->input('points'), 'year' => $req->input('year'), 'course' => $req->input('course')
            ], 200);
           }
           public function delete(Request $req, $id)
           {
           $idNew = SubjectModel::find($id);
            $idNew->delete();
           return new JsonResponse(['message' => 'Deleted'], 200);
           }
           public function saveSubs(Request $req)
           {
               $id = Auth::id();
               $exists = CourseYearModel::where('user_id', $id)->first();
               $existsub = SubjectStudentModel::where('subject_name', $req->input('subj_name'))
                                            ->where('user_id', $id)
                                            ->exists();
               if($existsub){
             return response()->json(['error' => 'error'], 422);
               } else {
                   $created =  SubjectStudentModel::create([
                       'user_id' => $id,
                       'course_id' => $exists->id,
                       'year_level' => $req->input('year_level'),
                       'subject_name' => $req->input('subj_name'),
                       'schedule' => $req->input('schedule'),
                       'points' => $req->input('points'),
                       'course' => $req->input('course')
                   ]);
                   return new JsonResponse(['success' => 'Success'], 200);
               }
           }
public function courseyear(Request $req)
{
  
    $id = Auth::id();
   $exists = CourseYearModel::where('user_id', $id)->first();
   if($exists)
   {
    $exists->update([
        'course' => $req->input('course'),
        'year_level' =>$req->input('year_level') 
    ]);
    return new JsonResponse(['success' => 'Updated Successfuly'], 200);
   }
   else{
    $success =  CourseYearModel::create(
        [
        'user_id' => $id,
         'course' => $req->input('course'),
         'year_level' =>$req->input('year_level') 
        ]);
        return new JsonResponse(['success' => 'Created Successfuly'], 200);

   }
}
public function courses()
{
    return view('admin/courses', ['data' => AdminCourseModel::paginate(5)]);
}
public function addCourses(Request $req)
{
  $success =  AdminCourseModel::create(
        [
            'courses' => $req->input('courses')
        ]);
        if($success)
        {
            Alert::success('Success Title', 'Success Message');
            return new JsonResponse(['success' => 'Success!', 'id' => $success->id], 200);
        }
        else{
            return new JsonResponse(['error' => 'error'], 500);
        }
}
public function acceptstudent(Request $req, $id, $user_id)
{
 
        $nameL = Enroll::where('user_id', $user_id)->first();
        $courseYear = CourseYearModel::where('user_id', $user_id)->first();

      $created =  AcceptedModel::create([
            'student_id' => $user_id,
            'name' => $nameL->name,
            'lastname' => $nameL->lastname,
            'course' => $courseYear->course
        ]);
        return response()->json(['success' => 'Success', 'id' => $created->id ], 200);
  
    
}
public function review()
{
    $id = Auth::id();
   $subjects = SubjectStudentModel::where('user_id', $id)->get();
   if($subjects)
   {
    return view('student/review', ['subjects' => $subjects]);
   }
   else
   {
    return view('student/review', ['subjects' => null]);
   }
}
public function deletesubject(Request $req, $id)
{
  $delete = SubjectStudentModel::find($id)->delete();
if($delete)
{
return new JsonResponse(['success' => 'Deleted Successfuly'], 200);
}
else
{
    return new JsonResponse(['error' => 'There was en error in deleting'], 422);
}
}
public function editcourse(Request $req, $id)
{
 $update = AdminCourseModel::find($id)->update([
    'courses' => $req->input('course')
            ]);
if($update)
  {
    return new JsonResponse(['success' => 'Success'], 200);
  }
else
 {
return new JsonResponse(['error' => 'Error'], 500);
 }
    
}
public function viewstudentsub(Request $req, $id)
{
    if(Auth::user()->role == 'student')
    {
     return redirect()->route('student.dashboard');
    }
    else if (!Auth::check())
    {
     return redirect()->route('login');
    }
    else{
        $idpdf = PDFModel::where('user_id', $id)->first();
        
   $subjects = SubjectStudentModel::where('user_id', $id)->get();
    return new JsonResponse(['success' => 'Success', 'subjects' => $subjects, 'idpdf' => $idpdf], 200);
    }
}
public function deleteaccept(Request $req, $user_id)
{   try{

  $delete =  AcceptedModel::where('student_id', $user_id)->delete();
    return new JsonResponse(['success' => 'Successfuly Deleted'], 200);
  }
  catch (\Exception $e) {
    Log::error('An error occurred: ' . $e->getMessage());
    // Optionally, you can also log the stack trace
    Log::error($e->getTraceAsString());
    // Handle the exception or rethrow it
    throw $e;
}
}
public function deletestudent($user_id)
{
   $removed = Enroll::where('user_id', $user_id)->delete();
   $removesubject = SubjectStudentModel::where('user_id', $user_id)->delete();
   if($removed && $removesubject)
   {
 return new JsonResponse(['success' => 'Success'], 200);
   }
   else
   {
    return new JsonResponse(['error' => 'Error'], 500);

   }
}
public function deletecourse($id)
{
    
   $delete = AdminCourseModel::find($id)->delete();
    if($delete)
    {
        Alert::success('Success Title', 'Success Message');
        return new JsonResponse(['success' => "success"], 200);
    }
    else
    {
        return new JsonResponse(['error' => "error"], 200);

    }
}
public function checkverification()
{
   $id = Auth::id();
    if(AcceptedModel::where('student_id', $id)->first())
    {
        return new JsonResponse(['verified' => 'Verified'], 200);
    }
    else if(Enroll::where('user_id', $id)->first() && !AcceptedModel::where('student_id', $id)->first())
        {
        return new JsonResponse(['unverified'=>'Verifying'], 200);
    }
    else
    {
        return new JsonResponse(['notverified'=>'Not Verified'], 200);
    }

}
public function uploadpdf(Request $req){
   
        $req->validate([
            'forms' => 'required|file|mimes:pdf' 
        ]);
        $file = $req->file('forms');
        $id = Auth::id();
        $ifexists = PDFModel::where('user_id', $id)->first();
        $path = 'pdfs/';
        $extension = $file->getClientOriginalExtension();
       $size = $file->getSize() / (1024);
        $filename = time(). '.'. $extension;
        if($ifexists)
        {
            if (file_exists(public_path($ifexists->path . $ifexists->filename))) {
                unlink(public_path($ifexists->path . $ifexists->filename));
                $file->move($path, $filename);
            }
            try {
                PDFModel::where('user_id', $id)->update([

                    'filename' => $filename,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $size,
                    'path' => $path
                ]);
                return new JsonResponse(['success' => 'success', 'id' => $id], 200);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage()], 500);
            }
        }
        else
        {
            $file->move($path, $filename);
            try {
            PDFModel::create([
                'user_id' => Auth::id(),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size' => $size,
                'path' => $path
            ]);
            return new JsonResponse(['success' => 'success', 'id' => $id], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        }
      
}

public function checksubverified()
{
 $id = Auth::id();
 if(AcceptedModel::where('student_id', $id)->first())
 {
    return new JsonResponse(['verified' => 'Verified'], 200);
 }
 else{
    return new JsonResponse(['unverified' => 'Not Verified'], 200);
 }
}
public function checkprofilever()
{
    $id = Auth::id();
    if(AcceptedModel::where('student_id', $id)->first())
    {
        return new JsonResponse(['verified' => 'Verified'], 200);
    }
    else if(Enroll::where('user_id', $id)->first() && !AcceptedModel::where('student_id', $id)->first()){
        return new JsonResponse(['unverified' => 'Pending Verification'], 200);
     }
}
public function editprofile()
{
   
    $id = User::where('id', Auth::id())->first();
    return view('student/profile', ['users' => $id]);
}
public function schedule()
{
    $school_year = SchoolYearModel::latest()->first();
    $id = Auth::id();
    $subjects = SubjectStudentModel::where('user_id', $id)->get();
    $year = CourseYearModel::where('user_id', $id)->first();
    return view('student/schedule', ['subjects' => $subjects, 'year' => $year, 'schoolyear' => $school_year]);
}
public function deleteacceptstudent($id)
{
try
   {
    AcceptedModel::where('student_id', $id)->delete();
  Enroll::where('user_id', $id)->delete();
    return new JsonResponse(['succcess' => 'Success'], 200);}
catch(\Exception $e)
{
    Log::error('An error occurred: ' . $e->getMessage());
    Log::error($e->getTraceAsString());
    throw $e;
}
}
}
