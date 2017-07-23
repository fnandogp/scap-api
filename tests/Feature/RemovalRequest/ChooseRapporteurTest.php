<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use App\Repositories\RoleRepository;
use App\User;
use Tests\Feature\FeatureTestCase;

class ChooseRapporteurTest extends FeatureTestCase
{
    /**
     * @var
     */
    private $removal_request;
    /**
     * @var
     */
    private $another_professor;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class, ['status' => 'started', 'type' => 'international']);

        $repo              = new RoleRepository();
        $professor_role    = $repo->findByName('professor')->toArray();
        $another_professor = create(User::class);
        $another_professor->attachRole($professor_role);
        $this->another_professor = $another_professor;
    }

    /** @test */
    function it_choose_the_rapporteur_of_a_international_removal_request()
    {
        $data = [
            'rapporteur_id' => $this->professor->id
        ];

        $this->patch("removal-requests/{$this->removal_request->id}/choose-rapporteur", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(200)
             ->assertJsonStructure(['data', 'message']);
    }

    /** @test */
    function a_department_chief_can_choose_the_rapporteur_of_a_international_removal_request()
    {
        $data = [
            'rapporteur_id' => $this->professor->id
        ];

        $this->patch("removal-requests/{$this->removal_request->id}/choose-rapporteur", $data,
            $this->getCustomHeader($this->department_chief))
             ->assertStatus(200)
             ->assertJsonStructure(['data', 'message']);
    }

    /** @test */
    function a_professor_can_not_choose_the_rapporteur_of_a_international_removal_request()
    {
        $data = [
            'rapporteur_id' => $this->another_professor->id
        ];

        $this->patch("removal-requests/{$this->removal_request->id}/choose-rapporteur", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }

    /** @test */
    function it_can_not_choose_a_rapporteur_for_national_removal_request()
    {
        $removal_request = create(RemovalRequest::class, ['status' => 'started', 'type' => 'national']);

        $data = [
            'rapporteur_id' => $this->professor->id
        ];

        $this->patch("removal-requests/{$removal_request->id}/choose-rapporteur", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(403);
    }
}
