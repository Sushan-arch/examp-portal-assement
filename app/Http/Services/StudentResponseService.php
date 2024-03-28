<?php

namespace App\Http\Services;

use App\Http\Repositories\StudentResponseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class StudentResponseService
{
    /**
     * StudentResponseRepository
     *
     * @var StudentResponseRepository
     */
    protected $studentResponseRepository;

    /**
     * QuestionService
     *
     * @var QuestionService
     */
    protected $questionService;

    /**
     * __construct
     *
     * @param  StudentResponseRepository $studentResponseRepository
     */
    public function __construct(StudentResponseRepository $studentResponseRepository, QuestionService $questionService)
    {
        $this->studentResponseRepository = $studentResponseRepository;
        $this->questionService = $questionService;
    }


    /**
     * Store student responses.
     *
     * @param array $answers
     * @param int $studentId
     */
    public function storeResponses(array $answers, int $studentId)
    {
        try {
            $data = collect(Arr::get($answers, 'answers'))->mapWithKeys(function ($response, $questionId) use ($studentId) {
                $question = $this->questionService->getQuestionById((int) $questionId);
                return [$questionId => [
                    'question_id' => $question->id,
                    'student_id' => $studentId,
                    'response' => $response,
                ]];
            })->filter()->toArray();
            return $this->studentResponseRepository->bulkInsert($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }
}
