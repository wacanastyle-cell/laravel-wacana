<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view_dashboard',
            'view_members', 'create_members', 'update_members', 'delete_members',
            'view_forms', 'create_forms', 'update_forms', 'delete_forms',
            'view_submissions', 'update_submissions', 'delete_submissions',
            'view_pages', 'create_pages', 'update_pages', 'delete_pages',
            'view_faqs', 'create_faqs', 'update_faqs', 'delete_faqs',
            'view_galleries', 'create_galleries', 'update_galleries', 'delete_galleries',
            'view_blogs', 'create_blogs', 'update_blogs', 'delete_blogs',
            'view_settings', 'update_settings',
            'view_roles', 'update_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $contentAdmin = Role::firstOrCreate(['name' => 'content_admin', 'guard_name' => 'web']);
        $dataAdmin = Role::firstOrCreate(['name' => 'data_admin', 'guard_name' => 'web']);

        $superAdmin->syncPermissions(Permission::all());
        $contentAdmin->syncPermissions(['view_dashboard', 'view_pages', 'create_pages', 'update_pages', 'delete_pages', 'view_faqs', 'create_faqs', 'update_faqs', 'delete_faqs', 'view_galleries', 'create_galleries', 'update_galleries', 'delete_galleries', 'view_blogs', 'create_blogs', 'update_blogs', 'delete_blogs', 'view_settings', 'update_settings']);
        $dataAdmin->syncPermissions(['view_dashboard', 'view_members', 'create_members', 'update_members', 'delete_members', 'view_forms', 'create_forms', 'update_forms', 'delete_forms', 'view_submissions', 'update_submissions', 'delete_submissions', 'view_roles', 'update_roles']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@wacanastyle.my.id'],
            ['name' => 'Super Admin', 'password' => bcrypt('WacanaStyle123!')]
        );
        $admin->syncRoles($superAdmin);

        Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'Wacana Style', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'site_description'], ['value' => 'Komunitas motor Jawa Tengah', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'email'], ['value' => 'admin@wacanastyle.my.id', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'contact_email'], ['value' => 'admin@wacanastyle.my.id', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'whatsapp'], ['value' => '08123456789', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'instagram'], ['value' => '@wacanastyle', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'address'], ['value' => 'Jawa Tengah', 'group' => 'general']);
        Setting::updateOrCreate(['key' => 'footer_text'], ['value' => 'Satu Aspal, Satu Keluarga', 'group' => 'general']);

        Faq::firstOrCreate([
            'question' => 'Apakah Wacana Style terbuka untuk semua rider?',
        ], [
            'answer' => 'Wacana Style terbuka untuk rider dari berbagai jenis motor dan komunitas.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Page::firstOrCreate([
            'slug' => 'tentang',
        ], [
            'title' => 'Tentang',
            'content' => '<p>Wacana Style adalah komunitas motor Jawa Tengah yang terbuka untuk semua rider.</p>',
            'excerpt' => 'Tentang Wacana Style',
            'status' => 'published',
        ]);

        Page::firstOrCreate([
            'slug' => 'kebijakan',
        ], [
            'title' => 'Kebijakan Privasi',
            'content' => '<h2>Kebijakan Privasi</h2><p>Kami berkomitmen untuk melindungi privasi Anda. Data pribadi yang Anda berikan hanya akan digunakan untuk tujuan yang sesuai dengan peraturan yang berlaku.</p>',
            'excerpt' => 'Kebijakan privasi Wacana Style',
            'status' => 'published',
        ]);

        Page::firstOrCreate([
            'slug' => 'peraturan',
        ], [
            'title' => 'Syarat & Ketentuan',
            'content' => '<h2>Syarat & Ketentuan</h2><p>Dengan mengikuti kegiatan Wacana Style, Anda menyetujui semua peraturan dan ketentuan yang berlaku dalam komunitas kami.</p>',
            'excerpt' => 'Syarat dan ketentuan Wacana Style',
            'status' => 'published',
        ]);

        $form = Form::firstOrCreate([
            'slug' => 'open-po-jaket',
        ], [
            'title' => 'Open PO Jaket Wacana Style 2026',
            'description' => 'Formulir open PO jaket komunitas',
            'status' => 'open',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'confirmation_message' => 'Terima kasih, data Anda telah diterima.',
            'email_notification_enabled' => true,
            'admin_notification_enabled' => true,
        ]);

        if ($form->fields()->count() === 0) {
            $fields = [
                ['label' => 'Nama Lengkap', 'name' => 'nama_lengkap', 'type' => 'text', 'is_required' => true, 'sort_order' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'is_required' => true, 'sort_order' => 2],
                ['label' => 'WhatsApp', 'name' => 'whatsapp', 'type' => 'phone', 'is_required' => true, 'sort_order' => 3],
                ['label' => 'Ukuran Jaket', 'name' => 'ukuran_jaket', 'type' => 'select', 'options' => ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'], 'is_required' => true, 'sort_order' => 4],
                ['label' => 'Jumlah', 'name' => 'jumlah', 'type' => 'number', 'is_required' => true, 'sort_order' => 5],
                ['label' => 'Alamat', 'name' => 'alamat', 'type' => 'textarea', 'is_required' => true, 'sort_order' => 6],
                ['label' => 'Catatan', 'name' => 'catatan', 'type' => 'textarea', 'is_required' => false, 'sort_order' => 7],
            ];

            foreach ($fields as $field) {
                FormField::create([
                    'form_id' => $form->id,
                    'label' => $field['label'],
                    'name' => $field['name'],
                    'type' => $field['type'],
                    'options' => array_key_exists('options', $field) ? $field['options'] : null,
                    'is_required' => $field['is_required'],
                    'sort_order' => $field['sort_order'],
                ]);
            }
        }

        // Create sample blogs
        if (Blog::count() === 0) {
            Blog::create([
                'title' => 'Selamat Datang di Blog Wacana Style',
                'slug' => 'selamat-datang-blog-wacana-style',
                'excerpt' => 'Artikel pertama di blog Wacana Style, tempat berbagi cerita dan pengalaman komunitas kami.',
                'content' => '<h2>Selamat Datang!</h2><p>Ini adalah artikel pertama di blog Wacana Style. Di sini kami akan berbagi informasi, tips, dan cerita dari komunitas motor kami.</p>',
                'status' => 'published',
                'user_id' => $admin->id,
                'published_at' => now(),
            ]);

            Blog::create([
                'title' => 'Tips Merawat Motor untuk Touring Jarak Jauh',
                'slug' => 'tips-merawat-motor-touring-jarak-jauh',
                'excerpt' => 'Panduan lengkap merawat motor agar siap untuk touring jarak jauh dengan aman dan nyaman.',
                'content' => '<h2>Persiapan Motor</h2><p>Sebelum melakukan touring jarak jauh, pastikan motor Anda dalam kondisi prima. Berikut adalah beberapa tips penting:</p><ul><li>Cek tekanan ban</li><li>Ganti oli berkala</li><li>Periksa sistem rem</li></ul>',
                'status' => 'published',
                'user_id' => $admin->id,
                'published_at' => now()->subDays(2),
            ]);
        }
    }
}
