@extends('layouts.admin')

@section('title', 'Brainy Admin - Kelola Kursus')
@section('page_title', 'Kelola Kursus')
@section('page_description', 'Tambah, edit, dan kelola semua kursus aktif Brainy.')

@php
    $activeTab = 'courses';
@endphp

@section('content')
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-violet-700 p-6 sm:p-8 text-white shadow-sm">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight">Kelola Kursus</h2>
                <p class="mt-2 text-sm font-medium text-blue-50/90">Tambah, edit, dan kelola semua kursus.</p>
            </div>
            <button
                onclick="openCourseModal()"
                class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-white px-5 text-sm font-bold text-slate-900 shadow-sm transition hover:bg-slate-50 active:scale-[0.98] sm:w-auto cursor-pointer"
            >
                <i data-lucide="plus" class="h-5 w-5"></i>
                Tambah Kursus Baru
            </button>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Daftar Kursus</h2>
                <p id="course-total-label" class="mt-1 text-sm text-slate-500">Total 0 kursus tersedia</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </span>
                    <input
                        id="search-input"
                        type="text"
                        oninput="handleSearch(this.value)"
                        placeholder="Cari kursus, tutor..."
                        class="h-9 w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500"
                    />
                </div>

                <div class="flex items-center gap-1.5 rounded-xl border border-slate-200/60 bg-slate-50 p-1">
                    <button onclick="setFilterLevel('All')" id="btn-level-All" class="rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-blue-600 shadow-sm">All</button>
                    <button onclick="setFilterLevel('beginner')" id="btn-level-beginner" class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900">Beginner</button>
                    <button onclick="setFilterLevel('intermediate')" id="btn-level-intermediate" class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900">Intermediate</button>
                    <button onclick="setFilterLevel('advanced')" id="btn-level-advanced" class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900">Advanced</button>
                </div>
            </div>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-bold text-slate-900">
                        <th class="whitespace-nowrap px-2 py-3">Kursus</th>
                        <th class="whitespace-nowrap px-2 py-3">Level</th>
                        <th class="whitespace-nowrap px-2 py-3">Tutor</th>
                        <th class="whitespace-nowrap px-2 py-3">Siswa</th>
                        <th class="whitespace-nowrap px-2 py-3">Harga</th>
                        <th class="whitespace-nowrap px-2 py-3">Status</th>
                        <th class="whitespace-nowrap px-2 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="courses-table-body" class="divide-y divide-slate-100">
                    <!-- Dynamic rendering via JS -->
                </tbody>
            </table>
        </div>
    </section>

    <div id="course-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div onclick="closeCourseModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

        <div class="relative z-10 w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl animate-scale-in">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 id="course-modal-title" class="text-base font-extrabold text-slate-900">Tambah Kursus Baru</h3>
                    <p id="course-modal-desc" class="mt-1 text-xs font-medium text-slate-400">Lengkapi detail kelas yang akan dibuka.</p>
                </div>
                <button onclick="closeCourseModal()" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-50 hover:text-slate-700">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form onsubmit="handleCourseSubmit(event)" class="mt-5 space-y-4">
                <input type="hidden" id="course-id-input">

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Nama Kursus</label>
                    <input id="course-name-input" type="text" required placeholder="Contoh: English for Beginners" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Level</label>
                        <select id="course-level-input" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs font-medium outline-none transition focus:border-blue-500">
                            <option value="beginner">beginner</option>
                            <option value="intermediate">intermediate</option>
                            <option value="advanced">advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Tutor</label>
                        <input id="course-tutor-input" type="text" required placeholder="Contoh: Sarah Johnson" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Jadwal</label>
                    <input id="course-schedule-input" type="text" required placeholder="Contoh: Senin & Rabu, 19:00 - 20:30" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Siswa</label>
                        <input id="course-students-input" type="number" min="0" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Kapasitas</label>
                        <input id="course-capacity-input" type="number" min="1" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Harga</label>
                        <input id="course-price-input" type="number" min="0" step="50000" required class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Status</label>
                    <select id="course-status-input" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs font-medium outline-none transition focus:border-blue-500">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Penuh">Penuh</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeCourseModal()" class="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white shadow-sm shadow-blue-500/10 transition hover:bg-blue-700 cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const DEFAULT_COURSES = [
            { id: 1, name: 'English for Beginners', schedule: 'Senin & Rabu, 19:00 - 20:30', level: 'beginner', tutor: 'Sarah Johnson', students: 12, capacity: 15, price: 1500000, status: 'Tersedia' },
            { id: 2, name: 'English Intermediate', schedule: 'Selasa & Kamis, 19:00 - 20:30', level: 'intermediate', tutor: 'Sarah Johnson', students: 15, capacity: 15, price: 1800000, status: 'Penuh' },
            { id: 3, name: 'English Advanced', schedule: 'Rabu & Jumat, 19:00 - 20:30', level: 'advanced', tutor: 'Michael Brown', students: 8, capacity: 12, price: 2100000, status: 'Tersedia' },
            { id: 4, name: 'Japanese for Beginners', schedule: 'Senin & Rabu, 18:00 - 19:30', level: 'beginner', tutor: 'Yuki Tanaka', students: 10, capacity: 12, price: 2000000, status: 'Tersedia' },
            { id: 5, name: 'Japanese Intermediate', schedule: 'Selasa & Kamis, 18:00 - 19:30', level: 'intermediate', tutor: 'Yuki Tanaka', students: 7, capacity: 12, price: 2300000, status: 'Tersedia' },
            { id: 6, name: 'Korean for Beginners', schedule: 'Senin & Kamis, 19:00 - 20:30', level: 'beginner', tutor: 'Min-Ji Park', students: 12, capacity: 12, price: 2000000, status: 'Penuh' },
            { id: 7, name: 'Korean Intermediate', schedule: 'Selasa & Jumat, 19:00 - 20:30', level: 'intermediate', tutor: 'Min-Ji Park', students: 11, capacity: 12, price: 2300000, status: 'Tersedia' }
        ];

        let currentLevelFilter = 'All';
        let currentSearchQuery = '';

        function ensureCoursesData() {
            if (!localStorage.getItem('brainy_courses')) {
                localStorage.setItem('brainy_courses', JSON.stringify(DEFAULT_COURSES));
            }
        }

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value).replace('IDR', 'Rp');
        }

        function levelBadgeClass(level) {
            if (level === 'beginner') return 'bg-slate-950 text-white border-slate-950';
            if (level === 'intermediate') return 'bg-slate-100 text-slate-900 border-slate-100';
            return 'bg-white text-slate-900 border-slate-200';
        }

        function statusBadgeClass(status) {
            if (status === 'Penuh') return 'bg-rose-600 text-white border-rose-600';
            return 'bg-emerald-50 text-emerald-700 border-emerald-200';
        }

        function renderCourses() {
            ensureCoursesData();
            const courses = JSON.parse(localStorage.getItem('brainy_courses') || '[]');
            const body = document.getElementById('courses-table-body');
            body.innerHTML = '';

            const query = currentSearchQuery.toLowerCase();
            const filtered = courses.filter(course => {
                const matchesSearch = course.name.toLowerCase().includes(query) ||
                    course.tutor.toLowerCase().includes(query) ||
                    course.schedule.toLowerCase().includes(query);
                const matchesLevel = currentLevelFilter === 'All' || course.level === currentLevelFilter;
                return matchesSearch && matchesLevel;
            });

            document.getElementById('course-total-label').innerText = `Total ${courses.length} kursus tersedia`;

            if (filtered.length === 0) {
                body.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-2 py-14 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center gap-2 text-slate-400">
                                <i data-lucide="graduation-cap" class="h-9 w-9 text-slate-300"></i>
                                <p class="text-xs font-semibold">Tidak ada kursus yang sesuai filter.</p>
                            </div>
                        </td>
                    </tr>
                `;
                lucide.createIcons();
                return;
            }

            filtered.forEach(course => {
                const row = document.createElement('tr');
                row.className = 'text-sm transition hover:bg-slate-50/60';
                row.innerHTML = `
                    <td class="min-w-64 px-2 py-4">
                        <p class="font-bold text-slate-900">${course.name}</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">${course.schedule}</p>
                    </td>
                    <td class="px-2 py-4">
                        <span class="inline-flex rounded-lg border px-2.5 py-1 text-[11px] font-bold ${levelBadgeClass(course.level)}">${course.level}</span>
                    </td>
                    <td class="whitespace-nowrap px-2 py-4 text-slate-900">${course.tutor}</td>
                    <td class="whitespace-nowrap px-2 py-4 font-medium text-slate-900">${course.students}/${course.capacity}</td>
                    <td class="whitespace-nowrap px-2 py-4 font-medium text-slate-900">${formatRupiah(course.price)}</td>
                    <td class="px-2 py-4">
                        <span class="inline-flex rounded-lg border px-2.5 py-1 text-[11px] font-bold ${statusBadgeClass(course.status)}">${course.status}</span>
                    </td>
                    <td class="px-2 py-4">
                        <div class="flex justify-end gap-2">
                            <button onclick="openCourseModal(${course.id})" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-900 transition hover:bg-slate-50 active:scale-[0.97] cursor-pointer" title="Edit kursus">
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                            </button>
                            <button onclick="deleteCourse(${course.id}, '${course.name.replace(/'/g, "\\'")}')" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-rose-600 transition hover:bg-rose-50 hover:border-rose-100 active:scale-[0.97] cursor-pointer" title="Hapus kursus">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </td>
                `;
                body.appendChild(row);
            });

            lucide.createIcons();
        }

        function setFilterLevel(level) {
            currentLevelFilter = level;
            ['All', 'beginner', 'intermediate', 'advanced'].forEach(item => {
                const btn = document.getElementById(`btn-level-${item}`);
                if (item === level) {
                    btn.className = 'rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-blue-600 shadow-sm';
                } else {
                    btn.className = 'rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900';
                }
            });
            renderCourses();
        }

        function handleSearch(query) {
            currentSearchQuery = query;
            renderCourses();
        }

        window.onLocalSearch = function(query) {
            document.getElementById('search-input').value = query;
            handleSearch(query);
        };

        function openCourseModal(courseId = null) {
            ensureCoursesData();
            const courses = JSON.parse(localStorage.getItem('brainy_courses') || '[]');
            const course = courses.find(item => item.id === courseId);

            document.getElementById('course-modal-title').innerText = course ? 'Edit Kursus' : 'Tambah Kursus Baru';
            document.getElementById('course-modal-desc').innerText = course ? `Perbarui detail kelas ${course.name}.` : 'Lengkapi detail kelas yang akan dibuka.';
            document.getElementById('course-id-input').value = course?.id || '';
            document.getElementById('course-name-input').value = course?.name || '';
            document.getElementById('course-level-input').value = course?.level || 'beginner';
            document.getElementById('course-tutor-input').value = course?.tutor || '';
            document.getElementById('course-schedule-input').value = course?.schedule || '';
            document.getElementById('course-students-input').value = course?.students ?? 0;
            document.getElementById('course-capacity-input').value = course?.capacity ?? 12;
            document.getElementById('course-price-input').value = course?.price ?? 1500000;
            document.getElementById('course-status-input').value = course?.status || 'Tersedia';
            document.getElementById('course-modal').classList.remove('hidden');
            lucide.createIcons();
        }

        function closeCourseModal() {
            document.getElementById('course-modal').classList.add('hidden');
        }

        function handleCourseSubmit(event) {
            event.preventDefault();

            const id = document.getElementById('course-id-input').value;
            const name = document.getElementById('course-name-input').value.trim();
            const level = document.getElementById('course-level-input').value;
            const tutor = document.getElementById('course-tutor-input').value.trim();
            const schedule = document.getElementById('course-schedule-input').value.trim();
            const students = parseInt(document.getElementById('course-students-input').value) || 0;
            const capacity = parseInt(document.getElementById('course-capacity-input').value) || 1;
            const price = parseInt(document.getElementById('course-price-input').value) || 0;
            const status = document.getElementById('course-status-input').value;

            if (students > capacity) {
                showToast('Jumlah siswa tidak boleh melebihi kapasitas kelas.', 'info');
                return;
            }

            let courses = JSON.parse(localStorage.getItem('brainy_courses') || '[]');
            const payload = { name, schedule, level, tutor, students, capacity, price, status };

            if (id) {
                courses = courses.map(course => course.id === parseInt(id) ? { ...course, ...payload } : course);
                showToast(`Kursus ${name} berhasil diperbarui.`, 'success');
            } else {
                courses.unshift({ id: Date.now(), ...payload });
                showToast(`Kursus ${name} berhasil ditambahkan.`, 'success');
            }

            localStorage.setItem('brainy_courses', JSON.stringify(courses));
            closeCourseModal();
            renderCourses();
        }

        function deleteCourse(courseId, courseName) {
            if (!confirm(`Apakah Anda yakin ingin menghapus kursus ${courseName}?`)) return;

            const courses = JSON.parse(localStorage.getItem('brainy_courses') || '[]').filter(course => course.id !== courseId);
            localStorage.setItem('brainy_courses', JSON.stringify(courses));
            showToast(`Kursus ${courseName} telah dihapus.`, 'info');
            renderCourses();
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCourses();
        });
    </script>
@endsection
