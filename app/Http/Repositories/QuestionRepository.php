<?php

namespace App\Http\Repositories;

use App\Models\Question;

/**
 * QuestionRepository
 */
class QuestionRepository
{
    /**
     * questionModel
     *
     * @var Question
     */
    protected $questionModel;

    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct(Question $model)
    {
        $this->questionModel = $model;
    }

    /**
     * getRandomQuestionsBySubject
     *
     * @param  string $subject
     * @param  int $limit
     */
    public function getRandomQuestionsBySubject(string $subject, int $limit = 5)
    {
        return $this->questionModel->where('subject', $subject)->inRandomOrder()->limit($limit)->get();
    }

    /**
     * getQuestionById
     *
     * @param  int $id
     */
    public function getQuestionById(int $id)
    {
        return $this->questionModel->find($id);
    }

    /**
     * getQuestionByIds
     *
     * @param array $ids
     */
    public function getQuestionByIds(array $ids)
    {
        return $this->questionModel->whereIn('id', $ids)->get();
    }
}
