import './bootstrap';
import { isValidNIK } from 'nusantara-valid/dist/esm/nusantara-valid.js';

const setupNikValidation = () => {
    const input = document.querySelector('[data-nik-input]');

    if (!input) {
        return;
    }

    const feedback = document.querySelector('[data-nik-feedback]');
    const submitButton = document.querySelector('[data-nik-submit]');
    const checkUrl = input.dataset.checkUrl;
    const checkContext = input.dataset.checkContext ?? 'registration';
    let debounceTimer;
    let abortController;

    const setFeedback = (message, state = 'neutral') => {
        if (!feedback) {
            return;
        }

        const colors = {
            neutral: 'mt-2 text-xs font-semibold text-slate-500',
            checking: 'mt-2 text-xs font-semibold text-blue-600',
            success: 'mt-2 text-xs font-semibold text-emerald-600',
            error: 'mt-2 text-xs font-semibold text-rose-600',
        };

        feedback.textContent = message;
        feedback.className = colors[state] ?? colors.neutral;
    };

    const setSubmittable = (enabled) => {
        if (submitButton) {
            submitButton.disabled = !enabled;
        }
    };

    const checkNikAvailability = async (nik) => {
        abortController?.abort();
        abortController = new AbortController();

        setSubmittable(false);
        setFeedback('Memeriksa NIK...', 'checking');

        try {
            const params = new URLSearchParams({
                nik,
                context: checkContext,
            });
            const response = await fetch(`${checkUrl}?${params.toString()}`, {
                headers: {
                    Accept: 'application/json',
                },
                signal: abortController.signal,
            });
            const result = await response.json();

            setSubmittable(Boolean(result.available));
            setFeedback(result.message, result.available ? 'success' : 'error');
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            setSubmittable(false);
            setFeedback('Gagal memeriksa NIK. Coba lagi.', 'error');
        }
    };

    const validateNik = () => {
        const nik = input.value.replace(/\D/g, '').slice(0, 16);
        input.value = nik;

        clearTimeout(debounceTimer);
        setSubmittable(false);

        if (nik.length === 0) {
            setFeedback('NIK digunakan untuk memastikan trial/pendaftaran hanya satu kali.');
            return;
        }

        if (nik.length < 16) {
            setFeedback('NIK harus terdiri dari 16 digit.', 'error');
            return;
        }

        if (!isValidNIK(nik)) {
            setFeedback('NIK tidak valid.', 'error');
            return;
        }

        debounceTimer = window.setTimeout(() => checkNikAvailability(nik), 350);
    };

    input.addEventListener('input', validateNik);
    validateNik();
};

document.addEventListener('DOMContentLoaded', setupNikValidation);
