<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class TimetableControllerTest extends TestCase
{
    public function test_loads_lessons_for_a_given_date(): void
    {
        $response = $this->get('api/timetable?date=2022-09-05T10:35:20.021Z&userId=A1725316986');

        dd($response->content());

        $response->assertStatus(200);
    }

    public function test_no_date_loads_current_date(): void
    {
        $response = $this->get('api/timetable?userId=A1725316986');

        dd($response->content());

        $response->assertStatus(200);
    }

    public function test_no_user_id_fails(): void
    {
        $response = $this->get('api/timetable');

        dd($response->content());

        $response->assertStatus(200);
    }

    public function test_get_class_using_id()
    {
        
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
