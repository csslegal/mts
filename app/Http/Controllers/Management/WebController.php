<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function get_index()
    {
        $countWebGroups = DB::table('web_groups')->get()->count();
        $countWebPanels = DB::table('web_panels')->get()->count();
        $countWebPanelAuth = DB::table('web_panel_auth')->get()->count();
        return view('management.web.index')->with([
            'countWebGroups' => $countWebGroups,
            'countWebPanels' => $countWebPanels,
            'countWebPanelAuth' => $countWebPanelAuth,
        ]);
    }
    public function get_paneller(Request $request)
    {
        $userAccesses = DB::table('users_access')->select('access.id',)
            ->leftJoin('access', 'access.id', '=', 'users_access.access_id')
            ->where('user_id', '=', $request->session()->get('userId'))
            ->pluck('access.id')->toArray();
        $webGroups = DB::table('web_groups')->get();
        $webPanels = DB::table('web_panel_auth')
            ->select([
                'web_panels.group_id', 'web_panels.name',
                'web_panels.url', 'web_panel_auth.access',
            ])
            ->join('web_panel_user', 'web_panel_auth.id', '=', 'web_panel_user.panel_auth_id')
            ->join('web_panels', 'web_panels.id', '=', 'web_panel_user.panel_id')
            ->where('web_panel_auth.user_id', '=', $request->session()->get('userId'))
            ->get();
        $webResults = DB::table('web_panel_auth')->where('user_id', '=', $request->session()->get('userId'))->get();
        if ($webResults->count() > 0) {
            //dd(date("Y-m-d", strtotime($webResults->start_time)) . " " . date("Y-m-d", time()));
            //suanki time başlangıctan buyuk sondan kucuk olamalı ki erişim izni olsun
            $webResultsFirst =  $webResults->first();
            $panelsTimeAccess = (strtotime($webResultsFirst->start_time) <= strtotime(date("Y-m-d", time()))) && (strtotime(date("Y-m-d", time())) <= strtotime($webResultsFirst->and_time));
        } else {
            $panelsTimeAccess = 2;
        }
        return view('management.web.panel')->with([
            'webPanels' => $webPanels,
            'webGroups' => $webGroups,
            'panelsTimeAccess' => $panelsTimeAccess,
            'userAccesses' => $userAccesses,
        ]);
    }
    public function get_graphic(Request $request)
    {
        /* $webSites = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'users.name AS u_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')


            ->where('visa_files.active', '=', 1)
            ->get();*/
        return view('management.web.users.graphic')->with([
            'webSites' => null,
        ]);
    }

    public function get_engineer(Request $request)
    {
        /**$webSites = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'advisor_users.name AS advisor_name',
                'expert_users.name AS expert_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS expert_users', 'expert_users.id', '=', 'visa_files.expert_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_GRADES_ID'))
            ->get();*/
        return view('management.web.users.engineer')->with([
            'webSites' => null,
        ]);
    }

    public function get_writer(Request $request)
    {
        /**$webSites = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'advisor_users.name AS advisor_name',
                'translator_users.name AS translator_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS translator_users', 'translator_users.id', '=', 'visa_files.translator_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATION_GRADES_ID'))
            ->get();*/
        return view('management.web.users.writer')->with([
            'webSites' => null,
        ]);
    }

    public function get_editor(Request $request)
    {
        /*  $webSites = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'users.name AS u_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
                'visa_sub_types.name AS visa_sub_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
            ->where('visa_files.active', '=', 1)

            ->where('visa_files.visa_file_grades_id', '=', env('VISA_PAYMENT_CONFIRM_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_MADE_PAYMENT_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_INVOICE_SAVE_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_RE_PAYMENT_CONFIRM_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_REFUND_CONFIRM_GRADES_ID'))
            ->get();*/
        return view('management.web.users.editor')->with([
            'webSites' => null,
        ]);
    }
}
