<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\BackupHistory;
use App\Models\Currency;
use App\Models\Option;
use App\Models\PaymentType;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BaariAppController extends Controller
{
    // should be updated all $data with fixed validate data
    public function index()
    {

        $app_setting        = get_option('setting');
        $app_message        = get_option('message');
        $login              = get_option('login');
        $banners            = get_option('banner');
        $business           = get_option('business');
        $dashboard          = get_option('dashboard');
        $feature            = get_option('features');
        $loan_sale          = get_option('loan-sale');
        $printer            = get_option('printer');
        $ad                 = get_option('ads');
        $theme              = get_option('theme');
        $notification_plan  = get_option('notification-plan');
        $user_types         = UserType::where('status', 1)->latest()->get();
        $notification_sents = get_option('notification-sent');
        $notification       = get_option('notification');
        $currencies         = Currency::orderBy('default', 'desc')->orderBy('status', 'desc')->get();
        $installment        = get_option('installment');
        $languages          = get_option('language');
        $loan               = get_option('loan');
        $template           = get_option('template');
        $announcements      = get_option('announcements');
        $invoices           = get_option('invoice');
        $payment_types      = PaymentType::latest()->get();
        $histories          = BackupHistory::where('status',2)->latest()->get();

        return view('author.pages.app.index', compact('app_setting', 'app_message', 'login', 'banners', 'business', 'dashboard', 'feature', 'loan_sale', 'printer', 'ad', 'theme', 'notification_plan', 'user_types', 'notification_sents', 'notification', 'currencies','installment', 'languages', 'loan', 'template', 'announcements', 'invoices', 'payment_types','histories'));
    }

    /** App Setting */
    public function settingUpdate(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'app_url'       => 'required|url',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'android_url'   => 'required|url',
            'ios_url'       => 'required|url',
            'version'       => 'required|string',
            'rate'          => 'required|numeric',
        ]);

        unset($data['logo']); // Remove the 'image' field from the $data array
        $app_setting = Option::where('key', 'setting')->first();
        $data['logo'] = $request->hasFile('logo') ? imageUpload($request->file('logo'), 'websites', $app_setting->value['logo'] ?? null) : $app_setting->value['logo'] ?? null;

        Option::updateOrCreate(
            ['key' => 'setting'],
            ['value' => $data]
        );
        cache::forget('setting');

        return response()->json(__('App-settings updated successfully.'));
    }

    public function messageUpdate(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string',
            'message'   => 'required|string',
        ]);

        Option::updateOrCreate(
            ['key' => 'message'],
            ['value' => $data]
        );

        cache::forget('message');
        return response()->json(__('App update-message saved successfully.'));
    }

    /** App Login Type */
    public function loginUpdate(Request $request)
    {
        $data = $request->validate([
            'mobile'    => 'nullable|in:on',
            'gmail'     => 'nullable|in:on',
            'otp'       => 'nullable|in:on',
            'guest'     => 'nullable|in:on',
            'social'    => 'nullable|in:on',
        ]);

        // Check if at least one input field is checked
        $checkedFields = array_filter($data);
        if (empty($checkedFields)) {
            return response()->json(__('At least one field must be checked.'), 404);
        }

        Option::updateOrCreate(
            ['key' => 'login'],
            ['value' => $data]
        );
        cache::forget('login');

        return response()->json(__('App login type updated successfully.'));
    }

    /** Banner Setting Start */
    public function bannerStore(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string',
            'link'          => 'nullable|url',
            'sub_title'     => 'nullable|string',
            'percentage'    => 'nullable|numeric|gt:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        Option::create([
            'key' => 'banner',
            'value' => $request->except('_token', 'image') + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'apps') : '',
                ]
        ]);
        Cache::forget('banner');

        return response()->json([
            'message' => __('Banner saved successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'banner'])
        ]);
    }

    public function bannerUpdate(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string',
            'link'          => 'nullable|url',
            'sub_title'     => 'nullable|string',
            'percentage'    => 'nullable|numeric|gt:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $banner = Option::findOrFail($id);
        $banner->update([
            'value' => $request->except('_token', '_method', 'image') + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'apps', $banner->value['image']) : $banner->value['image'] ?? null,
                ]
        ]);
        cache::forget('banner');
        return response()->json([
            'message' => __('Banner updated successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'banner'])
        ]);
    }

    public function bannerDestroy($id)
    {
        $banner = Option::findOrFail($id);
        if (isset($banner->value['image'])) {
            uploadImageDelete($banner->value['image']);
        }
        $banner->delete();
        cache::forget('banner');

        return response()->json([
            'message' => __('Banner deleted successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'banner'])
        ]);
    }

    public function bannerStatus(Request $request, $id)
    {
        $banner = Option::findOrFail($id);
        $banner->update([
            'status' => $request->status
        ]);
        cache::forget('banner');
        return response()->json(['message' => 'Banner']);
    }
    /** Banner Setting End */

    /** Business Setting */
    public function businessUpdate(Request $request)
    {
        $request->validate([
            'Create'            => 'nullable|in:on',
            'user_role'         => 'nullable|in:on',
            'category'          => 'nullable|in:on',
            'max_user_role'     => 'nullable|in:on',
            'customer_access'   => 'nullable|in:on',
            'guest'             => 'nullable|in:on',
            'status'            => 'nullable|in:on',
        ]);

        $data = $request->except('_token', '_method', 'status');
        Option::updateOrCreate(
            ['key' => 'business'],
            ['value' => $data],
            ['status' =>  $request->status ? 1 : 0],
        );

        cache::forget('business');

        return response()->json(__('Business setting updated successfully.'));
    }

    /** App Dashboard Setting */
    public function dashboardUpdate(Request $request)
    {
        $request->validate([
            'menu'              => 'nullable|in:on',
            'banner'            => 'nullable|in:on',
            'notification'      => 'nullable|in:on',
            'navigation'        => 'nullable|in:on',
            'search'            => 'nullable|in:on',
            'schedule'          => 'nullable|in:on',
            'installment'       => 'nullable|in:on',
            'today_collection'  => 'nullable|in:on',
            'transaction'       => 'nullable|in:on',
            'due_collection'    => 'nullable|in:on',
        ]);
        $data = $request->except('_token', '_method');
        $dashboard = Option::where('key', 'dashboard')->first();

        if($dashboard){
            $dashboard->update([
                'value' => $data,
            ]);
        } else{
            Option::create([
                'key' => 'dashboard',
                'value' => $data,
            ]);
        }
        cache::forget('dashboard');

        return response()->json(__('App dashboard setting updated successfully.'));
    }

    /** App Features List */
    public function featuresUpdate(Request $request)
    {
        $request->validate([
            'create_sales'  => 'nullable|in:on',
            'sales_list'    => 'nullable|in:on',
            'calculator'    => 'nullable|in:on',
            'installments'  => 'nullable|in:on',
            'products'      => 'nullable|in:on',
            'purchase'      => 'nullable|in:on',
            'stock'         => 'nullable|in:on',
            'ledger'        => 'nullable|in:on',
            'income'        => 'nullable|in:on',
            'expense'       => 'nullable|in:on',
            'loss_profit'   => 'nullable|in:on',
            'reports'       => 'nullable|in:on',
            'loan_list'     => 'nullable|in:on',
        ]);

        $data = $request->except('_token', '_method');
        Option::updateOrCreate(
            ['key' => 'features'],
            ['value' => $data]
        );

        cache::forget('features');

        return response()->json(__('App features updated successfully.'));
    }

    /** Loan & Sale Setting */
    public function loanSaleUpdate(Request $request)
    {
        $request->validate([
            'sale_setting'  => 'nullable|in:on',
            'loan_item'     => 'nullable|in:on',
            'loan'          => 'nullable|in:on',
            'item'          => 'nullable|in:on',
        ]);

        $data = $request->except('_token', '_method');
        Option::updateOrCreate(
            ['key' => 'loan-sale'],
            ['value' => $data]
        );
        cache::forget('loan-sale');

        return response()->json(__('Loan & sale setting updated successfully.'));
    }

    /** Printer Setting */
    public function printerUpdate(Request $request)
    {
        $request->validate([
            'sale_setting' => 'nullable|in:on',
            'loan_item'    => 'nullable|in:on',
            'loan'         => 'nullable|in:on',
            'item'         => 'nullable|in:on',
            'status'       => 'nullable|in:on',
        ]);

        $data = $request->except('_token', '_method', 'status');
        Option::updateOrCreate(
            ['key' => 'printer'],
            ['value' => $data, 'status' => $request->status ? 1 : 0]
        );
        Cache::forget('printer');

        return response()->json(__('Printer updated successfully.'));
    }

    /** Ads Setting */
    public function adsUpdate(Request $request)
    {
        $request->validate([
            'admob_status' => 'nullable|in:on',
            'fb_status' => 'nullable|in:on',
            'admob_banner.value' => 'nullable|string',
            'admob_banner.status' => 'nullable|in:on',
            'admob_interstitial.value' => 'nullable|string',
            'admob_interstitial.status' => 'nullable|in:on',
            'admob_native.value' => 'nullable|string',
            'admob_native.status' => 'nullable|in:on',
            'fb_banner.value' => 'nullable|string',
            'fb_banner.status' => 'nullable|in:on',
            'fb_interstitial.value' => 'nullable|string',
            'fb_interstitial.status' => 'nullable|in:on',
            'fb_native.value' => 'nullable|string',
            'fb_native.status' => 'nullable|in:on',
        ]);

        $data = $request->except('_token', '_method');
        Option::updateOrCreate(
            ['key' => 'ads'],
            ['value' => $data]
        );

        Cache::forget('ads');

        return response()->json(__('Ads updated successfully.'));
    }

    /** App Theme */
    public function themeUpdate(Request $request)
    {
        $request->validate([
            'status'    => 'nullable|in:on',
            'color'     => 'required|string',
            'theme'     => 'required|string',
        ]);

        $data = $request->only('color', 'theme');
        Option::updateOrCreate(
            ['key' => 'theme'],
            ['value' => $data, 'status' => $request->status ? 1 : 0]
        );
        Cache::forget('theme');

        return response()->json(__('App Theme updated successfully.'));
    }

    /** Notification Send Start*/
    public function notificationPlanUpdate(Request $request)
    {
        $request->validate([
            'status'    => 'nullable|in:on',
            'date'     => 'required|string',
        ]);

        $data = $request->only('date');
        Option::updateOrCreate(
            ['key' => 'notification-plan'],
            ['value' => $data, 'status' => $request->status ? 1 : 0]
        );
        Cache::forget('notification-plan');

        return response()->json(__('Notification plan updated successfully.'));
    }

    public function notificationSentStore(Request $request)
    {
        $request->validate([
            'sender'    => 'required|string',
            'link'      => 'nullable|url',
            'title'     => 'required|string',
            'message'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        Option::create([
            'key' => 'notification-sent',
            'value' => $request->except('_token', 'image') + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'apps') : '',
                ]
        ]);
        Cache::forget('notification-sent');

        return response()->json([
            'message' => __('Notification saved successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'notification'])
        ]);
    }

    public function notificationSentUpdate(Request $request, $id)
    {
        $request->validate([
            'sender'    => 'required|string',
            'link'      => 'nullable|url',
            'title'     => 'required|string',
            'message'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $notification_sent = Option::findOrFail($id);
        $notification_sent->update([
            'value' => $request->except('_token', '_method', 'image') + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'apps', $notification_sent->value['image']) : $notification_sent->value['image'] ?? null,
                ]
        ]);
        Cache::forget('notification-sent');

        return response()->json([
            'message' => __('Notification updated successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'notification'])
        ]);
    }

    public function notificationSentDestroy($id)
    {
        $notification_sent = Option::findOrFail($id);
        if (isset($notification_sent->value['image'])) {
            uploadImageDelete($notification_sent->value['image']);
        }
        $notification_sent->delete();
        Cache::forget('notification-sent');

        return response()->json([
            'message' => __('Notification deleted successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'notification'])
        ]);
    }
    /** Notification Send End */

    /** Currency Setting Start */
    public function currencyStore(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|unique:currencies',
            'iso_code'  => 'required|string|unique:currencies',
            'symbol'    => 'required|string|unique:currencies',
        ]);

        Currency::create($request->all());

        return response()->json([
            'message' => __('Currency saved successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'currency'])
        ]);
    }

    public function currencyUpdate(Request $request, $id)
    {
        $request->validate([
            'default' => 'nullable|integer|in:0,1',
        ]);

        $currency = Currency::findOrFail($id);

        if ($request->default == 1) {
            // default value of all currencies set to 0 except current request
            Currency::where('id', '!=', $currency->id)->update(['default' => 0]);
        } else {
            // Check exist default value 1
            $remainingDefaultCurrencies = Currency::where('default', 1)->where('id', '!=', $currency->id)->count();
            if ($remainingDefaultCurrencies == 0) {
                return response()->json( __('At least one currency must be set as default.'), 404);
            }
        }
        $currency->update(['default' => $request->default]);

        return response()->json([
            'message' => __('Currency updated successfully.'),
            'redirect' => route('authorapps.index', ['tab' => 'currency'])
        ]);
    }
    /** Currency Setting End */

    /** Installment System */
    public function installmentUpdate(Request $request)
    {
        $request->validate([
            'installment'    => 'nullable|in:on',
        ]);
        $data = $request->except('_token', '_method');
        Option::updateOrCreate(
            ['key' => 'installment'],
            ['value' => $data]
        );
        cache::forget('installment');
        return response()->json(__('Installment updated successfully.'));
    }
    /** App Language Start */
    public function languageStore(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|unique:options,value->name',
            'status'    => 'required|integer',
        ]);

        Option::create([
            'key' => 'language',
            'value' => $request->only('name'),
            'status' => $request->status,
        ]);
        Cache::forget('language');

        return response()->json([
            'message' => __('Language saved successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'language'])
        ]);
    }

    public function languageUpdate(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|unique:options,value->name,'.$id,
            'status'    => 'required|integer',
        ]);

        $language = Option::findOrFail($id);
        $language->update([
            'value' => $request->only('name'),
            'status' => $request->status,
        ]);
        cache::forget('language');
        return response()->json([
            'message' => __('Language updated successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'language'])
        ]);
    }

    public function languageDestroy($id)
    {
        $language = Option::findOrFail($id);
        $language->delete();
        cache::forget('language');

        return response()->json([
            'message' => __('Language deleted successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'language'])
        ]);
    }

    public function languageStatus(Request $request, $id)
    {
        $language = Option::findOrFail($id);
        $language->update([
            'status' => $request->status
        ]);
        cache::forget('language');
        return response()->json(['message' => 'Language']);
    }

    /** App Language End */

    /** Loan Setting */
    public function loanUpdate(Request $request)
    {
        $request->validate([
            'loan_due_collection' => 'nullable|in:daily,weekly,semi-month,month',
            'interest_or_tax' => 'nullable|in:1,0',
            'loan_start_date' => 'nullable|date',
            'interest_setting' => 'nullable|in:on',
            'number_of_installments' => 'nullable|integer',
            'tax_setting' => 'nullable|in:on',
            'interest_rate' => 'nullable|numeric',
            'other_setting' => 'nullable|in:on',
            'interest_on_loan' => 'nullable|in:on',
            'interest_on_item' => 'nullable|in:on',
            'calculate_result' => 'nullable|in:on',
        ]);

        $data = $request->except('_token', '_method');
        Option::updateOrCreate(
            ['key' => 'loan'],
            ['value' => $data]
        );

        Cache::forget('loan');

        return response()->json(__('Loan updated successfully.'));
    }

    /** Receipt Template Setting */
    public function templateUpdate(Request $request)
    {
        $request->validate([
            'multiple_invoice' => 'nullable|in:on',
            'amount_received_details' => 'nullable|in:on',
            'filter_button' => 'nullable|in:on',
            'instalments_details' => 'nullable|in:on',
            'store_logo' => 'nullable|in:on',
            'generated_date' => 'nullable|in:on',
            'store_mobile_number' => 'nullable|in:on',
            'invoice_text' => 'nullable|in:on',
            'invoice_id' => 'nullable|in:on',
            'invoice_bottom_text' => 'nullable|in:on',
            'customer_name' => 'nullable|in:on',
            'signature' => 'nullable|in:on',
            'share_button' => 'nullable|in:on',
            'customer_signature' => 'nullable|in:on',
            'print_button' => 'nullable|in:on',
            'barcode_bottom' => 'nullable|in:on',
            'pdf_button' => 'nullable|in:on',
            'app_name_logo' => 'nullable|in:on',
            'download_button' => 'nullable|in:on',
            'modern_box' => 'nullable|in:on',
            'paper_size_value' => 'nullable|in:a4,34,letter',
            'paper_size_status' => 'nullable|in:on',
            'color' => 'nullable|in:app,blue,pink,black_white',
        ]);

        $data = $request->except('_token', '_method');
        Option::updateOrCreate(
            ['key' => 'template'],
            ['value' => $data]
        );

        Cache::forget('template');

        return response()->json(__('Receipt template updated successfully.'));
    }

    /** Invoice Setting Start */
    public function invoiceStore(Request $request)
    {
        $data = $request->validate([
            'logo' => 'nullable|in:on',
            'app_link' => 'nullable|in:on',
            'name' => 'required|string',
            'size' => 'required|string',
        ]);

        Option::create([
            'key' => 'invoice',
            'value' => $data,
        ]);
        Cache::forget('invoice');

        return response()->json([
            'message' => __('Invoice saved successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'invoice'])
        ]);
    }


    public function invoiceDestroy($id)
    {
        $invoice = Option::findOrFail($id);
        $invoice->delete();
        cache::forget('invoice');

        return response()->json([
            'message' => __('Invoice deleted successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'invoice'])
        ]);
    }

    public function invoiceStatus(Request $request, $id)
    {
        $invoice = Option::findOrFail($id);
        $invoice->update([
            'status' => $request->status
        ]);
        cache::forget('invoice');
        return response()->json(['message' => 'Invoice']);
    }
    /** Invoice Setting End */

    /** Payment Type Setting Start */
    public function paymentTypeStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:payment_types',
        ]);

        PaymentType::create($data);

        return response()->json([
            'message' => __('Payment Type saved successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'payment'])
        ]);
    }

    public function paymentTypeDestroy($id)
    {
        $payment_type = PaymentType::findOrFail($id);
        $payment_type->delete();

        return response()->json([
            'message' => __('Payment Type deleted successfully'),
            'redirect' => route('authorapps.index', ['tab' => 'payment'])
        ]);
    }

    public function paymentTypeStatus(Request $request, $id)
    {
        $payment_type = PaymentType::findOrFail($id);
        $payment_type->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'Payment Type']);
    }
    /** Payment Type Setting End */

}
