<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Http\Services\QuestionService;
use App\Http\Repositories\QuestionRepository;
use Mockery;

class QuestionServiceTest extends TestCase
{
    /**
     * questionService
     *
     * @var mixed
     */
    protected $questionService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance of QuestionRepository
        $questionRepository = Mockery::mock(QuestionRepository::class);
        $this->app->instance(QuestionRepository::class, $questionRepository);
        // Create an instance of QuestionService
        $this->questionService = new QuestionService($questionRepository);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /** @test */
    public function it_generates_random_questions_by_subject()
    {
        // Mock data for the random questions
        $randomQuestions = [
            'Question 1',
            'Question 2',
            'Question 3',
            'Question 4',
            'Question 5',
        ];

        // Mock the return value of getRandomQuestionsBySubject method in the repository
        $this->questionService->questionRepository
            ->shouldReceive('getRandomQuestionsBySubject')
            ->once()
            ->with('chemistry')
            ->andReturn($randomQuestions);

        $this->questionService->questionRepository
            ->shouldReceive('getRandomQuestionsBySubject')
            ->once()
            ->with('physics')
            ->andReturn($randomQuestions);

        // Call the generateRandomQuestion method
        $result = $this->questionService->generateRandomQuestion();

        // Assert that the method returns an array containing random questions for chemistry and physics
        $this->assertIsArray($result);
        $this->assertArrayHasKey('chemistry', $result);
        $this->assertArrayHasKey('physics', $result);
        $this->assertCount(count($randomQuestions), $result['chemistry']);
        $this->assertCount(count($randomQuestions), $result['physics']);
    }
}
