<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  execSelect("
                    SELECT 
                        u.id,
                        u.name AS name,
                        u.email AS email
                    FROM
                        users u
                    ORDER BY u.id DESC;", []);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        


        $data['columns'] = excludeColumn(getColumnList($this->user), []); // Array to be excluded.
        $data['columns'] = array_merge([], $data['columns'], []);
        
        $data['pk'] = User::getKeyField();

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];
        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);

        return view('vendor', ['data' => $data]);
    }


    public function create() 
    {
        return view('vendorcreate');
    }
}
