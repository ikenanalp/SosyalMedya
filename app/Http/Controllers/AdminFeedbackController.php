<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with('user')->latest();

        // Duruma göre filtre: ?status=0
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Türe göre filtre: ?type=1 (şikayet) veya ?type=2 (öneri)
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $feedbackList = $query->paginate(15)->withQueryString();

        return view('panel.admin.feedback.index', compact('feedbackList'));
    }

    /**
     * Tek bir kaydın detayı + yanıt formu.
     */
    public function show(Feedback $feedback)
    {
        $feedback->load('user', 'images', 'respondedBy');

        return view('panel.admin.feedback.show', compact('feedback'));
    }

    /**
     * Admin yanıtı kaydet ve durumu güncelle.
     */
    public function respond(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'status' => ['required', 'integer', 'in:0,1,2,3'],
            'admin_response' => ['required', 'string', 'max:5000'],
        ], [
            'status.required' => 'Lütfen bir durum seçin.',
            'admin_response.required' => 'Yanıt alanı boş bırakılamaz.',
            'admin_response.max' => 'Yanıt en fazla 5000 karakter olabilir.',
        ]);

        $feedback->update([
            'status' => $validated['status'],
            'admin_response' => $validated['admin_response'],
            'responded_by' => auth()->id(),
            'responded_at' => now(),
        ]);

        return redirect()
            ->route('admin.feedback.show', $feedback)
            ->with('success', 'Yanıtınız kaydedildi.');
    }
}
