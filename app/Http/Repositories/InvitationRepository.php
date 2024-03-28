<?php

namespace App\Http\Repositories;

use App\Models\Invitation;

// Remove unnecessary inheritance from Controller
class InvitationRepository
{
    /**
     * @var Invitation
     */
    protected $invitationModel;

    /**
     * InvitationRepository constructor.
     *
     * @param Invitation $model The Invitation model for database interaction
     */
    public function __construct(Invitation $model)
    {
        $this->invitationModel = $model;
    }

    /**
     * Store a new invitation in the database.
     *
     * Creates a new Invitation record with the provided data.
     *
     * @param array $invitation An array containing invitation data (e.g., email, questionnaire ID)
     * @return Invitation The created Invitation model instance
     */
    public function storeInvitation(array $invitation): Invitation
    {
        return $this->invitationModel->create($invitation);
    }

    /**
     * Get an invitation and its associated questionnaire and questions by unique URL.
     *
     * Retrieves an Invitation record matching the provided unique URL (token),
     * eager loads the related Questionnaire model, and further eager loads the
     * questions belonging to that questionnaire.
     *
     * @param string $generatedUrl The (token) of the invitation
     * @return Invitation|null
     */
    public function getInvitationQuestionByUniqueUrl(string $generatedUrl): ?Invitation
    {
        return $this->invitationModel->where('token', $generatedUrl)
            ->with('questionnaire.questions')
            ->first();
    }
}
