<?php

namespace Database\Factories;

use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    protected $model = Form::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'status' => 'open',
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addMonth(),
            'confirmation_message' => 'Terima kasih sudah mengisi formulir ini.',
            'email_notification_enabled' => true,
            'admin_notification_enabled' => true,
        ];
    }
}
