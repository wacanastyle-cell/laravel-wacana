<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFormFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_form_page_renders(): void
    {
        $form = Form::factory()->create([
            'title' => 'Open PO Jaket',
            'slug' => 'open-po-jaket',
            'status' => 'open',
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => 'Nama Lengkap',
            'name' => 'nama_lengkap',
            'type' => 'text',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        $this->get('/form/open-po-jaket')
            ->assertOk()
            ->assertSee('Open PO Jaket')
            ->assertSee('Nama Lengkap');
    }

    public function test_form_submission_stores_reference_number_and_redirects(): void
    {
        $form = Form::factory()->create([
            'title' => 'Open PO Jaket',
            'slug' => 'open-po-jaket',
            'status' => 'open',
            'confirmation_message' => 'Terima kasih.',
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => 'Nama Lengkap',
            'name' => 'nama_lengkap',
            'type' => 'text',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        $response = $this->post('/form/open-po-jaket', [
            'nama_lengkap' => 'Ahmad',
            'email' => 'ahmad@example.com',
            'whatsapp' => '08123456789',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('form_submissions', [
            'form_id' => $form->id,
            'submitter_name' => 'Ahmad',
            'submitter_email' => 'ahmad@example.com',
        ]);
    }
}
