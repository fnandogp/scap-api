<?php

namespace Tests\Feature\Opinion;

use App\Opinion;
use App\RemovalRequest;
use App\Repositories\RoleRepository;
use App\User;
use Tests\Feature\FeatureTestCase;

class DeferOpinionTest extends FeatureTestCase
{

    /**
     * @var
     */
    private $removal_request;
    /**
     * @var
     */
    private $rapporteur;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'released']);

        $repo           = new RoleRepository();
        $professor_role = $repo->findByName('professor')->toArray();
        $rapporteur     = create(User::class);
        $rapporteur->attachRole($professor_role);
        $this->rapporteur = $rapporteur;
    }

    /** @test */
    function it_defer_a_opinion()
    {
        $data = make(Opinion::class)->toArray();

        $this->post("removal-requests/{$this->removal_request->id}/defer-opinion", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);
    }

    /** @test */
    function a_professor_can_only_defer_opinions_to_removal_request_that_he_is_rapporteur()
    {
        $removal_request = create(RemovalRequest::class,
            ['type' => 'international', 'status' => 'released', 'rapporteur_id' => $this->rapporteur->id]);

        $data = make(Opinion::class)->toArray();

        $this->post("removal-requests/{$removal_request->id}/defer-opinion", $data,
            $this->getCustomHeader($this->rapporteur))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);
    }

    /** @test */
    function a_professor_that_is_not_the_rapporteur_can_not_defer_opinion()
    {
        $removal_request = create(RemovalRequest::class,
            ['type' => 'international', 'status' => 'released', 'rapporteur_id' => $this->rapporteur->id]);

        $data = make(Opinion::class)->toArray();

        $this->post("removal-requests/{$removal_request->id}/defer-opinion", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }
}
