@extends('layouts.admin')

@section('title', 'Brainy Admin - Jadwal Kelas')
@section('page_title', 'Jadwal Kelas')
@section('page_description', 'Atur dan monitor jadwal semua kelas.')

@php
    $activeTab = 'schedules';
@endphp

@section('content')
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-violet-800 p-6 sm:p-8 text-white shadow-sm">
        <div class="flex items-center gap-5">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-2 border-white/80 text-white">
                <i data-lucide="calendar-days" class="h-9 w-9"></i>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight">Jadwal Kelas</h2>
                <p class="mt-2 text-sm font-medium text-blue-50/90">Atur dan monitor jadwal semua kelas.</p>
            </div>
        </div>
    </section>

    <section id="schedule-board" class="grid gap-5 lg:grid-cols-3">
        <!-- Dynamic rendering via JS -->
    </section>

    <div id="schedule-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div onclick="closeScheduleModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

        <div class="relative z-10 w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl animate-scale-in">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 id="schedule-modal-title" class="text-base font-extrabold text-slate-900">Tambah Jadwal Kelas</h3>
                    <p id="schedule-modal-desc" class="mt-1 text-xs font-medium text-slate-400">Lengkapi detail jadwal kelas.</p>
                </div>
                <button onclick="closeScheduleModal()" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-50 hover:text-slate-700">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form onsubmit="handleScheduleSubmit(event)" class="mt-5 space-y-4">
                <input type="hidden" id="schedule-id-input">

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Nama Kelas</label>
                    <input id="schedule-name-input" type="text" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Deskripsi Singkat</label>
                    <input id="schedule-desc-input" type="text" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Level</label>
                        <select id="schedule-level-input" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs font-medium outline-none transition focus:border-blue-500">
                            <option value="beginner">beginner</option>
                            <option value="intermediate">intermediate</option>
                            <option value="advanced">advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Status</label>
                        <select id="schedule-status-input" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs font-medium outline-none transition focus:border-blue-500">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Penuh">Penuh</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Jadwal</label>
                    <input id="schedule-time-input" type="text" required placeholder="Contoh: Senin & Rabu, 19:00 - 20:30" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Siswa</label>
                        <input id="schedule-students-input" type="number" min="0" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Kapasitas</label>
                        <input id="schedule-capacity-input" type="number" min="1" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Harga</label>
                        <input id="schedule-price-input" type="number" min="0" step="50000" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Total Sesi</label>
                        <input id="schedule-sessions-input" type="number" min="1" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Durasi</label>
                        <input id="schedule-duration-input" type="text" required placeholder="3 bulan" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Mulai</label>
                        <input id="schedule-start-input" type="text" required placeholder="Senin, 1 Juni 2026" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeScheduleModal()" class="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white shadow-sm shadow-blue-500/10 transition hover:bg-blue-700 cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const DAYS = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        const DEFAULT_SCHEDULE_COURSES = [
            { id: 1, name: 'English for Beginners', desc: 'Mulai perjalanan belajar bahasa Inggris dari dasar', schedule: 'Senin & Rabu, 19:00 - 20:30', level: 'beginner', tutor: 'Sarah Johnson', students: 12, capacity: 15, price: 1500000, status: 'Tersedia', sessions: 24, duration: '3 bulan', startsAt: 'Senin, 1 Juni 2026' },
            { id: 2, name: 'English Intermediate', desc: 'Tingkatkan kemampuan berbicara dan menulis', schedule: 'Selasa & Kamis, 19:00 - 20:30', level: 'intermediate', tutor: 'Sarah Johnson', students: 15, capacity: 15, price: 1800000, status: 'Penuh', sessions: 24, duration: '3 bulan', startsAt: 'Jumat, 5 Juni 2026' },
            { id: 3, name: 'English Advanced', desc: 'Perdalam strategi komunikasi profesional', schedule: 'Rabu & Jumat, 19:00 - 20:30', level: 'advanced', tutor: 'Michael Brown', students: 8, capacity: 12, price: 2100000, status: 'Tersedia', sessions: 24, duration: '3 bulan', startsAt: 'Rabu, 3 Juni 2026' },
            { id: 4, name: 'Japanese for Beginners', desc: 'Pelajari huruf, percakapan dasar, dan budaya Jepang', schedule: 'Senin & Rabu, 18:00 - 19:30', level: 'beginner', tutor: 'Yuki Tanaka', students: 10, capacity: 12, price: 2000000, status: 'Tersedia', sessions: 24, duration: '3 bulan', startsAt: 'Senin, 8 Juni 2026' },
            { id: 5, name: 'Japanese Intermediate', desc: 'Perkuat percakapan dan tata bahasa Jepang', schedule: 'Selasa & Kamis, 18:00 - 19:30', level: 'intermediate', tutor: 'Yuki Tanaka', students: 7, capacity: 12, price: 2300000, status: 'Tersedia', sessions: 24, duration: '3 bulan', startsAt: 'Selasa, 9 Juni 2026' },
            { id: 6, name: 'Korean for Beginners', desc: 'Bangun fondasi percakapan dan tata bahasa Korea', schedule: 'Senin & Kamis, 19:00 - 20:30', level: 'beginner', tutor: 'Min-Ji Park', students: 14, capacity: 15, price: 2000000, status: 'Tersedia', sessions: 24, duration: '3 bulan', startsAt: 'Senin, 8 Juni 2026' },
            { id: 7, name: 'Korean Intermediate', desc: 'Tingkatkan percakapan dan pemahaman bacaan Korea', schedule: 'Rabu & Jumat, 18:00 - 19:30', level: 'intermediate', tutor: 'Min-Ji Park', students: 11, capacity: 12, price: 2300000, status: 'Tersedia', sessions: 24, duration: '3 bulan', startsAt: 'Rabu, 10 Juni 2026' }
        ];

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value).replace('IDR', 'Rp');
        }

        function courseDescription(name) {
            if (name.toLowerCase().includes('intermediate')) return 'Tingkatkan kemampuan berbicara dan menulis';
            if (name.toLowerCase().includes('advanced')) return 'Perdalam strategi komunikasi profesional';
            if (name.toLowerCase().includes('japanese')) return 'Pelajari percakapan, tata bahasa, dan budaya Jepang';
            if (name.toLowerCase().includes('korean')) return 'Bangun fondasi percakapan dan tata bahasa Korea';
            return 'Mulai perjalanan belajar bahasa Inggris dari dasar';
        }

        function ensureScheduleData() {
            if (!localStorage.getItem('brainy_courses')) {
                localStorage.setItem('brainy_courses', JSON.stringify(DEFAULT_SCHEDULE_COURSES));
            }
        }

        function getCourses() {
            ensureScheduleData();
            const saved = JSON.parse(localStorage.getItem('brainy_courses') || '[]');
            const savedNames = saved.map(course => course.name);
            const missingDefaults = DEFAULT_SCHEDULE_COURSES.filter(course => !savedNames.includes(course.name));

            return [...saved, ...missingDefaults].map(course => ({
                sessions: 24,
                duration: '3 bulan',
                startsAt: 'Senin, 1 Juni 2026',
                desc: courseDescription(course.name),
                ...course
            }));
        }

        function parseSchedule(schedule) {
            const [daysPart, timePart = ''] = schedule.split(',');
            const days = DAYS.filter(day => daysPart.toLowerCase().includes(day.toLowerCase()));
            return {
                days,
                time: timePart.trim()
            };
        }

        function renderSchedules() {
            const courses = getCourses();
            const board = document.getElementById('schedule-board');
            board.innerHTML = '';

            DAYS.forEach(day => {
                const dayCourses = courses
                    .map(course => ({ ...course, parsedSchedule: parseSchedule(course.schedule) }))
                    .filter(course => course.parsedSchedule.days.includes(day))
                    .sort((a, b) => a.parsedSchedule.time.localeCompare(b.parsedSchedule.time));

                const column = document.createElement('article');
                column.className = 'rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm min-h-80';

                const itemsHtml = dayCourses.length === 0
                    ? `
                        <div class="mt-8 rounded-xl border border-dashed border-slate-200 bg-slate-50/50 py-8 text-center text-xs font-semibold text-slate-400">
                            Belum ada kelas
                        </div>
                    `
                    : dayCourses.map(course => `
                        <button onclick="openScheduleModal(${course.id})" class="group mt-4 block w-full rounded-r-xl border-l-4 border-l-blue-600 bg-blue-50 p-4 text-left transition hover:bg-blue-100/70 active:scale-[0.99] cursor-pointer">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="min-w-0 text-sm font-extrabold leading-snug text-slate-900 group-hover:text-blue-700">${course.name}</h3>
                                <span class="shrink-0 rounded-lg border border-slate-200 bg-white/80 px-2.5 py-1 text-[11px] font-bold text-slate-900 shadow-sm">${course.parsedSchedule.time}</span>
                            </div>
                            <p class="mt-2 text-xs font-medium text-slate-600">${course.tutor}</p>
                            <p class="mt-2 text-xs font-medium text-slate-500">${course.students}/${course.capacity} siswa</p>
                        </button>
                    `).join('');

                column.innerHTML = `
                    <h3 class="text-base font-extrabold text-slate-900">${day}</h3>
                    <p class="mt-2 text-sm font-medium text-slate-500">${dayCourses.length} kelas terjadwal</p>
                    <div class="mt-4">
                        ${itemsHtml}
                    </div>
                `;

                board.appendChild(column);
            });

            lucide.createIcons();
        }

        function openScheduleModal(courseId = null) {
            const courses = getCourses();
            const course = courses.find(item => item.id === courseId);

            document.getElementById('schedule-modal-title').innerText = course ? 'Edit Jadwal Kelas' : 'Tambah Jadwal Kelas';
            document.getElementById('schedule-modal-desc').innerText = course ? `Perbarui jadwal ${course.name}.` : 'Lengkapi detail jadwal kelas.';
            document.getElementById('schedule-id-input').value = course?.id || '';
            document.getElementById('schedule-name-input').value = course?.name || '';
            document.getElementById('schedule-desc-input').value = course?.desc || '';
            document.getElementById('schedule-level-input').value = course?.level || 'beginner';
            document.getElementById('schedule-status-input').value = course?.status || 'Tersedia';
            document.getElementById('schedule-time-input').value = course?.schedule || '';
            document.getElementById('schedule-students-input').value = course?.students ?? 0;
            document.getElementById('schedule-capacity-input').value = course?.capacity ?? 12;
            document.getElementById('schedule-price-input').value = course?.price ?? 1500000;
            document.getElementById('schedule-sessions-input').value = course?.sessions ?? 24;
            document.getElementById('schedule-duration-input').value = course?.duration || '3 bulan';
            document.getElementById('schedule-start-input').value = course?.startsAt || 'Senin, 1 Juni 2026';
            document.getElementById('schedule-modal').classList.remove('hidden');
            lucide.createIcons();
        }

        function closeScheduleModal() {
            document.getElementById('schedule-modal').classList.add('hidden');
        }

        function handleScheduleSubmit(event) {
            event.preventDefault();

            const id = document.getElementById('schedule-id-input').value;
            const payload = {
                name: document.getElementById('schedule-name-input').value.trim(),
                desc: document.getElementById('schedule-desc-input').value.trim(),
                level: document.getElementById('schedule-level-input').value,
                status: document.getElementById('schedule-status-input').value,
                schedule: document.getElementById('schedule-time-input').value.trim(),
                students: parseInt(document.getElementById('schedule-students-input').value) || 0,
                capacity: parseInt(document.getElementById('schedule-capacity-input').value) || 1,
                price: parseInt(document.getElementById('schedule-price-input').value) || 0,
                sessions: parseInt(document.getElementById('schedule-sessions-input').value) || 24,
                duration: document.getElementById('schedule-duration-input').value.trim(),
                startsAt: document.getElementById('schedule-start-input').value.trim(),
                tutor: 'Belum Ditentukan'
            };

            if (payload.students > payload.capacity) {
                showToast('Jumlah siswa tidak boleh melebihi kapasitas kelas.', 'info');
                return;
            }

            let courses = getCourses();
            if (id) {
                courses = courses.map(course => course.id === parseInt(id) ? { ...course, ...payload, tutor: course.tutor || payload.tutor } : course);
                showToast(`Jadwal ${payload.name} berhasil diperbarui.`, 'success');
            } else {
                courses.unshift({ id: Date.now(), ...payload });
                showToast(`Jadwal ${payload.name} berhasil ditambahkan.`, 'success');
            }

            localStorage.setItem('brainy_courses', JSON.stringify(courses));
            closeScheduleModal();
            renderSchedules();
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderSchedules();
        });
    </script>
@endsection
