<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaEmailsInformationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kayitlar = DB::table('visa_emails_information')
            ->select(
                'language.name AS l_name',
                'visa_emails_information.id',
                'visa_emails_information.created_at',
                'visa_emails_information.updated_at',
                'visa_sub_types.name AS vst_name',
                'visa_types.name AS vt_name',
            )
            ->leftJoin(
                'visa_sub_types',
                'visa_sub_types.id',
                '=',
                'visa_emails_information.visa_sub_type_id'
            )
            ->leftJoin(
                'visa_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->leftJoin(
                'language',
                'language.id',
                '=',
                'visa_emails_information.language_id'
            )
            ->get();

        return view('management.visa.emails-information.index')
            ->with(
                ['kayitlar' => $kayitlar]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $language = DB::table('language')->get();

        $visaSubTypes = DB::table('visa_types')
            ->select(
                'visa_types.name AS vt_name',
                'visa_sub_types.name AS vst_name',
                'visa_sub_types.id AS id',
            )
            ->join(
                'visa_sub_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->get();

        return view('management.visa.emails-information.create')
            ->with(
                [
                    'visaSubTypes' => $visaSubTypes,
                    'language' => $language,
                ]
            );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'dil' => 'required|numeric',
            'vize-tipi' => 'required|numeric',
            'icerik' => 'required|min:3'
        ]);
        if (
            DB::table('visa_emails_information')
            ->where(
                'language_id',
                '=',
                $request->input('dil')
            )
            ->where(
                'visa_sub_type_id',
                '=',
                $request->input('vize-tipi')
            )->get()->count() == 0
        ) {
            if ($kayitId = DB::table('visa_emails_information')->insertGetId(
                [
                    'language_id' => $request->input('dil'),
                    'content' => $request->input('icerik'),
                    'visa_sub_type_id' => $request->input('vize-tipi'),
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                ]
            )) {
                DB::table('visa_emails_information')
                    ->where('id', '=', $kayitId)
                    ->update([
                        'orderby' => $kayitId
                    ]);
                $request->session()
                    ->flash('mesajSuccess', 'Ba??ar??yla kaydedildi');
                return redirect('yonetim/vize/bilgi-emaili');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Kay??t s??ralas??nda sorun olu??tu');
                return redirect('yonetim/vize/bilgi-emaili');
            }
        } else {
            $request->session()
                ->flash('mesajInfo', 'Vize tipi ve dil se??imine g??re ??nceden kay??t yap??ld??');
            return redirect('yonetim/vize/bilgi-emaili');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = DB::table('language')->get();

        $visaSubTypes = DB::table('visa_types')
            ->select(
                'visa_types.name AS vt_name',
                'visa_sub_types.name AS vst_name',
                'visa_sub_types.id AS id',
            )
            ->join(
                'visa_sub_types',
                'visa_types.id',
                '=',
                'visa_sub_types.visa_type_id'
            )
            ->get();

        $kayit = DB::table('visa_emails_information')
            ->where('id', '=', $id)
            ->first();

        return view('management.visa.emails-information.edit')
            ->with(
                [
                    'kayit' => $kayit,
                    'visaSubTypes' => $visaSubTypes,
                    'language' => $language,
                ]
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'dil' => 'required|numeric',
            'vize-tipi' => 'required|numeric',
            'icerik' => 'required|min:3'
        ]);

        if (is_numeric($id)) {

            if ($request->input('vize-tipi') != $id) {

                if (
                    DB::table('visa_emails_information')
                    ->where('language_id', '=', $request->input('dil'))
                    ->where('visa_sub_type_id', '=', $request->input('vize-tipi'))
                    ->get()->count() == 0
                ) {

                    if (
                        DB::table('visa_emails_information')
                        ->where('id', '=', $id)
                        ->update(
                            [
                                'language_id' => $request->input('dil'),
                                'content' => $request->input('icerik'),
                                'visa_sub_type_id' => $request->input('vize-tipi'),
                                "updated_at" => date('Y-m-d H:i:s')
                            ]
                        )
                    ) {
                        $request->session()
                            ->flash('mesajSuccess', 'Ba??ar??yla g??ncellendi');
                        return redirect('yonetim/vize/bilgi-emaili');
                    } else {
                        $request->session()
                            ->flash('mesajDanger', 'G??ncelleme s??ralas??nda sorun olu??tu');
                        return redirect('yonetim/vize/bilgi-emaili');
                    }
                } else {
                    $request->session()
                        ->flash('mesajInfo', 'Dil ve Vize tipine ait kay??t bulundu');
                    return redirect('yonetim/vize/bilgi-emaili');
                }
            } else {
                if (
                    DB::table('visa_emails_information')
                    ->where('id', '=', $id)
                    ->update(
                        [
                            'language_id' => $request->input('dil'),
                            'content' => $request->input('icerik'),
                            'visa_sub_type_id' => $request->input('vize-tipi'),
                            "updated_at" => date('Y-m-d H:i:s')
                        ]
                    )
                ) {
                    $request->session()
                        ->flash('mesajSuccess', 'Ba??ar??yla g??ncellendi');
                    return redirect('yonetim/vize/bilgi-emaili');
                } else {
                    $request->session()
                        ->flash('mesajDanger', 'G??ncelleme s??ralas??nda sorun olu??tu');
                    return redirect('yonetim/vize/bilgi-emaili');
                }
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID al??n??rken sorun olu??tu');
            return redirect('yonetim/vize/bilgi-emaili');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (is_numeric($id)) {
            if (
                DB::table('visa_emails_information')
                ->where('id', '=', $id)
                ->delete()
            ) {
                $request->session()
                    ->flash('mesajSuccess', 'Ba??ar??yla silindi');
                return redirect('yonetim/vize/bilgi-emaili');
            } else {
                $request->session()
                    ->flash('mesajDanger', 'Silinme s??ralas??nda sorun olu??tu');
                return redirect('yonetim/vize/bilgi-emaili');
            }
        } else {
            $request->session()
                ->flash('mesajDanger', 'ID al??n??rken sorun olu??tu');
            return redirect('yonetim/vize/bilgi-emaili');
        }
    }
}
