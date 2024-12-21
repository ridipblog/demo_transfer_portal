<?php

namespace App\Http\Controllers;

use App\Models\Public\DepertmentModel;
use App\Models\Public\DepertPostsMapModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Public\PostsNameModel;
use App\our_modules\reuse_modules\ReuseModule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index()
    {
        $view_data = [
            'depertments' => [],
            'posts' => [],
            'map_data' => []
        ];
        try {
            $view_data['depertments'] = DepertmentModel::get();
            $view_data['posts'] = PostsNameModel::get();
            $main_query = DepertPostsMapModel::query()->with(['deptartments', 'post_names']);
            $view_data['map_data'] = $main_query->orderBy('dept_id')->get();
        } catch (Exception $err) {
            dd($err->getMessage());
        }
        return view('add_post_table', [
            'view_data' => $view_data
        ]);
    }

    public function addPost(Request $request)
    {
        $depertment_id = $request->depertment;
        $select_post = $request->select_post;
        $input_post = $request->input_post;
        $grade_type = $request->grade_type;
        $grade_pay = $request->grade_pay;
        $message = null;
        try {
            DB::beginTransaction();
            if (!$select_post) {
                $save_post = PostsNameModel::create([
                    'name' => $input_post,
                    'type' => $grade_type
                ]);
                $select_post = $save_post->id;
            }
            DepertPostsMapModel::create([
                'dept_id' => $depertment_id,
                'post_id' => $select_post,
                'grade_pay' => $grade_pay
            ]);
            DB::commit();
        } catch (Exception $err) {
            DB::rollBack();
            dd($err->getMessage());
        }
        return redirect()->route('add.post.name.index')->with('message', 'Data Inserted ');
    }
    // ----------------- add office details ----------------------
    public function addOfficeDetails(Request $request)
    {
        // $districts = DistrictModel::get();
        // $districts = $districts->pluck('id')->toArray();
        // $map_data = array_map(function ($district_id) {
        //     return ['office_id' => 1, 'district_id' => $district_id, 'depertment_id' => 12];
        // }, $districts);
        // OfficesDistDeptModel::insert($map_data);
        try {
            $districts = DistrictModel::get();
            $depertments = DepertmentModel::get();
            $office_details = OfficesDistDeptModel::query()->with([
                'office_fin_assam',
                'deptartments',
                'districts'
            ])->get();
            return view('add_office_details', [
                'districts' => $districts,
                'depertments' => $depertments,
                'office_details' => $office_details
            ]);
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }
    public function addOfficeDetailsPost(Request $request)
    {


        try {
            $incomming_data = [
                'office' => 'required',
                'district' => 'required|array',
                'depertment' => 'required'
            ];
            $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
            if ($validate->fails()) {
                return redirect()->route('add.office.details')->with('message', 'Fill all required fields ');
            } else {
                $save_office = OfficeFinAsssamModel::create([
                    'name' => $request->office,
                ]);
                $map_data = array_map(function ($district_id) use ($save_office, $request) {
                    return ['office_id' => $save_office->id, 'district_id' => $district_id, 'depertment_id' => $request->depertment];
                }, $request->district);
                OfficesDistDeptModel::insert($map_data);
                return redirect()->route('add.office.details')->with('message', 'Data insert ');
            }
        } catch (Exception $err) {
            dd($err->getMessage());
        }
    }
}
