<?php

namespace App\Http\Repositories;

use App\Models\Student;

/**
 * StudentRepository
 */
class StudentRepository
{
    /**
     * studentModel
     *
     * @var Student
     */
    protected $studentModel;

    /**
     * __construct
     *
     * @param  Student $model
     * @return void
     */
    public function __construct(Student $model)
    {
        $this->studentModel = $model;
    }

    /**
     * getStudentsEmail
     */
    public function getStudentsEmail()
    {
        return $this->studentModel->select('id', 'name', 'email')->get();
    }
}
