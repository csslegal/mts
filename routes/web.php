<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\General\LoginController as GeneralLoginController;
use App\Http\Controllers\Management\IndexController as ManagementIndexController;
use App\Http\Controllers\Management\NoticeController as ManagementNoticeController;
use App\Http\Controllers\Management\ProfilController as ManagementProfilController;
use App\Http\Controllers\Management\LanguageController as ManagementLanguageController;
use App\Http\Controllers\Management\CustomersController as ManagementCustomersController;
use App\Http\Controllers\Management\AjaxController as ManagementAjaxController;
use App\Http\Controllers\Management\ApplicationOfficeController as ManagementApplicationOfficeController;
use App\Http\Controllers\Management\AppointmentOfficeController as ManagementAppointmentOfficeController;
use App\Http\Controllers\Management\UsersAccessController as ManagementUsersAccessController;
use App\Http\Controllers\Management\UsersController as ManagementUsersController;
use App\Http\Controllers\Management\UsersTypeController as ManagementUsersTypeController;

use App\Http\Controllers\Management\WebController as ManagementWebController;
use App\Http\Controllers\Management\WebGroupsController as ManagementWebGroupsController;
use App\Http\Controllers\Management\WebPanelsController as ManagementWebPanelsController;
use App\Http\Controllers\Management\WebPanelAuthController as ManagementWebPanelAuthController;

use App\Http\Controllers\Management\VisaController as ManagementVisaController;
use App\Http\Controllers\Management\VisaEmailsDocumentListController as ManagementVisaEmailsDocumentListController;
use App\Http\Controllers\Management\VisaSubTypesController as ManagementVisaSubTypesController;
use App\Http\Controllers\Management\VisaTypesController as ManagementVisaTypesController;
use App\Http\Controllers\Management\VisaEmailsInformationController as ManagementVisaEmailsInformationController;
use App\Http\Controllers\Management\VisaFileGradesController as ManagementVisaFileGradesController;
use App\Http\Controllers\Management\VisaFileGradesUsersTypeController as ManagementVisaFileGradesUsersTypeController;
use App\Http\Controllers\Management\VisaValidityController as ManagementVisaValidityController;
use App\Http\Controllers\Management\UrlController;

use App\Http\Controllers\Web\IndexController as WebIndexController;

use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\AjaxController as UserAjaxController;

use App\Http\Controllers\Customer\IndexController as CustomerIndexController;
use App\Http\Controllers\Customer\SearchController as CustomerSearchController;
use App\Http\Controllers\Customer\NoteController as CustomerNoteController;
use App\Http\Controllers\Customer\EditRequestController as CustomerEditRequestController;
use App\Http\Controllers\Customer\LogsController as CustomerLogsController;
use App\Http\Controllers\Customer\AjaxController as CustomerAjaxController;
use App\Http\Controllers\Customer\Visa\IndexController as VisaIndexController;
use App\Http\Controllers\Customer\Visa\GradesUpdateController as VisaGradesUpdateController;
use App\Http\Controllers\Customer\Visa\InformationEmailController as VisaInformationEmailController;
use App\Http\Controllers\Customer\Visa\Grades\FileOpenController as VisaFileOpenController;
use App\Http\Controllers\Customer\Visa\Grades\ReceivedPaymentsController as VisaReceivedPaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\ReceivedPaymentsConfirmController as VisaReceivedPaymentsConfirmController;
use App\Http\Controllers\Customer\Visa\Grades\DocumentListEmailSendController as VisaDocumentListEmailSendController;
use App\Http\Controllers\Customer\Visa\Grades\DocumentListCompletedController as VisaDocumentListCompletedController;
use App\Http\Controllers\Customer\Visa\Grades\TranslatorAuthController as VisaTranslatorAuthController;
use App\Http\Controllers\Customer\Visa\Grades\TranslationsCompletedController as VisaTranslationsCompletedController;
use App\Http\Controllers\Customer\Visa\Grades\ExpertAuthController as VisaExpertAuthController;
use App\Http\Controllers\Customer\Visa\Grades\AppointmentCompletedController as VisaAppointmentCompletedController;
use App\Http\Controllers\Customer\Visa\Grades\MadePaymentsController as VisaMadePaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\DactylogramController as VisaDactylogramController;

