<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use App\MyClass\VisaFileWhichGrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlWaitController extends Controller
{

    public function index($id)
    {
        $baseCustomerDetails = DB::table('customers')->where('id', '=', $id)->first();

        return view('customer.visa.grades.control-wait')->with([
            'baseCustomerDetails' => $baseCustomerDetails,
        ]);
    }

    public function  store($id, $visa_file_id, Request $request)
    {
        if ($request->has('tamam')) {

            $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
            $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => '<p>Uzman onayı bekleyen dosyalar aşamasında;</p>
                                <ul>
                                    <li>Evraklar onaylandı</li>
                                </ul>
                            <p>şeklinde kayıt tamamlandı.</p>',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $whichGrades = new VisaFileWhichGrades();
            $nextGrades = $whichGrades->nextGrades($visa_file_id);

            if ($nextGrades != null) {

                DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => $nextGrades]);

                if ($request->session()->has($visa_file_id . '_grades_id')) {
                    $request->session()->forget($visa_file_id . '_grades_id');
                }
                $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
                return redirect('/musteri/' . $id . '/vize');
            } else {
                $request->session()->flash('mesajDanger', 'Sonraki aşama bulunamadı');
                return redirect('/musteri/' . $id . '/vize');
            }
        }

        if ($request->has('iptal')) {

            $visaFileGradesId = DB::table('visa_files')->select(['visa_file_grades_id'])->where('id', '=', $visa_file_id)->first();
            $visaFileGradesName = new VisaFileGradesName($visaFileGradesId->visa_file_grades_id);

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => '<p>Uzman onayı bekleyen dosyalar aşamasında;</p>
                                <ul>
                                    <li>Evrakların onayı ret edildi</li>
                                </ul>
                            <p>şeklinde kayıt tamamlandı.</p>',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('visa_files')->where("id", "=", $visa_file_id)->update(['visa_file_grades_id' => env('VISA_DOCUMENT_WAIT_GRADES_ID')]);

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            $request->session()->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
