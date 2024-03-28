<?php

namespace App\Jobs;

use App\Http\Services\InvitationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * StoreInvitationJob
 */
class StoreInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * invitationService
     *
     * @var InvitationService
     */
    protected $invitationService;

    /**
     * invitationData
     *
     * @var array
     */
    protected $invitationData;

    /**
     * __construct
     *
     * @param  InvitationService $invitationService
     * @param  array $invitationData
     */
    public function __construct(InvitationService $invitationService, array $invitationData)
    {
        $this->invitationService = $invitationService;
        $this->invitationData = $invitationData;
    }

    /**
     * handle
     *
     */
    public function handle()
    {
        $this->invitationService->storeInvitation($this->invitationData);
    }
}
