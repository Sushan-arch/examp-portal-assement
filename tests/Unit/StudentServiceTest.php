<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Http\Services\StudentService;
use App\Http\Repositories\StudentRepository;
use Mockery;

class StudentServiceTest extends TestCase
{
    protected $studentService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance of StudentRepository
        $studentRepository = Mockery::mock(StudentRepository::class);
        $this->app->instance(StudentRepository::class, $studentRepository);

        // Create an instance of StudentService
        $this->studentService = new StudentService($studentRepository);
    }

    /**
     * tearDown
     *
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /** @test */
    public function it_gets_all_students_email()
    {
        // Mock data for student emails
        $studentEmails = ['student1@exam.com', 'student2@exam.com', 'student3@exam.com'];

        // Mock the return value of getStudentsEmail method in the repository
        $this->studentService->studentRepository
            ->shouldReceive('getStudentsEmail')
            ->once()
            ->andReturn($studentEmails);

        // Call the getAllStudentsEmail method
        $result = $this->studentService->getAllStudentsEmail();

        // Assert that the method returns the correct array of student emails
        $this->assertEquals($studentEmails, $result);
    }
}
