<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SiswaTranslateController extends Controller
{
    private const LANGUAGES = [
        'id' => ['label' => 'Indonesia', 'short' => 'ID'],
        'en' => ['label' => 'English', 'short' => 'EN'],
        'ko' => ['label' => 'Korean', 'short' => 'KO'],
        'ja' => ['label' => 'Japanese', 'short' => 'JA'],
    ];

    public function index(Request $request)
    {
        $history = $this->normalizeHistory(session('translation_history', []));
        session(['translation_history' => $history]);

        return view('siswa.translate', [
            'languages' => self::LANGUAGES,
            'sourceLanguage' => $request->old('source_language', 'en'),
            'targetLanguage' => $request->old('target_language', 'id'),
            'inputText' => $request->old('input_text', ''),
            'translatedText' => session('translated_text', ''),
            'errorMessage' => session('translate_error'),
            'history' => $history,
        ]);
    }

    public function translate(Request $request)
    {
        $validated = $request->validate([
            'source_language' => ['required', 'string', 'in:id,en,ko,ja'],
            'target_language' => ['required', 'string', 'in:id,en,ko,ja'],
            'input_text' => ['required', 'string', 'max:5000'],
        ]);

        if ($validated['source_language'] === $validated['target_language']) {
            return back()
                ->withInput()
                ->with('translate_error', 'Bahasa sumber dan target tidak boleh sama.');
        }

        if (!$this->isAllowedPair($validated['source_language'], $validated['target_language'])) {
            return back()
                ->withInput()
                ->with('translate_error', 'Pilih pasangan bahasa Indonesia dengan English, Korean, atau Japanese.');
        }

        $apiKey = config('services.nvidia.key');

        if (!$apiKey) {
            return back()
                ->withInput()
                ->with('translate_error', 'API key translate belum dikonfigurasi di .env.');
        }

        try {
            $translatedText = $this->requestTranslation(
                $validated['input_text'],
                $validated['source_language'],
                $validated['target_language'],
                $apiKey
            );
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('translate_error', 'Terjemahan gagal diproses. Coba lagi beberapa saat lagi.');
        }

        $this->storeHistory($validated, $translatedText);

        return back()
            ->withInput($validated)
            ->with('translated_text', $translatedText);
    }

    private function isAllowedPair(string $sourceLanguage, string $targetLanguage): bool
    {
        return $sourceLanguage === 'id' || $targetLanguage === 'id';
    }

    private function requestTranslation(string $text, string $sourceLanguage, string $targetLanguage, string $apiKey): string
    {
        $sourceLabel = self::LANGUAGES[$sourceLanguage]['label'];
        $targetLabel = self::LANGUAGES[$targetLanguage]['label'];
        $baseUrl = rtrim((string) config('services.nvidia.base_url'), '/');

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(30)
            ->post($baseUrl . '/chat/completions', [
                'model' => config('services.nvidia.model'),
                'temperature' => 0.1,
                'max_tokens' => 800,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a precise translation engine. Return only the translated text, without explanation, markdown, quotes, or alternatives.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Translate this {$sourceLabel} text into {$targetLabel}. Preserve meaning, tone, punctuation, and line breaks:\n\n{$text}",
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('Translate API request failed with status ' . $response->status());
        }

        $translatedText = trim((string) data_get($response->json(), 'choices.0.message.content', ''));

        if ($translatedText === '') {
            throw new \RuntimeException('Translate API returned an empty response.');
        }

        return $translatedText;
    }

    private function storeHistory(array $validated, string $translatedText): void
    {
        $history = session('translation_history', []);

        $createdAt = now();

        array_unshift($history, [
            'id' => (string) Str::uuid(),
            'source_language' => $validated['source_language'],
            'target_language' => $validated['target_language'],
            'source_label' => self::LANGUAGES[$validated['source_language']]['label'],
            'target_label' => self::LANGUAGES[$validated['target_language']]['label'],
            'source_short' => self::LANGUAGES[$validated['source_language']]['short'],
            'target_short' => self::LANGUAGES[$validated['target_language']]['short'],
            'input_text' => $validated['input_text'],
            'translated_text' => $translatedText,
            'created_at' => $createdAt->diffForHumans(),
            'created_at_iso' => $createdAt->toIso8601String(),
        ]);

        session(['translation_history' => array_slice($history, 0, 5)]);
    }

    private function normalizeHistory(array $history): array
    {
        return array_map(function (array $item) {
            if (empty($item['created_at_iso'])) {
                $createdAt = now();
                $item['created_at_iso'] = $createdAt->toIso8601String();
                $item['created_at'] = $item['created_at'] ?? $createdAt->diffForHumans();
            }

            return $item;
        }, $history);
    }
}