use App\Http\Controllers\Customer\Visa\Grades\AppointmentCancelController as VisaAppointmentCancelController;

use App\Http\Controllers\Customer\Visa\Grades\AppointmentPutOffController as VisaAppointmentPutOffController;
use App\Http\Controllers\Customer\Visa\Grades\ReReceivedPaymentsController as VisaReReceivedPaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\ReReceivedPaymentsConfirmController as VisaReReceivedPaymentsConfirmController;

use App\Http\Controllers\Customer\Visa\Grades\InvoicesSaveController as VisaInvoicesSaveController;
use App\Http\Controllers\Customer\Visa\Grades\ApplicationResultController as VisaApplicationResultController;
use App\Http\Controllers\Customer\Visa\Grades\FileDeliveryController as VisaFileDeliveryController;
use App\Http\Controllers\Customer\Visa\Grades\RefusalTranslationController as VisaRefusalTranslationController;

use App\Http\Controllers\Customer\Visa\Grades\CloseRequestController as VisaCloseRequestController;
use App\Http\Controllers\Customer\Visa\Grades\CloseConfirmController as VisaCloseConfirmController;
use App\Http\Controllers\Customer\Visa\Grades\RefundPaymentsController as VisaRefundPaymentsController;
use App\Http\Controllers\Customer\Visa\Grades\RefundPaymentsConfirmController as VisaRefundPaymentsConfirmController;

use App\Http\Controllers\Customer\Visa\PaymentsController as VisaPaymentsController;
use App\Http\Controllers\Customer\Visa\InvoicesController as VisaInvoicesController;
use App\Http\Controllers\Customer\Visa\ArchivesController as VisaArchivesController;
use App\Http\Controllers\Customer\Visa\ArchiveTransportController as VisaArchiveTransportController;

/**Genel y??nlendirmeler*/
Route::get('/', [GeneralLoginController::class, "get_index"]);

Route::redirect('yonlendirme', '/');
Route::resource('giris', GeneralLoginController::class);

