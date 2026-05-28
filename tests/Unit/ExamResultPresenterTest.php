<?php

namespace Tests\Unit;

use App\Models\PermitApplication;
use App\Models\User;
use App\Support\ExamResultPresenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamResultPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_shows_prevalidated_obtencion_without_score(): void
    {
        config(['gestoria.exam_prevalidated' => true]);

        $user = User::factory()->create(['nie' => '12345678Z']);
        $application = PermitApplication::query()->create([
            'user_id' => $user->id,
            'nie' => '12345678Z',
            'birth_date' => $user->birth_date,
            'tramite_type' => 'obtencion',
            'reference_code' => 'OBT-TEST-001',
            'status' => 'en_tramitacion',
            'exam_score' => null,
            'min_pass_score' => 70,
            'score_improvement_paid' => true,
            'submitted_at' => now(),
        ]);

        $presenter = new ExamResultPresenter($application, $user);

        $this->assertTrue($presenter->visible());
        $this->assertTrue($presenter->passed());
        $this->assertSame(3, $presenter->errorsCount());
    }

    public function test_fails_when_score_below_minimum_and_not_paid(): void
    {
        config(['gestoria.exam_prevalidated' => false]);

        $user = User::factory()->create();
        $application = PermitApplication::query()->create([
            'user_id' => $user->id,
            'nie' => '99999999R',
            'birth_date' => $user->birth_date,
            'tramite_type' => 'obtencion',
            'reference_code' => 'OBT-TEST-002',
            'status' => 'en_tramitacion',
            'exam_score' => 55,
            'exam_errors' => 12,
            'min_pass_score' => 70,
            'score_improvement_paid' => false,
            'submitted_at' => now(),
        ]);

        $presenter = new ExamResultPresenter($application, $user);

        $this->assertTrue($presenter->visible());
        $this->assertFalse($presenter->passed());
        $this->assertSame(12, $presenter->errorsCount());
    }
}
