<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Student;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_students()
    {
        // Create some students for testing the list
        Student::factory()->count(3)->create();

        $response = $this->get('/api/students');

        $response->assertStatus(200)
                 ->assertJsonCount(3);  // Assert that there are 3 students in the response
    }

    /** @test */
    public function it_can_create_a_student()
    {
        $response = $this->post('/api/students', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '1234567890',
            'date_of_birth' => '1990-01-01',
            'address' => '123 Main St',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'first_name' => 'John',
                     'last_name' => 'Doe',
                     'email' => 'john@example.com',
                 ]);

        // Assert the student is in the database
        $this->assertDatabaseHas('students', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '1234567890',
            'date_of_birth' => '1990-01-01',
            'address' => '123 Main St',
        ]);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        $student = Student::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone_number' => '0987654321',
            'date_of_birth' => '1992-02-02',
            'address' => '456 Elm St',
        ]);

        $response = $this->put("/api/students/{$student->id}", [
            'first_name' => 'Jane Updated',
            'last_name' => 'Doe Updated',
            'email' => 'janeupdated@example.com',
            'phone_number' => '1112223333',
            'date_of_birth' => '1992-02-03',
            'address' => '789 Oak St',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'first_name' => 'Jane Updated',
                     'last_name' => 'Doe Updated',
                     'email' => 'janeupdated@example.com',
                 ]);

        // Assert the student's information was updated in the database
        $this->assertDatabaseHas('students', [
            'first_name' => 'Jane Updated',
            'last_name' => 'Doe Updated',
            'email' => 'janeupdated@example.com',
            'phone_number' => '1112223333',
            'date_of_birth' => '1992-02-03',
            'address' => '789 Oak St',
        ]);
    }

    /** @test */
    public function it_can_delete_a_student()
    {
        $student = Student::factory()->create([
            'first_name' => 'Mark',
            'last_name' => 'Smith',
            'email' => 'mark@example.com',
            'phone_number' => '5556667777',
            'date_of_birth' => '1988-05-15',
            'address' => '321 Pine St',
        ]);

        $response = $this->delete("/api/students/{$student->id}");

        $response->assertStatus(200);

        // Assert the student is no longer in the database
        $this->assertDatabaseMissing('students', [
            'first_name' => 'Mark',
            'last_name' => 'Smith',
            'email' => 'mark@example.com',
            'phone_number' => '5556667777',
            'date_of_birth' => '1988-05-15',
            'address' => '321 Pine St',
        ]);
    }
}
