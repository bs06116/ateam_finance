<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

use Response;

use Illuminate\Support\Facades\Auth;

class ForemenController extends Controller
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
            $foremen = User::where(['type'=>3])
                    ->get();
            return Response::json($foremen);
        }


        $data = ['menu'=>'foremen'];

        $username  = $user->name;
        return view('pages.foremen.index', compact("username"));
    }

    public function show($id)
    {
        if (Auth::check()) {
            // The user is logged in...
        }
        if(request()->ajax()){
            $foreman = Foreman::find($id);
            return Response::json($foreman);
        }
        $user = Auth::user();
        $username=$user->name;

        $foreman = User::join('users as U1', 'projects.pm_id', '=', 'U1.id')->join('users as U2', 'projects.foreman_id', '=', 'U2.id')
        ->where('projects.id',$id)->first(['projects.*','U1.name as Manager','U2.name as Foreman']);
        $foreman->load('paygroups');
        $foremanManagers = User::where("type",1)->get();
        $foremans = User::where("type",3)->get();
        $employees = User::where("type",4)->get();
        $paygroups = Paygroup::all();

        return view('pages.jobs.show',compact('username','project','projectManagers','foremans','employees','paygroups'));
    }

    public function store(Request $request)
    {
        
        $PassWord = Hash::make($request->password);
        $request->user_id ='0';
        /*
        $foreman = User::create([
            "type"=>3,
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "password"=>Hash::make($request->password)
        ]);
        */
        //return Response::json($foreman);
        
        
        $date_time = date("Y-m-d H:i:s");
        $conn = mysqli_connect('localhost','btrulead_ateamuser','nY^J$U_Z+;q,','btrulead_ateam');
        mysqli_query($conn,"INSERT INTO `users`(`user_id`, `type`, `name`, `email`, `phone`, `password`, `created_at`, `updated_at`) VALUES ('$request->user_id', '3','$request->name','$request->email','$request->phone','$PassWord','$date_time','$date_time')");

    }

    public function update($id, Request $request)
    {
        $foreman = User::find($id);
        $data = [
                "name"=>$request->name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "password"=>Hash::make($request->password)
        ];
        $foreman->update($data);
        return Response::json($foreman);
    }


    public function destroy($id)
    {
        $foreman = User::find($id);
        $foreman->delete();

        return back();

    }

}
