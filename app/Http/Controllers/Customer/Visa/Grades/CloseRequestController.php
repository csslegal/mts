<?php

namespace App\Http\Controllers\Customer\Visa\Grades;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CloseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $visa_file_id, Request $request)
    {


        $visaApplicationResultCount = DB::table('visa_application_result')
            ->where('visa_file_id', '=', $visa_file_id)->get()->count();

        $dataArray = array(
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'visa_result' => 2,
            'visa_date' => null,
            'visa_refusal_reason' => null,
            'visa_refusal_date' => null,
            'visa_file_close_date' => null,
        );

        if ($visaApplicationResultCount > 0) {
            $dataArray = array_merge(
                $dataArray,
                array('updated_at' => date('Y-m-d H:i:s'))
            );
            DB::table('visa_application_result')
                ->where("visa_file_id", "=", $visa_file_id)
                ->update($dataArray);
        } else {
            $dataArray = array_merge(
                $dataArray,
                array('created_at' => date('Y-m-d H:i:s'))
            );
            DB::table('visa_application_result')->insert($dataArray);
        }

        $visaFileGradesName = new VisaFileGradesName(
            env('VISA_FILE_CLOSE_REQUEST_GRADES_ID')
        );

        DB::table('visa_file_logs')->insert([
            'visa_file_id' => $visa_file_id,
            'user_id' => $request->session()->get('userId'),
            'subject' => $visaFileGradesName->getName(),
            'content' => 'Cari dosyası kapatma isteği oluşturuldu.',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('visa_files')->where("id", "=", $visa_file_id)
            ->update(['visa_file_grades_id' => env('VISA_FILE_CLOSE_CONFIRM_GRADES_ID')]);

        if ($request->session()->has($visa_file_id . '_grades_id')) {
            $request->session()->forget($visa_file_id . '_grades_id');
        }

        $request->session()
            ->flash('mesajSuccess', 'Kayıt başarıyla yapıldı');
        return redirect('/musteri/' . $id . '/vize');
    }
}
