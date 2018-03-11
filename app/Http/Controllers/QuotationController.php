<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\User;

class QuotationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Quotation $quotation, User $user, Customer $customer)
    {
        $this->middleware('auth');
        $this->quotation = $quotation;
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

        // dd(Config::get('constants.Quotation.prefix'));
        if ($request->ajax()) {
            // dd($request->ajax());

            $data =  execSelect("
                SELECT q.quotation_id,
                        COALESCE(c.c_name,'NA') AS party_name,
                        DATE_FORMAT(q.q_quotation_date, '%W %M %e %Y') as quotation_date,
                        q.q_address as address,
                        q.q_contact_number as contact_number,
                        q.q_reference as reference,
                        q.q_quantity as quantity,
                        q.q_rate as rate,
                        q.q_subtotal as subtotal,
                        q.q_taxes as taxes,
                        q.q_product_description as product_description,
                        q.q_email as email,
                        q.q_total as total,
                        q.q_warranty_product AS warranty_product,
                        q.q_warranty_chargable AS warranty_chargable,
                        DATE_FORMAT(q.q_warranty_date, '%W %M %e %Y') AS warranty_date
                FROM quotation q
                    LEFT JOIN
                customers c ON c.customers_id = q.q_party_name;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->quotation);
        $data['columns'] = excludeColumn(getColumnList($this->quotation), ['rate','subtotal','taxes','quantity','product_description','total']); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], []);
        
        $data['pk'] = Quotation::getKeyField();
        $data['prefix'] = config('constants.Quotation.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('quotation', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'quotation';
        $data['disabled'] = [];

        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());
        return view('quotationcreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->quotation, $data);

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
        $data = Quotation::find($id);
        $data['party_name'] = Customer::orderBy(Customer::getKeyField(), 'desc')
                                    ->pluck('c_name', Customer::getKeyField());
        $data['q_quotation_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['q_quotation_date'])->format('Y-m-d');
        $data['q_warranty_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['q_warranty_date'])->format('Y-m-d');
        // return $data;
        return view('quotationcreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->quotation, $data, $id, Quotation::getKeyField());
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
        $res = delete($this->quotation, $id, Quotation::getKeyField());
        commit();
        return "success";
    }
}
