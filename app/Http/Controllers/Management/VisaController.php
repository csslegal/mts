<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaController extends Controller
{
    public function get_index(Request $request)
    {

        if ($request->has('dates') && $request->input('dates') != '') {
            $explodes =  explode('--', $request->input('dates'));
        } else {
            $explodes = [date('Y-m-01'), date('Y-m-28')];
        }

        /**Dosya acılış tarihine göre filtreleme */
        $startDate = $explodes[0];
        $endDate = $explodes[1];

        $countVisaFileGrades = DB::table('visa_file_grades')->get()->count();
        $countVisaFileGradesUsersType = DB::table('visa_file_grades_users_type')->distinct()->get()->count();
        $countVisaValidity = DB::table('visa_validity')->get()->count();
        $countVisaTypes = DB::table('visa_types')->get()->count();

        $customerNotes = DB::table('customer_notes')
            ->select([
                "users.name AS u_name",
                'customers.name AS c_name',
                "customer_notes.id",
                "customer_notes.created_at",
                "customer_notes.content"
            ])
            ->leftJoin('customers', 'customers.id', '=', 'customer_notes.customer_id')
            ->leftJoin("users", "users.id", "=", "customer_notes.user_id")
            ->orderByDesc('customer_notes.id')
            ->get();

        $visaFilesGradesCount = DB::table('visa_files')
            ->select([
                'visa_file_grades.name AS visa_file_grades_name',
                DB::raw('count(*) as total')
            ])
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->groupBy('visa_files.visa_file_grades_id')
            ->where('visa_files.active', '=', 1)

            ->whereDate('visa_files.created_at', '>=', $startDate)
            ->whereDate('visa_files.created_at', '<=', $endDate)

            ->pluck('total', 'visa_file_grades_name')->all();

        $visaFilesApplicationOfficeCount = DB::table('visa_files')
            ->select([
                'application_offices.name AS application_office_name',
                DB::raw('count(*) as total')
            ])
            ->leftJoin('application_offices', 'application_offices.id', '=', 'visa_files.application_office_id')

            ->groupBy('visa_files.application_office_id')
            ->where('visa_files.active', '=', 1)

            ->whereDate('visa_files.created_at', '>=', $startDate)
            ->whereDate('visa_files.created_at', '<=', $endDate)

            ->pluck('total', 'application_office_name')->all();

        $arrayVisaFilesAdvisorsAnalist = [];

        $AllAdvisors = DB::table('users')->select(['id', 'name'])->where('active', '=', 1)
            ->where('user_type_id', '=',  env('ADVISOR_USER_TYPE_ID'))->get();

        foreach ($AllAdvisors as $AllAdvisor) {
            $positiveCount =   DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.advisor_id', '=', $AllAdvisor->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_POSITIVE_ID'))
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            $negativeCount =  DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.advisor_id', '=', $AllAdvisor->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_NEGATIVE_ID'))
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();
            $iadeCount =  DB::table('visa_files')
                ->join('visa_application_result', 'visa_application_result.visa_file_id', '=', 'visa_files.id')
                ->where('visa_files.advisor_id', '=', $AllAdvisor->id)
                ->where('visa_application_result.visa_result', '=', env('VISA_APPLICATION_RESULT_IADE'))
                ->whereDate('visa_files.created_at', '>=', $startDate)
                ->whereDate('visa_files.created_at', '<=', $endDate)
                ->get()->count();

            array_push($arrayVisaFilesAdvisorsAnalist, array(
                $AllAdvisor->name,
                $positiveCount == null ? 0 : $positiveCount,
                $negativeCount == null ? 0 : $negativeCount,
                $iadeCount == null ? 0 : $iadeCount
            ));
        }

        return view('management.visa.index')->with(
            [
                'countVisaTypes' => $countVisaTypes,
                'countFileGrades' => $countVisaFileGrades,
                'countVisaFileGradesUsersType' => $countVisaFileGradesUsersType,
                'countVisaValidity' => $countVisaValidity,
                'customerNotes' => $customerNotes,

                'visaFilesGradesCount' => $visaFilesGradesCount,
                'visaFilesApplicationOfficeCount' => $visaFilesApplicationOfficeCount,
                'arrayVisaFilesAdvisorsAnalist' => $arrayVisaFilesAdvisorsAnalist,
            ]
        );
    }
    public function get_danisman(Request $request)
    {
        $visaCustomers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'users.name AS u_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')


            ->where('visa_files.active', '=', 1)
            ->get();
        return view('management.visa.users.danisman')->with(
            [
                'visaCustomers' => $visaCustomers,
            ]
        );
    }

    public function get_uzman(Request $request)
    {
        $visaCustomers = DB::table('customers')
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
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS expert_users', 'expert_users.id', '=', 'visa_files.expert_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_CONTROL_WAIT_GRADES_ID'))
            ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPLICATION_WAIT_GRADES_ID'))
            ->get();
        return view('management.visa.users.uzman')->with(
            [
                'visaCustomers' => $visaCustomers,
            ]
        );
    }

    public function get_tercuman(Request $request)
    {
        $visaCustomers = DB::table('customers')
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
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users AS advisor_users', 'advisor_users.id', '=', 'visa_files.advisor_id')
            ->leftJoin('users AS translator_users', 'translator_users.id', '=', 'visa_files.translator_id')

            ->where('visa_files.active', '=', 1)
            ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATIONS_WAIT_GRADES_ID'))
            ->get();
        return view('management.visa.users.tercuman')->with([
            'visaCustomers' => $visaCustomers,
        ]);
    }

    public function get_muhasebe(Request $request)
    {
        $visaCustomers = DB::table('customers')
            ->select([
                'customers.id AS id',
                'customers.name AS name',
                'users.name AS u_name',
                'visa_files.id AS visa_file_id',
                'visa_files.status AS status',
                'visa_file_grades.name AS visa_file_grades_name',
                'visa_validity.name AS visa_validity_name',
                'visa_types.name AS visa_type_name',
            ])
            ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
            ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')

            ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_files.visa_type_id')
            ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
            ->where('visa_files.active', '=', 1)

            ->where('visa_files.visa_file_grades_id', '=', env('VISA_FILE_OPEN_CONFIRM_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_MADE_PAYMENT_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_INVOICE_SAVE_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_RE_PAYMENT_CONFIRM_GRADES_ID'))
            // ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_FILE_REFUND_CONFIRM_GRADES_ID'))
            ->get();
        return view('management.visa.users.muhasebe')->with([
            'visaCustomers' => $visaCustomers,
        ]);
    }
}
