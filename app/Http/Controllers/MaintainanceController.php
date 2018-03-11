<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Maintainance;
use App\Models\Customer;
use App\Models\User;

class MaintainanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Maintainance $maintainance, User $user, Customer $customer)
    {
        $this->middleware('auth');
        $this->maintainance = $maintainance;
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
                SELECT  mnt.maintainance_id,
                        COALESCE(c.c_name,'NA') AS party_name,
                        mnt.mnt_type as type,
                        mnt.mnt_name as name,
                        mnt.mnt_product_serial_number as product_serial_number,
                        DATE_FORMAT(mnt.mnt_from_date, '%W %M %e %Y') as from_date,
                        DATE_FORMAT(mnt.mnt_to_date, '%W %M %e %Y') as to_date,
                        mnt.mnt_rate as rate,
                        mnt.mnt_quantity as quantity,
                        mnt.mnt_subtotal as subtotal,
                        mnt.mnt_taxes as taxes,
                        mnt.mnt_total as total
                FROM 
                maintainance mnt
                    LEFT JOIN
                customers c ON c.customers_id = mnt.mnt_party_name;", []);


                // SELECT maintainance_id,
                //         mnt_type as type,
                //         mnt_name as name,
                //         mnt_product_serial_number as product_serial_number,
                //         DATE_FORMAT(mnt_from_date, '%W %M %e %Y') as from_date,
                //         DATE_FORMAT(mnt_to_date, '%W %M %e %Y') as to_date,
                //         mnt_rate as rate,
                //         mnt_quantity as quantity,
                //         mnt_subtotal as subtotal,
                //         mnt_taxes as taxes,
                //         mnt_total as total
                //     FROM maintainance;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->maintainance);
        $data['columns'] = excludeColumn(getColumnList($this->maintainance), []); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], []);
        
        $data['pk'] = Maintainance::getKeyField();
        $data['prefix'] = config('constants.Maintainance.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('maintainance', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'maintainance';
        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());
        return view('maintainancecreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->maintainance, $data);

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
        $data = Maintainance::find($id);
        $data['mnt_from_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['mnt_from_date'])->format('Y-m-d');
        $data['mnt_to_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['mnt_to_date'])->format('Y-m-d');
        // return $data;
        return view('maintainancecreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->maintainance, $data, $id, Maintainance::getKeyField());
        commit();

        return redirect('/'.$request->segment(1));
    }

    public function destroy($id)
    {
        beginTransaction();
        $res = delete($this->maintainance, $id, Maintainance::getKeyField());
        commit();
        return "success";
    }
}
