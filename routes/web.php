<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentResponseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Pages/Auth/Login', [
        'canLogin' => Route::has('login'),
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/generate/questionnaire', [QuestionnaireController::class, 'generate'])->name('submit.questionnaire');
Route::post('/send/{questionnaireId}/invitations', [DashboardController::class, 'sendInvitations'])->name('send.invitation');
Route::get('/response/{questionnaire}/questionnaire', [StudentController::class, 'showInvitedQuestionnaire'])->name('student.questionnaire.show');
Route::post('/response/questionnaire/submit', [StudentResponseController::class, 'storeStudentResponse'])->name('questionnaire.submit');

require __DIR__ . '/auth.php';
