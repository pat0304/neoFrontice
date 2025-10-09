<?php

use App\Models\Email;
use App\Models\Password;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

it('can register a user successfully', function () {
    dump(DB::connection()->getConfig());


    $response = $this->postJson('/api/auth/register', [
        'username' => 'Pat',
        'first_name' => 'Tien',
        'last_name' => 'Phan',
        'role' => 'taskee',
        'email' => 'pat@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',

    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('users', [
        'username' => 'pat',
    ]);
});

// it('can login with valid credentials', function () {
//     $user = User::factory()->create([
//         'username' => 'Pat',
//         'first_name' => 'Tien',
//         'last_name' => 'Phan',
//     ]);
//     Password::factory()->create([
//         'user_id' => $user->id,
//         'password' => bcrypt('secret123')
//     ]);
//     Email::factory()->create(
//         [
//             'user_id' => $user->id,
//             'email' => "pat@gmail.com",
//             'is_active' => true,
//             'is_verified' => true
//         ]
//     );

//     $response = $this->postJson('/api/auth/login', [
//         'email' => $user->email,
//         'password' => 'secret123',
//     ]);

//     $response->assertStatus(200)
//         ->assertJsonStructure([
//             'message',
//             'status',
//             'data' => []
//         ]);
// });

// it('returns unauthorized with invalid credentials', function () {
//     $user = User::factory()->create([
//         'password' => Hash::make('secret123'),
//     ]);

//     $response = $this->postJson('/api/auth/login', [
//         'email' => $user->email,
//         'password' => 'wrongpassword',
//     ]);

//     $response->assertStatus(401);
// });

// it('can get user profile after login', function () {
//     $user = User::factory()->create();
//     $this->actingAs($user, 'api');

//     $response = $this->getJson('/api/auth/me');

//     $response->assertStatus(200)
//         ->assertJsonFragment([
//             'email' => $user->email,
//         ]);
// });

// it('can logout successfully', function () {
//     $user = User::factory()->create();
//     $this->actingAs($user, 'api');

//     $response = $this->postJson('/api/auth/logout');

//     $response->assertStatus(200);
// });

// it('can refresh token with valid refresh token', function () {
//     // giả định bạn có service tạo refresh token, 
//     // ở đây mock cho đơn giản
//     $user = User::factory()->create();
//     $this->actingAs($user, 'api');

//     $refreshToken = Str::random(40);

//     // set cookie refresh_token giả
//     $response = $this->withCookie('refresh_token', $refreshToken)
//         ->postJson('/api/auth/refresh');

//     // tuỳ logic của bạn mà assert lại
//     $response->assertStatus(200);
// });
