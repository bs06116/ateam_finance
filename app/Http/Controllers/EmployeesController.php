<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

use Response;

use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            // The user is logged in...
        }
        $user = Auth::user();
        if($request->ajax){
            $employees = User::where(['type'=>4])
                    ->get();
            return Response::json($employees);
        }


        $data = ['menu'=>'employees'];

        $username  = $user->name;
        return view('pages.employees.index', compact("username"));
    }

    public function show($id)
    {
        if (Auth::check()) {
            // The user is logged in...
        }
        if(request()->ajax()){
            $employee = User::find($id);
            return Response::json($employee);
        }
        $user = Auth::user();
        $username=$user->name;

        $employee = User::join('users as U1', 'projects.pm_id', '=', 'U1.id')->join('users as U2', 'projects.employee_id', '=', 'U2.id')
        ->where('projects.id',$id)->first(['projects.*','U1.name as Manager','U2.name as Foreman']);
        $employee->load('paygroups');
        $employeeManagers = User::where("type",1)->get();
        $employees = User::where("type",3)->get();
        $employees = User::where("type",4)->get();
        $paygroups = Paygroup::all();

        return view('pages.jobs.show',compact('username','project','projectManagers','employees','employees','paygroups'));
    }

    public function store(Request $request)
    {

        $request->password = 'eJ}9F[aP?K#7';
        $date_time = date("Y-m-d H:i:s");
        $conn = mysqli_connect('localhost','root','','ateamthe_ateam');
        mysqli_query($conn,"INSERT INTO `users`(`user_id`, `type`, `name`, `email`, `phone`, `desig`, `password`, `created_at`, `updated_at`) VALUES ('$request->user_id', '4','$request->name','$request->email','$request->phone','$request->desig','$request->password','$date_time','$date_time')");
        /*
        $employee = User::create([
            "user_id"=>$request->user_id,
            "type"=>4,
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "desig"=>$request->desig,
            "password"=>Hash::make($request->password)
        ]);

        return Response::json($employee);
        */

    }

    public function update($id, Request $request)
    {
        $request->password = 'eJ}9F[aP?K#7';
        $employee = User::find($id);
        $data = [
                "user_id"=>$request->user_id,
                "name"=>$request->name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "desig"=>$request->desig

        ];
        $conn = mysqli_connect('localhost','root','','ateamthe_ateam');
        $update = 'UPDATE users SET `user_id` ="'.$request->user_id.'" where id ="'.$id.'"';
    $updatedb = mysqli_query($conn,$update);


        $employee->update($data);
        return Response::json($employee);
    }


    public function destroy($id)
    {
        $employee = User::find($id);
        $employee->delete();

        return back();

    }

}
