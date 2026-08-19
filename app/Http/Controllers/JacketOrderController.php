<?php

namespace App\Http\Controllers;

use App\Mail\AdminJacketOrderNotification;
use App\Mail\JacketOrderConfirmation;
use App\Models\JacketOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class JacketOrderController extends Controller
{
    /**
     * Store a jacket order from website form
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:255',
            'jacket_type' => 'required|string|max:255',
            'jacket_model' => 'nullable|string|max:255',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'total_quantity' => 'required|integer|min:1',
            'design_reference' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'notes' => 'nullable|string|max:1000',
            'estimated_total' => 'nullable|numeric|min:0',
        ]);

        // Handle file upload
        if ($request->hasFile('design_reference')) {
            $file = $request->file('design_reference');
            $path = $file->storePubliclyAs(
                'jacket-designs',
                time() . '-' . $file->getClientOriginalName(),
                'public'
            );
            $validated['design_reference'] = $path;
        }

        // Create order
        $order = JacketOrder::create([
            ...$validated,
            'colors' => $request->input('colors', []),
            'sizes' => $request->input('sizes', []),
            'status' => 'new',
            'ordered_at' => now(),
        ]);

        // Send confirmation email to customer
        if (!empty($validated['customer_email'])) {
            Mail::to($validated['customer_email'])->send(
                new JacketOrderConfirmation($order)
            );
        }

        // Send notification to admin
        $adminEmails = config('mail.admin_addresses', ['admin@wacanastyle.my.id']);
        foreach ($adminEmails as $email) {
            Mail::to($email)->send(
                new AdminJacketOrderNotification($order)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan jaket berhasil dikirim! Kami akan segera menghubungi Anda.',
            'order_number' => $order->order_number,
        ]);
    }

    /**
     * Get jacket order data (optional - for frontend integration)
     */
    public function show(string $orderNumber)
    {
        $order = JacketOrder::where('order_number', $orderNumber)->firstOrFail();
        
        // Verify customer can view this order
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        return response()->json($order);
    }
}
