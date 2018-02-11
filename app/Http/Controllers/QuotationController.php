<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\Models\User;

class QuotationController extends Controller
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
                        u.email AS email,
                        REPLACE(GROUP_CONCAT(concat('<span class = \'label bg-sharekhan\'>',r.name,'</span>')), ',', ' ') AS role,
                        sc.code_desc AS status
                    FROM
                        users u
                            LEFT JOIN
                        (SELECT 
                            sc.code_id, sc.code_desc, sc.code_val
                        FROM
                            system_codes sc
                        WHERE
                            code_id = ?) sc ON u.status = sc.code_val
                            LEFT JOIN
                        (SELECT 
                            ru.id, r.name, ru.user_id
                        FROM
                            role_user ru
                        LEFT JOIN roles r ON ru.role_id = r.id) AS r ON u.id = r.user_id
                    GROUP BY u.id
                    ORDER BY u.id DESC;", [config('constants.CODE_ID_STATUS')]);

            $data = collect($data);
            return Datatables::of($data)->make(true);
        }
        


        $data['columns'] = excludeColumn(getColumnList($this->user), ['emp_id']); // Array to be excluded.
        $data['columns'] = array_merge(['user_action', 'role'], $data['columns'], []);
        
        $data['pk'] = User::getKeyField();

        $data['disable_footer_column'] = ['action'];
        $data['disable_footer_search'] = [];
        
        $data['disable_footer_search'] = getIndex($data['disable_footer_column'], $data['columns']);

        return view('quotation', ['data' => $data]);
    }


    public function create() 
    {
        return view('quotationcreate');
    }
}
