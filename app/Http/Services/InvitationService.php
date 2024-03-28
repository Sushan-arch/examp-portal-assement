<?php

namespace App\Http\Services;

use App\Http\Repositories\InvitationRepository;
use App\Http\Services\MailService;
use App\Http\Services\QuestionnaireService;
use App\Jobs\StoreInvitationJob;
use App\Models\Invitation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * InvitationService
 */
class InvitationService
{
    /**
     * @var QuestionnaireService
     */
    protected $questionnaireService;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var StudentService
     */
    protected $studentService;

    /**
     * @var InvitationRepository
     */
    protected $invitationRepository;

    /**
     * InvitationService constructor.
     *
     * @param  InvitationRepository  $invitationRepository
     * @param  QuestionnaireService  $questionnaireService
     * @param  MailService  $mailService
     * @param  StudentService  $studentService
     */
    public function __construct(
        InvitationRepository $invitationRepository,
        QuestionnaireService $questionnaireService,
        MailService $mailService,
        StudentService $studentService
    ) {
        $this->invitationRepository = $invitationRepository;
        $this->questionnaireService = $questionnaireService;
        $this->mailService = $mailService;
        $this->studentService = $studentService;
    }

    /**
     * Store an invitation.
     *
     * @param  array  $invitation
     */
    public function storeInvitation(array $invitation): Invitation
    {
        return $this->invitationRepository->storeInvitation($invitation);
    }

    /**
     * Queue an invitation before storing.
     *
     * @param  array  $invitation
     * @return mixed
     */
    public function queueInvitationBeforeStoring(array $invitation)
    {
        try {
            return StoreInvitationJob::dispatch($this, [
                'questionnaire_id' => $invitation['questionnaire_id'],
                'user_id' => $invitation['user_id'],
                'token' => $invitation['token']
            ])->onQueue('default');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Generate a unique URL
     */
    protected function generateUniqueUrl(): string
    {
        return Str::uuid()->toString();
    }

    /**
     * Send invitations for a questionnaire.
     * @param  int  $questionnaireId
     */
    public function sendInvitations(int $questionnaireId)
    {
        try {
            $questionnaire = $this->questionnaireService->getQuestionnaireById($questionnaireId);
            $studentEmails = $this->studentService->getAllStudentsEmail();
            foreach ($studentEmails as $student) {
                $url = $this->generateUniqueUrl();
                $this->queueInvitationBeforeStoring([
                    'questionnaire_id' => $questionnaire->id,
                    'user_id' => $student->id,
                    'token' =>  $url
                ]);
                $this->mailService->sendInvitationEmail([
                    'email' => $student->email,
                    'questionnaire' => $questionnaire,
                    'generatedUrl' => route('student.questionnaire.show', ['questionnaire' => $url]),
                    'studentName' => $student->name,
                ]);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Get an invitation by URL.
     * @param  string  $url
     */
    public function getInvitationByUrl(string $url): Invitation
    {
        return $this->invitationRepository->getInvitationQuestionByUniqueUrl($url);
    }
}
