<?php

namespace App\Http\Controllers\employees_access\verification\candidate;

use App\Http\Controllers\Controller;
use App\Http\Controllers\employees_access\verification\VerificationController;
use App\Models\authority_office_dist_map;
use App\Models\department\departments;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\OfficesDistDeptModel;
use App\Models\Public\RolesModel;
use App\Models\Transfer\TransfersModel;
use App\Models\trash\RejectedDocumentsModel;
use App\Models\User\DocumentModel;
use App\Models\verification\rejections;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User_auth\AllLoginModel;
use App\Models\User_auth\UserCredentialsModel;
use App\Models\verification\appointing_authorities;
use App\Models\verification\VerificationRemarksDocumentModel;
// use App\Models\verification_documents;
use App\our_modules\employees_modules\EmployeeModule;
use App\our_modules\reuse_modules\ReuseModule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;






class CandidateController extends Controller
{

    // department ///////////////////////////////
    public function department_fetch_candidates_approval(Request $request)
    {
        // dd('here');
        $user = Auth::guard('user_guard')->user();
        $roleName = '';
        if ($user) {
            $roleName = $user->roles->role;
        } else {
            dd('Unauthorized');
        }
        try {
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)->get();
            $dir = authority_office_dist_map::where('user_id', $user->id)->where('role_id', 2)->pluck('directorate_id')->first();
            $pendingTransfers = TransfersModel::leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('persional_details as employee_personal_details', 'employee.id', '=', 'employee_personal_details.user_id')
                ->leftJoin('persional_details as target_employee_personal_details', 'target_employee.id', '=', 'target_employee_personal_details.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->where('employee_employment.depertment_id', $verifier->department)
                ->where('target_employee_employment.depertment_id', $verifier->department)
                ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id', 'transafers.jto_generate_status', 'transafers.transfer_ref_code', 'transafers.2nd_recommend as second_recommend')
                ->orderBy('transafers.updated_at', 'desc');
            if ($dir != null && $dir != 0) {
                $pendingTransfers->where('employee_employment.directorate_id', $dir)->where('target_employee_employment.directorate_id', $dir);
            }
            if ($request->input('office') != null || $request->input('district') != null || $request->input('post') != null || $request->input('pan_search') != null) {
                $data = $pendingTransfers
                    ->leftJoin('offices_finassam as employee_offices', 'employee_employment.office_id', '=', 'employee_offices.id')
                    ->leftJoin('offices_finassam as target_employee_offices', 'target_employee_employment.office_id', '=', 'target_employee_offices.id')
                    ->leftJoin('districts as employee_district', 'employee_employment.district_id', '=', 'employee_district.id')
                    ->leftJoin('districts as target_employee_district', 'target_employee_employment.district_id', '=', 'target_employee_district.id')
                    ->when($request->input('pan_search') != null, function ($query) use ($request) {
                        $searchTerm = $request->input('pan_search');
                        $query->where(function ($query) use ($searchTerm) {
                            $query->where('employee_personal_details.pan_number', $searchTerm)
                                ->orWhere('employee.full_name', 'LIKE', "%$searchTerm%")
                                ->orWhere('target_employee_personal_details.pan_number', $searchTerm)
                                ->orWhere('target_employee.full_name', 'LIKE', "%$searchTerm%");
                        });
                    })
                    ->when($request->input('office') !== null && $request->input('office') != 'All', function ($query) use ($request) {
                        return $query->where(function ($q) use ($request) {
                            $q->where('employee_offices.id', $request->input('office'))
                                ->orWhere('target_employee_offices.id', $request->input('office'));
                        });
                    })
                    ->when($request->input('district') !== null && $request->input('district') != 'All', function ($query) use ($request) {
                        return $query->where(function ($q) use ($request) {
                            $q->where('employee_district.id', $request->input('district'))
                                ->orWhere('target_employee_district.id', $request->input('district'));
                        });
                    })
                    ->when($request->input('post') != null && $request->input('post') != 'All', function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where('employee_employment.designation_id', $request->input('post'))
                                ->orWhere('target_employee_employment.designation_id', $request->input('post'));
                        });
                    })
                    ->when($authority_maps->isNotEmpty(), function ($query) use ($authority_maps, $request) {
                        if ($request->input('office') == null && $request->input('district') == null) {
                            return $query->where(function ($query) use ($authority_maps) {
                                foreach ($authority_maps as $map) {
                                    $query->orWhere(function ($subQuery) use ($map) {
                                        if ($map->office_id && is_null($map->district_id)) {
                                            $subQuery->where('employee_employment.office_id', $map->office_id)
                                                ->orWhere('target_employee_employment.office_id', $map->office_id);
                                        } elseif ($map->district_id && is_null($map->office_id)) {
                                            // Only district_id is available
                                            $subQuery->where('employee_employment.district_id', $map->district_id)
                                                ->orWhere('target_employee_employment.district_id', $map->district_id);
                                        } elseif ($map->office_id && $map->district_id) {
                                            $subQuery->where(function ($nestedQuery) use ($map) {
                                                $nestedQuery->where('employee_employment.office_id', $map->office_id)
                                                    ->where('employee_employment.district_id', $map->district_id);
                                            })->orWhere(function ($nestedQuery) use ($map) {
                                                $nestedQuery->where('target_employee_employment.office_id', $map->office_id)
                                                    ->where('target_employee_employment.district_id', $map->district_id);
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
            } else {
                $data = $pendingTransfers->whereIn('final_approval', [0, 1])->where('request_status', 1);
            }
            // dd($data->get());
            // dd($data);
            $type = 'pending';
            if ($request->input('status') != '') {
                $type = $request->input('status');
            }
            if ($request->input('status') == 'approved') {
                // dd('heere');
                $verified_users = $data->where('request_status', 1)->where('final_approval', 1)->get();
            } else if ($request->input('status') == 'pending') {
                $verified_users = $data->where('request_status', 1)->where('final_approval', 0)->get();
            } else {
                $verified_users = $data->where('request_status', 1)->where('final_approval', 0)->get();
            }
            $verified_users = $verified_users->map(function ($user) {
                $user->encrypted_id = Crypt::encryptString($user->id);
                return $user;
            });
            return response()->json([
                'status' => 200,
                'type' => $type,
                'user_role' => $roleName,
                'data' => $verified_users,
            ]);
        } catch (Exception $e) {
            Log::error('Fetch candidate: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }





    public function department_candidate_profile($lang = null, $id = null, $status = null)
    {
        try {
            $id = Crypt::decryptString($id);
            $pendingTransfers = TransfersModel::where('id', $id)->first();

            // for employee
            $conditions = [
                ['id', $pendingTransfers->employee_id],
            ];
            $query = EmployeeModule::getEmployeesAllData($conditions);
            $data = $query->get();

            $docs = VerificationRemarksDocumentModel::where('user_id', $pendingTransfers->employee_id)->get();
            if ($docs->isEmpty()) {
                $docs = [];
            }
            $docPaths = [];
            foreach ($docs as $d) {
                $docPaths[] = [
                    'document_location' => $d->document_location,
                    'remarks' => $d->remarks,
                ];
            }
            // for target employee
            $conditions2 = [
                ['id', $pendingTransfers->target_employee_id],
            ];
            $query2 = EmployeeModule::getEmployeesAllData($conditions2);
            $data2 = $query2->get();

            $docs2 = VerificationRemarksDocumentModel::where('user_id', $pendingTransfers->target_employee_id)->get();
            if ($docs2->isEmpty()) {
                $docs2 = [];
            }
            $docPaths2 = [];
            foreach ($docs2 as $d) {
                $docPaths2[] = [
                    'document_location' => $d->document_location,
                    'remarks' => $d->remarks,
                ];
            }
            if (count($data) == 0 || count($data2) == 0) {
                dd("No Data found ");
            }

            if ($data[0]->verified_by != null) {
                $verified_by = appointing_authorities::where('id', $data[0]->verified_by)->first();
                $verified_on = $data2[0]->verified_on;
                if ($verified_by != null) {
                    $department_name = departments::where('id', $verified_by->department)->pluck('name')->first();
                    if ($verified_by->office != null && ($data2[0]->employment_details->office_id == $verified_by->office)) {
                        $office_name = OfficeFinAsssamModel::where('id', $verified_by->office)->pluck('name')->first();
                    } else {
                        $office_name = 'All Office';
                    }
                } else {
                    $verified_by = [];
                    $verified_on = [];
                    $office_name = null;
                    $department_name = null;
                }
            } else {
                $verified_by = [];
                $verified_on = [];
                $office_name = null;
                $department_name = null;
            }

            if ($data[0]->noc_generated_by != null) {
                $noc_generated_by = appointing_authorities::where('id', $data[0]->noc_generated_by)->first();
                $noc_generated_on = $data2[0]->noc_generated_on;
                if ($noc_generated_by != null) {
                    $noc_department_name = departments::where('id', $noc_generated_by->department)->pluck('name')->first();
                    if ($noc_generated_by->office != null && ($data2[0]->employment_details->office_id == $noc_generated_by->office)) {
                        $noc_office_name = OfficeFinAsssamModel::where('id', $noc_generated_by->office)->pluck('name')->first();
                    } else {
                        $noc_office_name = null;
                    }
                } else {
                    $noc_generated_by = [];
                    $noc_generated_on = [];
                    $noc_office_name = null;
                    $noc_department_name = null;
                }
            } else {
                $noc_generated_by = [];
                $noc_generated_on = [];
                $noc_office_name = null;
                $noc_department_name = null;
            }

            $jto_status = $pendingTransfers->jto_generate_status;
            $approved_on = $pendingTransfers->approved_on;
            $approver_remarks = $pendingTransfers->approver_remarks;

            $second_recommend_status = $pendingTransfers->{'2nd_recommend'};
            $second_recommended_by = $pendingTransfers->{'2nd_recommended_by'};

            // TransfersModel::where('employee_id', )

            if ($second_recommended_by != null && $second_recommend_status != 2) {
                $ar = appointing_authorities::where('id',  $second_recommended_by)->first();
                if ($ar != null) {
                    $sr_department_name = departments::where('id', $ar->department)->pluck('name')->first();
                    if ($ar->office != null && ($data2[0]->employment_details->office_id == $ar->office)) {
                        $sr_office_name = OfficeFinAsssamModel::where('id', $ar->office)->pluck('name')->first();
                    } else {
                        $sr_office_name = null;
                    }
                } else {
                    $ar = null;
                    $sr_department_name = null;
                    $sr_office_name = null;
                }
            } else {
                $ar = null;
                $sr_department_name = null;
                $sr_office_name = null;
            }
            $second_recommend_remark = $pendingTransfers->{'2nd_recommend_remarks'};

            $approved_by = $pendingTransfers->{'approved_by'};
            $final_approval_status = $pendingTransfers->{'final_approval'};
            if ($approved_by != null && $final_approval_status == 1) {
                $appr_by = appointing_authorities::where('id',  $approved_by)->first();
                $approved_on = $pendingTransfers->{'approved_on'};
                if ($appr_by != null) {
                    $approver_department_name = departments::where('id', $appr_by->department)->pluck('name')->first();
                    if ($appr_by->office != null && ($data2[0]->employment_details->office_id == $appr_by->office)) {
                        $approver_office_name = OfficeFinAsssamModel::where('id', $appr_by->office)->pluck('name')->first();
                    } else {
                        $approver_office_name = 'All Office';
                    }
                } else {
                    $appr_by = null;
                    $approved_on = null;
                    $approver_department_name = null;
                    $approver_office_name = null;
                }
            } else {
                $appr_by = null;
                $approved_on = null;
                $approver_department_name = null;
                $approver_office_name = null;
            }

            return view('verification.department.profile-details')->with(['approver_department_name' => $approver_department_name, 'approver_office_name' => $approver_office_name, 'sr_office_name' => $sr_office_name, 'sr_department_name' => $sr_department_name, 'noc_department_name' => $noc_department_name, 'noc_office_name' => $noc_office_name, 'department_name' => $department_name, 'office_name' => $office_name, 'approved_by' => $appr_by, 'approved_on' => $approved_on, 'second_recommended_on' => $pendingTransfers->{'2nd_recommended_on'}, 'ar' => $ar, 'srr' => $second_recommend_remark,  'second_recommend_status' => $second_recommend_status, 'second_recommend_status' => $pendingTransfers->{'2nd_recommend'}, 'approver_remarks' => $approver_remarks, 'noc_generated_by' => $noc_generated_by, 'verified_by' => $verified_by, 'noc_generated_on' => $noc_generated_on, 'verified_on' => $verified_on, 'approval_status' => $pendingTransfers->final_approval, 'id' => $id, 'request_date' => \Carbon\Carbon::parse($pendingTransfers->updated_at)->format('d-m-Y'), 'request_number' => $pendingTransfers->transfer_ref_code, 'candidate1' => $data[0], 'candidate2' => $data2[0], 'id' => $id, 'candidate_1_doc' => $docPaths, 'candidate_2_doc' => $docPaths2, 'jto_status' => $jto_status]);
        } catch (Exception $err) {
            Log::error('error fetching profile. [Approval] : ' . $err->getMessage());
            return redirect()->back();
        }
    }



    /////////////////////////



    // view candidate 
    public function candidate_profile_index(Request $request, $lang = null, $id = null, $type = null, $tab_recommend = null)
    {
        // if (!Session::has('profile_user_id')) {
        //     Session::put('profile_user_id', $tab_recommend);
        // }
        // return view('verification.pages.profile_details');
        try {
            Session::forget('allow_recommend');
            if ($tab_recommend != null) {
                $is = Crypt::decryptString($tab_recommend);
                if ($is == 'Yes') {
                    Session::put('allow_recommend', 1);
                } else {
                    Session::forget('allow_recommend');
                }
            }

            if ($tab_recommend != null && $tab_recommend == 1 && Session::has('is_appointing_user')) {
                Session::put('is_appointing_user', 1);
            } elseif (!Session::has('is_appointing_user_reversed')) {
                Session::put('is_appointing_user', 0);
            } else {
                Session::forget('is_appointing_user_reversed');
            }

            $switch_user_id = Auth::guard('user_guard')->user()->id;
            if ($type == null) {
                return redirect('/verifier/verifier-dashboard');
            } else {
                try {
                    $type = Crypt::decryptString($type);
                } catch (Exception $err) {
                    // dd($err->getMessage());
                    return redirect('/verifier/verifier-dashboard');
                }
            }
            $switch_role = RolesModel::where('role', $type)->first();
            if ($switch_role == null) {
                return redirect('/verifier/verifier-dashboard');
            }

            $switch_status = VerificationController::auth_role_change($switch_role->id, $switch_user_id, Auth::guard('user_guard')->user()->user_id);
            if ($switch_status != false) {
                // dd(Auth::guard('user_guard')->roles->role);
                $id = Crypt::decryptString($id);
                //$data = UserCredentialsModel::findOrFail($id);a
                $approver_remarks = null;
                $transfer_data = TransfersModel::where('employee_id', $id)
                    ->orWhere('target_employee_id', $id)
                    ->first();
                if ($transfer_data != null) {
                    $approver_remarks =  $transfer_data->approver_remarks;
                }
                $conditions = [
                    ['id', $id],
                ];
                $query = EmployeeModule::getEmployeesAllData($conditions);

                $data = $query->get();
                $dept = $data[0]->employment_details->depertment_id;

                $conditional_data = DB::table('additional_conditions')->where('department_id', $dept)->get();
                if ($conditional_data->isEmpty()) {
                    $conditional_data = [];
                } else {
                    $conditional_data =  $conditional_data;
                }
                if (count($data) == 0) {
                    dd("No Data found ");
                } else {
                    $data = $data[0];
                    $user = Auth::guard('user_guard')->user();
                    $roleName = '';
                    if ($user) {
                        $roleName = $user->roles->role;
                    }
                    if ($data->profile_verify_status == 2) {
                        return redirect('/verifier/verifier-dashboard');
                    }
                    $docs = VerificationRemarksDocumentModel::where('user_id', $id)->get();
                    if ($docs->isEmpty()) {
                        $docs = [];
                    }
                    $docPaths = [];
                    foreach ($docs as $d) {
                        foreach ($docs as $d) {
                            $docPaths[] = $d->document_location;
                        }
                    }


                    // rejected docs
                    $docs2 = DB::table('rejected_documents')->where('user_id', $id)->where('old_documents', '!=', null)->get();
                    if (count($docs2) == 0) {
                        $docs2 = [];
                    }
                    $docPaths2 = [];
                    foreach ($docs2 as $d) {
                        $docPaths2[] = json_decode($d->old_documents);
                    }
                    // dd($docPaths2);
                    $verifier_office = [];

                    if (!is_null($data->verified_by)) {
                        $mapp_data = authority_office_dist_map::where('user_id', $data->verified_by)->get(['office_id', 'department_id', 'district_id']);

                        if (!$mapp_data->isEmpty()) {
                            foreach ($mapp_data as $m) {
                                if (!is_null($m->office_id)) {
                                    $office_name = OfficeFinAsssamModel::where('id', $m->office_id)->pluck('name')->first();
                                    if ($office_name) {
                                        $verifier_office[] = $office_name;
                                    }
                                } elseif (is_null($m->office_id) && !is_null($m->district_id)) {
                                    $officeIds = OfficesDistDeptModel::where('district_id', $m->district_id)->pluck('office_id')->toArray();
                                    $office_names = OfficeFinAsssamModel::whereIn('id', $officeIds)->pluck('name')->toArray();
                                    $verifier_office = array_merge($verifier_office, $office_names);
                                } elseif (is_null($m->office_id) && is_null($m->district_id) && !is_null($m->department_id)) {
                                    $officeIds = OfficesDistDeptModel::where('depertment_id', $m->department_id)->pluck('office_id')->toArray();
                                    $office_names = OfficeFinAsssamModel::whereIn('id', $officeIds)->pluck('name')->toArray();
                                    $verifier_office = array_merge($verifier_office, $office_names);
                                }
                            }
                        }
                    }
                    $verifier_office = array_unique($verifier_office);
                    $office_name = !empty($verifier_office) ? implode(', ', $verifier_office) : null;

                    if ($data->verified_by != null) {
                        $verified_by = appointing_authorities::where('id', $data->verified_by)->first();
                        if ($verified_by != null) {
                            $department_name = departments::where('id', $verified_by->department)->pluck('name')->first();
                        } else {
                            $department_name = null;
                            $verified_by = [];
                        }
                    } else {
                        $department_name = null;
                        $verified_by = [];
                    }



                    $noc_office = [];

                    if (!is_null($data->verified_by)) {
                        $mapp_data = authority_office_dist_map::where('user_id', $data->verified_by)->get(['office_id', 'department_id', 'district_id']);

                        if (!$mapp_data->isEmpty()) {
                            foreach ($mapp_data as $m) {
                                if (!is_null($m->office_id)) {
                                    $office_name = OfficeFinAsssamModel::where('id', $m->office_id)->pluck('name')->first();
                                    if ($office_name) {
                                        $verifier_office[] = $office_name;
                                    }
                                } elseif (is_null($m->office_id) && !is_null($m->district_id)) {
                                    $officeIds = OfficesDistDeptModel::where('district_id', $m->district_id)->pluck('office_id')->toArray();
                                    $office_names = OfficeFinAsssamModel::whereIn('id', $officeIds)->pluck('name')->toArray();
                                    $verifier_office = array_merge($verifier_office, $office_names);
                                } elseif (is_null($m->office_id) && is_null($m->district_id) && !is_null($m->department_id)) {
                                    $officeIds = OfficesDistDeptModel::where('depertment_id', $m->department_id)->pluck('office_id')->toArray();
                                    $office_names = OfficeFinAsssamModel::whereIn('id', $officeIds)->pluck('name')->toArray();
                                    $verifier_office = array_merge($verifier_office, $office_names);
                                }
                            }
                        }
                    }
                    $verifier_office = array_unique($verifier_office);
                    $verifier_office_name = !empty($verifier_office) ? implode(', ', $verifier_office) : null;
                    if (count($verifier_office) > 1) {
                        $verifier_office_name = 'All Office';
                    }

                    if ($data->noc_generated_by != null) {
                        $noc_generated_by = appointing_authorities::where('id', $data->noc_generated_by)->first();
                        if ($noc_generated_by != null) {
                            $noc_department_name = departments::where('id', $noc_generated_by->department)->pluck('name')->first();
                            if ($noc_generated_by->office != null && ($data->employment_details->office_id == $noc_generated_by->office)) {
                                $noc_office_name = OfficeFinAsssamModel::where('id', $noc_generated_by->office)->pluck('name')->first();
                            } else {
                                $noc_office_name = null;
                            }
                        } else {
                            $noc_office_name = null;
                            $noc_office_name = null;
                            $noc_generated_by = [];
                            $noc_department_name = null;
                        }
                    } else {
                        $noc_office_name = null;
                        $noc_office_name = null;
                        $noc_generated_by = [];
                        $noc_department_name = null;
                    }



                    if ($transfer_data != null) {
                        $srs = $transfer_data->{'2nd_recommended_by'} == null ? null : $transfer_data->{'2nd_recommended_by'};
                        $srs_status = $transfer_data->{'2nd_recommend'};
                        if ($srs != null && $srs_status == 1) {
                            $sr = appointing_authorities::where('id', $srs)->first();
                            $second_Recommend_on = $transfer_data->{'2nd_recommended_on'};
                            if ($sr != null) {
                                $sr_department_name = departments::where('id', $sr->department)->pluck('name')->first();
                                if ($sr->office != null && ($data->employment_details->office_id == $sr->office)) {
                                    $sr_office_name = OfficeFinAsssamModel::where('id', $sr->office)->pluck('name')->first();
                                } else {
                                    $sr_office_name = null;
                                }
                            } else {
                                $sr_office_name = null;
                                $sr_department_name = null;
                            }
                        } else {
                            $sr_office_name = null;
                            $sr_department_name = null;
                            $sr = null;
                            $srr = null;
                            $second_Recommend_on = null;
                        }
                        $srr = $transfer_data->{'2nd_recommend_remarks'};
                    } else {
                        $sr_office_name = null;
                        $sr_department_name = null;
                        $sr = null;
                        $srr = null;
                        $second_Recommend_on = null;
                    }


                    if ($transfer_data != null) {
                        $approved_by = $transfer_data->{'approved_by'};
                        $approval_status = $transfer_data->{'final_approval'};
                        if ($approved_by != null && $transfer_data->{'final_approval'} == 1) {
                            $approved_by = appointing_authorities::where('id', $approved_by)->first();
                            $approved_on = $transfer_data->{'approved_on'};
                            if ($sr != null) {
                                $approver_department_name = departments::where('id', $approved_by->department)->pluck('name')->first();
                                if ($approved_by->office != null && ($data->employment_details->office_id == $approved_by->office)) {
                                    $approver_office_name = OfficeFinAsssamModel::where('id', $approved_by->office)->pluck('name')->first();
                                } else {
                                    $approver_office_name = null;
                                }
                            } else {
                                $approver_office_name = null;
                                $approver_department_name = null;
                            }
                        } else {
                            $approver_office_name = null;
                            $approver_department_name = null;
                            $approved_by = null;
                            $approved_on = null;
                        }

                        if ($approved_by != null) {
                            $mapp_data = authority_office_dist_map::where('user_id', $approved_by)->get(['office_id', 'department_id', 'district_id']);

                            if (!$mapp_data->isEmpty()) {
                                foreach ($mapp_data as $m) {
                                    if (!is_null($m->office_id)) {
                                        $office_name = OfficeFinAsssamModel::where('id', $m->office_id)->pluck('name')->first();
                                        if ($office_name) {
                                            $verifier_office[] = $office_name;
                                        }
                                    } elseif (is_null($m->office_id) && !is_null($m->district_id)) {
                                        $officeIds = OfficesDistDeptModel::where('district_id', $m->district_id)->pluck('office_id')->toArray();
                                        $office_names = OfficeFinAsssamModel::whereIn('id', $officeIds)->pluck('name')->toArray();
                                        $verifier_office = array_merge($verifier_office, $office_names);
                                    } elseif (is_null($m->office_id) && is_null($m->district_id) && !is_null($m->department_id)) {
                                        $officeIds = OfficesDistDeptModel::where('depertment_id', $m->department_id)->pluck('office_id')->toArray();
                                        $office_names = OfficeFinAsssamModel::whereIn('id', $officeIds)->pluck('name')->toArray();
                                        $verifier_office = array_merge($verifier_office, $office_names);
                                    }
                                }
                            }
                        }
                        $approver_office = array_unique($verifier_office);
                        $approver_office_name = !empty($verifier_office) ? implode(', ', $verifier_office) : null;
                        if (count($verifier_office) > 1) {
                            $approver_office_name = 'All Office';
                        }
                    } else {
                        $approval_status = null;
                        $approver_department_name = null;
                        $approver_office_name = null;
                        $approved_by = null;
                        $approved_on = null;
                    }
                    $rej = DB::table('rejected_documents')->where('user_id', $data->id)->count();

                    $conditions = DB::table('checkbox_conditions')->where('status', 1)->get();
                    return view('verification.pages.profile_details')->with(['conditions' => $conditions, 'verifier_office1' => $verifier_office_name, 'approver_officer1' => $approver_office_name, 'cond' => $conditional_data, 'rej' => $rej, 'approval_status' => $approval_status, 'docs2' => $docPaths2, 'approver_department_name' => $approver_department_name, 'approver_office_name' => $approver_office_name, 'sr_department_name' => $sr_department_name, 'sr_office_name' => $sr_office_name, 'noc_department_name' => $noc_department_name, 'noc_office_name' => $noc_office_name, 'department_name' => $department_name, 'office_name' => $office_name, 'approved_by' => $approved_by, 'approved_on' => $approved_on, 'second_recommended_on' => $second_Recommend_on, 'sr' => $sr, 'srr' => $srr,  'approver_remarks' => $approver_remarks, 'candidate' => $data, 'user_role' => $roleName, 'docs' => $docs, 'verified_by' => $verified_by, 'noc_generated_by' => $noc_generated_by]);
                }
            } else {
                return redirect('/verifier/verifier-dashboard');
            }
        } catch (Exception $err) {
            dd($err->getMessage());
            Log::error('verification profile: ' . $err->getMessage());
            return redirect()->back();
        }
    }

    public function fetch_noc_pending_candidates(Request $request)
    {
        try {
            $user = Auth::guard('user_guard')->user();
            $roleName = '';
            if ($user) {
                $roleName = $user->roles->role;
            }
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            if ($request->input('office') != null) {
                if ($request->input('office') == 'All') {
                    $data = UserCredentialsModel::where('profile_verify_status', 1)->where('noc_generate', 0)
                        ->leftJoin('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                        ->leftJoin('districts', 'employment_details.district_id', '=', 'districts.id')
                        ->leftJoin('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                        ->leftJoin('post_names as employee_post', 'employment_details.designation_id', '=', 'employee_post.id')
                        ->leftJoin('documents', function ($join) {
                            $join->on('user_credentials.id', '=', 'documents.user_id')
                                ->where('documents.document_type', '=', 1);
                        })
                        ->where('employment_details.depertment_id', $verifier->department)
                        ->when($roleName == 'Appointing Authority', function ($query) use ($verifier) {
                            if ($verifier->district !== null) {
                                return $query->where('employment_details.district_id', $verifier->district);
                            }
                            return $query;
                        })
                        ->when($roleName != 'Appointing Authority', function ($query) use ($verifier) {
                            return $query->where('employment_details.district_id', $verifier->district);
                            return $query;
                        })
                        ->select(
                            'user_credentials.*',
                            'documents.documet_location as photo_path',
                            'employee_post.name as employee_post',
                            'districts.name as district_name',
                            'deptartments.name as department_name',
                            'user_credentials.id as id'
                        )
                        ->orderBy('user_credentials.updated_at', 'desc')
                        ->get();
                } else {
                    $data = UserCredentialsModel::where('profile_verify_status', 1)->where('noc_generate', 0)
                        ->leftJoin('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                        ->leftJoin('districts', 'employment_details.district_id', '=', 'districts.id')
                        ->leftJoin('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                        ->leftJoin('post_names as employee_post', 'employment_details.designation_id', '=', 'employee_post.id')
                        ->leftJoin('documents', function ($join) {
                            $join->on('user_credentials.id', '=', 'documents.user_id')
                                ->where('documents.document_type', '=', 1);
                        })
                        ->where('employment_details.depertment_id', $verifier->department)
                        ->when($roleName == 'Appointing Authority', function ($query) use ($verifier) {
                            if ($verifier->district !== null) {
                                return $query->where('employment_details.district_id', $verifier->district);
                            }
                            return $query;
                        })
                        ->when($roleName != 'Appointing Authority', function ($query) use ($verifier) {
                            return $query->where('employment_details.district_id', $verifier->district);
                            return $query;
                        })
                        ->where('employment_details.office_id', $request->input('office'))
                        ->select(
                            'user_credentials.*',
                            'documents.documet_location as photo_path',
                            'employee_post.name as employee_post',
                            'districts.name as district_name',
                            'deptartments.name as department_name',
                            'user_credentials.id as id'
                        )
                        ->orderBy('user_credentials.updated_at', 'desc')
                        ->get();
                }
            } elseif ($request->input('pan_search') != null) {
                // dd($request->input('pan_search'));
                $data = UserCredentialsModel::where('profile_verify_status', 1)->where('noc_generate', 0)
                    ->leftJoin('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                    ->leftJoin('districts', 'employment_details.district_id', '=', 'districts.id')
                    ->leftJoin('persional_details', 'user_credentials.id', '=', 'persional_details.user_id')
                    ->leftJoin('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                    ->leftJoin('documents', function ($join) {
                        $join->on('user_credentials.id', '=', 'documents.user_id')
                            ->where('documents.document_type', '=', 1);
                    })
                    ->leftJoin('post_names as employee_post', 'employment_details.designation_id', '=', 'employee_post.id')
                    ->where('employment_details.depertment_id', $verifier->department)
                    ->when($roleName == 'Appointing Authority', function ($query) use ($verifier) {
                        if ($verifier->district !== null) {
                            return $query->where('employment_details.district_id', $verifier->district);
                        }
                        return $query;
                    })
                    ->when($roleName != 'Appointing Authority', function ($query) use ($verifier) {
                        return $query->where('employment_details.district_id', $verifier->district);
                        return $query;
                    })
                    ->where(function ($query) use ($request) {
                        $searchTerm = $request->input('pan_search');
                        $query->where('persional_details.pan_number', $searchTerm)
                            ->orWhere('user_credentials.full_name', 'LIKE', "%$searchTerm%");
                    })
                    ->select(
                        'user_credentials.*',
                        'documents.documet_location as photo_path',
                        'employee_post.name as employee_post',
                        'districts.name as district_name',
                        'deptartments.name as department_name',
                        'user_credentials.id as id'
                    )
                    ->orderBy('user_credentials.updated_at', 'desc')
                    ->get();

                // dd($data);
            } else {
                $data = UserCredentialsModel::where('profile_verify_status', 1)->where('noc_generate', 0)
                    ->leftJoin('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                    ->leftJoin('districts', 'employment_details.district_id', '=', 'districts.id')
                    ->leftJoin('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                    ->leftJoin('post_names as employee_post', 'employment_details.designation_id', '=', 'employee_post.id')
                    ->leftJoin('documents', function ($join) {
                        $join->on('user_credentials.id', '=', 'documents.user_id')
                            ->where('documents.document_type', '=', 1);
                    })
                    ->where('employment_details.depertment_id', $verifier->department)
                    ->when($roleName == 'Appointing Authority', function ($query) use ($verifier) {
                        if ($verifier->district !== null) {
                            return $query->where('employment_details.district_id', $verifier->district);
                        }
                        return $query;
                    })
                    ->when($roleName != 'Appointing Authority', function ($query) use ($verifier) {
                        return $query->where('employment_details.district_id', $verifier->district);
                        return $query;
                    })
                    ->select(
                        'user_credentials.*',
                        'documents.documet_location as photo_path',
                        'employee_post.name as employee_post',
                        'districts.name as district_name',
                        'deptartments.name as department_name',
                        'user_credentials.id as id'
                    )
                    ->orderBy('user_credentials.updated_at', 'desc')
                    ->get();
            }
            $type = 'pending';
            // dd($request->input('status'));
            $verified_users = $data->map(function ($user) {
                $user->encrypted_id = Crypt::encryptString($user->id);
                return $user;
            });
            return response()->json([
                'status' => 200,
                'type' => $type,
                'user_role' => $roleName,
                'data' => $verified_users,
            ]);
        } catch (Exception $e) {
            Log::error('Fetch candidate: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function noc_pending_index()
    {
        $id = Auth::guard('user_guard')->user()->user_id;
        $userD = appointing_authorities::where('id', $id)->first();
        if (Auth::guard('user_guard')->check()) {
            $user = Auth::guard('user_guard')->user();
            $roleName = '';
            if ($user) {
                $roleName = $user->roles->role;
            }
            if ($roleName == 'Appointing Authority') {
                $office = OfficeFinAsssamModel::where('department_id', $userD->department)->when($userD->district !== null, function ($query) use ($userD) {
                    return $query->where('district_id', $userD->district);
                })->get();
            } else {
                $office = OfficeFinAsssamModel::where('department_id', $userD->department)->where('district_id', $userD->district)->get();
            }

            return view('verification.pages.noc_pending')->with(['office' => $office]);
        } else {
            return redirect()->back();
        }
    }

    public function fetch_noc_pending_profiles_json($request = null)
    {
        try {
            $user = Auth::guard('user_guard')->user();
            $roleName = '';
            if ($user) {
                $roleName = $user->roles->role;
            }
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            if ($request['district'] != null || $request['office'] != null || $request['pan_search'] != null || $request['post'] != null) {
                $data = $this->generate_query($type = Auth::guard('user_guard')->user()->role_id, $search = true, $office = $request['office'], $district = $request['district'], $pan = $request['pan_search'], $post = $request['post'], $status = $request['status']);
            } else {
                $data = $this->generate_query($type = Auth::guard('user_guard')->user()->role_id, $search = false, $office = $request['office'], $district = $request['district'], $pan = $request['pan_search'], $post = $request['post'], $status = $request['status']);
            }

            $data = $data->get();

            $type = 'pending';
            if ($request['status'] != '') {
                $type = $request['status'];
            }
            if ($roleName == 'Appointing User') {
                if ($request['status'] == 'verified') {
                    $verified_users = $data->where('noc_generate', 1)->where('profile_verify_status', 1);
                } else if ($request['status'] == 'pending') {
                    $verified_users = $data->where('noc_generate', 0)->where('profile_verify_status', 1);
                } else if ($request['status'] == 'pending_verify') {
                    $verified_users = $data->where('noc_generate', 0)->where('profile_verify_status', 0);
                } else {
                    $type = 'pending_verify';
                    $verified_users = $data->where('noc_generate', 0)->where('profile_verify_status', 0);
                }
            } else {
                if ($request['status'] == 'verified') {
                    $verified_users = $data->where('noc_generate', 1)->where('profile_verify_status', 1);
                } else if ($request['status'] == 'pending') {
                    $verified_users = $data->where('noc_generate', 0)->where('profile_verify_status', 1);
                } else {
                    $type = 'pending_verify';
                    $verified_users = $data->where('noc_generate', 0)->where('profile_verify_status', 1);
                }
            }

            $verified_users = $verified_users->map(function ($user) {
                $user->encrypted_id = Crypt::encryptString($user->id);
                return $user;
            });
            $encryptedRole = Crypt::encryptString($roleName);
            $rec = Crypt::encryptString('Yes');
            return response()->json([
                'status' => 200,
                'type' => $type,
                'user_role' => $roleName,
                'data' => $verified_users,
                'encrypted_role' => $encryptedRole,
                'rec' => $rec
            ]);
        } catch (Exception $e) {
            Log::error('Fetch candidate: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function fetch_candidates(Request $request)
    {
        $user = Auth::guard('user_guard')->user();
        $roleName = '';
        if ($user) {
            $roleName = $user->roles->role;
        }

        if ($roleName == 'Appointing Authority' || $roleName == 'Appointing User') {
            return $this->fetch_noc_pending_profiles_json($request->all());
        }

        try {

            if (Session::has('re_submit')) {
                $fetch_resubmit = 1;
                Session::forget('re_submit');
            } else {
                $fetch_resubmit = 0;
            }

            if ($fetch_resubmit == 1) {
                $check_v = 1;
            } else {
                $check_v = (int)$request->input('check_value');
            }

            if ($request->input('status') != '') {
                $st = $request->input('status');
            } else {
                $st = null;
            }
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();


            if ($request->input('office') != null || $request->input('district') != null || $request->input('pan_search') != null || $request->input('post') != null) {

                $data = $this->generate_query($type = Auth::guard('user_guard')->user()->role_id, $search = true, $office = $request->input('office'), $district = $request->input('district'), $pan = $request->input('pan_search'), $post = $request->input('post'), $status = $st, $check = $check_v);
            } else {
                $data = $this->generate_query($type = Auth::guard('user_guard')->user()->role_id, $search = false, $office = $request->input('office'), $district = $request->input('district'), $pan = $request->input('pan_search'), $post = $request->input('post'), $status = $st, $check = $check_v);
            }
            $data = $data->get();

            $type = 'pending';
            if ($request->input('status') != '') {
                $type = $request->input('status');
            }

            if ($request->input('status') == 'verified') {
                $verified_users = $data->where('profile_verify_status', 1);
            } else if ($request->input('status') == 'pending') {
                $verified_users = $data->where('profile_verify_status', 0);
                $type = 'pending_verify';
            } else {
                $type = 'pending_verify';
                $verified_users = $data->where('profile_verify_status', 0);
            }
            $verified_users = $verified_users->map(function ($user) {
                $user->encrypted_id = Crypt::encryptString($user->id);
                return $user;
            });
            // dd($verified_users);
            $encryptedRole = Crypt::encryptString($roleName);
            return response()->json([
                'status' => 200,
                'type' => $type,
                'user_role' => $roleName,
                'data' => $verified_users,
                'encrypted_role' => $encryptedRole,
                're_submit' =>  $fetch_resubmit == 1 ? 1 : $check_v,
            ]);
        } catch (Exception $e) {
            Log::error('Fetch candidate: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function generate_query($type = null, $search = false, $office = null, $district = null, $pan = null, $post = null, $status = null, $check = null)
    {
        if ($type == null) {
            return [];
        }
        // dd($check);
        $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
        $roles = authority_office_dist_map::where('user_id', $verifier->id)->pluck('role_id')->toArray();
        $dept_ids = authority_office_dist_map::where('user_id', $verifier->id)->pluck('department_id')->toArray();
        $dir = authority_office_dist_map::where('user_id', $verifier->id)->where('role_id', 6)->pluck('directorate_id')->first();
        if (in_array(5, $roles) && $type != 5) {
            $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)
                ->where(function ($query) use ($type) {
                    $query->where('role_id', 5)
                        ->orWhere('role_id', $type);
                })->get();
        } else {
            $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)
                ->where('role_id', $type)
                ->get();
        }

        if ($search != false) {
            if ($type != 3 && $type != 5) {
                // dd('here');
                $main_query = UserCredentialsModel::query()
                    ->with([
                        'employment_details',
                        'employment_details.post_names',
                        'employment_details.districts',
                        'employment_details.departments',
                        'employment_details.user_credentials',
                        'documents' => function ($sub_query) {
                            $sub_query->where('document_type', 1);
                        }
                    ])
                    ->join('persional_details', 'user_credentials.id', '=', 'persional_details.user_id')

                    ->when($type != null, function ($query) use ($district) {
                        if ($district !== 'All' && $district !== null) {
                            return $query->where('employment_details.district_id', $district);
                        }
                    })
                    ->when($office !== null && $office != 'All', function ($query) use ($office) {
                        return $query->where('offices.id', $office);
                    })
                    ->when($pan != null, function ($query) use ($pan) {
                        $searchTerm = $pan;
                        return $query->where(function ($query) use ($searchTerm) {
                            $query->where('persional_details.pan_number', $searchTerm)
                                ->orWhere('user_credentials.full_name', 'LIKE', "%$searchTerm%");
                        });
                    })
                    ->when($post != null && $post != 'All', function ($query) use ($post) {
                        return $query->where('employment_details.designation_id', '=', $post);
                    })->whereHas('employment_details', function ($query) use ($dept_ids) {
                        // $query->where('depertment_id', $verifier->department);
                        $query->whereIn('depertment_id',  $dept_ids);
                    });

                if ($dir !== null && $dir != 0) {
                    $main_query->whereHas('employment_details', function ($query) use ($dir) {
                        $query->where('directorate_id', $dir);
                    });
                }
                // if ($check != null && $check == 1) {
                //     $main_query->join('rejected_documents as rd', 'user_credentials.id', '=', 'rd.user_id');
                // } else {
                //     // 
                // }
                if ($check != null && $check == 1) {
                    $main_query->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('rejected_documents')
                            ->whereRaw('rejected_documents.user_id = user_credentials.id');
                    });
                }
                if (!empty($authority_maps)) {
                    $main_query->whereHas('employment_details', function ($query) use ($authority_maps) {
                        $query->where(function ($subQuery) use ($authority_maps) {
                            foreach ($authority_maps as $map) {
                                if (is_null($map->office_id) && is_null($map->district_id)) {
                                    continue;
                                }

                                $subQuery->orWhere(function ($q) use ($map) {
                                    if ($map->office_id && is_null($map->district_id)) {
                                        $q->where('employment_details.office_id', $map->office_id);
                                    } elseif ($map->district_id && is_null($map->office_id)) {
                                        $q->where('employment_details.district_id', $map->district_id);
                                    } elseif ($map->office_id && $map->district_id) {
                                        $q->where('employment_details.office_id', $map->office_id)
                                            ->where('employment_details.district_id', $map->district_id);
                                    }
                                });
                            }
                        });
                    });
                    $data = $main_query;
                    return $data;
                } else {
                    return [];
                }
            } else {
                if (Session::has('is_mixed') && Session::get('is_mixed') == true) {
                    if ($status != 'pending_verify') {
                        $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)
                            ->where(function ($query) use ($type) {
                                $query->where('role_id', 3)
                                    ->orWhere('role_id', $type);
                            })->get();
                    }
                }
                $main_query = UserCredentialsModel::query()
                    ->with([
                        'employment_details',
                        'employment_details.post_names',
                        'employment_details.districts',
                        'employment_details.departments',
                        'employment_details.user_credentials',
                        'documents' => function ($sub_query) {
                            $sub_query->where('document_type', 1);
                        }
                    ])
                    ->when($district !== null && $district != 'All', function ($query) use ($district) {
                        return $query->whereHas('employment_details', function ($sub_query) use ($district) {
                            $sub_query->where('district_id', $district);
                        });
                    })
                    ->when($office !== null && $office != 'All', function ($query) use ($office) {
                        return $query->whereHas('employment_details', function ($sub_query) use ($office) {
                            $sub_query->where('office_id', $office);
                        });
                    })
                    ->when($pan != null, function ($query) use ($pan) {
                        $searchTerm = $pan;
                        return $query->whereHas('personal_details', function ($sub_query) use ($searchTerm) {
                            $sub_query->where('pan_number', $searchTerm);
                        })->orWhere('full_name', 'LIKE', "%$searchTerm%");
                    })
                    ->when($post != null && $post != 'All', function ($query) use ($post) {
                        return $query->whereHas('employment_details', function ($sub_query) use ($post) {
                            $sub_query->where('designation_id', '=', $post);
                        });
                    })
                    ->whereHas('employment_details', function ($query) use ($dept_ids) {
                        // $query->where('depertment_id', $verifier->department);
                        $query->whereIn('depertment_id',  $dept_ids);
                    });
                // if ($check != null && $check == 1) {
                //     $main_query->join('rejected_documents', 'user_credentials.id', '=', 'rejected_documents.user_id');
                // } else {
                //     // 
                // }
                if ($dir !== null && $dir != 0) {
                    $main_query->whereHas('employment_details', function ($query) use ($dir) {
                        $query->where('directorate_id', $dir);
                    });
                }
                if ($check != null && $check == 1) {
                    $main_query->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('rejected_documents')
                            ->whereRaw('rejected_documents.user_id = user_credentials.id');
                    });
                }
                if (!empty($authority_maps)) {
                    $main_query->whereHas('employment_details', function ($query) use ($authority_maps) {
                        $query->where(function ($subQuery) use ($authority_maps) {
                            foreach ($authority_maps as $map) {
                                $subQuery->orWhere(function ($nestedQuery) use ($map) {
                                    if (is_null($map['office_id']) && is_null($map['district_id'])) {
                                        return;
                                    }
                                    if ($map['office_id'] && is_null($map['district_id'])) {
                                        $nestedQuery->where('employment_details.office_id', $map['office_id']);
                                    } elseif ($map['district_id'] && is_null($map['office_id'])) {
                                        $nestedQuery->where('employment_details.district_id', $map['district_id']);
                                    } elseif ($map['office_id'] && $map['district_id']) {
                                        $nestedQuery->where('employment_details.office_id', $map['office_id'])
                                            ->where('employment_details.district_id', $map['district_id']);
                                    }
                                });
                            }
                        });
                    });
                    $data = $main_query;

                    return $data;
                } else {
                    return [];
                }
            }
        } else {
            if ($type != 5 && $type != 3) {
                $main_query = UserCredentialsModel::query()
                    ->with([
                        'employment_details',
                        'employment_details.post_names',
                        'employment_details.districts',
                        'employment_details.departments',
                        'documents' => function ($sub_query) {
                            $sub_query->where('document_type', 1);
                        }
                    ])
                    ->whereHas('employment_details', function ($query) use ($dept_ids) {
                        // $query->where('depertment_id', $verifier->department);
                        $query->whereIn('depertment_id',  $dept_ids);
                    });
                // if ($check != null && $check == 1) {
                //     $main_query->join('rejected_documents as rd', 'user_credentials.id', '=', 'rd.user_id');
                // } else {
                //     // 
                // }
                if ($check != null && $check == 1) {
                    $main_query->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('rejected_documents')
                            ->whereRaw('rejected_documents.user_id = user_credentials.id');
                    });
                }
                if ($dir !== null && $dir != 0) {
                    $main_query->whereHas('employment_details', function ($query) use ($dir) {
                        $query->where('directorate_id', $dir);
                    });
                }
                if ($authority_maps->isNotEmpty()) {
                    $main_query->whereHas('employment_details', function ($query) use ($authority_maps) {
                        $query->where(function ($subQuery) use ($authority_maps) {
                            foreach ($authority_maps as $map) {
                                if (is_null($map->office_id) && is_null($map->district_id)) {
                                    continue;
                                }

                                $subQuery->orWhere(function ($q) use ($map) {
                                    if ($map->office_id && is_null($map->district_id)) {
                                        $q->where('employment_details.office_id', $map->office_id);
                                    } elseif ($map->district_id && is_null($map->office_id)) {
                                        $q->where('employment_details.district_id', $map->district_id);
                                    } elseif ($map->office_id && $map->district_id) {
                                        $q->where('employment_details.office_id', $map->office_id)
                                            ->where('employment_details.district_id', $map->district_id);
                                    }
                                });
                            }
                        });
                    });
                    $data = $main_query;

                    return $data;
                } else {
                    return [];
                }
            } else {
                $main_query = UserCredentialsModel::query()
                    ->with([
                        'employment_details',
                        'employment_details.post_names',
                        'employment_details.districts',
                        'employment_details.departments',
                        'documents' => function ($sub_query) {
                            $sub_query->where('document_type', 1);
                        }
                    ])->whereHas('employment_details', function ($query) use ($dept_ids) {
                        // $query->where('depertment_id', $verifier->department);
                        $query->whereIn('depertment_id',  $dept_ids);
                    });
                // if ($check != null && $check == 1) {
                //     $main_query->join('rejected_documents as rd', 'user_credentials.id', '=', 'rd.user_id');
                // } else {
                //     // 
                // }
                if ($dir !== null && $dir != 0) {
                    $main_query->whereHas('employment_details', function ($query) use ($dir) {
                        $query->where('directorate_id', $dir);
                    });
                }
                if ($check != null && $check == 1) {
                    $main_query->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('rejected_documents')
                            ->whereRaw('rejected_documents.user_id = user_credentials.id');
                    });
                }
                if ($authority_maps->isNotEmpty()) {
                    $main_query->whereHas('employment_details', function ($query) use ($authority_maps) {
                        $query->where(function ($subQuery) use ($authority_maps) {
                            foreach ($authority_maps as $map) {
                                $subQuery->orWhere(function ($nestedQuery) use ($map) {
                                    if (is_null($map['office_id']) && is_null($map['district_id'])) {
                                        return;
                                    }
                                    if ($map['office_id'] && is_null($map['district_id'])) {
                                        $nestedQuery->where('employment_details.office_id', $map['office_id']);
                                    } elseif ($map['district_id'] && is_null($map['office_id'])) {
                                        $nestedQuery->where('employment_details.district_id', $map['district_id']);
                                    } elseif ($map['office_id'] && $map['district_id']) {
                                        $nestedQuery->where('employment_details.office_id', $map['office_id'])
                                            ->where('employment_details.district_id', $map['district_id']);
                                    }
                                });
                            }
                        });
                    });
                    $data = $main_query;
                    return $data;
                } else {
                    return [];
                }
            }
        }
    }



    public function verify_candidates(Request $request)
    {
        $res_data = [
            'status' => 400,
            'message' => null
        ];
        try {
            $logged_user = Auth::guard('user_guard')->user();
            $incomming_data = [
                'remarks_documents' => 'array',
                'remarks_text' => 'array',
                'employee_id' => 'required',
                'forms_number' => 'required|integer'
            ];

            // $check_employee =
            $validate = ReuseModule::validateIncomingData($request, $incomming_data, $request->all());
            if ($validate->fails()) {
                $res_data['message'] = $validate->errors()->all();
            } else {
                $res_data['status'] = 401;
                $employee_id = Crypt::decryptString($request->employee_id);
                $error_indexs = [];
                $file_extensions = [
                    'jpg',
                    'jpeg',
                    'png',
                    'pdf'
                ];
                for ($i = 0; $i < $request->forms_number; $i++) {
                    // ------------ all field are require if form append --------------------
                    $temp_error = [
                        'document' => null,
                        'text' => null
                    ];
                    $check_document = false;
                    $check_text = false;
                    $temp_error['document'] = isset($request->file('remarks_documents')[$i]) ? (in_array($request->file('remarks_documents')[$i]->getClientOriginalExtension(), $file_extensions) ? $check_document = true : 'document extention type invalid !') : 'document is required';
                    $temp_error['text'] = isset($request->remarks_text[$i]) ? $check_text = true : 'remarks is required';
                    if (!$check_document || !$check_text) {
                        $error_indexs[] = $temp_error;
                    }
                }

                if (count($error_indexs) == 0) {
                    $conditions = [
                        ['id', $employee_id],
                        ['profile_verify_status', 0]
                    ];
                    $with_models = [
                        'employment_details' => function ($query) {
                            $query->select('id', 'user_id', 'depertment_id', 'district_id');
                        },
                    ];
                    $main_query = EmployeeModule::dynamicOneModelsQuery(new UserCredentialsModel(), $conditions, [], $with_models);
                    $departmentIds = authority_office_dist_map::where('user_id', $logged_user->appointing_authorities->id)->pluck('department_id')->toArray();
                    $main_query->whereHas('employment_details', function ($query) use ($logged_user, $departmentIds) {
                        if (!is_null($logged_user->appointing_authorities->district)) {
                            $query->where('district_id', $logged_user->appointing_authorities->district);
                        }
                        if (!is_null($logged_user->appointing_authorities->department)) {
                            $query->whereIn('depertment_id', $departmentIds);
                        }
                    });

                    $main_query->select('id', 'profile_verify_status', 'phone');

                    if ($main_query->exists()) {
                        session()->flash('flash_message', 1);
                        session()->flash('message', 'Candidate verified');
                        $res_data['status'] = 200;
                        $user_datas = $main_query->first();
                    } else {
                        $res_data['message'] = "Employee details not found !";
                    }
                } else {
                    $res_data['message'] = $error_indexs;
                }
            }
        } catch (Exception $err) {
            $res_data['message'] = $err->getMessage();
        }
        if ($res_data['status'] == 200) {
            try {
                DB::beginTransaction();
                $file_location = '';

                for ($i = 0; $i < $request->forms_number; $i++) {

                    if ($request->hasFile('remarks_documents') && isset($request->file('remarks_documents')[$i])) {
                        // dd( $request->file('remarks_documents')[$i]->getClientOriginalName());
                        $photo_path = 'uploads/verification_remarks/' . $logged_user->appointing_authorities->id . '/' . $employee_id . '/';
                        $file_location = ReuseModule::uploadPhoto($request->remarks_documents[$i], $photo_path, $request->file('remarks_documents')[$i]->getClientOriginalName());
                        // dd($photo_path);

                        $save_data = VerificationRemarksDocumentModel::create([
                            'user_id' => $employee_id,
                            'document_location' => $file_location,
                            'remarks' => $request->remarks_text[$i],
                            'remarks_by' => $logged_user->appointing_authorities->id,
                            'authority_type' => $logged_user->role_id
                        ]);
                    }
                }
                $update_data = UserCredentialsModel::where('id', $employee_id)
                    ->update([
                        'profile_verify_status' => 1,
                        'verified_by' => $logged_user->appointing_authorities->id,
                        'verified_remarks_status' => $request->forms_number > 0  ? 1 : 0,
                        'verified_remarks' => $request->verifier_remarks,
                        'verified_on' => Carbon::now(),
                        'noc_generate' => 1,
                        'comment' => $request->input('comment') != null ? $request->input('comment') : null,
                    ]);
                ReuseModule::approvedProfileByVerifier($user_datas->phone);
                DB::commit();
                // $user = UserCredentialsModel::where('id', $employee_id)->first();

                // ReuseModule::approvedProfileByVerifier($c2->phone);
                $res_data['message'] = "Ok";
                $res_data['status'] = 200;
            } catch (Exception $err) {
                DB::rollBack();
                $res_data['message'] = "Server error please try later !";
                $res_data['message'] = $err->getMessage();
                $res_data['status'] = 401;
            }
        }
        return response()->json(['res_data' => $res_data]);
    }


    public function fetch_candidates_approval(Request $request)
    {
        // dd('here');
        // dd('hello');
        $user = Auth::guard('user_guard')->user();
        $roleName = '';
        if ($user) {
            $roleName = $user->roles->role;
        } else {
            dd('Unauthorized');
        }
        try {
            $verifier = appointing_authorities::where('id', Auth::guard('user_guard')->user()->user_id)->first();
            $authority_maps = authority_office_dist_map::where('user_id', $verifier->id)->get();
            $dir = authority_office_dist_map::where('user_id', $user->id)->where('role_id', 2)->pluck('directorate_id')->first();
            $pendingTransfers = TransfersModel::leftJoin('user_credentials as employee', 'transafers.employee_id', '=', 'employee.id')->where('2nd_recommend', '!=', 2)
                ->leftJoin('user_credentials as target_employee', 'transafers.target_employee_id', '=', 'target_employee.id')
                ->leftJoin('employment_details as employee_employment', 'transafers.employee_id', '=', 'employee_employment.user_id')
                ->leftJoin('persional_details as employee_personal_details', 'employee.id', '=', 'employee_personal_details.user_id')
                ->leftJoin('persional_details as target_employee_personal_details', 'target_employee.id', '=', 'target_employee_personal_details.user_id')
                ->leftJoin('employment_details as target_employee_employment', 'transafers.target_employee_id', '=', 'target_employee_employment.user_id')
                ->where('employee_employment.depertment_id', $verifier->department)
                ->where('target_employee_employment.depertment_id', $verifier->department)
                ->select('employee.full_name as employee_name', 'target_employee.full_name as target_employee_name', 'transafers.id as id', 'transafers.transfer_ref_code', 'transafers.jto_generate_status', 'transafers.2nd_recommend as second_recommend')
                ->orderBy('transafers.updated_at', 'desc');
            if ($dir != null) {
                $pendingTransfers->where('employee_employment.directorate_id', $dir)->where('target_employee_employment.directorate_id', $dir);
            }
            if ($request->input('office') != null || $request->input('district') != null || $request->input('post') != null || $request->input('pan_search') != null) {
                $data = $pendingTransfers
                    ->leftJoin('offices_finassam as employee_offices', 'employee_employment.office_id', '=', 'employee_offices.id')
                    ->leftJoin('offices_finassam as target_employee_offices', 'target_employee_employment.office_id', '=', 'target_employee_offices.id')
                    ->leftJoin('districts as employee_district', 'employee_employment.district_id', '=', 'employee_district.id')
                    ->leftJoin('districts as target_employee_district', 'target_employee_employment.district_id', '=', 'target_employee_district.id')
                    ->when($request->input('pan_search') != null, function ($query) use ($request) {
                        $searchTerm = $request->input('pan_search');
                        $query->where(function ($query) use ($searchTerm) {
                            $query->where('employee_personal_details.pan_number', $searchTerm)
                                ->orWhere('employee.full_name', 'LIKE', "%$searchTerm%")
                                ->orWhere('target_employee_personal_details.pan_number', $searchTerm)
                                ->orWhere('target_employee.full_name', 'LIKE', "%$searchTerm%");
                        });
                    })
                    ->when($request->input('office') !== null && $request->input('office') != 'All', function ($query) use ($request) {
                        return $query->where(function ($q) use ($request) {
                            $q->where('employee_offices.id', $request->input('office'))
                                ->orWhere('target_employee_offices.id', $request->input('office'));
                        });
                    })
                    ->when($request->input('district') !== null && $request->input('district') != 'All', function ($query) use ($request) {
                        return $query->where(function ($q) use ($request) {
                            $q->where('employee_district.id', $request->input('district'))
                                ->orWhere('target_employee_district.id', $request->input('district'));
                        });
                    })
                    ->when($request->input('post') != null && $request->input('post') != 'All', function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where('employee_employment.designation_id', $request->input('post'))
                                ->orWhere('target_employee_employment.designation_id', $request->input('post'));
                        });
                    })
                    ->when($authority_maps->isNotEmpty(), function ($query) use ($authority_maps, $request) {
                        if ($request->input('office') == null && $request->input('district') == null) {
                            return $query->where(function ($query) use ($authority_maps, $request) {
                                foreach ($authority_maps as $map) {
                                    $query->orWhere(function ($subQuery) use ($map, $request) {
                                        if ($map->office_id && is_null($map->district_id)) {
                                            $subQuery->where('employee_employment.office_id', $map->office_id)->orWhere('target_employee_employment.office_id', $map->office_id);
                                        } elseif ($map->district_id && is_null($map->office_id)) {
                                            $subQuery->where('target_employee_employment.district_id', $map->district_id)->orWhere('target_employee_employment.district_id', $map->district_id);
                                        } elseif ($map->office_id && $map->district_id) {
                                            $subQuery->where('employee_employment.office_id', $map->office_id)->orWhere('target_employee_employment.office_id', $map->office_id)
                                                ->where('employment_details.district_id', $map->district_id)->orWhere('target_employee_employment.district_id', $map->district_id);
                                        }
                                    });
                                }
                            });
                        }
                    });
            } else {
                $data = $pendingTransfers->whereIn('final_approval', [0, 1])->where('request_status', 1);
            }
            $type = 'pending';
            if ($request->input('status') != '') {
                $type = $request->input('status');
            }
            if ($request->input('status') == 'approved') {
                $verified_users = $data->where('request_status', 1)->where('final_approval', 1)->get();
            } else if ($request->input('status') == 'pending') {
                $verified_users = $data->where('request_status', 1)->where('final_approval', 0)->get();
            } else {
                $verified_users = $data->where('request_status', 1)->where('final_approval', 0)->get();
            }
            // dd($request->input('status'));
            $verified_users = $verified_users->map(function ($user) {
                $user->encrypted_id = Crypt::encryptString($user->id);
                return $user;
            });
            return response()->json([
                'status' => 200,
                'type' => $type,
                'user_role' => $roleName,
                'data' => $verified_users,
            ]);
        } catch (Exception $e) {
            Log::error('Fetch candidate: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }


    // public function verify_candidates(Request $request)
    // {
    //     if (Auth::guard('user_guard')->check()) {
    //         $candidate = UserCredentialsModel::findOrFail($request->input('candidate_verify_id'));


    //         $candidate->update([
    //             'profile_verify_status' => 1,
    //             'verified_by' => Auth::guard('user_guard')->user()->user_id
    //         ]);
    //         session()->flash('flash_message', 1);
    //         session()->flash('message', 'User verified successfully');
    //         return redirect('verifier/candidate-profile/' . Crypt::encryptString($candidate->id));
    //     } else {
    //         session()->flash('flash_message', 2);
    //         session()->flash('message', 'Something went wrong');
    //         return redirect('verifier.dashboard');
    //     }
    // }

    public function resubmitted_profile_details($id = null)
    {
        if (Auth::guard('user_guard')->check()) {
            try {
                $decryptedId = Crypt::decryptString($id);
                $data = DB::table('rejected_documents')->where('user_id', $decryptedId)->get();
                $data2 = [];

                if (!$data->isEmpty()) {
                    foreach ($data as $d) {
                        $rejections = DB::table('authority_rejections')
                            ->where('rejected_document_id', $d->id)
                            ->get();

                        foreach ($rejections as $r) {
                            $data2[] = [
                                'document_type' => $r->document_type,
                                'document_location' => $r->document_location,
                                'remarks' => $r->remarks,
                                'rejection_id' => $r->rejected_document_id
                            ];
                        }
                    }
                }
                return view('verification.pages.resubmitted-data', compact('data2', 'data'));
            } catch (Exception $err) {
                dd($err->getMessage());
                return back()->withErrors(['error' => 'An error occurred: ' . $err->getMessage()]);
            }
        } else {
            return redirect()->back();
        }
    }


    public function reject_candidates(Request $request)
    {
        // dd($request->all());
        if (Auth::guard('user_guard')->check()) {
            $user = Auth::guard('user_guard')->user();
            $roleName = $user->roles->role;
            if ($roleName == 'Appointing Authority') {
                $incoming_data = [
                    'reject_message' => 'required',
                    'candidate_reject_id' => 'required'
                ];
                $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
                if ($validate->fails()) {
                    session()->flash('verified_count', 2);
                    session()->flash('message', $validate->errors()->first());
                    return redirect()->back();
                } else {
                    try {
                        $candidate = UserCredentialsModel::findOrFail($request->input('candidate_reject_id'));
                        $candidate->update([
                            'noc_generate' => 2,
                            'noc_remarks' =>  $request->input('reject_message'),
                        ]);
                        $office = EmploymentDetailsModel::where('user_id', $candidate->id)->pluck('office_id')->first();

                        // rejections::create([
                        //     'user_id' => $candidate->id,
                        //     'date' => Carbon::now()->toDateString(),
                        //     'message' => $request->input('comment'),
                        //     'office_id' => $office,
                        //     'created_by' =>  $user->user_id,
                        //     'role' => $user->role_id
                        // ]);
                        session()->flash('flash_message', 1);
                        session()->flash('message', ' User profile rejected ');
                        return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
                    } catch (Exception $e) {
                        Log::error('Reject error: ' . $e->getMessage());
                        session()->flash('flash_message', 2);
                        session()->flash('message', 'Something went wrong');
                        return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
                    }
                }
            } else {
                $incoming_data = [
                    'candidate_id' => 'required'
                ];

                $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
                if ($validate->fails()) {
                    session()->flash('verified_count', 2);
                    session()->flash('message', $validate->errors()->first());
                    return redirect()->back();
                } else {
                    try {

                        $candidate = UserCredentialsModel::findOrFail($request->input('candidate_id'));
                        $candidate->update([
                            'profile_verify_status' => 2,
                            'verified_remarks' => $request->has('reject_message') != null ? $request->input('reject_message') : null,
                            'comment' => $request->has('comment') ? $request->input('comment') : null,
                        ]);
                        $office = EmploymentDetailsModel::where('user_id', $candidate->id)->pluck('office_id')->first();
                        rejections::create([
                            'user_id' => $candidate->id,
                            'date' => Carbon::now()->toDateString(),
                            'message' =>  $request->input('reject_message') != null ? $request->input('reject_message') : '',
                            'office_id' => $office,
                            'created_by' =>  $user->user_id,
                            'role' => $user->role_id
                        ]);
                        $comment = $request->has('comment') ? $request->input('comment') : null;
                        $rejectionType = 1;

                        $rejectedDocument = RejectedDocumentsModel::create([
                            'user_id' => $request->input('candidate_id'),
                            'commnents' => $comment,
                            'rejection_type' => $rejectionType,
                            'old_update_on' => null,
                            'old_documents' => null,
                            'authority_id' => $user->user_id,
                        ]);


                        $remarksData = json_decode($request->input('allRemarks'), true);
                        // dd($request->all());
                        foreach ($remarksData as $remark) {
                            $doc_key = $remark['document'];
                            $documents = config('globalVariables.registration_documtns');
                            $documentKey = null;
                            // dd($remarksData);
                            foreach ($documents as $key => $value) {
                                if ($doc_key == $key) {
                                    $documentKey = $key;
                                    break;
                                }
                            }

                            $doc = DocumentModel::where('user_id', $request->input('candidate_id'))->where('document_type', $documentKey)->first();

                            if ($doc != null) {
                                DB::table('authority_rejections')->insert([
                                    'rejected_document_id' => $rejectedDocument->id,
                                    'document_location' => $doc->documet_location,
                                    'document_type' => $documentKey,
                                    'remarks' => $remark['remark'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                        try {
                            if ($request->hasFile('remarks_documents')) {

                                $remarksDocuments = $request->file('remarks_documents');

                                if (count($remarksDocuments) > 0) {
                                    foreach ($remarksDocuments as $index => $file) {
                                        if ($file->isValid()) {

                                            $photo_path = 'uploads/verification_remarks/' . $user->user_id . '/' . $request->input('candidate_reject_id') . '/';
                                            $file_location = ReuseModule::uploadPhoto(
                                                $file,
                                                $photo_path,
                                                $file->getClientOriginalName()
                                            );

                                            DB::table('authority_rejections')->insert([
                                                'rejected_document_id' => $rejectedDocument->id,
                                                'document_location' => $file_location,
                                                'document_type' => 0,
                                                'remarks' => $request->remarks_text[$index] ?? null,
                                                'created_at' => now(),
                                                'updated_at' => now(),
                                            ]);
                                        }
                                    }
                                }
                            }
                        } catch (Exception $err) {
                            // dd($err->getMessage());
                        }



                        session()->flash('flash_message', 1);
                        session()->flash('message', ' User profile rejected successfully');
                        return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
                    } catch (Exception $e) {
                        // dd($e->getMessage());
                        Log::error('Reject error: ' . $e->getMessage());
                        session()->flash('flash_message', 2);
                        session()->flash('message', 'Something went wrong');
                        return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
                    }
                }
            }
        } else {
            session()->flash('verified_count', 2);
            session()->flash('message', 'Something went wrong');
            return redirect()->route('verifier.dashboard', ['lang' => app()->getLocale()]);
        }
    }


    public function noc_print(Request $request)
    {
        try {
            $data2 = UserCredentialsModel::leftJoin('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                ->leftJoin('districts', 'employment_details.district_id', '=', 'districts.id')
                ->leftJoin('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                ->leftJoin('offices_finassam as offices', 'employment_details.office_id', '=', 'offices.id')
                ->leftJoin('post_names as employee_post', 'employment_details.designation_id', '=', 'employee_post.id')
                ->select(
                    'user_credentials.*',
                    'employment_details.*',
                    'districts.name as district_name',
                    'employee_post.name as employee_post',
                    'deptartments.name as department_name',
                    'offices.name as office_name'
                )
                ->where('user_credentials.id', $request->input('noc_print_candidate'))
                ->first();
            $pdf = Pdf::loadView('verification.noc.noc', ['candidate' => $data2]);
            return $pdf->download('document.pdf');
        } catch (Exception $err) {
            dd($err->getMessage());
            Log::error('Noc print: ' . $err->getMessage());
        }
    }


    public function noc_update(Request $request)
    {
        if (Auth::guard('user_guard')->check()) {
            $incoming_data = [
                'direct_noc_id' => 'required',
            ];
            $validate = ReuseModule::validateIncomingData($request, $incoming_data, $request->all());
            try {
                if ($validate->fails()) {
                    $firstError = $validate->errors()->first();
                    session()->flash('flash_message', 2);
                    session()->flash('message', 'Something went wrong');
                    Log::error('noc_error: ' . $firstError);
                } else {

                    $user = UserCredentialsModel::findOrFail($request->input('direct_noc_id'));
                    ReuseModule::sendNOCOTP($user->phone);
                    $user->update([
                        'noc_generate' => 1,
                        'noc_remarks_status' => $request->input('noc_remarks') ? 1 : 0,
                        'noc_remarks' => $request->input('noc_remarks') ? $request->input('noc_remarks') : null,
                        'noc_generated_by' => Auth::guard('user_guard')->user()->user_id,
                        'noc_generated_on' => Carbon::now()
                    ]);
                    session()->flash('flash_message', 1);
                    session()->flash('message', 'NOC generated successfully');
                    return redirect()->back();
                }
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        } else {
            session()->flash('flash_message', 2);
            session()->flash('message', 'Something went wrong');
            return redirect()->back();
        }
    }

    public function jto_certificate(Request $request, $id = null)
    {
        try {
            $id = Crypt::decryptString($id);
            $data = TransfersModel::where('id', $id)->first();

            if ($data == null) {
                dd("No Data found ");
            } else {
                $candidate1 = UserCredentialsModel::join('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                    ->join('offices_finassam', 'employment_details.office_id', '=', 'offices_finassam.id')
                    ->join('districts', 'employment_details.district_id', '=', 'districts.id')
                    ->join('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                    ->join('post_names', 'employment_details.designation_id', '=', 'post_names.id')
                    ->select('user_credentials.*', 'offices_finassam.name as office_name', 'districts.name as district_name', 'deptartments.name as department_name', 'post_names.type as grade_type')
                    ->where('user_credentials.id', $data->employee_id)
                    ->first();


                $candidate2 = UserCredentialsModel::join('employment_details', 'user_credentials.id', '=', 'employment_details.user_id')
                    ->join('offices_finassam', 'employment_details.office_id', '=', 'offices_finassam.id')
                    ->join('districts', 'employment_details.district_id', '=', 'districts.id')
                    ->join('deptartments', 'employment_details.depertment_id', '=', 'deptartments.id')
                    ->join('post_names', 'employment_details.designation_id', '=', 'post_names.id')
                    ->select('user_credentials.*', 'offices_finassam.name as office_name', 'districts.name as district_name', 'deptartments.name as department_name', 'post_names.type as grade_type')
                    ->where('user_credentials.id', $data->target_employee_id)
                    ->first();

                $ref_code = $data->transfer_ref_code;
                $date = $data->updated_at->format('Y-m-d');
                if ($data->jto_generate_status == 0) {
                    ReuseModule::generateOrderMessage($candidate1->phone);
                    ReuseModule::generateOrderMessage($candidate2->phone);

                    $data->update([
                        'jto_generate_status' => 1
                    ]);
                }
                $approved_by = '';
                $designation = '';
                if ($data->{'2nd_recommend'} != null && $data->{'2nd_recommend'} != 2) {
                    $ar = appointing_authorities::where('id', $data->{'2nd_recommended_by'})->first();
                    $designation = $ar->designation;
                    $all_login = AllLoginModel::where('user_id', $ar->id)->where('user_type', 2)->where('role_id', 2)->first();
                    $role_name = RolesModel::where('id', $all_login->role_id)->first();
                    $approved_by = $role_name->display_name;
                } else {
                    $ar = appointing_authorities::where('id', $data->approved_by)->first();
                    $designation = $ar->designation;
                    $all_login = AllLoginModel::where('user_id', $ar->id)->where('user_type', 2)->where('role_id', 2)->first();
                    $role_name = RolesModel::where('id', $all_login->role_id)->first();
                    $approved_by = $role_name->display_name;
                }


                $pdf = Pdf::loadView('pdfs.jto-format', ['candidate1' => $candidate1, 'candidate2' => $candidate2, 'ref_code' => $ref_code, 'date' => $date, 'designation' => $designation, 'approved_by' => $approved_by]);
                return $pdf->download('jto.pdf');
            }
        } catch (Exception $err) {
            dd($err->getMessage());
            Log::error('verification profile: ' . $err->getMessage());
            return redirect('/verifier/approval-dashboard');
        }
    }
}