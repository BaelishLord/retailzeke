<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Outwards;
use App\Models\User;

class OutwardsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Outwards $outwards, User $user)
    {
        $this->middleware('auth');
        $this->outwards = $outwards;
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
                SELECT outwards_id,
                        o_party_name as party_name,
                        DATE_FORMAT(o_outwards_date, '%W %M %e %Y') as outwards_date,
                        o_address as address,
                        o_contact_number as contact_number,
                        o_quantity as quantity,
                        o_orderby as order_by,
                        o_product_description as product_description,
                        o_warranty as warranty
                    FROM outwards;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->outwards);
        $data['columns'] = excludeColumn(getColumnList($this->outwards), ['orderby']); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], ['order_by']);
        
        $data['pk'] = Outwards::getKeyField();
        $data['prefix'] = config('constants.Outwards.prefix');

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('outwards', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'outwards';
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
}
