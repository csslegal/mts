<?php

namespace App\Http\Controllers\Customer\Visa;

use App\Http\Controllers\Controller;
use App\MyClass\VisaFileGradesName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveTransportController extends Controller
{

    public function index($id, $visa_file_id, Request $request)
    {
        if (is_numeric($visa_file_id)) {

            $visaFileGradesId = DB::table('visa_files')
                ->select(['visa_file_grades_id'])
                ->where('id', '=', $visa_file_id)->first();

            $visaFileGradesName = new VisaFileGradesName(
                $visaFileGradesId->visa_file_grades_id
            );

            DB::table('visa_files')->where("id", "=", $visa_file_id)
                ->update([
                    'active' => 0,
                    'visa_file_grades_id' => env('VISA_FILE_CLOSED_GRADES_ID')
                ]);

            if ($request->session()->has($visa_file_id . '_grades_id')) {
                $request->session()->forget($visa_file_id . '_grades_id');
            }

            DB::table('visa_file_logs')->insert([
                'visa_file_id' => $visa_file_id,
                'user_id' => $request->session()->get('userId'),
                'subject' => $visaFileGradesName->getName(),
                'content' => 'Vize dosyası arşive taşındı',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $request->session()->flash('mesajSuccess', 'İşlem başarıyla yapıldı');
            return redirect('/musteri/' . $id . '/vize');
        } else {
            $request->session()->flash('mesajDanger', 'Vize dosyası ID alınırken hata oluştu');
            return redirect('/musteri/' . $id . '/vize');
        }
    }
}
