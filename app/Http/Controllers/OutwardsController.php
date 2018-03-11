<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Outwards;
use App\Models\Customer;
use App\Models\User;

class OutwardsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Outwards $outwards, User $user, Customer $customer)
    {
        $this->middleware('auth');
        $this->outwards = $outwards;
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
                SELECT  o.outwards_id,
                        COALESCE(c.c_name,'NA') AS party_name,
                        DATE_FORMAT(o.o_outwards_date, '%W %M %e %Y') as outwards_date,
                        o.o_address as address,
                        o.o_contact_number as contact_number,
                        o.o_quantity as quantity,
                        o.o_orderby as order_by,
                        o.o_product_description as product_description,
                        o.o_email AS email,
                        o.o_warranty_product AS warranty_product,
                        o.o_warranty_chargable AS warranty_chargable,
                        DATE_FORMAT(o.o_warranty_date, '%W %M %e %Y') AS warranty_date
                FROM 
                outwards o
                    LEFT JOIN
                customers c ON c.customers_id = o.o_party_name;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->outwards);
        $data['columns'] = excludeColumn(getColumnList($this->outwards), ['orderby']); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], ['order_by']);
        
        $data['pk'] = Outwards::getKeyField();
        $data['prefix'] = config('constants.Outwards.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('outwards', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'outwards';
        $data['disabled'] = [];

        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());

        return view('outwardscreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->outwards, $data);

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
        $data = Outwards::find($id);
        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                            ->pluck('c_name', Customer::getKeyField());
        $data['o_outwards_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['o_outwards_date'])->format('Y-m-d');
        $data['o_warranty_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['o_warranty_date'])->format('Y-m-d');
        // return $data;
        return view('outwardscreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->outwards, $data, $id, Outwards::getKeyField());
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
        $res = delete($this->outwards, $id, Outwards::getKeyField());
        commit();
        return "success";
    }
}
