<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Maintainance;
use App\Models\User;

class MaintainanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Maintainance $maintainance, User $user)
    {
        $this->middleware('auth');
        $this->maintainance = $maintainance;
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
                SELECT maintainance_id,
                        m_type as type,
                        m_name as name,
                        m_product_serial_number as product_serial_number,
                        DATE_FORMAT(m_from_date, '%W %M %e %Y') as from_date,
                        DATE_FORMAT(m_to_date, '%W %M %e %Y') as to_date,
                        m_quantity as quantity,
                        m_subtotal as subtotal,
                        m_taxes as taxes,
                        m_total as total
                    FROM maintainance;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->maintainance);
        $data['columns'] = excludeColumn(getColumnList($this->maintainance), []); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], []);
        
        $data['pk'] = Maintainance::getKeyField();
        $data['prefix'] = config('constants.Maintainance.prefix');

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('maintainance', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'maintainance';
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
}
