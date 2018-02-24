<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Vendor;
use App\Models\User;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor, User $user)
    {
        $this->middleware('auth');
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

        // dd(Config::get('constants.Customer.prefix'));
        if ($request->ajax()) {
            // dd($request->ajax());

            $data =  execSelect("
                SELECT vendors_id,
                        v_name as name,
                        v_telephone as telephone,
                        v_company_name as company_name,
                        v_email as email,
                        v_address as address,
                        v_gst as gst,
                        v_product_dealin as product_dealin,
                        DATE_FORMAT(v_birthday, '%W %M %e %Y') as birthday
                    FROM vendors;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->vendor);
        $data['columns'] = excludeColumn(getColumnList($this->vendor), []); // Array to be excluded.
        $data['columns'] = array_merge(['activity'], $data['columns'], []);
        
        $data['pk'] = Vendor::getKeyField();
        $data['prefix'] = config('constants.Vendor.prefix');

        $data['disable_footer_column'] = ['activity'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('vendor', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'vendors';
        return view('vendorcreate', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $save_cond =  $request->save;
        
        beginTransaction();

        $response = create($this->vendor, $data);

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
        $data = Vendor::find($id);
        // return $data;
        return view('vendorcreate', ['data' => $data]);
    }

    public function update(Request $request, $id) 
    {
        $data = $request->all();
        // return $data;
        beginTransaction();
            fillUpdate($this->vendor, $data, $id, Vendor::getKeyField());
        commit();

        return redirect('/'.$request->segment(1));
    }
}
