<?php

namespace Tests\Unit;

use App\Jobs\Mandate\MandateCreate;
use App\Mandate;
use App\Repositories\MandateRepository;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MandateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_mandate_belongs_to_a_user()
    {
        $user    = create(User::class);
        $mandate = create(Mandate::class, ['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $mandate->user);
    }

    /** @test */
    function when_a_mandate_is_create_all_current_mandates_are_deactivated()
    {
        $repo = new MandateRepository();

        $data = make(Mandate::class, ['date_to' => null])->toArray();
        $job  = new MandateCreate($data);
        dispatch($job);
        $this->assertEquals(1, $repo->getActives()->count());

        $data = make(Mandate::class, ['date_to' => null])->toArray();
        $job  = new MandateCreate($data);
        dispatch($job);
        $this->assertEquals(1, $repo->getActives()->count());
    }

    /** @test */
    function a_user_can_be_or_cannot_be_the_department_chief()
    {
        $user = create(User::class);
        create(Mandate::class, ['user_id' => $user->id, 'date_to' => null]);
        $this->assertTrue($user->is_department_chief);

        $another_user = create(User::class);
        $this->assertFalse($another_user->is_department_chief);
    }
}