/**Oturum y??nlendirmeler*/
Route::middleware(['sessionCheck'])->group(function () {

    Route::get('/index', [GeneralLoginController::class, "get_index"]);
    Route::get('/cikis', [GeneralLoginController::class, "get_cikis"]);
    Route::post('/theme', [GeneralLoginController::class, "post_theme"]);

    /**Musteri y??nlendirmeler*/
    Route::resource('musteri/sorgula', CustomerSearchController::class);
    Route::resource('musteri', CustomerIndexController::class);

    Route::group(['prefix' => 'musteri'], function () {

        Route::resource('{id}/not-ekle', CustomerNoteController::class);
        Route::resource('{id}/duzenle-istek', CustomerEditRequestController::class);
        Route::resource('{id}/logs', CustomerLogsController::class);

        /**Vize i??lemleri*/
        Route::group(['prefix' => '{id}/vize'], function () {
            Route::get('/', [VisaIndexController::class, 'index']);
            Route::get('asama', [CustomerAjaxController::class, 'get_grades']);
            Route::resource('bilgi-emaili', VisaInformationEmailController::class);
            Route::resource('arsiv', VisaArchivesController::class);

            /**Dosya a??ama i??lemleri */
            Route::resource('dosya-ac', VisaFileOpenController::class);

            Route::group(['prefix' => '{visa_file_id}', 'middleware' => 'gradesCheck'], function () {

                /***Dosya a??amalar??ndan ba????ms??z b??l??mler */
                Route::resource('asama-guncelle', VisaGradesUpdateController::class);
                Route::resource('odeme', VisaPaymentsController::class);
                Route::resource('fatura', VisaInvoicesController::class);
                Route::resource('arsive-tasima', VisaArchiveTransportController::class);

                /***Dosya a??amalar?? ba??lang???? */
                Route::get('alinan-odeme-tamamla', [VisaReceivedPaymentsController::class, 'tamamla']);
                Route::get('yapilan-odeme-tamamla', [VisaMadePaymentsController::class, 'tamamla']);
                Route::get('fatura-kayit-tamamla', [VisaInvoicesSaveController::class, 'tamamla']);
                Route::get('yeniden-alinan-odeme-tamamla', [VisaReReceivedPaymentsController::class, 'tamamla']);
                Route::get('iade-bilgileri-tamamla', [VisaRefundPaymentsController::class, 'tamamla']);

                Route::resource('alinan-odeme', VisaReceivedPaymentsController::class);
                Route::resource('alinan-odeme-onay', VisaReceivedPaymentsConfirmController::class);
                Route::resource('evrak-listesi', VisaDocumentListEmailSendController::class);
                Route::resource('evrak-hazirlama', VisaDocumentListCompletedController::class);
                Route::resource('tercuman-yetkilendir', VisaTranslatorAuthController::class);
                Route::resource('tercume-tamamlama', VisaTranslationsCompletedController::class);
                Route::resource('uzman-yetkilendir', VisaExpertAuthController::class);
                Route::resource('form-bilgileri', VisaAppointmentCompletedController::class);
                Route::resource('yapilan-odeme', VisaMadePaymentsController::class);
                Route::resource('parmak-izi', VisaDactylogramController::class);

                Route::resource('randevu-iptali', VisaAppointmentCancelController::class);

                Route::resource('randevu-erteleme', VisaAppointmentPutoffController::class);
                Route::resource('yeniden-alinan-odeme', VisaReReceivedPaymentsController::class);
                Route::resource('yeniden-alinan-odeme-onay', VisaReReceivedPaymentsConfirmController::class);

                Route::resource('fatura-kayit', VisaInvoicesSaveController::class);
                Route::resource('basvuru-sonuc', VisaApplicationResultController::class);
                Route::resource('red-tercume', VisaRefusalTranslationController::class);
                Route::resource('teslimat-bilgisi', VisaFileDeliveryController::class);

                Route::resource('kapatma', VisaCloseRequestController::class);
                Route::resource('kapatma-onayi', VisaCloseConfirmController::class);
                Route::resource('iade-bilgileri', VisaRefundPaymentsController::class);
                Route::resource('iade-bilgileri-onayi', VisaRefundPaymentsConfirmController::class); //sonras??nda teslimat a??amas??na gececek
                /***Dosya a??amalar?? son */
            });
        });

        /**Musteri ajax i??lemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('name-kontrol', [CustomerAjaxController::class, 'post_name_kontrol']);
            Route::post('telefon-kontrol', [CustomerAjaxController::class, 'post_telefon_kontrol']);
            Route::post('email-kontrol', [CustomerAjaxController::class, 'post_email_kontrol']);
            Route::post('not-goster', [CustomerAjaxController::class, 'post_not_goster']);
            Route::post('email-log-goster', [CustomerAjaxController::class, 'post_email_log_goster']);
            Route::post('visa-log-goster', [CustomerAjaxController::class, 'post_visa_log_goster']);
            Route::post('not-sil', [CustomerAjaxController::class, 'post_not_sil']);
            Route::post('alt-vize-tipi', [CustomerAjaxController::class, 'post_visa_sub_type']);
            Route::post('vize-dosya-log', [CustomerAjaxController::class, 'post_visa_file_log_content']);

            Route::group(['prefix' => 'vize'], function () {

                Route::post('arsiv-log', [CustomerAjaxController::class, 'post_visa_archive_log']);
                Route::post('arsiv-odeme', [CustomerAjaxController::class, 'post_visa_archive_payment']);
                Route::post('arsiv-makbuz', [CustomerAjaxController::class, 'post_visa_archive_receipt']);
                Route::post('arsiv-fatura', [CustomerAjaxController::class, 'post_visa_archive_invoice']);
            });
        });
    });

    /**Kullan??c??lar y??nlendirmeler*/
    Route::group(['prefix' => 'kullanici'], function () {
        Route::get('/', [UserIndexController::class, 'get_index']);
        Route::get('profil', [UserIndexController::class, 'get_profil']);
        Route::post('profil', [UserIndexController::class, 'post_profil']);
        Route::get('duyuru', [UserIndexController::class, 'get_duyuru']);

        /**web y??nlendirmeleri */
        Route::prefix('web')->group(function () {
            Route::resource('/', WebIndexController::class);
        });

        /*** Kullan??c??lar ajax i??lemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('duyuru', [UserAjaxController::class, 'post_duyuru_icerik_cek']);
            Route::get('duyuru-sayisi', [UserAjaxController::class, 'get_active_notice_count']);
        });
    });

    /**Yonetim y??nlendirmeler*/
    Route::group(['prefix' => 'yonetim', 'middleware' => 'managementCheck'], function () {

        Route::get('/', [ManagementIndexController::class, 'get_index']);

        Route::resource('duyuru', ManagementNoticeController::class);
        Route::resource('profil', ManagementProfilController::class);
        Route::resource('users', ManagementUsersController::class);
        Route::resource('users-type', ManagementUsersTypeController::class);
        Route::resource('users-access', ManagementUsersAccessController::class);
        Route::resource('application-office', ManagementApplicationOfficeController::class);
        Route::resource('appointment-office', ManagementAppointmentOfficeController::class);
        Route::resource('customers', ManagementCustomersController::class);
        Route::resource('language', ManagementLanguageController::class);

        /**Yonetim ajax i??lemleri*/
        Route::group(['prefix' => 'ajax'], function () {
            Route::post('duyuru', [ManagementAjaxController::class, 'post_duyuru_cek']);
            Route::post('bilgi-emaili', [ManagementAjaxController::class, 'post_bilgi_emaili_cek']);
            Route::post('evrak-emaili', [ManagementAjaxController::class, 'post_evrak_emaili_cek']);
            Route::post('sirala', [ManagementAjaxController::class, 'post_sorting']);
            Route::post('dosya-asama-erisim', [ManagementAjaxController::class, 'post_visa_file_grades_users_type']);
            Route::post('panel-list', [ManagementAjaxController::class, 'post_panel_list']);

            Route::get('customers', [ManagementAjaxController::class, 'get_customers_list']);
            Route::get('visa-logs', [ManagementAjaxController::class, 'get_visa_logs_list']);
        });

        /**Yonetim vize i??lemleri*/
        Route::group(['prefix' => 'vize'], function () {

            Route::get('/', [ManagementVisaController::class, 'get_index']);
            Route::get('danisman', [ManagementVisaController::class, 'get_danisman']);
            Route::get('uzman', [ManagementVisaController::class, 'get_uzman']);
            Route::get('muhasebe', [ManagementVisaController::class, 'get_muhasebe']);
            Route::get('tercuman', [ManagementVisaController::class, 'get_tercuman']);

            Route::resource('vize-tipi', ManagementVisaTypesController::class);
            Route::resource('vize-suresi', ManagementVisaValidityController::class);
            Route::resource('alt-vize-tipi', ManagementVisaSubTypesController::class);
            Route::resource('bilgi-emaili', ManagementVisaEmailsInformationController::class);
            Route::resource('evrak-emaili', ManagementVisaEmailsDocumentListController::class);
            Route::resource('dosya-asama', ManagementVisaFileGradesController::class);
            Route::resource('dosya-asama-erisim', ManagementVisaFileGradesUsersTypeController::class);
        });

        /**Yonetim web i??lemleri*/
        Route::group(['prefix' => 'web'], function () {
            Route::get('/', [ManagementWebController::class, 'get_index']);
            Route::get('engineer', [ManagementWebController::class, 'get_engineer']);
            Route::get('editor', [ManagementWebController::class, 'get_editor']);
            Route::get('writer', [ManagementWebController::class, 'get_writer']);
            Route::get('graphic', [ManagementWebController::class, 'get_graphic']);
            Route::get('paneller', [ManagementWebController::class, 'get_paneller']);

            /**Url tespit ????lemleri */
            Route::post('/url/ajax-ozet', [UrlController::class, 'get_ajax_ozet']);
            Route::post('/url/ajax-detay', [UrlController::class, 'get_ajax_detay']);
            Route::get('/url/detay', [UrlController::class, 'get_detay']);
            Route::get('/url/{id}/home', [UrlController::class, 'get_home_links']);
            Route::get('/url/{id}/subpage/{subId}', [UrlController::class, 'get_subpage']);
            Route::get('/url/{id}/subpage/{subId}/home', [UrlController::class, 'get_subpage_links']);

            Route::resource('groups', ManagementWebGroupsController::class);
            Route::resource('panels', ManagementWebPanelsController::class);
            Route::resource('panel-auth', ManagementWebPanelAuthController::class);
            Route::resource('url', UrlController::class);
        });
    });
});
