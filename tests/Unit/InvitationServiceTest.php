<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Http\Repositories\InvitationRepository;
use App\Http\Services\InvitationService;
use App\Http\Services\MailService;
use App\Http\Services\QuestionnaireService;
use App\Http\Services\StudentService;
use App\Jobs\StoreInvitationJob;
use App\Models\Invitation;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Log;

/**
 * InvitationServiceTest
 */
class InvitationServiceTest extends TestCase
{
    /**
     * Test storing an invitation.
     *
     * @return void
     */
    public function test_storeInvitation()
    {
        // Create a mock for InvitationRepository
        $repositoryMock = $this->createMock(InvitationRepository::class);

        // Set up expectations
        $repositoryMock->expects($this->once())
            ->method('storeInvitation')
            ->willReturn(new Invitation());

        // Create an instance of InvitationService with the mock repository
        $service = new InvitationService(
            $repositoryMock,
            $this->createMock(QuestionnaireService::class),
            $this->createMock(MailService::class),
            $this->createMock(StudentService::class)
        );

        // Call the method under test
        $result = $service->storeInvitation([]);

        // Assert the result
        $this->assertInstanceOf(Invitation::class, $result);
    }

    /**
     * Test queuing an invitation before storing.
     *
     * @return void
     */
    public function test_queueInvitationBeforeStoring()
    {
        // Create a mock for StoreInvitationJob
        $jobMock = $this->createMock(StoreInvitationJob::class);

        // Create a mock for Log facade
        Log::shouldReceive('error')->once();

        // Create an instance of InvitationService
        $service = new InvitationService(
            $this->createMock(InvitationRepository::class),
            $this->createMock(QuestionnaireService::class),
            $this->createMock(MailService::class),
            $this->createMock(StudentService::class)
        );

        // Call the method under test
        $result = $service->queueInvitationBeforeStoring([]);

        // Assert the result
        $this->assertNull($result);
    }

    /**
     * Test sending invitations for a questionnaire.
     *
     * @return void
     */
    public function test_sendInvitations()
    {
        // Create mocks for dependencies
        $questionnaireServiceMock = $this->createMock(QuestionnaireService::class);
        $mailServiceMock = $this->createMock(MailService::class);
        $studentServiceMock = $this->createMock(StudentService::class);

        // Set up expectations
        $questionnaireServiceMock->expects($this->once())
            ->method('getQuestionnaireById')
            ->willReturn(new Questionnaire());

        $studentServiceMock->expects($this->once())
            ->method('getAllStudentsEmail')
            ->willReturn([]);

        // Create an instance of InvitationService with mocked dependencies
        $service = new InvitationService(
            $this->createMock(InvitationRepository::class),
            $questionnaireServiceMock,
            $mailServiceMock,
            $studentServiceMock
        );

        // Call the method under test
        $service->sendInvitations(1);
        // Assertions can be added based on the expected behavior
    }

    /**
     * Test getting an invitation by URL.
     *
     * @return void
     */
    public function test_getInvitationByUrl()
    {
        // Create a mock for InvitationRepository
        $repositoryMock = $this->createMock(InvitationRepository::class);

        // Set up expectations
        $repositoryMock->expects($this->once())
            ->method('getInvitationQuestionByUniqueUrl')
            ->willReturn(new Invitation());

        // Use mock repository to create an InvitationService
        $service = new InvitationService(
            $repositoryMock,
            $this->createMock(QuestionnaireService::class),
            $this->createMock(MailService::class),
            $this->createMock(StudentService::class)
        );

        // Method call under test
        $result = $service->getInvitationByUrl('sample-url');

        // Assert the result
        $this->assertInstanceOf(Invitation::class, $result);
    }
}
