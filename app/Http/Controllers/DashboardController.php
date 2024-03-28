<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Http\Services\QuestionnaireService;
use App\Http\Services\InvitationService;
use Inertia\Inertia;
use Inertia\Response;

/**
 * DashboardController
 *
 * This controller handles functionalities related to the dashboard.
 */
class DashboardController extends Controller
{
    /**
     * @var QuestionnaireService
     */
    protected $questionnaireService;

    /**
     * @var InvitationService
     */
    protected $invitationService;

    /**
     * DashboardController constructor.
     *
     * @param QuestionnaireService $questionnaireService Service for managing questionnaires
     * @param InvitationService $invitationService Service for sending invitations
     */
    public function __construct(
        QuestionnaireService $questionnaireService,
        InvitationService $invitationService
    ) {
        $this->questionnaireService = $questionnaireService;
        $this->invitationService = $invitationService;
    }

    /**
     * Display the Dashboard Page.
     *
     * Renders the "Dashboard" Inertia view with data on active questionnaires.
     *
     * @return Response
     */
    public function dashboard(): Response
    {
        return Inertia::render('Dashboard', [
            'activeQuestionnaries' => $this->questionnaireService->getActiveQuestionnaries()
        ]);
    }

    /**
     * Send invitations to participants for a questionnaire.
     *
     * Processes an InvitationRequest, retrieves the questionnaire ID,
     * and delegates invitation sending to the InvitationService.
     *
     * @param InvitationRequest $invitationRequest Validated request data for invitations
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure
     */
    public function sendInvitations(InvitationRequest $invitationRequest)
    {
        try {
            $questionnaireId = (int) $invitationRequest->questionnaireId;
            $this->invitationService->sendInvitations($questionnaireId);
            return response()->json(['message' => 'Invitations sent successfully']);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }
}
