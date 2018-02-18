<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Callcomplete;
use App\Models\User;

class CallCompleteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Callcomplete $callcomplete, User $user)
    {
        $this->middleware('auth');
        $this->callcomplete = $callcomplete;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(Config::get('constants.Callcomplete.prefix'));
        if ($request->ajax()) {
            // dd($request->ajax());

            $data =  execSelect("
                SELECT callcomplete_id,
                        DATE_FORMAT(cc_call_complete_date, '%W %M %e %Y %H:%i %p') as call_complete_date,
                        cc_status as call_status
                    FROM callcomplete;", []);


            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->callcomplete);
        $data['columns'] = excludeColumn(getColumnList($this->callcomplete), ['status']); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], ['call_status']);
        
        $data['pk'] = Callcomplete::getKeyField();
        $data['prefix'] = config('constants.Callcomplete.prefix');

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('callcomplete', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'callcomplete';
        return view('callcompletecreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->callcomplete, $data);

        commit();

        if ($save_cond == "save_continue") {
            return redirect('/'.$request->path().'/create');
        } else {
            return redirect('/'.$request->path());
        }

    }
}
