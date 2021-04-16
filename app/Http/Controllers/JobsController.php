<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CostCode;
use App\User;
use App\Models\Paygroup;

use Response;

use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
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
            // $projects = Project::join('users as U1', 'projects.pm_id', '=', 'U1.id')->join('users as U2', 'projects.foreman_id', '=', 'U2.id')
            //         ->get(['projects.id as id','projects.name as Name','projects.desc as Description','U1.name as Manager','U2.name as Foreman']);
            $projects = Project::with('pm','foreman','users')->get();
            return Response::json($projects);
        }


        $data = ['menu'=>'jobs'];
        $projectManagers = User::where("type",1)->get();
        $foremans = User::where("type",3)->get();
        $employees = User::where("type",4)->get();
        $paygroups = Paygroup::all();

        $username  = $user->name;
        return view('pages.jobs.index', compact("username","projectManagers","foremans","employees","paygroups"));
    }
    
    
 
    
    
    
    

    public function getEmps(Request $request) {
        $id = $request->post("id");

        $project = Project::find($id);
        // $project->users()->detach(2);
        // $project->0users()->attach(2, ['hours'=>300]);

// $user->roles()->detach([1, 2, 3]);

// $user->roles()->attach([
//     1 => ['expires' => $expires],
//     2 => ['expires' => $expires],
// ]);
        // $project->users()->updateExistingPivot(8, ['hours'=>200]);

        // $tuser = $project->users->where(['id'=>8])->first();
        // var_dump($tuser); die;
        // $tuser->extra->hours=200;
        // $tuser->extra->save();
        $emps = $project->users;
        foreach ($emps as $one) {
            $pg = Paygroup::find($one->pivot->paygroup_id);
            if ($pg) {
                $one->pivot->paygroup = $pg->name;
                $one->pivot->apprentice = $pg->class;
            }
        }
        return Response::json($emps);
    }

    public function removeEmp(Request $req) {
        $pid = $req->id;
        $uid = $req->uid;
        $project = Project::find($pid);
        $project->users()->detach($uid);
        echo 'ok';
    }

    
    

    public function addEmp(Request $req) {
        $pid = $req->id;
        $uid = $req->uid;
        $project = Project::find($pid);
        if ($project->users()->find($uid)) {
            echo 'exist'; die;
        }
        $project->users()->attach($uid, ['paygroup_id'=>$req->pgid, 'cost_code'=>$req->cost_code]);
        echo 'ok';
    }

    public function show($id)
    {
        if (Auth::check()) {
            // The user is logged in...
        }
        $user = Auth::user();
        $username=$user->name;

        $project = Project::find($id);

        // $project = Project::join('users as U1', 'projects.pm_id', '=', 'U1.id')->join('users as U2', 'projects.foreman_id', '=', 'U2.id')
        // ->where('projects.id',$id)->first(['projects.*','U1.name as Manager','U2.name as Foreman']);

        $projectManagers = User::where("type",1)->get();
        $foremans = User::where("type",3)->get();
        $employees = User::where("type",4)->get();
        $costCodes = CostCode::all();
        $paygroups = Paygroup::all();
        $costcodes = CostCode::all();

        $empToChoose = User::where("type",4)->get();
        
        $pCostCodes = $project->costCodes;
        $pCostCodes = $pCostCodes->toArray();
        $pPaygroups = $project->paygroups->toArray();
        
        

        
        

        $pCostCodes = $project->costCodes;
        $pCostCodes = $pCostCodes->toArray();
        $pPaygroups = $project->paygroups->toArray();
        return view('pages.jobs.show',compact('username','project','projectManagers','foremans','employees','paygroups','empToChoose','costCodes','pCostCodes','pPaygroups'));
    }
    

    
    
    

    public function store(Request $request)
    {
        $project = Project::create([
            "name"=>$request->_ip_add_project_name,
            "desc"=>$request->_ip_add_des,
            "pm_id"=>$request->_ip_add_pm,
            "foreman_id"=>$request->_ip_add_pf,
            "start_date"=>$request->_ip_add_start_date.' 00:00:00',
            "status"=>1
        ]);
        $project->users()->sync($request->input('_ip_add_employee', []));
        $project->paygroups()->sync($request->input('_ip_add_paygroups', []));
        $project->costcodes()->sync($request->input('_ip_add_cost_codes', []));
        
        // _ip_add_employee
        // _ip_add_paygroups
        // _ip_add_cost_codes
        // $project = Project::create([
        //     "name"=>$request->_ip_add_project_name,
        //     "desc"=>$request->_ip_add_des,
        //     "pm_id"=>$request->_ip_add_pm,
        //     "foreman"=>$request->_ip_add_pf,
        //     "start_date"=>$request->_ip_add_start_date,
        //     "status"=>1
        // ]);

        $project = Project::join('users as U1', 'projects.pm_id', '=', 'U1.id')->join('users as U2', 'projects.foreman_id', '=', 'U2.id')
        ->where('projects.id',$project->id)->get(['projects.id as id','projects.name as Name','projects.desc as Description','U1.name as Manager','U2.name as Foreman'])->first();
        
        return Response::json($project);

        // return redirect()->route('jobs.index');

    }

    public function update($id, Request $request)
    {
        //$project = Project::find($request->id_job)->first();
         $project = Project::find($id);
        
    //$conn = mysqli_connect('localhost','btrulead_ateamuser','nY^J$U_Z+;q,','btrulead_ateam');    
    //$update = 'UPDATE projects SET `name` ="'.$request->_ip_job_name.'",`desc` ="'.$request->_ip_job_des.'",`pm_id` ="'.$request->_ip_job_pm.'",`foreman_id` ="'.$request->_ip_job_pf.'",`status` ="1" where id ="'.$request->id_job.'"';
    //$updatedb = mysqli_query($conn,$update);
        
        
        $data = [
                "name"=>$request->_ip_job_name,
                "desc"=>$request->_ip_job_des,
                "pm_id"=>$request->_ip_job_pm,
                "foreman_id"=>$request->_ip_job_pf,
                //"start_date"=>$request->_ip_job_start_date.' 00:00:00',
                "status"=>1
       ];
        $project->update($data);
        $project->users()->sync($request->input('_ip_job_employees', []));
        
        
        $project->paygroups()->sync($request->input('_ip_job_paygroups', []));
        
        
        $project->costcodes()->sync($request->input('_ip_job_cost_codes', []));
        return redirect()->route('jobs.index');

    }


    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        return back();

    }

    


}
