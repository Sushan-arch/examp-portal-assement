<?php

namespace App\Http\Services;

use App\Http\Repositories\QuestionnaireRepository;
use App\Http\Services\QuestionService;
use App\Models\Questionnaire;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * QuestionnaireService
 */
class QuestionnaireService
{
    /**
     * @var QuestionnaireRepository
     */
    protected $questionnaireRepository;

    /**
     * @var QuestionService
     */
    protected $questionService;

    /**
     * QuestionnaireService constructor.
     *
     * @param  QuestionnaireRepository  $repository
     * @param  QuestionService  $questionService
     */
    public function __construct(QuestionnaireRepository $repository, QuestionService $questionService)
    {
        $this->questionnaireRepository = $repository;
        $this->questionService = $questionService;
    }

    /**
     * Generate and save a questionnaire.
     *
     * @param array $questionnaire
     */
    public function generateAndStoreQuestionnaire(array $questionnaire)
    {
        try {
            $generatedQuestionnaire = $this->questionService->generateRandomQuestion();
            $newQuestionnaire = $this->questionnaireRepository->storeQuestionnaire([
                'title' => $questionnaire['title'],
                'expiry_date' => $questionnaire['expiryDate'],
            ]);

            $newQuestionnaire->questions()->attach($generatedQuestionnaire['chemistry']);
            $newQuestionnaire->questions()->attach($generatedQuestionnaire['physics']);

            return $newQuestionnaire;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }

    /**
     * Get active questionnaires.
     *
     * @return Collection
     */
    public function getActiveQuestionnaries(): Collection
    {
        return $this->questionnaireRepository->getActiveQuestionnaries();
    }

    /**
     * Get questionnaire by ID.
     * @param  int $id
     */
    public function getQuestionnaireById(int $id): Questionnaire
    {
        return $this->questionnaireRepository->findQuestionnaireById($id);
    }
}
