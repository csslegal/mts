<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReReceivedPaymentsConfirmController extends Controller
{
    public function index($id, $visa_file_id, Request $request)
    {
        $baseCustomerDetails = DB::table('customers')
            ->select([
                'customers.id AS id',
                'visa_files.id AS visa_file_id',
            ])
            ->join('visa_files', 'visa_files.customer_id', '=', 'customers.id')
            ->where('visa_files.active', '=', 1)
            ->where('customers.id', '=', $id)->first();

        $receivedPayments = DB::table('visa_received_payments')
            ->select([
                'visa_received_payments.id AS id',
                'visa_received_payments.name AS name',
                'visa_received_payments.received_tl AS received_tl',
                'visa_received_payments.received_euro AS received_euro',
                'visa_received_payments.received_dolar AS received_dolar',
                'visa_received_payments.received_pound AS received_pound',
                'visa_received_payments.payment_total AS payment_total',
                'visa_received_payments.payment_method AS payment_method',
                'visa_received_payments.payment_date AS payment_date',
                'visa_received_payments.confirm AS confirm',
                'visa_received_payments.created_at AS created_at',
                'users.name AS user_name',
            ])
            ->leftJoin('users', 'users.id', '=', 'visa_received_payments.user_id')
            ->where('visa_file_id', '=', $visa_file_id)
            ->get();

        return view('customer.visa.grades.re-received-payments-confirm')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'receivedPayments' => $receivedPayments,
                ]
            );
    }

    public function update($id, $visa_file_id, Request $request)
    {

        $visaFileGradesId = DB::table('visa_files')
            ->select(['visa_file_grades_id'])
            ->where('id', '=', $visa_file_id)
            ->first();

        $visaFileGradesName = new VisaFileGradesName(
            $visaFileGradesId->visa_file_grades_id
        );

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'Yeniden ??deme kay??tlar?? onayland??',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('visa_received_payments')
            ->where('visa_file_id', '=', $visa_file_id)
            ->where('confirm', '=', 0)
            ->update([
                'confirm' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        if (DB::table('visa_files')
            ->where("id", "=", $visa_file_id)
            ->update(['visa_file_grades_id' => env('VISA_APPOINTMENT_GRADES_ID')])
        ) {

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()
                ->flash('mesajSuccess', '????lem ba??ar??yla yap??ld??');

            return redirect('/musteri/' . $id . '/vize/');
        } else {
            $request->session()
                ->flash('mesajDanger', '????lem s??ralas??nda sorun olu??tu');
            return redirect('/musteri/' . $id . '/vize/' . $visa_file_id . '/yeniden-alinan-odeme-onay');
        }
    }

    public function destroy($id, $visa_file_id, Request $request)
    {
        $visaFileGradesId = DB::table('visa_files')
            ->select(['visa_file_grades_id'])
            ->where('id', '=', $visa_file_id)
            ->first();

        $visaFileGradesName = new VisaFileGradesName(
            $visaFileGradesId->visa_file_grades_id
        );

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'Yeniden ??deme kay??tlar?? iptal edildi',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('visa_received_payments')
            ->where('visa_file_id', '=', $visa_file_id)
            ->where('confirm', '=', 0)
            ->delete();

        $whichGrades = new VisaFileWhichGrades();
        $lastGrades = $whichGrades->lastGrades($visa_file_id);

        if (DB::table('visa_files')
            ->where("id", "=", $visa_file_id)
            ->update([
                'visa_file_grades_id' => $lastGrades
            ])
        ) {

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()
                ->flash('mesajSuccess', '????lem ba??ar??yla yap??ld??');

            return redirect('/musteri/' . $id . '/vize/');
        } else {
            $request->session()
                ->flash('mesajDanger', 'Silinme s??ralas??nda sorun olu??tu');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
