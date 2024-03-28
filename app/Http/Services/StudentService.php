<?php

namespace App\Http\Services;

use App\Http\Repositories\studentRepository;

class StudentService
{
    /**
     * StudentRepository
     *
     * @var StudentRepository
     */
    public $studentRepository;

    /**
     * __construct
     *
     * @param  StudentRepository $repository
     */
    public function __construct(StudentRepository $repository)
    {
        $this->studentRepository = $repository;
    }

    /**
     * getAllStudentsEmail
     */
    public function getAllStudentsEmail()
    {
        return $this->studentRepository->getStudentsEmail();
    }
}
