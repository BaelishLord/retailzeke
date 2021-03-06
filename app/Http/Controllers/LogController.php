<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Log;
use App\Models\Customer;
use App\Models\User;

class LogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Log $log, User $user, Customer $customer)
    {
        $this->middleware('auth');
        $this->log = $log;
        $this->user = $user;
        $this->customer = $customer;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(Config::get('constants.Log.prefix'));
        if ($request->ajax()) {
            // dd($request->ajax());

            $data =  execSelect("
                    SELECT  l.logs_id,
                            COALESCE(c.c_name,'NA') AS party_name,
                            DATE_FORMAT(l.l_log_date, '%W %M %e %Y %H:%i %p') as log_date,
                            l.l_contact_number as contact_number,
                            l.l_called_by as called_by,
                            l.l_problem_description as problem_description,
                            l.l_email as email,
                            l.l_assigned_engineer as assigned_engineer,
                            l.l_part_to_be_taken as part_to_be_taken
                    FROM logs l
                        LEFT JOIN
                    customers c ON c.customers_id = l.l_party_name;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->log);
        $data['columns'] = excludeColumn(getColumnList($this->log), []); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], []);
        
        $data['pk'] = Log::getKeyField();
        $data['prefix'] = config('constants.Log.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        
        return view('log', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'log';
        $data['disabled'] = [];
        // dd($data);
        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());

        return view('logcreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        // return $data;
        beginTransaction();

        $response = create($this->log, $data);

        commit();
        if ($save_cond == "save_continue") {
            return redirect('/'.$request->path().'/create');
        } else {
            return redirect('/'.$request->path());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Log::find($id);
        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());
        // return $data;
        return view('logcreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->log, $data, $id, Log::getKeyField());
        commit();

        return redirect('/'.$request->segment(1));
    }

    //create function to return customer data from inwards create screen
    public function getCustomerData(Request $request) 
    {
        $data = $request->all();

        $res = Customer::find($data['id']);
        return $res;

    }

    public function destroy($id)
    {
        beginTransaction();
        $res = delete($this->log, $id, Log::getKeyField());
        commit();
        return "success";
    }
}
