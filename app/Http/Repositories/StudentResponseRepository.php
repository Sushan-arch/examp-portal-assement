<?php

namespace App\Http\Repositories;

use App\Models\StudentResponse;

/**
 * StudentResponseRepository
 */
class StudentResponseRepository
{
    /**
     * StudentResponse
     *
     * @var StudentResponse
     */
    protected $studentResponse;

    /**
     * __construct
     *
     * @param StudentResponse $model
     */
    public function __construct(StudentResponse $model)
    {
        $this->studentResponse = $model;
    }

    /**
     * Create
     * @param  mixed $data
     */
    public function create(array $data)
    {
        return $this->studentResponse->create($data);
    }

    /**
     * Bulk Data Create
     * @param array $data
     */
    public function bulkInsert(array $data)
    {
        return $this->studentResponse->insert($data);
    }
}
