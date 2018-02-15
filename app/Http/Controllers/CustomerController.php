<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Customer;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, User $user)
    {
        $this->middleware('auth');
        $this->customer = $customer;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(Config::get('constants.Customer.prefix'));
        if ($request->ajax()) {
            // dd($request->ajax());

            $data =  execSelect("
                    SELECT customers_id,
                            c_name as name,
                            c_telephone as telephone,
                            c_company_name as company_name,
                            c_email as email,
                            c_address as address,
                            c_gst as gst,
                            c_birthday as birthday
                        FROM customers;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->customer);
        $data['columns'] = excludeColumn(getColumnList($this->customer), []); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], []);
        
        $data['pk'] = Customer::getKeyField();
        $data['prefix'] = config('constants.Customer.prefix');

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('customer', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'customers';
        return view('customercreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;

        beginTransaction();

        $response = create($this->customer, $data);

        commit();

        if ($save_cond == "save_continue") {
            return redirect('/'.$request->path().'/create');
        } else {
            return redirect('/'.$request->path());
        }

    }
}
