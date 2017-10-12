<?php

namespace Tests\Unit;

use App\Jobs\Opinion\DeferOpinion;
use App\Jobs\Opinion\RegisterOpinion;
use App\Jobs\RemovalRequest\ApproveNonManifestedNationalRemovalRequest;
use App\Jobs\RemovalRequest\ChooseRapporteur;
use App\Jobs\RemovalRequest\CreateRemovalRequest;
use App\Opinion;
use App\RemovalRequest;
use App\Repositories\RemovalRequestRepository;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RemovalRequestTest extends TestCase
{
    use DatabaseMigrations;

    private $removal_request;
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class);
        $this->user            = create(User::class);
    }

    /** @test */
    public function a_request_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->removal_request->user);
    }

    /** @test */
    function a_national_request_starts_with_the_released_status()
    {
        $data = make(RemovalRequest::class, ['user_id' => $this->user->id, 'type' => 'national'])->toArray();

        $request = dispatch(new CreateRemovalRequest($data));

        $this->assertEquals('released', $request->status);
    }

    /** @test */
    function a_international_request_starts_with_the_initial_status()
    {
        $data = make(RemovalRequest::class, ['user_id' => $this->user->id, 'type' => 'international'])->toArray();

        $request = dispatch(new CreateRemovalRequest($data));

        $this->assertEquals('initial', $request->status);
    }

    /** @test */
    function it_approve_all_national_released_removal_requests()
    {
        $repo = new RemovalRequestRepository;

        $removal_request = create(RemovalRequest::class, ['type' => 'national', 'status' => 'released']);
        create(Opinion::class, ['removal_request_id' => $removal_request->id]);
        create(RemovalRequest::class, ['type' => 'national', 'status' => 'released'], 3);

        $this->assertEquals(3, $repo->getNonManifestedNationalReleased()->count());

        dispatch(new ApproveNonManifestedNationalRemovalRequest);
        $this->assertEquals(0, $repo->getNonManifestedNationalReleased()->count());
    }

    /** @test */
    function it_update_the_status_of_a_removal_request_after_the_choose_of_rapporteur()
    {
        $removal_request = create(RemovalRequest::class, ['status' => 'started']);

        $removal_request = dispatch(new ChooseRapporteur($removal_request->id, $this->user->id));

        $this->assertEquals('released', $removal_request->status);
    }

    /** @test */
    function a_removal_request_has_a_rapporteur_after_the_choose()
    {
        $removal_request = create(RemovalRequest::class, ['status' => 'started']);

        $removal_request = dispatch(new ChooseRapporteur($removal_request->id, $this->user->id));

        $this->assertInstanceOf(User::class, $removal_request->rapporteur);
        $this->assertEquals($removal_request->rapporteur->id, $this->user->id);
    }

    /** @test */
    function a_removal_request_change_the_status_after_a_opinion_deferred()
    {
        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'released']);
        $data            = make(Opinion::class,
            ['removal_request_id' => $removal_request->id, 'type' => 'positive'])->toArray();
        $opinion         = dispatch(new DeferOpinion($data));

        $this->assertEquals('approved-di', $opinion->removalRequest->status);


        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'released']);
        $data            = make(Opinion::class,
            ['removal_request_id' => $removal_request->id, 'type' => 'negative'])->toArray();
        $opinion         = dispatch(new DeferOpinion($data));

        $this->assertEquals('disapproved', $opinion->removalRequest->status);
    }

    /** @test */
    function a_removal_request_change_the_status_after_the_ct_opinion_registered()
    {
        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-di']);
        $data            = make(Opinion::class,
            ['removal_request_id' => $removal_request->id, 'type' => 'positive', 'registered_for' => 'ct'])
            ->toArray();
        $opinion         = dispatch(new RegisterOpinion($data));

        $this->assertEquals('approved-ct', $opinion->removalRequest->status);


        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-di']);
        $data            = make(Opinion::class,
            ['removal_request_id' => $removal_request->id, 'type' => 'negative', 'registered_for' => 'prppg'])
            ->toArray();
        $opinion         = dispatch(new DeferOpinion($data));

        $this->assertEquals('disapproved', $opinion->removalRequest->status);
    }

    /** @test */
    function a_removal_request_change_the_status_after_the_prppg_opinion_registered()
    {
        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-ct']);
        $data            = make(Opinion::class,
            ['removal_request_id' => $removal_request->id, 'type' => 'positive', 'registered_for' => 'prppg'])
            ->toArray();
        $opinion         = dispatch(new RegisterOpinion($data));

        $this->assertEquals('approved-prppg', $opinion->removalRequest->status);


        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-ct']);
        $data            = make(Opinion::class,
            ['removal_request_id' => $removal_request->id, 'type' => 'negative', 'registered_for' => 'prppg'])
            ->toArray();
        $opinion         = dispatch(new DeferOpinion($data));

        $this->assertEquals('disapproved', $opinion->removalRequest->status);
    }

}
