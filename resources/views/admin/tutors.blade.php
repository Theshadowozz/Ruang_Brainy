@extends('layouts.admin')

@section('title', 'Brainy Admin - Kelola Tutor')
@section('page_title', 'Direktori Pengajar (Tutors)')
@section('page_description', 'Kelola kualifikasi, profil mengajar, dan jadwal kelas para tutor.')

@php
    $activeTab = 'tutors';
@endphp

@section('content')
    <!-- Header action panel -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-1.5 p-1 bg-slate-50 border border-slate-200/50 rounded-xl w-max">
            <button onclick="setFilterLang('All')" id="btn-filter-All" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-blue-600 shadow-sm border border-slate-200/20 cursor-pointer">All</button>
            <button onclick="setFilterLang('English')" id="btn-filter-English" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900 cursor-pointer">English</button>
            <button onclick="setFilterLang('Japanese')" id="btn-filter-Japanese" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900 cursor-pointer">Japanese</button>
            <button onclick="setFilterLang('Korean')" id="btn-filter-Korean" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900 cursor-pointer">Korean</button>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-60">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i data-lucide="search" class="h-4 w-4"></i>
                </span>
                <input
                    id="search-input"
                    type="text"
                    oninput="handleSearch(this.value)"
                    placeholder="Cari tutor, email, sertifikasi..."
                    class="h-9 w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500"
                />
            </div>
            <button
                onclick="openAddModal()"
                class="inline-flex h-9 items-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-bold text-white shadow-md shadow-blue-500/10 transition hover:bg-blue-700 active:scale-[0.98] cursor-pointer"
            >
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah Tutor Baru
            </button>
        </div>
    </div>

    <!-- Tutors Grid -->
    <section id="tutors-grid" class="grid gap-6 md:grid-cols-2">
        <!-- Dynamic rendering via JS -->
    </section>

    <!-- Custom Add / Edit Tutor Modal -->
    <div id="tutor-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div onclick="closeTutorModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
        
        <div class="relative bg-white rounded-2xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 animate-scale-in z-10 flex flex-col gap-5">
            <div class="flex justify-between items-start">
                <div>
                    <h3 id="tutor-modal-title" class="text-base font-extrabold text-slate-900">Tambah Tutor Baru</h3>
                    <p id="tutor-modal-desc" class="text-xs text-slate-400 font-medium mt-1">Registrasikan data tutor baru ke dalam sistem.</p>
                </div>
                <button onclick="closeTutorModal()" class="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form onsubmit="handleTutorFormSubmit(event)" class="space-y-4">
                <input type="hidden" id="tutor-id-input">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input
                        type="text"
                        id="tutor-name-input"
                        placeholder="Contoh: Yuki Tanaka"
                        class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Tutor</label>
                    <input
                        type="email"
                        id="tutor-email-input"
                        placeholder="Contoh: yuki@brainy.com"
                        class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Spesialisasi Bahasa</label>
                        <select
                            id="tutor-lang-input"
                            class="h-10 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                        >
                            <option value="English">English</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Pengalaman (Tahun)</label>
                        <input
                            type="number"
                            min="1"
                            id="tutor-exp-input"
                            placeholder="Contoh: 5"
                            class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                            required
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Sertifikasi</label>
                    <textarea
                        id="tutor-desc-input"
                        placeholder="Contoh: Native speaker dengan sertifikasi JLPT N1..."
                        rows="3"
                        class="w-full rounded-xl border border-slate-200 p-3.5 text-xs font-medium outline-none transition focus:border-blue-500 resize-none bg-slate-50/30 focus:bg-white"
                        required
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button
                        type="button"
                        onclick="closeTutorModal()"
                        class="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-50 cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white transition hover:bg-blue-700 shadow-sm shadow-blue-500/10 cursor-pointer"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Classes and Schedules Editing Modal -->
    <div id="schedule-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div onclick="closeScheduleModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
        
        <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-xl w-full p-6 animate-scale-in z-10 flex flex-col gap-5">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Jadwal Mengajar Tutor</h3>
                    <p class="text-xs text-slate-400 font-medium mt-1">
                        Atur kelas aktif dan pembagian ruang waktu untuk tutor: <strong id="schedule-tutor-name" class="text-slate-700 font-bold">-</strong>
                    </p>
                </div>
                <button onclick="closeScheduleModal()" class="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <!-- List of current classes inside modal -->
            <div class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Daftar Kelas Aktif</h4>
                <div id="modal-classes-list" class="space-y-2">
                    <!-- Loaded dynamically via JS -->
                </div>
            </div>

            <!-- Add class inline form -->
            <form onsubmit="handleAddClassSubmit(event)" class="border-t border-slate-100 pt-4 space-y-3">
                <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400">+ Tambah Jadwal Kelas Baru</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Pilih Kelas</label>
                        <select
                            id="schedule-class-name-select"
                            class="h-9 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                        >
                            <!-- Options updated dynamically matching specialization -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Hari & Jam Mengajar</label>
                        <input
                            type="text"
                            id="schedule-class-time-input"
                            placeholder="Contoh: Senin & Rabu, 19:00 - 20:30"
                            class="h-9 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                            required
                        />
                    </div>
                </div>
                <div class="flex justify-end pt-1">
                    <button
                        type="submit"
                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs font-bold text-slate-700 transition hover:bg-slate-100 hover:border-slate-350 active:scale-[0.98] cursor-pointer"
                    >
                        <i data-lucide="plus" class="h-4 w-4 text-slate-400"></i>
                        Tambahkan ke List
                    </button>
                </div>
            </form>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button
                    type="button"
                    onclick="closeScheduleModal()"
                    class="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-50 cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="button"
                    onclick="saveScheduleChanges()"
                    class="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white transition hover:bg-blue-700 shadow-sm shadow-blue-500/10 cursor-pointer"
                >
                    Simpan Jadwal
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentFilterLang = 'All';
        let currentSearchQuery = '';
        
        let selectedTutorIdForSchedule = null;
        let temporaryClasses = [];

        function renderTutors() {
            const tutors = JSON.parse(localStorage.getItem('brainy_tutors') || '[]');
            const grid = document.getElementById('tutors-grid');
            grid.innerHTML = '';

            const filtered = tutors.filter(tutor => {
                const matchesSearch = tutor.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) || 
                                      tutor.email.toLowerCase().includes(currentSearchQuery.toLowerCase()) ||
                                      tutor.desc.toLowerCase().includes(currentSearchQuery.toLowerCase());
                
                const matchesLang = currentFilterLang === 'All' || tutor.lang === currentFilterLang;
                
                return matchesSearch && matchesLang;
            });

            if (filtered.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full rounded-2xl border border-slate-200/60 bg-white py-16 text-center text-slate-400">
                        <div class="flex justify-center mb-3">
                            <i data-lucide="users" class="h-8 w-8 text-slate-300"></i>
                        </div>
                        <p class="text-xs font-semibold">Tidak ada pengajar/tutor yang sesuai filter.</p>
                    </div>
                `;
            } else {
                filtered.forEach(tutor => {
                    const card = document.createElement('article');
                    card.className = 'group relative rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300 flex flex-col justify-between gap-6';
                    
                    let langBadgeStyle = '';
                    switch(tutor.lang) {
                        case 'English': langBadgeStyle = 'bg-blue-50 text-blue-700 border-blue-100/50'; break;
                        case 'Japanese': langBadgeStyle = 'bg-purple-50 text-purple-700 border-purple-100/50'; break;
                        case 'Korean': langBadgeStyle = 'bg-orange-50 text-orange-700 border-orange-100/50'; break;
                        default: langBadgeStyle = 'bg-slate-50 text-slate-700 border-slate-100';
                    }

                    // Render classes html
                    let classesHtml = '';
                    if (tutor.classes.length === 0) {
                        classesHtml = `
                            <div class="rounded-xl border border-dashed border-slate-200 p-4 text-center text-[10px] font-medium text-slate-400 bg-slate-50/10">
                                Belum ditugaskan ke kelas mana pun.
                            </div>
                        `;
                    } else {
                        classesHtml = '<div class="space-y-2">';
                        tutor.classes.forEach(cls => {
                            classesHtml += `
                                <div class="rounded-xl border border-slate-100 bg-[#F8FAFC]/50 px-4.5 py-2.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 shadow-sm">
                                    <p class="text-xs font-bold text-slate-800">${cls.name}</p>
                                    <p class="text-[10px] text-slate-400 font-bold flex items-center gap-1.5"><i data-lucide="clock" class="h-3.5 w-3.5 text-slate-400"></i>${cls.schedule}</p>
                                </div>
                            `;
                        });
                        classesHtml += '</div>';
                    }

                    card.innerHTML = `
                        <!-- Profile Info Row -->
                        <div class="flex gap-4">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl font-bold text-xl ${tutor.avatarColor} shadow-inner">
                                ${tutor.initials}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-900 truncate group-hover:text-blue-600 transition-colors">${tutor.name}</h3>
                                    <span class="text-sm shrink-0" title="${tutor.lang}">${tutor.flag}</span>
                                </div>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed mt-1">${tutor.desc}</p>
                                <p class="text-[10px] text-slate-400 font-medium flex items-center gap-1.5 mt-2"><i data-lucide="mail" class="h-3.5 w-3.5 text-slate-400"></i>${tutor.email}</p>
                            </div>
                        </div>

                        <!-- Experience and Students metrics -->
                        <div class="grid grid-cols-2 gap-3 bg-slate-50/50 border border-slate-100 rounded-xl p-3.5 shadow-inner">
                            <div class="text-center sm:text-left">
                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Pengalaman</p>
                                <p class="text-sm font-extrabold text-slate-800 mt-1">${tutor.exp} Tahun</p>
                            </div>
                            <div class="text-center sm:text-left border-l border-slate-200/60 pl-3">
                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Total Siswa</p>
                                <p class="text-sm font-extrabold text-blue-600 mt-1">${tutor.students} Siswa</p>
                            </div>
                        </div>

                        <!-- Specialization Badge -->
                        <div>
                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Spesialisasi</h4>
                            <span class="inline-block rounded-lg border px-3 py-1 text-[11px] font-bold ${langBadgeStyle}">
                                ${tutor.lang} Speaker
                            </span>
                        </div>

                        <!-- Classes Taught list -->
                        <div>
                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">
                                Kelas yang Diajar (${tutor.classes.length})
                            </h4>
                            ${classesHtml}
                        </div>

                        <!-- Actions -->
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button
                                onclick="openEditModal(${tutor.id})"
                                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700 transition hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98] cursor-pointer"
                            >
                                <i data-lucide="edit-2" class="h-3.5 w-3.5 text-slate-400"></i>
                                Edit Profil
                            </button>
                            <button
                                onclick="openScheduleModal(${tutor.id})"
                                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl bg-slate-900 text-xs font-bold text-white transition hover:bg-slate-800 active:scale-[0.98] cursor-pointer"
                            >
                                <i data-lucide="calendar-days" class="h-3.5 w-3.5 text-slate-400"></i>
                                Lihat Jadwal
                            </button>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            }
            lucide.createIcons();
        }

        function setFilterLang(lang) {
            currentFilterLang = lang;
            ['All', 'English', 'Japanese', 'Korean'].forEach(l => {
                const btn = document.getElementById(`btn-filter-${l}`);
                if (l === lang) {
                    btn.className = "px-4 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-blue-600 shadow-sm border border-slate-200/20 cursor-pointer";
                } else {
                    btn.className = "px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900 cursor-pointer";
                }
            });
            renderTutors();
        }

        function handleSearch(query) {
            currentSearchQuery = query;
            renderTutors();
        }

        // Search redirection override
        window.onLocalSearch = function(query) {
            document.getElementById('search-input').value = query;
            handleSearch(query);
        };

        // Modal Add/Edit Tutor Actions
        function openAddModal() {
            document.getElementById('tutor-modal-title').innerText = 'Tambah Tutor Baru';
            document.getElementById('tutor-modal-desc').innerText = 'Registrasikan data tutor baru ke dalam sistem.';
            document.getElementById('tutor-id-input').value = '';
            document.getElementById('tutor-name-input').value = '';
            document.getElementById('tutor-email-input').value = '';
            document.getElementById('tutor-lang-input').value = 'English';
            document.getElementById('tutor-exp-input').value = '';
            document.getElementById('tutor-desc-input').value = '';
            
            document.getElementById('tutor-modal').classList.remove('hidden');
        }

        function openEditModal(tutorId) {
            const tutors = JSON.parse(localStorage.getItem('brainy_tutors') || '[]');
            const tutor = tutors.find(t => t.id === tutorId);
            if (!tutor) return;

            document.getElementById('tutor-modal-title').innerText = 'Edit Profil Tutor';
            document.getElementById('tutor-modal-desc').innerText = `Perbarui kualifikasi & informasi untuk tutor ${tutor.name}.`;
            document.getElementById('tutor-id-input').value = tutor.id;
            document.getElementById('tutor-name-input').value = tutor.name;
            document.getElementById('tutor-email-input').value = tutor.email;
            document.getElementById('tutor-lang-input').value = tutor.lang;
            document.getElementById('tutor-exp-input').value = tutor.exp;
            document.getElementById('tutor-desc-input').value = tutor.desc;

            document.getElementById('tutor-modal').classList.remove('hidden');
        }

        function closeTutorModal() {
            document.getElementById('tutor-modal').classList.add('hidden');
        }

        function handleTutorFormSubmit(e) {
            e.preventDefault();
            const id = document.getElementById('tutor-id-input').value;
            const name = document.getElementById('tutor-name-input').value.trim();
            const email = document.getElementById('tutor-email-input').value.trim();
            const lang = document.getElementById('tutor-lang-input').value;
            const exp = parseInt(document.getElementById('tutor-exp-input').value) || 1;
            const desc = document.getElementById('tutor-desc-input').value.trim();

            const flag = lang === 'English' ? '🇬🇧' : lang === 'Japanese' ? '🇯🇵' : '🇰🇷';
            const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();

            let tutors = JSON.parse(localStorage.getItem('brainy_tutors') || '[]');

            if (id) {
                // Edit mode
                tutors = tutors.map(tutor => {
                    if (tutor.id === parseInt(id)) {
                        return { ...tutor, name, email, lang, flag, initials, exp, desc };
                    }
                    return tutor;
                });
                showToast(`Profil ${name} berhasil diperbarui!`, 'success');
            } else {
                // Add mode
                const colors = [
                    'bg-blue-50 text-blue-600 border-blue-100/50',
                    'bg-purple-50 text-purple-600 border-purple-100/50',
                    'bg-orange-50 text-orange-600 border-orange-100/50'
                ];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                
                const newTutor = {
                    id: Date.now(),
                    name, desc, email, exp, students: 0, lang, flag, initials,
                    avatarColor: randomColor,
                    classes: []
                };
                tutors.unshift(newTutor);
                showToast(`Tutor ${name} berhasil didaftarkan!`, 'success');
            }

            localStorage.setItem('brainy_tutors', JSON.stringify(tutors));
            closeTutorModal();
            renderTutors();
        }

        // Schedule Modal Actions
        function openScheduleModal(tutorId) {
            const tutors = JSON.parse(localStorage.getItem('brainy_tutors') || '[]');
            const tutor = tutors.find(t => t.id === tutorId);
            if (!tutor) return;

            selectedTutorIdForSchedule = tutorId;
            temporaryClasses = [...tutor.classes];
            
            document.getElementById('schedule-tutor-name').innerText = tutor.name;
            
            // Set options for class select matching specialization
            const select = document.getElementById('schedule-class-name-select');
            select.innerHTML = '';
            if (tutor.lang === 'English') {
                select.innerHTML = `
                    <option value="English for Beginners">English for Beginners</option>
                    <option value="English Intermediate">English Intermediate</option>
                    <option value="English Advanced">English Advanced</option>
                `;
            } else if (tutor.lang === 'Japanese') {
                select.innerHTML = `
                    <option value="Japanese for Beginners">Japanese for Beginners</option>
                    <option value="Japanese Intermediate">Japanese Intermediate</option>
                    <option value="Japanese Advanced">Japanese Advanced</option>
                `;
            } else {
                select.innerHTML = `
                    <option value="Korean for Beginners">Korean for Beginners</option>
                    <option value="Korean Intermediate">Korean Intermediate</option>
                    <option value="Korean Advanced">Korean Advanced</option>
                `;
            }
            
            document.getElementById('schedule-class-time-input').value = '';
            
            renderModalClasses();
            document.getElementById('schedule-modal').classList.remove('hidden');
        }

        function closeScheduleModal() {
            document.getElementById('schedule-modal').classList.add('hidden');
        }

        function renderModalClasses() {
            const container = document.getElementById('modal-classes-list');
            container.innerHTML = '';

            if (temporaryClasses.length === 0) {
                container.innerHTML = `
                    <div class="rounded-xl border border-dashed border-slate-200 py-6 text-center text-xs font-medium text-slate-400 bg-slate-50/20">
                        Belum mengajar kelas apa pun. Silakan tambahkan jadwal kelas di bawah.
                    </div>
                `;
            } else {
                temporaryClasses.forEach((cls, idx) => {
                    const row = document.createElement('div');
                    row.className = 'rounded-xl border border-slate-100 bg-slate-50/60 px-4 py-3 flex items-center justify-between gap-3 shadow-inner';
                    row.innerHTML = `
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-800 truncate">${cls.name}</p>
                            <p class="text-[10px] text-slate-500 font-medium flex items-center gap-1.5 mt-1"><i data-lucide="clock" class="h-3.5 w-3.5 text-slate-400"></i>${cls.schedule}</p>
                        </div>
                        <button
                            type="button"
                            onclick="removeTempClass(${idx})"
                            class="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition active:scale-[0.95] cursor-pointer"
                            title="Hapus"
                        >
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                        </button>
                    `;
                    container.appendChild(row);
                });
            }
            lucide.createIcons();
        }

        function removeTempClass(idx) {
            temporaryClasses.splice(idx, 1);
            renderModalClasses();
        }

        function handleAddClassSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('schedule-class-name-select').value;
            const schedule = document.getElementById('schedule-class-time-input').value.trim();

            if (!schedule) {
                showToast('Jadwal mengajar tidak boleh kosong.', 'info');
                return;
            }

            temporaryClasses.push({ name, schedule });
            document.getElementById('schedule-class-time-input').value = '';
            renderModalClasses();
        }

        function saveScheduleChanges() {
            let tutors = JSON.parse(localStorage.getItem('brainy_tutors') || '[]');
            tutors = tutors.map(tutor => {
                if (tutor.id === selectedTutorIdForSchedule) {
                    return { ...tutor, classes: temporaryClasses };
                }
                return tutor;
            });

            const tutor = tutors.find(t => t.id === selectedTutorIdForSchedule);
            localStorage.setItem('brainy_tutors', JSON.stringify(tutors));
            closeScheduleModal();
            showToast(`Jadwal mengajar tutor ${tutor?.name || ''} berhasil disimpan!`, 'success');
            renderTutors();
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderTutors();
        });
    </script>
@endsection
