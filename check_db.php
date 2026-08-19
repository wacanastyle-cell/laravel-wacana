<?php
echo "=== FORMS ===\n";
\App\Models\Form::all()->each(fn($f) => echo "ID: $f->id, Slug: $f->slug, Status: $f->status, Title: $f->title\n");

echo "\n=== FORM SUBMISSIONS ===\n";
\App\Models\FormSubmission::all()->each(fn($s) => echo "ID: $s->id, Ref: $s->reference_number, Name: $s->submitter_name, Form: {$s->form_id}\n");

echo "\n=== MEMBERS ===\n";
echo "Total: " . \App\Models\Member::count() . "\n";

echo "\n=== SETTINGS ===\n";
\App\Models\Setting::all()->each(fn($s) => echo "Key: $s->key, Value: " . substr($s->value ?? '', 0, 50) . "\n");

echo "\n=== PAGES ===\n";
\App\Models\Page::all()->each(fn($p) => echo "ID: $p->id, Slug: $p->slug, Status: $p->status\n");

echo "\nDone\n";
