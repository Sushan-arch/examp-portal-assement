<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionnaireRequest;
use App\Http\Services\QuestionnaireService;
use Illuminate\Http\JsonResponse;

/**
 * QuestionnaireController
 *
 * This controller handles functionalities related to questionnaires, including generation.
 */
class QuestionnaireController extends Controller
{
    /**
     * @var QuestionnaireService
     */
    protected $questionnaireService; // Use protected for better encapsulation

    /**
     * QuestionnaireController constructor.
     *
     * @param QuestionnaireService $questionnaireService Service for managing questionnaires
     */
    public function __construct(QuestionnaireService $questionnaireService)
    {
        $this->questionnaireService = $questionnaireService;
    }

    /**
     * Generate a new questionnaire.
     *
     * Processes a validated QuestionnaireRequest, extracts the data as an array,
     * and delegates questionnaire generation and storage to the QuestionnaireService.
     * Returns a JSON response indicating success and an HTTP status code of 200 (OK).
     *
     * @param QuestionnaireRequest $request Validated request data for questionnaire generation
     * @return JsonResponse JSON response with success message
     */
    public function generate(QuestionnaireRequest $request): JsonResponse
    {
        $this->questionnaireService->generateAndStoreQuestionnaire((array) $request->all());
        return response()->json(['message' => 'Questionnaire generated successfully'], 200);
    }
}
