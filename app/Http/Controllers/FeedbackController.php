<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * Giriş yapan kullanıcının kendi şikayet/önerilerinin listesi.
     */
    public function index(): View
    {
        $feedbackList = Feedback::with('images')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('panel.feedbacks.index', compact('feedbackList'));
    }

    /**
     * Yeni şikayet/öneri formu.
     */
    public function create()
    {
        return view('panel.feedbacks.create');
    }

    /**
     * Şikayet/öneriyi kaydet, varsa resimleri yükle.
     */
    public function store(Request $request): RedirectResponse
    {
        // Sadece giriş yapmış kullanıcılar gönderebilir
        abort_unless(auth()->check(), 403);

        $validated = $request->validate([
            'type' => ['required', 'integer', 'in:' . Feedback::TYPE_COMPLAINT . ',' . Feedback::TYPE_SUGGESTION],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],

            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5 MB
        ], [
            'type.required' => 'Lütfen şikayet mi öneri mi gönderdiğinizi seçin.',
            'type.in' => 'Geçersiz kayıt türü.',
            'subject.required' => 'Konu başlığı zorunludur.',
            'subject.max' => 'Konu başlığı en fazla 255 karakter olabilir.',
            'message.required' => 'Mesaj alanı zorunludur.',
            'message.max' => 'Mesaj en fazla 5000 karakter olabilir.',
            'images.max' => 'En fazla 5 resim ekleyebilirsiniz.',
            'images.*.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'images.*.mimes' => 'Resimler yalnızca jpg, jpeg, png veya webp formatında olabilir.',
            'images.*.max' => 'Her resim en fazla 5 MB olabilir.',
        ]);

        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => Feedback::STATUS_PENDING,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('feedback', 'public');

                $feedback->images()->create([
                    'image_url' => Storage::url($path),
                    'position' => $index,
                ]);
            }
        }

        return redirect()
            ->route('feedback.index')
            ->with('success', 'Talebiniz alındı, en kısa sürede incelenecektir.');
    }

    /**
     * Tek bir şikayet/öneri kaydının detayı (kullanıcı sadece kendininkini görebilir).
     */
    public function show(Feedback $feedback)
    {
        abort_unless($feedback->user_id === auth()->id(), 403);

        $feedback->load('images', 'respondedBy');

        return view('panel.feedbacks.show', compact('feedback'));
    }
}
