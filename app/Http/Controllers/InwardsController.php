<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Inwards;
use App\Models\User;

class InwardsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Inwards $inwards, User $user)
    {
        $this->middleware('auth');
        $this->inwards = $inwards;
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
                SELECT inwards_id,
                        i_party_name as party_name,
                        DATE_FORMAT(i_inwards_date, '%W %M %e %Y') as inwards_date,
                        i_address as address,
                        i_contact_number as contact_number,
                        i_quantity as quantity,
                        i_problem as problem,
                        i_remark as remark,
                        i_product_description as product_description,
                        i_accessories as accessories,
                        i_warranty as warranty
                    FROM inwards;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->inwards);
        $data['columns'] = excludeColumn(getColumnList($this->inwards), []); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], []);
        
        $data['pk'] = Inwards::getKeyField();
        $data['prefix'] = config('constants.Inwards.prefix');

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('inwards', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'inwards';
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
}
