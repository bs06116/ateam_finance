<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

use Response;

use Illuminate\Support\Facades\Auth;

class ProjectManagersController extends Controller
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
            $projectManagers = User::where(['type'=>1])
                    ->get();
            return Response::json($projectManagers);
        }


        $data = ['menu'=>'projectManagers'];

        $username  = $user->name;
        return view('pages.projectManagers.index', compact("username"));
    }

    public function show($id)
    {
        if (Auth::check()) {
            // The user is logged in...
        }
        if(request()->ajax()){
            $projectManager = User::find($id);
            return Response::json($projectManager);
        }

        $user = Auth::user();
        $username=$user->name;

        $pm = User::find($id);
        $currentP = Project::where(['pm_id'=>$id])->first();
        // $projects = Project::where(['pm_id'=>$id])->get();
        // $projects = $pm->projects;

        // $projectManager = User::join('users as U1', 'projects.pm_id', '=', 'U1.id')->join('users as U2', 'projects.projectManager_id', '=', 'U2.id')
        // ->where('projects.id',$id)->first(['projects.*','U1.name as Manager','U2.name as Foreman']);
        // $projectManager->load('paygroups');
        // $projectManagerManagers = User::where("type",1)->get();
        // $projectManagers = User::where("type",3)->get();
        // $employees = User::where("type",4)->get();
        // $paygroups = Paygroup::all();

        return view('pages.projectManagers.show',compact('username','pm','currentP'));
    }

    public function store(Request $request)
    {
        $PassWord = Hash::make($request->password);
        $request->user_id ='0';

        /*
        $projectManager = User::create([
            "type"=>1,
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "password"=>Hash::make($request->password)
        ]);
        */
        //return Response::json($projectManager);

        $date_time = date("Y-m-d H:i:s");
        $conn = mysqli_connect('localhost','btrulead_ateamuser','nY^J$U_Z+;q,','btrulead_ateam');
        mysqli_query($conn,"INSERT INTO `users`(`user_id`, `type`, `name`, `email`, `phone`, `password`, `created_at`, `updated_at`) VALUES ('$request->user_id', '1','$request->name','$request->email','$request->phone','$PassWord','$date_time','$date_time')");

    }

    public function update($id, Request $request)
    {
        $projectManager = User::find($id);
        $data = [
                "name"=>$request->name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "password"=>Hash::make($request->password)
        ];
        $projectManager->update($data);
        return Response::json($projectManager);
    }


    public function destroy($id)
    {
        $projectManager = User::find($id);
        $projectManager->delete();

        return back();

    }

}
