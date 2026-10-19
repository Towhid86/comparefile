<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\BackupHistory;
use App\Models\Option;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class BaariWebSettingController extends Controller
{
    public function index()
    {
        $logo = get_option('logo');
        $general = get_option('general');
        $landings = get_option('landing');
        $app_download = get_option('app-download');
        $footer = get_option('footer');
        $pages = get_option('pages');
        $policy = get_option('policy');
        $term = get_option('term');
        $faqs = get_option('faqs');
        $histories = BackupHistory::where('status', 1)->latest()->get();
        /* $user_types = UserType::where('status', 1)
            ->whereNotIn('name', ['Super Admin', 'superadmin'])
            ->select('id', 'name')
            ->latest()
            ->get(); */

        return view('author.web-setting.manage-pages', compact('logo', 'general', 'landings', 'app_download', 'footer', 'pages', 'policy', 'term', 'faqs', 'histories'/* , 'user_types' */));
    }

    /** Logo Setting */
    public function logoUpdate(Request $request)
    {
        $logo_setting = Option::where('key', 'logo')->first();

        if ($logo_setting) {
            $request->validate([
                'logo' => $request->filled('logo') ? 'required|image|mimes:jpeg,png,jpg,gif|max:1024' : '',
                'favicon' => $request->filled('favicon') ? 'required|image|mimes:jpeg,png,jpg,gif|max:1024' : '',
            ]);
            $logo_setting->update([
                'value' => [
                    'logo' => $request->hasFile('logo') ? imageUpload($request->file('logo'), 'websites', $logo_setting->value['logo'] ?? '') : $logo_setting->value['logo'] ?? null,
                    'favicon' => $request->hasFile('favicon') ? imageUpload($request->file('favicon'), 'websites', $logo_setting->value['favicon'] ?? '') : $logo_setting->value['favicon'] ?? null,
                ]
            ]);
        } else {
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
                'favicon' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);
            Option::create([
                'key' => 'logo',
                'value' => [
                    'logo' => $request->hasFile('logo') ? imageUpload($request->file('logo'), 'websites') : '',
                    'favicon' => $request->hasFile('favicon') ? imageUpload($request->file('favicon'), 'websites') : '',
                ]
            ]);
        }

        cache::forget('logo');

        return response()->json(__('Logo setting updated successfully.'));
    }

    /** General Setting */
    public function generalUpdate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'tagline' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string',
            'description' => 'required|string',
            'html' => 'nullable|string',
            'fb' => 'nullable|in:on',
            'twitter' => 'nullable|in:on',
            'youtube' => 'nullable|in:on',
            'instagram' => 'nullable|in:on',
        ]);

        Option::updateOrCreate(
            ['key' => 'general'],
            ['value' => $data]
        );
        cache::forget('general');

        return response()->json(__('General setting updated successfully.'));
    }

    /** Landing Page Setting Start */
    public function landingStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'btn_txt' => 'nullable|string',
            'btn_status' => 'nullable|in:on',
        ]);
        unset($data['image']); // Remove the 'image' field from the $data array
        Option::create([
            'key' => 'landing',
            'value' => $data + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'websites') : '',
                ]
        ]);
        cache::forget('landing');

        return response()->json([
            'message' => __('Landing page saved successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'landing'])
        ]);
    }

    public function landingUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'btn_txt' => 'nullable|string',
            'btn_status' => 'nullable|in:on',
        ]);
        unset($data['image']);
        $landing = Option::findOrFail($id);
        $landing->update([
            'value' => $data + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'websites', $landing->value['image']) : $landing->value['image'] ?? null,
                ]
        ]);
        cache::forget('landing');
        return response()->json([
            'message' => __('Landing page updated successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'landing'])
        ]);
    }

    public function landingDestroy($id)
    {
        $landing = Option::findOrFail($id);
        if (isset($landing->value['image'])) {
            uploadImageDelete($landing->value['image']);
        }
        $landing->delete();
        cache::forget('landing');

        return response()->json([
            'message' => __('Landing page deleted successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'landing'])
        ]);
    }

    public function landingStatus(Request $request, $id)
    {
        $landing = Option::findOrFail($id);
        $landing->update([
            'status' => $request->status
        ]);
        cache::forget('landing');
        return response()->json(['message' => 'Landing page']);
    }
    /** Landing Page Setting End */

    /** App Download */
    public function appDownloadUpdate(Request $request)
    {
        $data = $request->validate([
            'android_play_store' => 'nullable|url',
            'android_about_app' => 'nullable|string',
            'android_logo' => $request->filled('android_logo') ? 'required|image|mimes:jpeg,png,jpg,gif|max:1024' : '',
            'ios_store_url' => 'nullable|url',
            'ios_about_app' => 'nullable|string',
            'ios_logo' => $request->filled('ios_logo') ? 'required|image|mimes:jpeg,png,jpg,gif|max:1024' : '',
        ]);

        unset($data['android_logo'], $data['ios_logo']);
        $app_download = Option::where('key', 'app-download')->first();

        if ($app_download) {
            $app_download->update([
                'value' => $data + [
                        'android_logo' => $request->hasFile('android_logo') ? imageUpload($request->file('android_logo'), 'websites', $app_download->value['android_logo'] ?? null) : $app_download->value['android_logo'] ?? null,
                        'ios_logo' => $request->hasFile('ios_logo') ? imageUpload($request->file('ios_logo'), 'websites', $app_download->value['ios_logo'] ?? null) : $app_download->value['ios_logo'] ?? null,
                    ]
            ]);
        } else {
            $request->validate([
                'android_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
                'ios_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);
            Option::create([
                'key' => 'app-download',
                'value' => $data + [
                        'android_logo' => imageUpload($request->file('android_logo'), 'websites'),
                        'ios_logo' => imageUpload($request->file('ios_logo'), 'websites'),
                    ]
            ]);
        }

        cache::forget('app-download');

        return response()->json(__('App download updated successfully.'));
    }

    /** Footer Setting */
    public function footerUpdate(Request $request)
    {
        $data = $request->validate([
            'footer_text' => 'nullable|string',
            'email' => 'nullable|string',
            'social_link_value' => 'nullable|string',
            'social_link_status' => 'nullable|in:on',
            'address' => 'nullable|string',
        ]);

        Option::updateOrCreate(
            ['key' => 'footer'],
            ['value' => $data]
        );
        cache::forget('footer');

        return response()->json(__('Footer setting updated successfully.'));
    }

    /** Pages Start */
    public function pageStore(Request $request)
    {
        $data = $request->validate([
            'page_url' => 'required|url',
            'page' => 'required|string',
            'content_title' => 'required|string',
            'content' => 'required|string',
        ]);

        Option::create([
            'key' => 'pages',
            'value' => $data,
        ]);
        cache::forget('pages');

        return response()->json([
            'message' => __('Pages saved successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'pages'])
        ]);
    }

    public function pageUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'page_url' => 'required|url',
            'page' => 'required|string',
            'content_title' => 'required|string',
            'content' => 'required|string',
        ]);

        $page = Option::findOrFail($id);
        $page->update([
            'value' => $data,
        ]);
        cache::forget('pages');

        return response()->json([
            'message' => __('Pages updated successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'pages'])
        ]);
    }

    public function pageDestroy($id)
    {
        $page = Option::findOrFail($id);
        $page->delete();

        cache::forget('pages');

        return response()->json([
            'message' => __('Pages deleted successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'pages'])
        ]);
    }

    public function pageStatus(Request $request, $id)
    {
        $page = Option::findOrFail($id);
        $page->update([
            'status' => $request->status
        ]);
        cache::forget('pages');
        return response()->json(['message' => 'Pages']);
    }
    /** Pages End */

    /** Privacy Policy */
    public function policyUpdate(Request $request)
    {
        $data = $request->validate([
            'url' => 'nullable|url',
            'content' => 'nullable|string',

        ]);

        Option::updateOrCreate(
            ['key' => 'policy'],
            ['value' => $data]
        );
        cache::forget('policy');

        return response()->json(__('Privacy Policy updated successfully.'));
    }

    /** Term of Use */
    public function termUpdate(Request $request)
    {
        $data = $request->validate([
            'url' => 'nullable|url',
            'content' => 'nullable|string',

        ]);

        Option::updateOrCreate(
            ['key' => 'term'],
            ['value' => $data]
        );
        cache::forget('term');

        return response()->json(__('Term of use updated successfully.'));
    }

    /** Faqs Start */
    public function faqStore(Request $request)
    {
        $data = $request->validate([
            'url' => 'nullable|url',
            'question' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'answer' => 'required|string',
        ]);
        unset($data['image']); // Remove the 'image' field from the $data array

        Option::create([
            'key' => 'faqs',
            'value' => $data + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'websites') : '',
                ],
        ]);
        cache::forget('faqs');

        return response()->json([
            'message' => __('FAQs saved successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'faqs'])
        ]);
    }

    public function faqUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'url' => 'nullable|url',
            'question' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'answer' => 'required|string',
        ]);
        unset($data['image']);

        $faq = Option::findOrFail($id);
        $faq->update([
            'value' => $data + [
                    'image' => $request->hasFile('image') ? imageUpload($request->file('image'), 'websites', $faq->value['image']) : $faq->value['image'] ?? null,
                ]
        ]);
        cache::forget('faqs');

        return response()->json([
            'message' => __('FAQs updated successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'faqs'])
        ]);
    }

    public function faqDestroy($id)
    {
        $faq = Option::findOrFail($id);
        if (isset($faq->value['image'])) {
            uploadImageDelete($faq->value['image']);
        }
        $faq->delete();

        cache::forget('faqs');

        return response()->json([
            'message' => __('FAQs deleted successfully'),
            'redirect' => route('authorwebsites.index', ['tab' => 'faqs'])
        ]);
    }

    public function faqStatus(Request $request, $id)
    {
        $faq = Option::findOrFail($id);
        $faq->update([
            'status' => $request->status
        ]);
        cache::forget('faqs');
        return response()->json(['message' => 'FAQs']);
    }
    /** Pages End */

    /** Newsletter */

    public function sendEmail(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'message' => 'required|string',
            'announcement_show_website' => 'nullable|in:on',
            'receiver' => 'nullable|string',
            'send_user' => 'nullable|in:on',
            'subscriber_btn_show_website' => 'nullable|in:on',
        ]);

        if ($request->send_user){
            $receiver = User::where('user_type_id', '!=', 1)->select('email')->get();
        }else{
            $receiver = User::when($request->receiver !== 'all', function ($query) use ($request) {
                return $query->where('user_type_id', $request->receiver);
            }, function ($query) {
                return $query->where('user_type_id', '!=', 1);
            })->select('email')->get();
        }

        if ($receiver->isEmpty()) {
            return response()->json(__('No receivers found.'), 400);
        }
        $messageContent = $request->message;
        $category = $request->category;
        Mail::to($receiver)->queue(new SendEmail($messageContent, $category));

        return response()->json(__('Emails queued for sending.'));

    }

}
