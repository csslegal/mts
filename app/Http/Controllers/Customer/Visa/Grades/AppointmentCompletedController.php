<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentCompletedController extends Controller
{
    public function index($id, $visa_file_id)
    {
        $baseCustomerDetails = DB::table('customers')
            ->where('id', '=', $id)->first();

        $times = DB::table('times')->get();

        return view('customer.visa.grades.appointment-completed')
            ->with(
                [
                    'baseCustomerDetails' => $baseCustomerDetails,
                    'times' => $times,
                ]
            );
    }

    public function store($id, $visa_file_id, Request $request)
    {
        $validatorStringArray = array(
            'gwf' => 'required',
            'hesap_adi' => 'required',
            'sifre' => 'required',
            'tarih' => 'required',
            'saat' => 'required',
        );

        $request->validate($validatorStringArray);

        $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
        $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

        $whichGrades = new VisaFileWhichGrades();
        $nextGrades = $whichGrades->nextGrades($visa_file_id);

        if ($nextGrades != null) {
            $customerAppointmentCount = DB::table('visa_appointments')
            ->where('visa_file_id', '=', $visa_file_id)->get()->count();

            if ($customerAppointmentCount == 0) {

                DB::table('visa_appointments')->insert(array(
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'gwf' => $request->input('gwf'),
                    'name' => $request->input('hesap_adi'),
                    'password' => $request->input('sifre'),
                    'date' => $request->input('tarih'),
                    'time' => $request->input('saat'),
                    'created_at' => date('Y-m-d H:i:s'),
                ));
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Randevu bilgisi kaydedildi',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                DB::table('visa_appointments')->where("visa_file_id", "=", $visa_file_id)->update([
                    'user_id' => $request->session()->get('userId'),
                    'gwf' => $request->input('gwf'),
                    'name' => $request->input('hesap_adi'),
                    'password' => $request->input('sifre'),
                    'date' => $request->input('tarih'),
                    'time' => $request->input('saat'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                DB::table('visa_file_logs')->insert([
                    'visa_file_id' => $visa_file_id,
                    'user_id' => $request->session()->get('userId'),
                    'subject' => $visaFileGradesName->getName(),
                    'content' => 'Randevu bilgisi g??ncellendi',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            DB::table('visa_files')->where("id", "=", $visa_file_id)->update([
                'visa_file_grades_id' => $nextGrades,
                'expert_id' => $request->session()->get('userId')
            ]);

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()->flash('mesajSuccess', '????lem ba??ar??yla tamamland??');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()->flash('mesajDanger', 'Sonraki a??ama bulunamad??');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
