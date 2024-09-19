<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_student()
    {
        $student = Student::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number'  => '1234567890',
            'date_of_birth' => '1990-01-01',
            'address'        => '123 Main St',
        ]);

        $this->assertDatabaseHas('students', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number'  => '1234567890',
            'date_of_birth' => '1990-01-01',
            'address'        => '123 Main St',
        ]);
    }

    /** @test */
    public function it_can_update_a_student()
    {
        $student = Student::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number'  => '1234567890',
            'date_of_birth' => '1990-01-01',
            'address'        => '123 Main St',
        ]);

        $student->update([
            'first_name' => 'John update',
            'last_name' => 'Doe update',
            'email' => 'johnupdate@example.com',
            'phone_number'  => '1234567894',
            'date_of_birth' => '1990-01-02',
            'address'        => '123 Main St update',
        ]);

        $this->assertDatabaseHas('students', [
            'first_name' => 'John update',
            'last_name' => 'Doe update',
            'email' => 'johnupdate@example.com',
            'phone_number'  => '1234567894',
            'date_of_birth' => '1990-01-02',
            'address'        => '123 Main St update',
        ]);

        $this->assertDatabaseMissing('students', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number'  => '1234567890',
            'date_of_birth' => '1990-01-01',
            'address'        => '123 Main St',
        ]);
    }

    /** @test */
public function it_can_delete_a_student()
{
    // Create a student record
    $student = Student::create([
        'first_name' => 'Mark',
        'last_name' => 'Doe',
        'email' => 'mark@example.com',
        'phone_number' => '1234567890',
        'date_of_birth' => '1990-01-01',
        'address' => '456 Another St',
    ]);

    // Delete the student record
    $student->delete();

    // Assert the student record no longer exists in the database
    $this->assertDatabaseMissing('students', [
        'first_name' => 'Mark',
        'last_name' => 'Doe',
        'email' => 'mark@example.com',
        'phone_number' => '1234567890',
        'date_of_birth' => '1990-01-01',
        'address' => '456 Another St',
    ]);
}

}
