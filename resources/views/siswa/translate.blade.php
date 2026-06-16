@extends('layouts.siswa')

@section('title', 'Translate - Brainy')

@section('content')
@php
    $languageIcons = [
        'id' => 'ID',
        'en' => 'EN',
        'ko' => 'KO',
        'ja' => 'JA',
    ];
@endphp

<!-- Header Banner -->
<div class="text-white py-12 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl flex items-center gap-5">
        <div class="p-4 bg-white/15 rounded-xl">
            <img src="{{ asset('asset/translate.svg') }}" alt="" class="h-10 w-10 object-contain brightness-0 invert">
        </div>
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Translate</h1>
            <p class="mt-2 text-blue-100 text-sm sm:text-base">Terjemahkan bahasa Indonesia, English, Korean, dan Japanese untuk belajar lebih mudah</p>
        </div>
    </div>
</div>

<div class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28 space-y-8">
    <form id="translate-form" method="POST" action="{{ route('siswa.translate.store') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 sm:p-8 space-y-8">
        @csrf

        <div class="flex items-start gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-gray-700">
            <div class="mt-0.5 flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold text-white" style="background-color: #1D4ED8;">i</div>
            <p>Ruang Brainy Translate mendukung English, Korean, dan Japanese ke bahasa Indonesia, serta dari Indonesia ke tiga bahasa tersebut.</p>
        </div>

        @if($errorMessage)
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ $errorMessage }}
            </div>
        @endif

        @error('input_text')
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ $message }}
            </div>
        @enderror

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_auto_1fr] lg:items-center">
            <div>
                <div class="relative">
                    <select id="source_language" name="source_language" class="block w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-3 pr-12 text-base font-semibold text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($languages as $code => $language)
                            <option value="{{ $code }}" {{ $sourceLanguage === $code ? 'selected' : '' }}>
                                {{ $languageIcons[$code] }} - {{ $language['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-lg leading-none text-gray-700">&#9662;</span>
                </div>
            </div>

            <button type="button" id="swap-languages" class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg border border-gray-200 bg-white text-2xl font-bold shadow-sm transition hover:border-blue-300 hover:bg-blue-50" style="color: #1D4ED8;" aria-label="Tukar bahasa">
                ⇄
            </button>

            <div>
                <div class="relative">
                    <select id="target_language" name="target_language" class="block w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-3 pr-12 text-base font-semibold text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($languages as $code => $language)
                            <option value="{{ $code }}" {{ $targetLanguage === $code ? 'selected' : '' }}>
                                {{ $languageIcons[$code] }} - {{ $language['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-lg leading-none text-gray-700">&#9662;</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="flex min-h-[24rem] flex-col rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-bold text-gray-950">Input Text</h2>
                    <button type="button" id="clear-input" class="text-2xl leading-none text-gray-400 transition hover:text-red-500" aria-label="Hapus input">&times;</button>
                </div>
                <textarea id="input_text" name="input_text" maxlength="5000" class="min-h-0 flex-1 resize-none rounded-md border-0 p-0 text-base leading-8 text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-0" placeholder="Masukkan kata atau kalimat yang ingin diterjemahkan...">{{ $inputText }}</textarea>
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <span id="character-count">{{ strlen($inputText) }} / 5000</span>
                        <span id="voice-status" class="ml-3 font-medium"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" id="voice-input-button" class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 transition hover:bg-gray-50" aria-label="Input dengan suara">
                            <img src="{{ asset('asset/voice.svg') }}" alt="" class="h-5 w-5 object-contain">
                        </button>
                        <button type="button" class="speak-button flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 transition hover:bg-gray-50" data-target="input_text" aria-label="Dengarkan input">
                            <img src="{{ asset('asset/volume.svg') }}" alt="" class="h-5 w-5 object-contain">
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex min-h-[24rem] flex-col rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="font-bold text-gray-950">Translation Result</h2>
                </div>
                <div id="translation-result" class="min-h-0 flex-1 whitespace-pre-line rounded-md text-base leading-8 text-gray-900 focus:outline-none" tabindex="0">
                    {{ $translatedText ?: 'Hasil terjemahan akan muncul di sini.' }}
                </div>
                <div class="mt-4 flex items-center justify-start gap-2">
                    <button type="button" class="speak-button flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 transition hover:bg-gray-50" data-target="translation-result" aria-label="Dengarkan hasil">
                        <img src="{{ asset('asset/volume.svg') }}" alt="" class="h-5 w-5 object-contain">
                    </button>
                    <button type="button" class="copy-button flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 transition hover:bg-gray-50" data-copy="{{ $translatedText }}" aria-label="Salin hasil terjemahan">
                        <img src="{{ asset('asset/copy.svg') }}" alt="" class="h-5 w-5 object-contain">
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg px-10 py-3 text-base font-bold text-white shadow-sm transition hover:opacity-90" style="background-color: #1D4ED8;">
                <span>✦</span>
                <span>Translate</span>
            </button>
        </div>
    </form>

    <section class="rounded-lg border border-gray-200 bg-white p-5 sm:p-7 shadow-sm">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-950">Riwayat Terjemahan</h2>
            <span class="text-sm font-semibold" style="color: #1D4ED8;">Terbaru</span>
        </div>

        @if(empty($history))
            <div class="rounded-lg bg-gray-50 px-4 py-8 text-center text-sm font-medium text-gray-500">
                Belum ada riwayat terjemahan.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="py-3 pr-4">No.</th>
                            <th class="py-3 pr-4">Dari</th>
                            <th class="py-3 pr-4">Ke</th>
                            <th class="py-3 pr-4">Input Text</th>
                            <th class="py-3 pr-4">Hasil Terjemahan</th>
                            <th class="py-3 pr-4">Waktu</th>
                            <th class="py-3 pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @foreach($history as $item)
                            <tr>
                                <td class="py-4 pr-4 font-semibold text-gray-900">{{ $loop->iteration }}</td>
                                <td class="py-4 pr-4">
                                    <span class="font-bold text-gray-900">{{ $item['source_short'] }}</span>
                                    <span class="ml-2">{{ $item['source_label'] }}</span>
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="font-bold text-gray-900">{{ $item['target_short'] }}</span>
                                    <span class="ml-2">{{ $item['target_label'] }}</span>
                                </td>
                                <td class="py-4 pr-4">{{ \Illuminate\Support\Str::limit($item['input_text'], 58) }}</td>
                                <td class="py-4 pr-4">{{ \Illuminate\Support\Str::limit($item['translated_text'], 58) }}</td>
                                <td class="py-4 pr-4">
                                    @if(!empty($item['created_at_iso']))
                                        <span class="history-time" data-created-at="{{ $item['created_at_iso'] }}">{{ $item['created_at'] }}</span>
                                    @else
                                        {{ $item['created_at'] }}
                                    @endif
                                </td>
                                <td class="py-4 pr-4">
                                    <button type="button" class="copy-button rounded border border-gray-200 px-2 py-1 text-xs font-semibold hover:bg-gray-50" data-copy="{{ $item['translated_text'] }}">Copy</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>

<script>
    const sourceLanguage = document.getElementById('source_language');
    const targetLanguage = document.getElementById('target_language');
    const inputText = document.getElementById('input_text');
    const characterCount = document.getElementById('character-count');
    const translateForm = document.getElementById('translate-form');

    document.getElementById('swap-languages').addEventListener('click', () => {
        const sourceValue = sourceLanguage.value;
        sourceLanguage.value = targetLanguage.value;
        targetLanguage.value = sourceValue;
    });

    document.getElementById('clear-input').addEventListener('click', () => {
        inputText.value = '';
        characterCount.textContent = '0 / 5000';
        inputText.focus();
    });

    inputText.addEventListener('input', () => {
        characterCount.textContent = `${inputText.value.length} / 5000`;
    });

    const voiceInputButton = document.getElementById('voice-input-button');
    const voiceStatus = document.getElementById('voice-status');
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const speechLocales = {
        id: 'id-ID',
        en: 'en-US',
        ko: 'ko-KR',
        ja: 'ja-JP',
    };
    let recognition = null;
    let isListening = false;
    let shouldSubmitVoiceResult = false;
    let finalVoiceText = '';

    const setVoiceStatus = (message, isError = false) => {
        voiceStatus.textContent = message;
        voiceStatus.classList.toggle('text-red-600', isError);
        voiceStatus.classList.toggle('text-blue-600', !isError && message !== '');
    };

    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = true;
        recognition.maxAlternatives = 1;

        recognition.addEventListener('result', (event) => {
            let interimText = '';

            for (let index = event.resultIndex; index < event.results.length; index++) {
                const transcript = event.results[index][0].transcript;

                if (event.results[index].isFinal) {
                    finalVoiceText += transcript;
                } else {
                    interimText += transcript;
                }
            }

            const currentText = (finalVoiceText || interimText).trim();

            if (currentText) {
                inputText.value = currentText;
                characterCount.textContent = `${inputText.value.length} / 5000`;
                setVoiceStatus(interimText ? 'Mendengar suara...' : 'Suara diterima, menerjemahkan...');
            }

            if (finalVoiceText.trim()) {
                shouldSubmitVoiceResult = true;
            }
        });

        recognition.addEventListener('end', () => {
            isListening = false;
            voiceInputButton.classList.remove('border-blue-500', 'bg-blue-50');

            if (shouldSubmitVoiceResult && finalVoiceText.trim()) {
                inputText.value = finalVoiceText.trim();
                characterCount.textContent = `${inputText.value.length} / 5000`;
                shouldSubmitVoiceResult = false;
                finalVoiceText = '';
                translateForm.requestSubmit();
                return;
            }

            if (!finalVoiceText.trim()) {
                setVoiceStatus('Tidak ada suara terdeteksi.', true);
            }

            finalVoiceText = '';
        });

        recognition.addEventListener('error', (event) => {
            isListening = false;
            shouldSubmitVoiceResult = false;
            finalVoiceText = '';
            voiceInputButton.classList.remove('border-blue-500', 'bg-blue-50');

            if (event.error === 'not-allowed' || event.error === 'service-not-allowed') {
                setVoiceStatus('Izinkan akses mikrofon di browser.', true);
            } else if (event.error === 'no-speech') {
                setVoiceStatus('Tidak ada suara terdeteksi.', true);
            } else {
                setVoiceStatus('Voice input belum bisa dipakai di browser ini.', true);
            }
        });

        voiceInputButton.addEventListener('click', async () => {
            if (isListening) {
                recognition.stop();
                return;
            }

            recognition.lang = speechLocales[sourceLanguage.value] || 'id-ID';
            shouldSubmitVoiceResult = false;
            finalVoiceText = '';
            setVoiceStatus('Mendengarkan...');

            try {
                if (!window.isSecureContext) {
                    setVoiceStatus('Voice input perlu HTTPS atau localhost.', true);
                    return;
                }

                if (navigator.mediaDevices?.getUserMedia) {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    stream.getTracks().forEach((track) => track.stop());
                }

                recognition.start();
                isListening = true;
                voiceInputButton.classList.add('border-blue-500', 'bg-blue-50');
            } catch (error) {
                const message = error?.name === 'NotAllowedError'
                    ? 'Izinkan akses mikrofon di browser.'
                    : 'Mikrofon belum bisa diakses. Coba gunakan Chrome/Edge di localhost atau HTTPS.';
                setVoiceStatus(message, true);
            }
        });
    } else {
        voiceInputButton.disabled = true;
        voiceInputButton.classList.add('opacity-50', 'cursor-not-allowed');
        setVoiceStatus('Voice input hanya didukung browser tertentu seperti Chrome atau Edge.', true);
    }

    const relativeTime = new Intl.RelativeTimeFormat('id', { numeric: 'auto' });
    const updateHistoryTimes = () => {
        document.querySelectorAll('.history-time').forEach((element) => {
            const createdAt = new Date(element.dataset.createdAt);
            const seconds = Math.round((createdAt.getTime() - Date.now()) / 1000);
            const absoluteSeconds = Math.abs(seconds);

            if (absoluteSeconds < 60) {
                element.textContent = relativeTime.format(seconds, 'second');
                return;
            }

            const minutes = Math.round(seconds / 60);
            if (Math.abs(minutes) < 60) {
                element.textContent = relativeTime.format(minutes, 'minute');
                return;
            }

            const hours = Math.round(minutes / 60);
            if (Math.abs(hours) < 24) {
                element.textContent = relativeTime.format(hours, 'hour');
                return;
            }

            const days = Math.round(hours / 24);
            element.textContent = relativeTime.format(days, 'day');
        });
    };

    updateHistoryTimes();
    setInterval(updateHistoryTimes, 1000);

    document.querySelectorAll('.copy-button').forEach((button) => {
        button.addEventListener('click', async () => {
            const text = button.dataset.copy || document.getElementById('translation-result').textContent.trim();
            if (!text || text === 'Hasil terjemahan akan muncul di sini.') {
                return;
            }

            await navigator.clipboard.writeText(text);
            button.classList.add('border-blue-500', 'bg-blue-50');
            setTimeout(() => {
                button.classList.remove('border-blue-500', 'bg-blue-50');
            }, 900);
        });
    });

    document.querySelectorAll('.speak-button').forEach((button) => {
        button.addEventListener('click', () => {
            const element = document.getElementById(button.dataset.target);
            const text = element.value || element.textContent.trim();

            if (!text || !window.speechSynthesis) {
                return;
            }

            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(new SpeechSynthesisUtterance(text));
        });
    });
</script>
@endsection
