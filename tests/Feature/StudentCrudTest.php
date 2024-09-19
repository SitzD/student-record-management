<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_students()
    {
        Student::factory()->count(3)->create();

        $response = $this->get('/api/students');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_student()
    {
        $response = $this->postJson('/api/students', [
            'name' => 'New Student',
            'email' => 'newstudent@example.com',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'New Student',
                     'email' => 'newstudent@example.com',
                 ]);

        $this->assertDatabaseHas('students', [
            'name' => 'New Student',
            'email' => 'newstudent@example.com',
        ]);
    }

    /** @test */
    public function it_can_show_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->get("/api/students/{$student->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => $student->name,
                     'email' => $student->email,
                 ]);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->putJson("/api/students/{$student->id}", [
            'name' => 'Updated Student',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['name' => 'Updated Student']);

        $this->assertDatabaseHas('students', [
            'name' => 'Updated Student',
        ]);
    }

    /** @test */
    public function it_can_delete_a_student()
    {
        $student = Student::factory()->create();

        $response = $this->delete("/api/students/{$student->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }
}
