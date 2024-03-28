<?php

namespace App\Http\Controllers;

use App\Http\Services\InvitationService;
use Inertia\Inertia;

/**
 * StudentController
 */
class StudentController extends Controller
{
    /**
     * invitationService
     *
     * @var InvitationService
     */
    protected $invitationService;

    /**
     * studentResponseService
     *
     * @var mixed
     */
    protected $studentResponseService;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    /**
     * ShowInvitedQuestionnaire
     *
     * @param  mixed $questionnaire
     */
    public function showInvitedQuestionnaire(string $questionnaire)
    {
        return Inertia::render('StudentAnswer', [
            'invitation' => $this->invitationService->getInvitationByUrl($questionnaire)
        ]);
    }
}
