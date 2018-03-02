<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Inwards;
use App\Models\Customer;
use App\Models\User;

class InwardsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Inwards $inwards, User $user, Customer $customer)
    {
        $this->middleware('auth');
        $this->inwards = $inwards;
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

        // dd(Config::get('constants.Customer.prefix'));
        if ($request->ajax()) {
            // dd($request->ajax());

            $data =  execSelect("
                                SELECT 
                                    i.inwards_id,
                                    COALESCE(c.c_name,'NA') AS party_name,
                                    DATE_FORMAT(i.i_inwards_date, '%W %M %e %Y') AS inwards_date,
                                    i.i_address AS address,
                                    i.i_contact_number AS contact_number,
                                    i.i_quantity AS quantity,
                                    i.i_problem AS problem,
                                    i.i_remark AS remark,
                                    i.i_product_description AS product_description,
                                    i.i_accessories AS accessories,
                                    i.i_warranty AS warranty
                                FROM
                                    inwards i
                                        LEFT JOIN
                                    customers c ON c.customers_id = i.i_party_name;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->inwards);
        $data['columns'] = excludeColumn(getColumnList($this->inwards), []); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], []);
        
        $data['pk'] = Inwards::getKeyField();
        $data['prefix'] = config('constants.Inwards.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];
        

        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('inwards', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'inwards';
        $data['disabled'] = [];

        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());

        return view('inwardscreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->inwards, $data);

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
        $data = Inwards::find($id);
        // return $data;
        return view('inwardscreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->inwards, $data, $id, Inwards::getKeyField());
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
        $res = delete($this->inwards, $id, Inwards::getKeyField());
        commit();
        return "success";
    }

}
  