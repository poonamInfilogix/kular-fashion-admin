<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DepartmentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Department;
use Exception;

class DepartmentController extends Controller
{
    public function departments(Request $request)
    {
        $per_page = $request->per_page ?? 1; 
        $page =  $request->page ?? 1;

        $departments = Department::where('status','Active')->paginate($per_page,['*'],'page',$page); 
        if($departments)
        {
            return new DepartmentCollection($departments); 
        }
    }
}
