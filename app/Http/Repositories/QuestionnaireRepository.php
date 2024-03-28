<?php

namespace App\Http\Repositories;

use App\Models\Questionnaire;
use Illuminate\Support\Collection;

/**
 * QuestionnaireRepository
 *
 * This repository handles questionnaire data access.
 */
class QuestionnaireRepository
{
    /**
     * @var Questionnaire
     */
    protected $questionnaire;

    public function __construct(Questionnaire $model)
    {
        $this->questionnaire = $model;
    }

    /**
     * Stores a new questionnaire.
     *
     * @param array $questionnaire
     * @return Questionnaire
     */
    public function storeQuestionnaire(array $questionnaire): Questionnaire
    {
        return $this->questionnaire->create($questionnaire);
    }

    /**
     * Gets active questionnaires with eager-loaded questions.
     * @return Collection 
     */
    public function getActiveQuestionnaries(): Collection
    {
        return $this->questionnaire->active()->with('questions')->get();
    }

    /**
     * Finds a questionnaire by its ID.
     *
     * @param int $id
     * @return Questionnaire|null
     */
    public function findQuestionnaireById(int $id): Questionnaire
    {
        return $this->questionnaire->find($id);
    }
}
