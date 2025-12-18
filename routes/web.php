<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [ServiceController::class, 'UserIndex'])->name('home');
Route::get('/services', [ServiceController::class, 'serviceIndex'])->name('user.services.index');
Route::get('/service/{slug}', [ServiceController::class, 'Usershow'])->name('user.service.show');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('service.show');

Route::get('/search-services', [ServiceController::class, 'search']);
Route::post('/save-inquiry', [ServiceController::class, 'saveInquiry']);
Route::get('/get-service-questions', [ServiceController::class, 'getQuestions']);

// AI Chat Route (if needed)
Route::post('/ai-chat', [App\Http\Controllers\AIChatController::class, 'chat'])->name('ai.chat');

// Subscribe Route
Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');

// Projects Routes
Route::get('/projects', [ProjectController::class, 'userIndex'])->name('user.projects');
Route::get('/project/{slug}', [ProjectController::class, 'show'])->name('user.project.show');

// Pricing Route
Route::get('/pricing', [ServiceController::class, 'pricing'])->name('user.pricing');

// Payment Routes
Route::post('/payment/create', [App\Http\Controllers\PaymentController::class, 'createOrder'])->name('payment.create');
Route::post('/payment/verify', [App\Http\Controllers\PaymentController::class, 'verifyPayment'])->name('payment.verify');
Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');

// Blog Routes
Route::get('/blog', [BlogController::class, 'userIndex'])->name('user.blogs');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('user.blog.show');
Route::get('/blog/category/{category}', [BlogController::class, 'byCategory'])->name('user.blog.category');

// About Page
Route::get('/about', function () {
    return view('user.about.index');
})->name('user.about');

// Contact Routes
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/thanks', [App\Http\Controllers\ContactController::class, 'thanks'])->name('contact.thanks');

// Admin Login Routes
Route::get('admin/login', [AdminAuthController::class, 'loginPage'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);

// Protected Admin Routes
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    
    // Dashboard & Logout
    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Services Management
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('services/store', [ServiceController::class, 'store'])->name('services.store');
    Route::get('services/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('services/update/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::get('services/delete/{id}', [ServiceController::class, 'destroy'])->name('services.delete');

    // Service Questions Management
    Route::get('service-questions/{id}', [ServiceController::class, 'questionsPage'])->name('services.questionsPage');
    Route::post('service-questions/add', [ServiceController::class, 'addQuestion'])->name('services.questions.add');
    Route::put('service-questions/update/{id}', [ServiceController::class, 'updateQuestion'])->name('services.questions.update');
    Route::get('service-questions/delete/{id}', [ServiceController::class, 'deleteQuestion'])->name('services.questions.delete');

    // Service Inquiries Management
    Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{id}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::put('inquiries/update-status/{id}', [InquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');
    Route::get('inquiries/delete/{id}', [InquiryController::class, 'destroy'])->name('inquiries.delete');

    // Projects Management
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('projects/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('projects/delete/{id}', [ProjectController::class, 'destroy'])->name('projects.delete');

    // Blogs Management
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('blogs/store', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('blogs/update/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::get('blogs/delete/{id}', [BlogController::class, 'destroy'])->name('blogs.delete');

    // Subscribers Management
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('subscribers/delete/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.delete');
    Route::get('subscribers/toggle/{id}', [SubscriberController::class, 'toggleStatus'])->name('subscribers.toggle');
    Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
    Route::get('subscribers/newsletter', [SubscriberController::class, 'newsletterForm'])->name('subscribers.newsletter');
    Route::post('subscribers/newsletter/send', [SubscriberController::class, 'sendNewsletter'])->name('subscribers.newsletter.send');

    // Payments Management
    Route::get('payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/export', [App\Http\Controllers\PaymentController::class, 'export'])->name('admin.payments.export');
    Route::get('payments/{id}', [App\Http\Controllers\PaymentController::class, 'show'])->name('admin.payments.show');

    // Admin Management
    Route::get('admins', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.admins.index');
    Route::get('admins/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('admins/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.admins.store');
    Route::get('admins/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('admins/update/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.admins.update');
    Route::get('admins/delete/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.admins.delete');
    Route::get('admins/toggle/{id}', [App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('admin.admins.toggle');

    // Profile Management
    Route::get('profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
    Route::put('profile/update', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // Contacts Management
    Route::get('contacts', [App\Http\Controllers\ContactController::class, 'adminIndex'])->name('admin.contacts.index');
    Route::get('contacts/{id}', [App\Http\Controllers\ContactController::class, 'show'])->name('admin.contacts.show');
    Route::put('contacts/status/{id}', [App\Http\Controllers\ContactController::class, 'updateStatus'])->name('admin.contacts.updateStatus');
    Route::get('contacts/delete/{id}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('admin.contacts.delete');
});