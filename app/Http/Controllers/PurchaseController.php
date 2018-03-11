<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\User;

class PurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase, User $user, Vendor $vendor)
    {
        $this->middleware('auth');
        $this->purchase = $purchase;
        $this->vendor = $vendor;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd(Config::get('constants.Purchase.prefix'));
        if ($request->ajax()) {

            $data =  execSelect("
                    SELECT  p.purchase_id,
                            COALESCE(v.v_name,'NA') AS party_name,
                            DATE_FORMAT(p.p_purchase_date, '%W %M %e %Y') as purchase_date,
                            p.p_address as address,
                            p.p_contact_number as contact_number,
                            p.p_reference as reference,
                            p.p_quantity as quantity,
                            p.p_rate as rate,
                            p.p_subtotal as subtotal,
                            p.p_taxes as taxes,
                            p.p_product_description as product_description,
                            p.p_email as email,
                            p.p_total as total,
                            p.p_warranty_product AS warranty_product,
                            p.p_warranty_chargable AS warranty_chargable,
                            DATE_FORMAT(p.p_warranty_date, '%W %M %e %Y') AS warranty_date
                    FROM purchase p
                        LEFT JOIN
                    vendors v ON v.vendors_id = p.p_party_name;", []);
            
            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->purchase);
        $data['columns'] = excludeColumn(getColumnList($this->purchase), []); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], []);
        
        $data['pk'] = Purchase::getKeyField();
        $data['prefix'] = config('constants.Purchase.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('purchase', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'purchase';
        $data['disabled'] = [];

        $data['party_name'] = Vendor::orderBy(Vendor::getKeyField(), 'desc')
                                    ->pluck('v_name', Vendor::getKeyField());
        return view('purchasecreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->purchase, $data);

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
        $data = Purchase::find($id);
        $data['party_name'] = Vendor::orderBy(Vendor::getKeyField(), 'desc')
                                    ->pluck('v_name', Vendor::getKeyField());
        $data['p_purchase_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['p_purchase_date'])->format('Y-m-d');
        $data['p_warranty_date'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['p_warranty_date'])->format('Y-m-d');
        // return $data;
        return view('purchasecreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->purchase, $data, $id, Purchase::getKeyField());
        commit();

        return redirect('/'.$request->segment(1));
    }

    //create function to return customer data from inwards create screen
    public function getCustomerData(Request $request) 
    {
        $data = $request->all();

        $res = Vendor::find($data['id']);
        return $res;

    }

    public function destroy($id)
    {
        beginTransaction();
        $res = delete($this->purchase, $id, Purchase::getKeyField());
        commit();
        return "success";
    }
}
