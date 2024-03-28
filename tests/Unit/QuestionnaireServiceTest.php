<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Http\Services\QuestionnaireService;
use App\Http\Repositories\QuestionnaireRepository;
use App\Http\Services\QuestionService;
use Mockery;
use App\Models\Questionnaire;
use Illuminate\Support\Collection;

class QuestionnaireServiceTest extends TestCase
{
    protected $questionnaireService;
    protected $questionnaireRepository;
    protected $questionService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mock instances of repositories and services
        $this->questionnaireRepository = Mockery::mock(QuestionnaireRepository::class);
        $this->questionService = Mockery::mock(QuestionService::class);

        // Create an instance of QuestionnaireService with mocked dependencies
        $this->questionnaireService = new QuestionnaireService($this->questionnaireRepository, $this->questionService);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /** @test */
    public function it_generates_and_stores_questionnaire()
    {
        // Mock data for a sample questionnaire
        $questionnaire = [
            'title' => 'Sample Questionnaire',
            'expiryDate' => '2024-12-31',
        ];

        // Mock data for generated random questions
        $generatedQuestionnaire = [
            'chemistry' => [/* mock chemistry questions */],
            'physics' => [/* mock physics questions */],
        ];

        // Expectations
        $this->questionService
            ->shouldReceive('generateRandomQuestion')
            ->once()
            ->andReturn($generatedQuestionnaire);

        // Mock the created questionnaire model
        $newQuestionnaire = new Questionnaire();
        $newQuestionnaire->id = 1; // Set the ID
        $this->questionnaireRepository
            ->shouldReceive('storeQuestionnaire')
            ->once()
            ->with([
                'title' => $questionnaire['title'],
                'expiry_date' => $questionnaire['expiryDate'],
            ])
            ->andReturn($newQuestionnaire); // Return the created questionnaire model

        // Call the method under test
        $createdQuestionnaire = $this->questionnaireService->generateAndStoreQuestionnaire($questionnaire);

        // Assert that the method returns a questionnaire instance
        $this->assertInstanceOf(Questionnaire::class, $createdQuestionnaire);
        // Assert that the questionnaire ID is set
        $this->assertEquals(1, $createdQuestionnaire->id);
    }


    /** @test */
    public function it_gets_active_questionnaires()
    {
        // Mock data for active questionnaires
        $activeQuestionnaires = new Collection([/* mock active questionnaires data */]);

        // Mock the behavior of the QuestionnaireRepository's getActiveQuestionnaries method
        $this->questionnaireRepository
            ->shouldReceive('getActiveQuestionnaries')
            ->once()
            ->andReturn($activeQuestionnaires);

        // Perform the test by calling the method under test
        $result = $this->questionnaireService->getActiveQuestionnaries();

        // Assert that the method returns a Collection instance
        $this->assertInstanceOf(Collection::class, $result);
        // Assert that the returned collection contains the expected data
        $this->assertEquals($activeQuestionnaires, $result);
    }

    /** @test */
    public function it_gets_questionnaire_by_id()
    {
        // Mock data for a sample questionnaire
        $questionnaireId = 1;
        $questionnaire = new Questionnaire(); // Create a mock questionnaire model
        // Set mock properties as needed
        $questionnaire->id = $questionnaireId;
        $questionnaire->title = 'Sample Questionnaire';

        // Mock the behavior of the QuestionnaireRepository's findQuestionnaireById method
        $this->questionnaireRepository
            ->shouldReceive('findQuestionnaireById')
            ->once()
            ->with($questionnaireId)
            ->andReturn($questionnaire);

        // Perform the test by calling the method under test
        $result = $this->questionnaireService->getQuestionnaireById($questionnaireId);

        // Assert that the method returns a Questionnaire instance
        $this->assertInstanceOf(Questionnaire::class, $result);
        // Assert that the returned questionnaire has the expected ID and title
        $this->assertEquals($questionnaireId, $result->id);
        $this->assertEquals('Sample Questionnaire', $result->title);
    }
}
