<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\MyClass\InputKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function get_index(Request $request)
    {
        $userAccesses = DB::table('users_access')
            ->select('access.id',)
            ->leftJoin('access', 'access.id', '=', 'users_access.access_id')
            ->where('user_id', '=', $request->session()->get('userId'))
            ->pluck('access.id')->toArray();

        switch ($request->session()->get('userTypeId')) {
            case 2: //danisman
                $visaCustomers = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
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

                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.advisor_id', '=', $request->session()->get('userId'))
                    ->get();

                return view('user.danisman.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                ]);
                break;
            case 3: //uzman
                $visaCustomers = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
                    ])
                    ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                    ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                    ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                    ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                    ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                    ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.expert_id', '=', $request->session()->get('userId'))
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_PUTOFF_GRADES_ID'))
                    ->get();

                return view('user.uzman.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                ]);
                break;
            case 4: //b. koordinatoor
                $mTBGIS = DB::table('customer_update')
                    ->select([
                        'customers.id AS customer_id',
                        'customers.name AS name',
                        'customer_update.id',
                        'customer_update.onay AS onay',
                        'customer_update.created_at',
                        'users.id AS user_id',
                        'users.name AS user_name',
                    ])
                    ->join('customers', 'customers.id', '=', 'customer_update.customer_id')
                    ->join('users', 'users.id', '=', 'customer_update.user_id')
                    ->get();

                $visaCustomersCount = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
                    ])
                    ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                    ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                    ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                    ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                    ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                    ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')
                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATOR_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_EXPERT_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_CANCEL_GRADES_ID'))
                    ->get()->count();

                return view('user.koordinator.index-basvuru')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomersCount' => $visaCustomersCount,
                    'mTBGIS' => $mTBGIS,
                ]);
                break;
            case 5: //tercuman
                $visaCustomers = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
                    ])
                    ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                    ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                    ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                    ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                    ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                    ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')

                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.translator_id', '=', $request->session()->get('userId'))
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATION_GRADES_ID'))
                    ->get();

                return view('user.tercuman.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                ]);
                break;
            case 6: //muhasebe
                $visaCustomers = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
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
                    ->get();

                return view('user.muhasebe.index')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomers' => $visaCustomers,
                ]);
                break;
            case 7: //m.koordinator
                $mTBGIS = DB::table('customer_update')
                    ->select([
                        'customers.id AS customer_id',
                        'customers.name AS customer_name',
                        'customer_update.id',
                        'customer_update.onay',
                        'customer_update.created_at',
                        'users.id AS user_id',
                        'users.name AS user_name',
                    ])
                    ->join('customers', 'customers.id', '=', 'customer_update.customer_id')
                    ->join('users', 'users.id', '=', 'customer_update.user_id')
                    ->get();

                $visaCustomersCount = DB::table('customers')
                    ->select([
                        'customers.id AS id',
                        'customers.name AS name',
                        'visa_files.id AS visa_file_id',
                        'visa_files.status AS status',
                        'visa_file_grades.name AS visa_file_grades_name',
                        'visa_validity.name AS visa_validity_name',
                        'visa_types.name AS visa_type_name',
                        'visa_sub_types.name AS visa_sub_type_name',
                        'users.name AS u_name',
                    ])

                    ->leftJoin('visa_files', 'visa_files.customer_id', '=', 'customers.id')
                    ->leftJoin('visa_validity', 'visa_validity.id', '=', 'visa_files.visa_validity_id')
                    ->leftJoin('visa_file_grades', 'visa_file_grades.id', '=', 'visa_files.visa_file_grades_id')
                    ->leftJoin('visa_sub_types', 'visa_sub_types.id', '=', 'visa_files.visa_sub_type_id')
                    ->leftJoin('visa_types', 'visa_types.id', '=', 'visa_sub_types.visa_type_id')
                    ->leftJoin('users', 'users.id', '=', 'visa_files.advisor_id')

                    ->where('visa_files.active', '=', 1)
                    ->where('visa_files.visa_file_grades_id', '=', env('VISA_TRANSLATOR_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_EXPERT_AUTH_GRADES_ID'))
                    ->orWhere('visa_files.visa_file_grades_id', '=', env('VISA_APPOINTMENT_CANCEL_GRADES_ID'))
                    ->get()->count();

                return view('user.koordinator.index-musteri')->with([
                    'userAccesses' => $userAccesses,
                    'visaCustomersCount' => $visaCustomersCount,
                    'mTBGIS' => $mTBGIS,
                ]);
                break;
            case 8: //ofis sorumlusu
                return view('user.ofissorumlusu.index')->with([
                    'userAccesses' => $userAccesses
                ]);
                break;
            default:
                return view('general.401');
        }
    }

    public function get_profil(Request $request)
    {
        $kullaniciBilgileri = DB::table('users AS u')
            ->select(
                'u.name AS u_name',
                'u.email AS u_email',
                'u.active AS u_active',
                'ut.name AS ut_name',
                'bo.name AS bo_name',
                'um.giris',
                'um.cikis'
            )
            ->Join('users_type AS ut', 'ut.id', '=', 'u.user_type_id')
            ->Join('application_offices AS bo', 'bo.id', '=', 'u.application_office_id')
            ->Join('users_mesai AS um', 'um.user_id', '=', 'u.id')
            ->where('u.id', '=', $request->session()->get('userId'))
            ->first();

        $erisimIzinleri = DB::table('users AS u')
            ->select('e.name AS name')
            ->rightJoin('users_access AS ue', 'u.id', '=', 'ue.user_id')
            ->rightJoin('access AS e', 'e.id', '=', 'ue.access_id')
            ->where('u.id', '=', $request->session()->get('userId'))
            ->get();
        return view('user.profil')->with(
            [
                'kullaniciBilgileri' => $kullaniciBilgileri,
                'erisimIzinleri' => $erisimIzinleri
            ]
        );
    }

    public function post_profil(Request $request)
    {
        //her ihtimale harşı güvenlik kontrolu
        $inputKontrol = new InputKontrol();

        $password = base64_encode($inputKontrol->kontrol($request->input('password')));
        $rePassword = base64_encode($inputKontrol->kontrol($request->input('rePassword')));

        $request->validate([
            'password' => 'required|max:10|min:8',
            'rePassword' => 'required|min:8|max:10',
        ]);

        if ($password == $rePassword) {
            if (DB::update(
                'update users set password = ? where id = ?',
                [$password, $request->session()->get('userId')]
            )) {
                $request->session()->flash('mesajSuccess', 'Şifreniz başarıyla değiştirildi');
                return redirect('kullanici/profil');
            } else {
                $request->session()->flash('mesajDanger', 'Şifreniz güncellenirken sorun oluştu');
                return redirect('kullanici/profil');
            }
        } else {
            $request->session()->flash('mesajInfo', 'Girilen şifreler aynı değil');
            return redirect('kullanici/profil');
        }
    }

    public function get_duyuru(Request $request)
    {
        $duyuruBilgileri = DB::table('notice AS d')
            ->select(
                'd.id AS d_id',
                'u.name AS u_name',
                'd.active AS d_active',
                'd.created_at AS d_tarih',
                'd.updated_at AS d_u_tarih'
            )
            ->Join('users AS u', 'u.id', '=', 'd.user_id')
            ->where('d.active', '=', 1)
            ->get();
        return view('user.notice.index')->with(
            ['notices' => $duyuruBilgileri]
        );
    }

    public function get_TBGI_onay(Request $request, $mg_id)
    {
        if (is_numeric($mg_id)) {

            if (DB::table('customer_update')
                ->where('id', '=', $mg_id)
                ->update(['onay' => 1])

            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Onay işlemi tamamlandı');
                return redirect('/kullanici');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Hatalı bilgi girdiniz');
            return redirect('/kullanici');
        }
    }
    public function get_TBGI_gerial(Request $request, $mg_id)
    {
        if (is_numeric($mg_id)) {

            if (DB::table('customer_update')
                ->where('id', '=', $mg_id)
                ->update(['onay' => 0])
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Geri alma işlemi tamamlandı');
                return redirect('/kullanici');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'Hatalı bilgi girdiniz');
            return redirect('/kullanici');
        }
    }
}
