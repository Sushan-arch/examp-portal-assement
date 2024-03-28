<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentResponseRequest;
use App\Http\Services\StudentResponseService;

/**
 * StudentResponseController
 *
 * This controller handles functionalities related to student responses for questionnaires.
 */
class StudentResponseController extends Controller
{
    /**
     * @var StudentResponseService
     */
    protected $studentResponseService;

    /**
     * StudentResponseController constructor.
     *
     * @param StudentResponseService $studentResponseService Service for managing student responses
     */
    public function __construct(StudentResponseService $studentResponseService)
    {
        $this->studentResponseService = $studentResponseService;
    }

    /**
     * Store student responses for a questionnaire.
     *
     * Processes a validated StudentResponseRequest, extracts the validated data,
     * and delegates response storage to the StudentResponseService. Returns a JSON
     * response indicating success and an HTTP status code of 200 (OK).
     *
     * **Note:** The request contains all necessary data. If the
     * controller interacts with the InvitationService to retrieve additional
     * information, update the description accordingly.
     *
     * @param StudentResponseRequest $request Validated request data with student responses
     * @return \Illuminate\Http\JsonResponse JSON response with success message
     */
    public function storeStudentResponse(StudentResponseRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->studentResponseService->storeResponses($request->validated(), 2); // Adjust second parameter as needed
        return response()->json(['message' => 'Response submitted successfully'], 200);
    }
}
