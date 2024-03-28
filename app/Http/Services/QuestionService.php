<?php

namespace App\Http\Services;

use App\Http\Repositories\QuestionRepository;

/**
 * QuestionService
 */
class QuestionService
{
    /**
     * questionRepository
     *
     * @var mixed
     */
    public $questionRepository;

    /**
     * __construct
     * @param  mixed $repository
     */
    public function __construct(QuestionRepository $repository)
    {
        $this->questionRepository = $repository;
    }

    /**
     * generateRandomQuestion
     */
    public function generateRandomQuestion(): array
    {
        return [
            'chemistry' => $this->questionRepository->getRandomQuestionsBySubject('chemistry'),
            'physics' => $this->questionRepository->getRandomQuestionsBySubject('physics')
        ];
    }

    /**
     * getQuestionById
     *
     * @param  int $id
     */
    public function getQuestionById(int $id)
    {
        return $this->questionRepository->getQuestionById($id);
    }

    /**
     * getQuestionByIds
     *
     * @param  array $ids
     */
    public function getQuestionByIds(array $ids)
    {
        return $this->questionRepository->getQuestionByIds($ids);
    }
}
