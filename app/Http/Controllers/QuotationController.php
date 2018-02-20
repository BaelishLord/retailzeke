<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Quotation;
use App\Models\User;

class QuotationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Quotation $quotation, User $user)
    {
        $this->middleware('auth');
        $this->quotation = $quotation;
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
                    SELECT quotation_id,
                            q_name as name,
                            DATE_FORMAT(q_quotation_date, '%W %M %e %Y') as quotation_date,
                            q_address as address,
                            q_contact_number as contact_number,
                            q_reference as reference,
                            q_quantity as quantity,
                            q_rate as rate,
                            q_subtotal as subtotal,
                            q_taxes as taxes,
                            q_product_description as product_description,
                            q_total as total,
                            q_warranty as warranty
                        FROM quotation;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        
        // return getColumnList($this->quotation);
        $data['columns'] = excludeColumn(getColumnList($this->quotation), []); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], []);
        
        $data['pk'] = Quotation::getKeyField();
        $data['prefix'] = config('constants.Quotation.prefix');

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];

        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);
        return view('quotation', ['data' => $data]);
    }


    public function create() 
    {
        $data['user'] = [];
        $data['screen_name'] = 'quotation';
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
}
