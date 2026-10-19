<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author as AUTHOR;

    Route::get('locale/{locale}', function ($locale) {
        session()->put('locale', $locale);
        return redirect()->back();
    });
    Route::get('locale/{locale}', [AUTHOR\LocaleBaariController::class, 'setLocale'])->name('locale');
//Route::group( [ /*'as' => 'author.', 'prefix' => 'author',   'middleware' => ['auth'] */ ], function () {
    Route::get('/', [AUTHOR\DashboardController::class, 'index'])->name('dashboard.index')->middleware('permission:dashboard-read');
    Route::get('/get-dashboard', [AUTHOR\DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/yearly-generates', [AUTHOR\DashboardController::class, 'yearlyGenerates'])->name('dashboard.generates');
    Route::get('/users-overview', [AUTHOR\DashboardController::class, 'userOverview'])->name('dashboard.user-overview');

    //Subscription Plans
    Route::resource('plans', AUTHOR\BaariPlanController::class)->except('show')->middleware([
        'create' => 'permission:plans-create',
       'store' => 'permission:plans-create',
        'index' => 'permission:plans-read',
        'edit' => 'permission:plans-update',
        'update' => 'permission:plans-update',
        'destroy' => 'permission:plans-delete',
    ]);

    Route::post('plans/filter', [AUTHOR\BaariPlanController::class, 'BaariFilter'])->name('plans.filter');
    Route::post('plans/status/{id}', [AUTHOR\BaariPlanController::class,'status'])->name('plans.status');
    Route::post('plans/delete-all', [AUTHOR\BaariPlanController::class,'deleteAll'])->name('plans.delete-all');

    Route::resource('plan-settings', AUTHOR\BaariPlanSettingController::class)->only('index', 'store', 'destroy');

     // Feedback
     Route::resource('feedbacks',AUTHOR\BaariFeedbackController::class)->except('create');
     Route::post('feedbacks/status/{id}',[AUTHOR\BaariFeedbackController::class,'status'])->name('feedbacks.status');
     Route::post('feedbacks/filter', [AUTHOR\BaariFeedbackController::class, 'baariFilter'])->name('feedbacks.baariFilter');
     Route::post('feedbacks/reply/{id}',[AUTHOR\BaariFeedbackController::class,'reply'])->name('feedbacks.reply');
     // Tasks
     Route::resource('tasks',AUTHOR\BaariTaskController::class);
     Route::post('tasks/status/{id}',[AUTHOR\BaariTaskController::class,'status'])->name('tasks.status');
     Route::post('tasks/filter', [AUTHOR\BaariTaskController::class,'baariFilter'])->name('tasks.baariFilter');
     Route::post('tasks/delete-all', [AUTHOR\BaariTaskController::class,'deleteAll'])->name('tasks.delete-all');
     Route::post('tasks/is_status/{id}',[AUTHOR\BaariTaskController::class,'isStatus'])->name('tasks.is-status');

    // Business
    Route::resource('business',AUTHOR\BaariBusinessController::class);
    Route::post('business/filter', [AUTHOR\BaariBusinessController::class, 'BaariFilter'])->name('business.filter');
    Route::post('business/status/{id}',[AUTHOR\BaariBusinessController::class,'status'])->name('business.status');
    Route::post('business/delete-all', [AUTHOR\BaariBusinessController::class,'deleteAll'])->name('business.delete-all');
    // Shop/Business Categories
    Route::resource('business-categories',AUTHOR\BaariBusinessCategoryController::class)->except('show');
    Route::post('business-categories/status/{id}',[AUTHOR\BaariBusinessCategoryController::class,'status'])->name('business-categories.status');
    Route::post('business-categories/delete-all', [AUTHOR\BaariBusinessCategoryController::class,'deleteAll'])->name('business-categories.delete-all');
    //Payment Settings
    Route::resource('payment-types',AUTHOR\BaariPaymentTypeController::class)->except('create', 'edit', 'show')->middleware([
        'create' => 'permission:payment-types-create',
        'store' => 'permission:payment-types-create',
        'index' => 'permission:payment-types-read',
        'update' => 'permission:payment-types-update',
        'destroy' => 'permission:payment-types-delete',]);
    Route::post('payment-types/status/{id}',[AUTHOR\BaariPaymentTypeController::class,'status'])->name('payment-types.status');
    Route::post('payment-types/delete-all', [AUTHOR\BaariPaymentTypeController::class,'deleteAll'])->name('payment-types.delete-all')->middleware('permission:payment-type-delete');
    // Faqs
    Route::resource('faqs',AUTHOR\BaariFaqController::class)->middleware([
        'create' => 'permission:faqs-create',
        'store' => 'permission:faqs-create',
        'index' => 'permission:faqs-read',
        'update' => 'permission:faqs-update',
        'destroy' => 'permission:faqs-delete',]);
    Route::post('faqs/status/{id}',[AUTHOR\BaariFaqController::class,'status'])->name('faqs.status');
    Route::post('faqs/delete-all', [AUTHOR\BaariFaqController::class,'deleteAll'])->name('faqs.delete-all')->middleware('permission:faqs-delete');
    // Tutorial
    Route::resource('tutorials',AUTHOR\BaariTutorialController::class);
    Route::post('tutorials/status/{id}',[AUTHOR\BaariTutorialController::class,'status'])->name('tutorials.status');
    Route::post('tutorials/delete-all', [AUTHOR\BaariTutorialController::class,'deleteAll'])->name('tutorials.delete-all');
    // Terms & Conditions
    Route::get('/terms',[AUTHOR\BaariTermController::class,'index'])->name('terms.index')->middleware('permission:terms-read');
    Route::put('/terms-update',[AUTHOR\BaariTermController::class,'update'])->name('terms.update')->middleware('permission:terms-update');
    // About Us
    Route::get('/about',[AUTHOR\BaariAboutController::class,'index'])->name('about.index')->middleware('permission:about-us-read');
    Route::put('/about-update',[AUTHOR\BaariAboutController::class,'update'])->name('about.update')->middleware('permission:about-us-update');

    Route::resource('business-reports',AUTHOR\BaariBusinessReportController::class)->except('create');

    Route::resource('profiles', AUTHOR\ProfileController::class)->only('index', 'update');

    // Roles & Permissions
    Route::resource('roles', AUTHOR\RoleController::class)->except('show');
    Route::resource('permissions', AUTHOR\PermissionController::class)->except('show', 'create', 'edit');

    // General Setting
    Route::resource('settings', AUTHOR\SettingController::class)->only('index', 'update');

    // System Settings
    Route::resource('system-settings', AUTHOR\SystemSettingController::class)->only('index', 'store')->middleware([
        'index' => 'permission:system-settings-read',
        'update' => 'permission:system-settings-update',
    ]);
    // Language Settings
    Route::resource('languages', AUTHOR\BaariLanguageController::class)->middleware([
        'index' => 'permission:settings-read',
        'update' => 'permission:settings-update',
    ]);
    Route::post('languages/status/{id}',[AUTHOR\BaariLanguageController::class,'status'])->name('languages.status');
    Route::post('languages/delete-all', [AUTHOR\BaariLanguageController::class,'deleteAll'])->name('languages.delete-all');
    Route::post('languages/default/{id}',[AUTHOR\BaariLanguageController::class,'default'])->name('languages.default');


    //Notifications manager
    Route::prefix('notifications')->controller(AUTHOR\NotificationController::class)->name('notifications.')->group(function () {
        Route::get('/', 'mtIndex')->name('index')->middleware('permission:notifications-read');
        Route::post('/filter', 'BaariFilter')->name('filter');
        Route::get('/{id}', 'mtView')->name('mtView');
        Route::get('view/all/', 'mtReadAll')->name('mtReadAll');

    });

    // Testimonial
    Route::resource('testimonials',AUTHOR\BaariTestimonialController::class);
    Route::post('testimonials/status/{id}',[AUTHOR\BaariTestimonialController::class,'status'])->name('testimonials.status');
    Route::post('testimonials/delete-all', [AUTHOR\BaariTestimonialController::class, 'deleteAll'])->name('testimonials.delete-all');
    Route::post('testimonials/filter', [AUTHOR\BaariTestimonialController::class, 'baariFilter'])->name('testimonials.filter');


    // Privacy Policy
    Route::resource('privacy-policy', AUTHOR\BaariPrivacyPolicyController::class)->only('index', 'store');

    // Blog Controller
    Route::resource('blogs', AUTHOR\BaariBlogController::class);
    Route::post('blogs/status/{id}', [AUTHOR\BaariBlogController::class,'status'])->name('blogs.status');
    Route::post('blogs/delete-all', [AUTHOR\BaariBlogController::class, 'deleteAll'])->name('blogs.delete-all');
    Route::get('blogs/comments/{id}', [AUTHOR\BaariBlogController::class, 'filterComment'])->name('blogs.filter.comment');
    Route::post('blogs/filter', [AUTHOR\BaariBlogController::class, 'baariFilter'])->name('blogs.baariFilter');

    //Comment Controller
    Route::resource('comments', AUTHOR\BaariCommentController::class);
    Route::post('comments/delete-all', [AUTHOR\BaariCommentController::class, 'deleteAll'])->name('comments.delete-all');

     // Features
     Route::resource('features',AUTHOR\BaariFeatureController::class);
     Route::post('features/status/{id}', [AUTHOR\BaariFeatureController::class,'status'])->name('features.status');
     Route::post('features/delete-all', [AUTHOR\BaariFeatureController::class, 'deleteAll'])->name('features.delete-all');
     Route::post('features/filter', [AUTHOR\BaariFeatureController::class, 'baariFilter'])->name('features.baariFilter');


        //AUTHOR Design
        Route::resource('designs',AUTHOR\BaariDesignController::class);
        Route::post('designs/status/{id}',[AUTHOR\BaaridesignController::class,'status'])->name('designs.status');
        Route::post('designs/delete-all',[AUTHOR\BaariDesignController::class,'deleteAll'])->name('designs.deleteAll');

        // Interface
        Route::resource('interfaces',AUTHOR\BaariInterfaceController::class);
        Route::put('AUTHOR/interfaces/{interface}', [AUTHOR\BaariInterfaceController::class, 'update'])->name('interfaces.update');
        Route::post('interfaces/status/{id}', [AUTHOR\BaariInterfaceController::class,'status'])->name('interfaces.status');
        Route::post('interfaces/delete-all', [AUTHOR\BaariInterfaceController::class, 'deleteAll'])->name('interfaces.delete-all');


    // Message
    Route::resource('messages', AUTHOR\BaariMessageController::class)->only('index', 'destroy');
    Route::post('messages/delete-all', [AUTHOR\BaariMessageController::class,'deleteAll'])->name('messages.delete-all');
    Route::post('messages/filter', [AUTHOR\BaariMessageController::class, 'baariFilter'])->name('messages.baariFilter');

    Route::resource('plan-features', AUTHOR\BaariPlanFeatureController::class);
    Route::post('plan-features/status/{id}', [AUTHOR\BaariPlanFeatureController::class, 'status'])->name('plan.features.status');
    Route::post('plan-features/delete-all', [AUTHOR\BaariPlanFeatureController::class, 'deleteAll'])->name('plan.features.deleteAll');
    Route::post('plan-features/filter', [AUTHOR\BaariPlanFeatureController::class, 'baariFilter'])->name('plan-features.baariFilter');

// Website settings
Route::resource('website-settings',AUTHOR\BaariWebSettingController::class);
 //Customize Setting
 Route::resource('customize-settings', AUTHOR\CustomizeSettingController::class)->only('index', 'update');
 //Currencies
 Route::resource('currencies', AUTHOR\BaariCurrencyController::class)->except('show', 'destroy');
 Route::post('currencies/status/{id}', [AUTHOR\BaariCurrencyController::class,'status'])->name('currencies.status');
 Route::post('currencies/filter', [AUTHOR\BaariCurrencyController::class, 'baariFilter'])->name('currencies.baariFilter');
 Route::match(['get', 'post'], 'currencies/default/{id}', [AUTHOR\BaariCurrencyController::class, 'default'])->name('currencies.default');
  //Countries
  Route::resource('countries', AUTHOR\BaariCountryController::class)->except('show', 'create');


 Route::resource('notices',AUTHOR\BaariNoticeController::class)->except('show');
 Route::post('notices/status/{id}',[AUTHOR\BaariNoticeController::class,'status'])->name('notices.status');
 Route::post('notices/delete-all', [AUTHOR\BaariNoticeController::class,'deleteAll'])->name('notices.delete-all');
 Route::post('notices/filter', [AUTHOR\BaariNoticeController::class, 'baariFilter'])->name('notices.baariFilter');

 //status publish unpublish
 Route::get('/publish/status',[AUTHOR\BaariAjaxController::class,'bariPublishStatus'])->name('publish.status');


//});
