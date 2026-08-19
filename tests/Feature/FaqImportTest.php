<?php

namespace Tests\Feature;

use App\Filament\Imports\FaqImporter;
use Tests\TestCase;

class FaqImportTest extends TestCase
{
    public function test_faq_importer_has_required_columns(): void
    {
        $columns = FaqImporter::getColumns();

        $this->assertNotEmpty($columns);
        $this->assertEquals(['question', 'answer', 'is_active', 'sort_order'], array_map(fn ($column) => $column->getName(), $columns));
    }

    public function test_livewire_temporary_upload_is_configured_for_csv_imports(): void
    {
        $this->assertSame('local', config('livewire.temporary_file_upload.disk'));
        $this->assertSame('livewire-tmp', config('livewire.temporary_file_upload.directory'));
    }
}
