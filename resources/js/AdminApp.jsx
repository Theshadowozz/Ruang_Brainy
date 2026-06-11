import {
    BookOpen,
    CalendarDays,
    ClipboardList,
    DollarSign,
    GraduationCap,
    Home,
    LogOut,
    UserCheck,
    Users,
    Bell,
    Search,
    Check,
    X,
    Menu,
    ChevronRight,
    TrendingUp,
    Lock,
    Mail,
    Settings,
    ShieldAlert,
    Phone,
    UserPlus,
    Clock,
    Plus,
    Trash2,
    Edit2
} from 'lucide-react';
import React from 'react';
import { BrowserRouter, Navigate, Route, Routes, useNavigate } from 'react-router-dom';

const ADMIN_EMAIL = 'admin@brainy.com';
const ADMIN_PASSWORD = 'admin123';
const AUTH_KEY = 'brainy_admin_auth';

// Custom mathematical SVG Sparkline component for analytics
function Sparkline({ points, color }) {
    const width = 120;
    const height = 30;
    const padding = 2;
    
    const maxVal = Math.max(...points);
    const minVal = Math.min(...points);
    const range = maxVal - minVal || 1;
    
    const pathData = points.map((p, idx) => {
        const x = (idx / (points.length - 1)) * (width - padding * 2) + padding;
        const y = height - ((p - minVal) / range) * (height - padding * 2) - padding;
        return `${idx === 0 ? 'M' : 'L'} ${x.toFixed(1)} ${y.toFixed(1)}`;
    }).join(' ');

    return (
        <svg className={`h-7 w-28 shrink-0 ${color}`} viewBox={`0 0 ${width} ${height}`}>
            <path
                d={pathData}
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
            />
        </svg>
    );
}

// Custom Toast Component for feedback
function Toast({ message, type, onClose }) {
    React.useEffect(() => {
        const timer = setTimeout(() => {
            onClose();
        }, 4000);
        return () => clearTimeout(timer);
    }, [onClose]);

    return (
        <div className="fixed bottom-5 right-5 z-50 flex items-center gap-3 rounded-xl bg-slate-900 px-5 py-4 text-white shadow-xl animate-slide-in border border-slate-800 max-w-sm">
            <div className={`flex h-8 w-8 shrink-0 items-center justify-center rounded-full ${type === 'success' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-blue-500/10 text-blue-400'}`}>
                {type === 'success' ? <Check className="h-5 w-5" /> : <Bell className="h-5 w-5" />}
            </div>
            <div className="flex-1">
                <p className="text-sm font-semibold">{type === 'success' ? 'Berhasil' : 'Info'}</p>
                <p className="text-xs text-slate-300 mt-0.5">{message}</p>
            </div>
            <button onClick={onClose} className="text-slate-400 hover:text-white transition">
                <X className="h-4 w-4" />
            </button>
        </div>
    );
}

function isAdminAuthenticated() {
    return localStorage.getItem(AUTH_KEY) === 'true';
}

function ProtectedRoute({ children }) {
    if (!isAdminAuthenticated()) {
        return <Navigate to="/admin/login" replace />;
    }
    return children;
}

export default function AdminApp() {
    const [toasts, setToasts] = React.useState([]);

    // Lifted state for full page synchronisation
    const [totalSiswa, setTotalSiswa] = React.useState(248);
    const [pendapatan, setPendapatan] = React.useState(45200000); // Rp 45.2M
    
    const [students, setStudents] = React.useState([
        { id: 1, name: 'Ahmad Fauzi', email: 'ahmad@email.com', phone: '081234567890', course: 'English Intermediate', level: 'Intermediate', lang: 'English', joinedDate: '26 Mei 2026', status: 'Active', attendance: 95, progress: 85, paymentStatus: 'Paid', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 2, name: 'Dewi Lestari', email: 'dewi@email.com', phone: '081234567891', course: 'Korean for Beginners', level: 'Beginner', lang: 'Korean', joinedDate: '26 Mei 2026', status: 'Active', attendance: 92, progress: 78, paymentStatus: 'Paid', avatar: 'DL', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
        { id: 3, name: 'Farhan Malik', email: 'farhan@email.com', phone: '081234567892', course: 'Japanese Intermediate', level: 'Intermediate', lang: 'Japanese', joinedDate: '25 Mei 2026', status: 'Active', attendance: 88, progress: 65, paymentStatus: 'Paid', avatar: 'FM', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
        { id: 4, name: 'Larasati Putri', email: 'laras@email.com', phone: '081234567893', course: 'English Advanced', level: 'Advanced', lang: 'English', joinedDate: '24 Mei 2026', status: 'Active', attendance: 100, progress: 92, paymentStatus: 'Paid', avatar: 'LP', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 5, name: 'Rizky Pratama', email: 'rizky@email.com', phone: '081234567894', course: 'Korean Intermediate', level: 'Intermediate', lang: 'Korean', joinedDate: '24 Mei 2026', status: 'Active', attendance: 85, progress: 70, paymentStatus: 'Paid', avatar: 'RP', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
        { id: 6, name: 'Siti Nurhaliza', email: 'siti@email.com', phone: '081234567895', course: 'Japanese Beginner', level: 'Beginner', lang: 'Japanese', joinedDate: '21 Mei 2026', status: 'Active', attendance: 90, progress: 60, paymentStatus: 'Paid', avatar: 'SN', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
        { id: 7, name: 'Budi Hartono', email: 'budi.h@email.com', phone: '081234567896', course: 'Korean Beginner', level: 'Beginner', lang: 'Korean', joinedDate: '20 Mei 2026', status: 'Inactive', attendance: 75, progress: 40, paymentStatus: 'Unpaid', avatar: 'BH', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
        { id: 8, name: 'Dewi Putri', email: 'dewip@email.com', phone: '081234567897', course: 'English Beginner', level: 'Beginner', lang: 'English', joinedDate: '19 Mei 2026', status: 'Active', attendance: 96, progress: 88, paymentStatus: 'Paid', avatar: 'DP', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 9, name: 'Rahman Ali', email: 'rahman@email.com', phone: '081234567898', course: 'Japanese Intermediate', level: 'Intermediate', lang: 'Japanese', joinedDate: '18 Mei 2026', status: 'Suspended', attendance: 60, progress: 30, paymentStatus: 'Paid', avatar: 'RA', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
    ]);

    const [waitingList, setWaitingList] = React.useState([
        { id: 1, name: 'Ahmad Fauzi', email: 'ahmad@email.com', phone: '081234567890', course: 'English Intermediate', rawLanguage: 'English', date: '26 Mei 2026', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 2, name: 'Dewi Lestari', email: 'dewi@email.com', phone: '081234567891', course: 'Korean for Beginners', rawLanguage: 'Korean', date: '26 Mei 2026', avatar: 'DL', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
        { id: 3, name: 'Farhan Malik', email: 'farhan@email.com', phone: '081234567892', course: 'Japanese Intermediate', rawLanguage: 'Japanese', date: '25 Mei 2026', avatar: 'FM', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
        { id: 4, name: 'Larasati Putri', email: 'laras@email.com', phone: '081234567893', course: 'English Advanced', rawLanguage: 'English', date: '24 Mei 2026', avatar: 'LP', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 5, name: 'Rizky Pratama', email: 'rizky@email.com', phone: '081234567894', course: 'Korean Intermediate', rawLanguage: 'Korean', date: '24 Mei 2026', avatar: 'RP', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
    ]);

    const [pendingPayments, setPendingPayments] = React.useState([
        { id: 101, name: 'Budi Santoso', course: 'Japanese Intermediate', amount: 'Rp 2.300.000', rawAmount: 2300000 },
        { id: 102, name: 'Lisa Wijaya', course: 'English Intermediate', amount: 'Rp 1.800.000', rawAmount: 1800000 },
        { id: 103, name: 'Agus Susanto', course: 'Korean Beginner', amount: 'Rp 2.000.000', rawAmount: 2000000 },
    ]);

    const [recentStudents, setRecentStudents] = React.useState([
        { id: 1, name: 'Ahmad Fauzi', course: 'English Beginner', date: '22 Mei 2026', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 2, name: 'Siti Nurhaliza', course: 'Japanese Intermediate', date: '21 Mei 2026', avatar: 'SN', color: 'bg-indigo-50 text-indigo-600 border border-indigo-100/50' },
        { id: 3, name: 'Budi Hartono', course: 'Korean Beginner', date: '20 Mei 2026', avatar: 'BH', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
        { id: 4, name: 'Dewi Putri', course: 'English Advanced', date: '19 Mei 2026', avatar: 'DP', color: 'bg-emerald-50 text-emerald-600 border border-emerald-100/50' },
        { id: 5, name: 'Rahman Ali', course: 'Japanese Beginner', date: '18 Mei 2026', avatar: 'RA', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
    ]);

    // Lifted Tutors State
    const [tutors, setTutors] = React.useState([
        {
            id: 1,
            name: 'Sarah Johnson',
            desc: 'Native speaker dengan sertifikasi TESOL',
            email: 'sarah@brainy.com',
            exp: 8,
            students: 27,
            lang: 'English',
            flag: '🇬🇧',
            initials: 'SJ',
            avatarColor: 'bg-blue-50 text-blue-600 border-blue-100/50',
            classes: [
                { name: 'English for Beginners', schedule: 'Senin & Rabu, 19:00 - 20:30' },
                { name: 'English Intermediate', schedule: 'Selasa & Kamis, 19:00 - 20:30' }
            ]
        },
        {
            id: 2,
            name: 'Michael Brown',
            desc: 'Spesialis Business English dan IELTS',
            email: 'michael@brainy.com',
            exp: 6,
            students: 8,
            lang: 'English',
            flag: '🇬🇧',
            initials: 'MB',
            avatarColor: 'bg-blue-50 text-blue-600 border-blue-100/50',
            classes: [
                { name: 'English Advanced', schedule: 'Rabu & Jumat, 19:00 - 20:30' }
            ]
        },
        {
            id: 3,
            name: 'Yuki Tanaka',
            desc: 'Native speaker Japan dengan sertifikasi JLPT N1',
            email: 'yuki@brainy.com',
            exp: 10,
            students: 17,
            lang: 'Japanese',
            flag: '🇯🇵',
            initials: 'YT',
            avatarColor: 'bg-purple-50 text-purple-600 border-purple-100/50',
            classes: [
                { name: 'Japanese for Beginners', schedule: 'Senin & Rabu, 18:00 - 19:30' },
                { name: 'Japanese Intermediate', schedule: 'Selasa & Kamis, 18:00 - 19:30' }
            ]
        },
        {
            id: 4,
            name: 'Min-Ji Park',
            desc: 'Native speaker Korea dengan pengalaman mengajar internasional',
            email: 'minji@brainy.com',
            exp: 7,
            students: 23,
            lang: 'Korean',
            flag: '🇰🇷',
            initials: 'MP',
            avatarColor: 'bg-orange-50 text-orange-600 border-orange-100/50',
            classes: [
                { name: 'Korean for Beginners', schedule: 'Senin & Kamis, 19:00 - 20:30' },
                { name: 'Korean Intermediate', schedule: 'Selasa & Jumat, 19:00 - 20:30' }
            ]
        }
    ]);

    const showToast = React.useCallback((message, type = 'success') => {
        const id = Date.now();
        setToasts((prev) => [...prev, { id, message, type }]);
    }, []);

    const removeToast = React.useCallback((id) => {
        setToasts((prev) => prev.filter((toast) => toast.id !== id));
    }, []);

    return (
        <BrowserRouter>
            <div className="relative min-h-screen bg-[#F8FAFC]">
                <Routes>
                    <Route path="/admin/login" element={<LoginPage showToast={showToast} />} />
                    <Route
                        path="/admin/dashboard"
                        element={
                            <ProtectedRoute>
                                <DashboardPage
                                    showToast={showToast}
                                    totalSiswa={totalSiswa}
                                    setTotalSiswa={setTotalSiswa}
                                    pendapatan={pendapatan}
                                    setPendapatan={setPendapatan}
                                    waitingList={waitingList}
                                    pendingPayments={pendingPayments}
                                    setPendingPayments={setPendingPayments}
                                    recentStudents={recentStudents}
                                    setRecentStudents={setRecentStudents}
                                    setStudents={setStudents}
                                />
                            </ProtectedRoute>
                        }
                    />
                    <Route
                        path="/admin/waitinglist"
                        element={
                            <ProtectedRoute>
                                <WaitingListPage
                                    showToast={showToast}
                                    waitingList={waitingList}
                                    setWaitingList={setWaitingList}
                                    setTotalSiswa={setTotalSiswa}
                                    setRecentStudents={setRecentStudents}
                                    pendingPaymentsCount={pendingPayments.length}
                                    setStudents={setStudents}
                                />
                            </ProtectedRoute>
                        }
                    />
                    <Route
                        path="/admin/tutors"
                        element={
                            <ProtectedRoute>
                                <TutorsPage
                                    showToast={showToast}
                                    tutors={tutors}
                                    setTutors={setTutors}
                                    pendingPaymentsCount={pendingPayments.length}
                                    waitingListCount={waitingList.length}
                                />
                            </ProtectedRoute>
                        }
                    />
                    <Route
                        path="/admin/students"
                        element={
                            <ProtectedRoute>
                                <StudentsPage
                                    showToast={showToast}
                                    students={students}
                                    setStudents={setStudents}
                                    setTotalSiswa={setTotalSiswa}
                                    pendingPaymentsCount={pendingPayments.length}
                                    waitingListCount={waitingList.length}
                                />
                            </ProtectedRoute>
                        }
                    />
                    {/* Routing aliases */}
                    <Route
                        path="/admin/waitlist"
                        element={<Navigate to="/admin/waitinglist" replace />}
                    />
                    <Route
                        path="/admin/tutor"
                        element={<Navigate to="/admin/tutors" replace />}
                    />
                    <Route
                        path="/admin/siswa"
                        element={<Navigate to="/admin/students" replace />}
                    />
                    <Route path="*" element={<Navigate to="/admin/dashboard" replace />} />
                </Routes>

                {/* Toasts Container */}
                <div className="fixed bottom-0 right-0 z-50 p-6 flex flex-col gap-3">
                    {toasts.map((toast) => (
                        <Toast
                            key={toast.id}
                            message={toast.message}
                            type={toast.type}
                            onClose={() => removeToast(toast.id)}
                        />
                    ))}
                </div>
            </div>
        </BrowserRouter>
    );
}

// Reusable Shared Layout Component
function AdminLayout({ children, activeTab, pendingPaymentsCount, waitingListCount, showToast }) {
    const navigate = useNavigate();
    const [sidebarOpen, setSidebarOpen] = React.useState(false);

    function handleLogout() {
        localStorage.removeItem(AUTH_KEY);
        showToast('Anda telah keluar dari sistem admin.', 'info');
        setTimeout(() => {
            window.location.href = '/logout';
        }, 500);
    }

    const navItems = [
        { id: 'dashboard', label: 'Dashboard', icon: Home, path: '/admin/dashboard' },
        { id: 'kursus', label: 'Kelola Kursus', icon: GraduationCap },
        { id: 'pembayaran', label: 'Pembayaran', icon: DollarSign, badge: pendingPaymentsCount },
        { id: 'waitinglist', label: 'Waiting List', icon: ClipboardList, badge: waitingListCount, path: '/admin/waitinglist' },
        { id: 'tutor', label: 'Kelola Tutor', icon: UserCheck, path: '/admin/tutors' },
        { id: 'jadwal', label: 'Jadwal Kelas', icon: CalendarDays },
        { id: 'siswa', label: 'Data Siswa', icon: Users, path: '/admin/students' },
    ];

    const handleNavItemClick = (item) => {
        if (item.path) {
            navigate(item.path);
        } else {
            showToast(`Halaman ${item.label} sedang dikembangkan.`, 'info');
        }
        setSidebarOpen(false);
    };

    return (
        <div className="min-h-screen bg-[#F8FAFC] flex text-slate-800 font-sans">
            {/* Sidebar Navigation */}
            <aside className={`fixed inset-y-0 left-0 z-40 w-64 border-r border-slate-200/80 bg-white px-5 py-6 transition-transform lg:translate-x-0 ${sidebarOpen ? 'translate-x-0' : '-translate-x-full'} lg:static lg:shrink-0`}>
                <div className="flex items-center justify-between mb-8">
                    <div className="flex items-center gap-3">
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/10">
                            <BookOpen className="h-5 w-5" strokeWidth={2.2} />
                        </div>
                        <span className="text-lg font-bold tracking-tight text-slate-900">Brainy <span className="text-blue-600">Admin</span></span>
                    </div>
                    <button onClick={() => setSidebarOpen(false)} className="lg:hidden text-slate-400 hover:text-slate-600">
                        <X className="h-5 w-5" />
                    </button>
                </div>

                <nav className="space-y-1">
                    <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 block mb-2">Menu Utama</span>
                    {navItems.map((item) => {
                        const Icon = item.icon;
                        const isActive = activeTab === item.id;
                        return (
                            <button
                                key={item.id}
                                onClick={() => handleNavItemClick(item)}
                                className={`flex group w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 ${
                                    isActive
                                        ? 'bg-blue-50/80 text-blue-600'
                                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                                }`}
                            >
                                <div className="flex items-center gap-3">
                                    <Icon className={`h-5 w-5 transition-transform duration-200 group-hover:scale-110 ${isActive ? 'text-blue-600' : 'text-slate-400'}`} />
                                    <span>{item.label}</span>
                                </div>
                                {item.badge ? (
                                    <span className={`rounded-full px-2 py-0.5 text-xs font-bold ${isActive ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600'}`}>
                                        {item.badge}
                                    </span>
                                ) : null}
                            </button>
                        );
                    })}
                </nav>

                <div className="absolute bottom-6 left-5 right-5 border-t border-slate-100 pt-5 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-sm shadow-sm shadow-blue-500/10">
                            AD
                        </div>
                        <div className="min-w-0">
                            <p className="text-sm font-bold text-slate-900 truncate">Administrator</p>
                            <p className="text-xs text-slate-400 truncate">admin@brainy.com</p>
                        </div>
                    </div>
                </div>
            </aside>

            {/* Mobile Sidebar Overlay */}
            {sidebarOpen && (
                <div
                    onClick={() => setSidebarOpen(false)}
                    className="fixed inset-0 z-30 bg-slate-900/25 backdrop-blur-sm lg:hidden"
                />
            )}

            {/* Main Area */}
            <div className="flex-1 flex flex-col min-w-0">
                {/* Top Header */}
                <header className="sticky top-0 z-20 border-b border-slate-200/60 bg-[#F8FAFC]/95 backdrop-blur-md px-6 py-4 flex items-center justify-between gap-4">
                    <div className="flex items-center gap-3">
                        <button
                            onClick={() => setSidebarOpen(true)}
                            className="lg:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-950"
                        >
                            <Menu className="h-6 w-6" />
                        </button>
                        <div>
                            <h1 className="text-xl font-extrabold text-slate-900 tracking-tight">
                                {activeTab === 'dashboard' 
                                    ? 'Dasbor Ringkasan' 
                                    : activeTab === 'waitinglist' 
                                        ? 'Daftar Tunggu (Waiting List)' 
                                        : activeTab === 'tutor' 
                                            ? 'Direktori Pengajar (Tutors)' 
                                            : 'Data Siswa (Students)'}
                            </h1>
                            <p className="hidden sm:block text-xs text-slate-400 font-medium mt-0.5">
                                {activeTab === 'dashboard' 
                                    ? 'Pantau parameter operasional lembaga bahasa asing Brainy.' 
                                    : activeTab === 'waitinglist' 
                                        ? 'Kelola antrean kelas siswa karena keterbatasan kapasitas ruangan.' 
                                        : activeTab === 'tutor' 
                                            ? 'Kelola kualifikasi, profil mengajar, dan jadwal kelas para tutor.' 
                                            : 'Kelola data pribadi, status akademis, dan perkembangan kursus siswa.'}
                            </p>
                        </div>
                    </div>

                    <div className="flex items-center gap-4">
                        <div className="hidden sm:relative max-w-xs">
                            <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <Search className="h-4 w-4" />
                            </span>
                            <input
                                type="text"
                                placeholder="Cari data..."
                                className="h-9 w-60 rounded-xl border border-slate-200 bg-white pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500"
                            />
                        </div>

                        <a
                            href="/"
                            className="inline-flex h-9 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 active:scale-[0.98]"
                        >
                            <Home className="h-4 w-4" />
                            Home
                        </a>

                        <button
                            onClick={handleLogout}
                            className="inline-flex h-9 items-center gap-2 rounded-xl bg-slate-900 px-4 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800 active:scale-[0.98]"
                        >
                            <LogOut className="h-4 w-4" />
                            Logout
                        </button>
                    </div>
                </header>

                <main className="flex-1 p-6 space-y-6 max-w-[1600px] w-full mx-auto animate-scale-in">
                    {children}
                </main>

                <footer className="border-t border-slate-200/50 bg-white py-4 text-center text-[10px] text-slate-400 mt-10">
                    &copy; 2026 Brainy Language Institute Portal Admin. Hak cipta dilindungi.
                </footer>
            </div>
        </div>
    );
}

function LoginPage({ showToast }) {
    const navigate = useNavigate();
    const [email, setEmail] = React.useState('');
    const [password, setPassword] = React.useState('');
    const [error, setError] = React.useState('');
    const [isLoading, setIsLoading] = React.useState(false);

    React.useEffect(() => {
        if (isAdminAuthenticated()) {
            navigate('/admin/dashboard', { replace: true });
        }
    }, [navigate]);

    function handleSubmit(event) {
        event.preventDefault();
        setIsLoading(true);
        setError('');

        setTimeout(() => {
            if (email === ADMIN_EMAIL && password === ADMIN_PASSWORD) {
                localStorage.setItem(AUTH_KEY, 'true');
                showToast('Login berhasil! Selamat datang di dashboard admin.', 'success');
                navigate('/admin/dashboard', { replace: true });
            } else {
                setError('Email atau password admin tidak sesuai.');
                showToast('Gagal masuk. Periksa kembali kredensial Anda.', 'info');
                setIsLoading(false);
            }
        }, 800);
    }

    return (
        <div className="flex min-h-screen bg-white text-slate-900 font-sans">
            {/* Left Side: Form */}
            <div className="flex w-full flex-col justify-between px-6 py-10 lg:w-[45%] lg:px-16 xl:px-24">
                <div className="flex items-center gap-3">
                    <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/20">
                        <BookOpen className="h-6 w-6" strokeWidth={2.2} />
                    </div>
                    <span className="text-xl font-bold tracking-tight text-slate-900">Brainy <span className="text-blue-600">Admin</span></span>
                </div>

                <div className="my-auto py-12">
                    <div className="mb-8">
                        <h1 className="text-3xl font-extrabold tracking-tight text-slate-900">Masuk Dasbor</h1>
                        <p className="mt-2 text-sm text-slate-500">Kelola pendaftaran, pembayaran, dan aktivitas belajar bahasa asing.</p>
                    </div>

                    {error && (
                        <div className="mb-6 flex gap-3 rounded-xl border border-red-100 bg-red-50 p-4 text-sm font-medium text-red-700 animate-shake">
                            <ShieldAlert className="h-5 w-5 shrink-0 text-red-500" />
                            <span>{error}</span>
                        </div>
                    )}

                    <form className="space-y-6" onSubmit={handleSubmit}>
                        <div>
                            <label className="block text-sm font-semibold text-slate-700 mb-2">Email Admin</label>
                            <div className="relative">
                                <span className="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <Mail className="h-5 w-5" />
                                </span>
                                <input
                                    type="email"
                                    value={email}
                                    onChange={(event) => setEmail(event.target.value)}
                                    placeholder="admin@brainy.com"
                                    className="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-11 pr-4 text-sm font-medium outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100/50"
                                    required
                                />
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                            <div className="relative">
                                <span className="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <Lock className="h-5 w-5" />
                                </span>
                                <input
                                    type="password"
                                    value={password}
                                    onChange={(event) => setPassword(event.target.value)}
                                    placeholder="••••••••"
                                    className="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-11 pr-4 text-sm font-medium outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100/50"
                                    required
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            disabled={isLoading}
                            className="flex h-12 w-full items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition-all hover:bg-blue-700 hover:shadow-blue-600/30 active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            {isLoading ? (
                                <div className="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent" />
                            ) : (
                                'Masuk sebagai Admin'
                            )}
                        </button>
                    </form>
                </div>

                <div className="text-xs text-slate-400">
                    &copy; 2026 Brainy Language Platform. Hak cipta dilindungi.
                </div>
            </div>

            {/* Right Side: Graphic Panel */}
            <div className="hidden lg:flex w-[55%] flex-col justify-between bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-950 p-16 text-white relative overflow-hidden">
                <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
                <div className="absolute -top-40 -right-40 h-[600px] w-[600px] rounded-full bg-blue-500/20 blur-3xl"></div>
                <div className="absolute -bottom-45 -left-40 h-[600px] w-[600px] rounded-full bg-indigo-500/25 blur-3xl"></div>

                <div className="z-10 flex items-center justify-end">
                    <span className="rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold backdrop-blur-md border border-white/10">v1.2.0 Stable</span>
                </div>

                <div className="z-10 my-auto max-w-lg space-y-6">
                    <h2 className="text-4xl font-extrabold leading-tight tracking-tight">Satu Dasbor untuk Mengelola Seluruh Kelas Bahasa.</h2>
                    <p className="text-lg text-blue-100 font-light">Pantau aktivitas pendaftaran siswa secara real-time, validasi transaksi pembayaran secara aman, dan atur ketersediaan jadwal tutor dalam satu platform.</p>

                    <div className="mt-8 rounded-2xl border border-white/10 bg-white/10 p-6 backdrop-blur-lg">
                        <div className="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                            <span className="text-xs font-semibold uppercase tracking-wider text-blue-200">Aktivitas Hari Ini</span>
                            <span className="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <p className="text-xs text-blue-200">Siswa Baru Terdaftar</p>
                                <p className="text-2xl font-bold mt-1">+12 Siswa</p>
                            </div>
                            <div>
                                <p className="text-xs text-blue-200">Menunggu Konfirmasi</p>
                                <p className="text-2xl font-bold mt-1 text-amber-300">3 Pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="z-10 flex items-center justify-between text-sm text-blue-200">
                    <span>Kemudahan Operasional Kursus</span>
                    <a href="/" className="hover:underline hover:text-white transition">Halaman Utama &rarr;</a>
                </div>
            </div>
        </div>
    );
}

function DashboardPage({
    showToast,
    totalSiswa,
    setTotalSiswa,
    pendapatan,
    setPendapatan,
    waitingList,
    pendingPayments,
    setPendingPayments,
    recentStudents,
    setRecentStudents,
    setStudents
}) {
    const [sidebarOpen, setSidebarOpen] = React.useState(false);

    function handleConfirmPayment(paymentId) {
        const payment = pendingPayments.find(p => p.id === paymentId);
        if (!payment) return;

        setPendingPayments(prev => prev.filter(p => p.id !== paymentId));

        const initials = payment.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        const colors = ['bg-blue-50 text-blue-600 border border-blue-100/50', 'bg-emerald-50 text-emerald-600 border border-emerald-100/50', 'bg-indigo-50 text-indigo-600 border border-indigo-100/50'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        
        const newStudent = {
            id: Date.now(),
            name: payment.name,
            course: payment.course,
            date: 'Hari Ini',
            avatar: initials,
            color: randomColor
        };

        setRecentStudents(prev => [newStudent, ...prev.slice(0, 4)]);
        setTotalSiswa(prev => prev + 1);
        setPendapatan(prev => prev + payment.rawAmount);

        // Synchronize with main students state
        if (setStudents) {
            const newFullStudent = {
                id: newStudent.id,
                name: newStudent.name,
                email: `${newStudent.name.toLowerCase().replace(/\s+/g, '')}@email.com`,
                phone: '081234567899',
                course: newStudent.course,
                level: newStudent.course.toLowerCase().includes('begin') ? 'Beginner' : newStudent.course.toLowerCase().includes('adv') ? 'Advanced' : 'Intermediate',
                lang: newStudent.course.toLowerCase().includes('english') ? 'English' : newStudent.course.toLowerCase().includes('japan') ? 'Japanese' : 'Korean',
                joinedDate: 'Hari Ini',
                status: 'Active',
                attendance: 100,
                progress: 0,
                paymentStatus: 'Paid',
                avatar: initials,
                color: randomColor
            };
            setStudents(prev => [newFullStudent, ...prev]);
        }

        showToast(`Pembayaran ${payment.name} (${payment.amount}) berhasil dikonfirmasi!`, 'success');
    }

    const formatCurrency = (val) => {
        return 'Rp ' + (val / 1000000).toFixed(1) + 'M';
    };

    return (
        <AdminLayout
            activeTab="dashboard"
            pendingPaymentsCount={pendingPayments.length}
            waitingListCount={waitingList.length}
            showToast={showToast}
            sidebarOpen={sidebarOpen}
            setSidebarOpen={setSidebarOpen}
        >
            {/* Compact Greeting Banner & Dynamic Calendar widget */}
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-sm">
                <div className="max-w-xl">
                    <div className="flex items-center gap-2">
                        <span className="flex h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <span className="rounded-full bg-blue-50 px-2.5 py-0.5 text-[11px] font-bold text-blue-600 border border-blue-100/30">Laporan Lembaga</span>
                    </div>
                    <h2 className="text-xl font-extrabold text-slate-900 tracking-tight mt-2">Selamat Datang Kembali, Admin!</h2>
                    <p className="text-xs text-slate-500 mt-1 leading-relaxed">Kelola pendaftaran siswa, verifikasi pembayaran tertunda, dan pantau operasional kelas bahasa secara terpusat.</p>
                </div>
                <div className="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/50 px-4 py-2.5 text-xs font-bold text-slate-600 w-max shadow-inner">
                    <CalendarDays className="h-4.5 w-4.5 text-blue-600" />
                    <span>{new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</span>
                </div>
            </div>

            {/* Stats Widget Row - FORCED horizontal layout in single row on desktop and tablet */}
            <section className="grid gap-5 grid-cols-1 md:grid-cols-4">
                {/* Stat Card 1: Total Siswa */}
                <article className="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div className="flex justify-between items-start">
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Siswa</p>
                            <p className="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">{totalSiswa}</p>
                        </div>
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100/30">
                            <Users className="h-5 w-5" />
                        </div>
                    </div>
                    <div className="mt-4 flex items-center justify-between gap-2">
                        <div className="flex items-center gap-1 text-[10px] text-emerald-600 font-extrabold bg-emerald-50 border border-emerald-100/30 rounded-lg px-2 py-0.5">
                            <TrendingUp className="h-3 w-3" />
                            <span>+12</span>
                        </div>
                        <Sparkline points={[220, 225, 230, 238, 242, totalSiswa]} color="text-blue-500" />
                    </div>
                </article>

                {/* Stat Card 2: Kelas Aktif */}
                <article className="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div className="flex justify-between items-start">
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kelas Aktif</p>
                            <p className="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">12</p>
                        </div>
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 border border-violet-100/30">
                            <GraduationCap className="h-5 w-5" />
                        </div>
                    </div>
                    <div className="mt-4 flex items-center justify-between gap-2">
                        <span className="text-[10px] text-violet-600 font-extrabold bg-violet-50 border border-violet-100/30 rounded-lg px-2 py-0.5">
                            7 bahasa
                        </span>
                        <Sparkline points={[8, 9, 10, 10, 11, 12]} color="text-violet-500" />
                    </div>
                </article>

                {/* Stat Card 3: Pendapatan */}
                <article className="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div className="flex justify-between items-start">
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pendapatan</p>
                            <p className="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">{formatCurrency(pendapatan)}</p>
                        </div>
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/30">
                            <DollarSign className="h-5 w-5" />
                        </div>
                    </div>
                    <div className="mt-4 flex items-center justify-between gap-2">
                        <div className="flex items-center gap-1 text-[10px] text-emerald-600 font-extrabold bg-emerald-50 border border-emerald-100/30 rounded-lg px-2 py-0.5">
                            <TrendingUp className="h-3 w-3" />
                            <span>+18%</span>
                        </div>
                        <Sparkline points={[30, 32, 35, 38, 42, pendapatan / 1000000]} color="text-emerald-500" />
                    </div>
                </article>

                {/* Stat Card 4: Waiting List */}
                <article className="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div className="flex justify-between items-start">
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Waiting List</p>
                            <p className="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">{waitingList.length}</p>
                        </div>
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 border border-orange-100/30">
                            <ClipboardList className="h-5 w-5" />
                        </div>
                    </div>
                    <div className="mt-4 flex items-center justify-between gap-2">
                        <span className="text-[10px] text-orange-600 font-extrabold bg-orange-50 border border-orange-100/30 rounded-lg px-2 py-0.5">
                            Tindak lanjut
                        </span>
                        <Sparkline points={[15, 18, 22, 28, 25, waitingList.length]} color="text-orange-500" />
                    </div>
                </article>
            </section>

            {/* Quick Access Menu Cards */}
            <section>
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-sm font-bold text-slate-900">Menu Administrasi Cepat</h2>
                </div>
                <div className="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    {[
                        { title: 'Kelola Kursus', desc: 'Tambah, edit, dan hapus kurikulum bahasa.', icon: GraduationCap, id: 'kursus' },
                        { title: 'Pembayaran', desc: 'Verifikasi & pantau mutasi invoice pendaftaran.', icon: DollarSign, id: 'pembayaran' },
                        { title: 'Waiting List', desc: 'Kelola alokasi kelas pendaftaran penuh.', icon: ClipboardList, id: 'waitinglist', path: '/admin/waitinglist' },
                        { title: 'Kelola Tutor', desc: 'Atur penugasan dan ketersediaan mengajar.', icon: UserCheck, id: 'tutor', path: '/admin/tutors' },
                        { title: 'Jadwal Kelas', desc: 'Atur pemetaan ruangan dan waktu belajar.', icon: CalendarDays, id: 'jadwal' },
                        { title: 'Data Siswa', desc: 'Direktori komprehensif profil & status siswa.', icon: Users, id: 'siswa' },
                    ].map((item) => {
                        const Icon = item.icon;
                        const navigate = useNavigate();
                        return (
                            <button
                                key={item.title}
                                onClick={() => {
                                    if (item.path) {
                                        navigate(item.path);
                                    } else {
                                        showToast(`Halaman ${item.title} sedang dikembangkan.`, 'info');
                                    }
                                }}
                                className="group relative text-left rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500"
                            >
                                <div className="flex justify-between items-start">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                                        <Icon className="h-5 w-5" />
                                    </div>
                                    <span className="text-slate-300 transition-transform group-hover:translate-x-1"><ChevronRight className="h-4 w-4" /></span>
                                </div>
                                <h3 className="mt-4 text-xs font-bold text-slate-900">{item.title}</h3>
                                <p className="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">{item.desc}</p>
                            </button>
                        );
                    })}
                </div>
            </section>

            {/* Operational Tables Section */}
            <section className="grid gap-5 xl:grid-cols-12">
                {/* Recent Registrations Table */}
                <div className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm xl:col-span-7 flex flex-col justify-between">
                    <div>
                        <div className="flex justify-between items-start pb-3.5 border-b border-slate-100">
                            <div>
                                <h2 className="text-sm font-bold text-slate-900">Pendaftaran Terbaru</h2>
                                <p className="text-[11px] text-slate-500 mt-0.5">Daftar pendaftaran siswa paling mutakhir.</p>
                            </div>
                        </div>
                        <div className="mt-3 divide-y divide-slate-100">
                            {recentStudents.map((student) => (
                                <div key={student.id} className="flex items-center gap-3.5 py-3 first:pt-0 last:pb-0 group">
                                    <div className={`flex h-9 w-9 shrink-0 items-center justify-center rounded-xl font-bold text-xs ${student.color}`}>
                                        {student.avatar}
                                    </div>
                                    <div className="min-w-0 flex-1">
                                        <p className="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{student.name}</p>
                                        <p className="text-[10px] text-slate-500 mt-0.5">{student.course}</p>
                                    </div>
                                    <div className="text-right">
                                        <p className="text-[10px] text-slate-400 font-semibold">{student.date}</p>
                                        <span className="inline-block mt-1 text-[9px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100/50 rounded-full px-2 py-0.5">
                                            Aktif
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Pending Payments Table */}
                <div className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm xl:col-span-5 flex flex-col justify-between">
                    <div>
                        <div className="flex justify-between items-start pb-3.5 border-b border-slate-100">
                            <div>
                                <h2 className="text-sm font-bold text-slate-900">Pembayaran Pending</h2>
                                <p className="text-[11px] text-slate-500 mt-0.5">Validasi struk transaksi pendaftaran.</p>
                            </div>
                            <span className="rounded-full bg-amber-50 border border-amber-100/50 px-2 py-0.5 text-[10px] font-bold text-amber-600">
                                {pendingPayments.length} Pending
                            </span>
                        </div>

                        <div className="mt-3 divide-y divide-slate-100">
                            {pendingPayments.length === 0 ? (
                                <div className="py-12 text-center text-slate-400 space-y-2">
                                    <div className="flex justify-center text-emerald-500">
                                        <Check className="h-8 w-8 rounded-full bg-emerald-50 p-1 border border-emerald-100" />
                                    </div>
                                    <p className="text-xs font-semibold">Semua Pembayaran Selesai divalidasi!</p>
                                </div>
                            ) : (
                                pendingPayments.map((payment) => (
                                    <div key={payment.id} className="flex items-center gap-4 py-3.5 first:pt-0 last:pb-0">
                                        <div className="min-w-0 flex-1">
                                            <p className="text-xs font-bold text-slate-900">{payment.name}</p>
                                            <p className="text-[10px] text-slate-500 mt-0.5">{payment.course}</p>
                                            <p className="text-xs font-extrabold text-blue-600 mt-1">{payment.amount}</p>
                                        </div>
                                        <button
                                            onClick={() => handleConfirmPayment(payment.id)}
                                            className="inline-flex h-8 items-center justify-center rounded-xl bg-blue-600 px-4.5 text-[11px] font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.97] hover:shadow-md"
                                        >
                                            Konfirmasi
                                        </button>
                                    </div>
                                ))
                            )}
                        </div>
                    </div>
                </div>
            </section>
        </AdminLayout>
    );
}

// Brand New Premium, Minimalist, Clean Waiting List Page
function WaitingListPage({
    showToast,
    waitingList,
    setWaitingList,
    setTotalSiswa,
    setRecentStudents,
    pendingPaymentsCount,
    setStudents
}) {
    const [sidebarOpen, setSidebarOpen] = React.useState(false);
    const [searchQuery, setSearchQuery] = React.useState('');
    const [filterLang, setFilterLang] = React.useState('All');

    function handleAcceptStudent(studentId) {
        const student = waitingList.find(s => s.id === studentId);
        if (!student) return;

        setWaitingList(prev => prev.filter(s => s.id !== studentId));

        const newStudent = {
            id: Date.now(),
            name: student.name,
            course: student.course,
            date: 'Hari Ini',
            avatar: student.avatar,
            color: student.color
        };

        setRecentStudents(prev => [newStudent, ...prev.slice(0, 4)]);
        setTotalSiswa(prev => prev + 1);

        // Synchronize with main students state
        if (setStudents) {
            const newFullStudent = {
                id: newStudent.id,
                name: student.name,
                email: student.email,
                phone: student.phone,
                course: student.course,
                level: student.course.toLowerCase().includes('begin') ? 'Beginner' : student.course.toLowerCase().includes('adv') ? 'Advanced' : 'Intermediate',
                lang: student.rawLanguage,
                joinedDate: 'Hari Ini',
                status: 'Active',
                attendance: 100,
                progress: 0,
                paymentStatus: 'Paid',
                avatar: student.avatar,
                color: student.color
            };
            setStudents(prev => [newFullStudent, ...prev]);
        }

        showToast(`Siswa ${student.name} berhasil diterima masuk kelas ${student.course}!`, 'success');
    }

    function handleRejectStudent(studentId) {
        const student = waitingList.find(s => s.id === studentId);
        if (!student) return;

        setWaitingList(prev => prev.filter(s => s.id !== studentId));
        showToast(`Antrean daftar tunggu untuk ${student.name} telah dibatalkan.`, 'info');
    }

    const filteredList = waitingList.filter(student => {
        const matchesSearch = student.name.toLowerCase().includes(searchQuery.toLowerCase()) || 
                              student.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
                              student.phone.includes(searchQuery) ||
                              student.course.toLowerCase().includes(searchQuery.toLowerCase());
        
        const matchesLang = filterLang === 'All' || student.rawLanguage === filterLang;
        
        return matchesSearch && matchesLang;
    });

    const getLanguageColor = (lang) => {
        switch (lang) {
            case 'English':
                return 'bg-blue-50 text-blue-700 border-blue-100/50';
            case 'Japanese':
                return 'bg-purple-50 text-purple-700 border-purple-100/50';
            case 'Korean':
                return 'bg-orange-50 text-orange-700 border-orange-100/50';
            default:
                return 'bg-slate-50 text-slate-700 border-slate-100';
        }
    };

    return (
        <AdminLayout
            activeTab="waitinglist"
            pendingPaymentsCount={pendingPaymentsCount}
            waitingListCount={waitingList.length}
            showToast={showToast}
            sidebarOpen={sidebarOpen}
            setSidebarOpen={setSidebarOpen}
        >
            {/* Clean Stats highlights for Waiting List */}
            <section className="grid gap-5 grid-cols-1 sm:grid-cols-3">
                <article className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                    <div className="flex items-center gap-3">
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 border border-orange-100/30">
                            <ClipboardList className="h-5 w-5" />
                        </div>
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Antrean</p>
                            <p className="text-xl font-extrabold text-slate-900 mt-0.5">{waitingList.length} Siswa</p>
                        </div>
                    </div>
                </article>
                <article className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                    <div className="flex items-center gap-3">
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100/30">
                            <GraduationCap className="h-5 w-5" />
                        </div>
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kursus Terpadat</p>
                            <p className="text-xl font-extrabold text-slate-900 mt-0.5">English (12 siswa)</p>
                        </div>
                    </div>
                </article>
                <article className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                    <div className="flex items-center gap-3">
                        <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/30">
                            <Clock className="h-5 w-5" />
                        </div>
                        <div>
                            <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-rata Waktu Tunggu</p>
                            <p className="text-xl font-extrabold text-slate-900 mt-0.5">4.2 Hari</p>
                        </div>
                    </div>
                </article>
            </section>

            {/* Waiting List Core Panel */}
            <section className="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden">
                <div className="p-5 border-b border-slate-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div className="flex items-center gap-1.5 p-1 bg-slate-50 border border-slate-200/50 rounded-xl w-max">
                        {['All', 'English', 'Japanese', 'Korean'].map((lang) => (
                            <button
                                key={lang}
                                onClick={() => setFilterLang(lang)}
                                className={`px-4 py-1.5 rounded-lg text-xs font-bold transition-all ${
                                    filterLang === lang
                                        ? 'bg-white text-blue-600 shadow-sm border border-slate-200/20'
                                        : 'text-slate-500 hover:text-slate-900'
                                }`}
                            >
                                {lang}
                            </button>
                        ))}
                    </div>

                    <div className="relative max-w-sm w-full sm:w-64">
                        <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <Search className="h-4 w-4" />
                        </span>
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            placeholder="Cari nama, email, kursus..."
                            className="h-9 w-full rounded-xl border border-slate-200 pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white"
                        />
                    </div>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-left border-collapse">
                        <thead>
                            <tr className="border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th className="px-6 py-4">Nama Siswa</th>
                                <th className="px-6 py-4">Kontak</th>
                                <th className="px-6 py-4">Kursus</th>
                                <th className="px-6 py-4">Tanggal Masuk</th>
                                <th className="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 text-slate-700">
                            {filteredList.length === 0 ? (
                                <tr>
                                    <td colSpan="5" className="px-6 py-12 text-center text-slate-400">
                                        <div className="flex justify-center mb-3">
                                            <ClipboardList className="h-8 w-8 text-slate-300" />
                                        </div>
                                        <p className="text-xs font-semibold">Tidak ada siswa yang menunggu dalam daftar.</p>
                                    </td>
                                </tr>
                            ) : (
                                filteredList.map((student) => (
                                    <tr key={student.id} className="transition hover:bg-slate-50/30 group">
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className={`flex h-9 w-9 shrink-0 items-center justify-center rounded-xl font-bold text-xs ${student.color}`}>
                                                    {student.avatar}
                                                </div>
                                                <p className="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{student.name}</p>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="space-y-0.5">
                                                <p className="text-xs text-slate-700 flex items-center gap-1.5"><Mail className="h-3.5 w-3.5 text-slate-400" />{student.email}</p>
                                                <p className="text-[10px] text-slate-400 flex items-center gap-1.5"><Phone className="h-3.5 w-3.5 text-slate-400" />{student.phone}</p>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`inline-block rounded-full border px-2.5 py-0.5 text-[10px] font-bold ${getLanguageColor(student.rawLanguage)}`}>
                                                {student.course}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                                <CalendarDays className="h-4 w-4 text-slate-400" />
                                                <span>{student.date}</span>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            <div className="flex items-center justify-end gap-2">
                                                <button
                                                    onClick={() => handleAcceptStudent(student.id)}
                                                    className="inline-flex h-8 items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 text-xs font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.97]"
                                                >
                                                    <UserPlus className="h-3.5 w-3.5" />
                                                    Terima
                                                </button>
                                                <button
                                                    onClick={() => handleRejectStudent(student.id)}
                                                    className="inline-flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition active:scale-[0.95]"
                                                    title="Tolak"
                                                >
                                                    <X className="h-4.5 w-4.5" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </section>
        </AdminLayout>
    );
}

// Brand New Premium, Minimalist, Clean Tutors Directory Page
function TutorsPage({
    showToast,
    tutors,
    setTutors,
    pendingPaymentsCount,
    waitingListCount
}) {
    const [sidebarOpen, setSidebarOpen] = React.useState(false);
    const [searchQuery, setSearchQuery] = React.useState('');
    const [filterLang, setFilterLang] = React.useState('All');
    
    // Modal states: 'add' | 'edit' | 'schedule' | null
    const [activeModal, setActiveModal] = React.useState(null);
    const [selectedTutorId, setSelectedTutorId] = React.useState(null);

    // Form inputs state
    const [formName, setFormName] = React.useState('');
    const [formEmail, setFormEmail] = React.useState('');
    const [formDesc, setFormDesc] = React.useState('');
    const [formLang, setFormLang] = React.useState('English');
    const [formExp, setFormExp] = React.useState('');
    
    // Class Scheduling temporary state
    const [tempClasses, setTempClasses] = React.useState([]);
    const [newClassName, setNewClassName] = React.useState('English for Beginners');
    const [newClassSchedule, setNewClassSchedule] = React.useState('');

    // Open add tutor modal
    const openAddModal = () => {
        setFormName('');
        setFormEmail('');
        setFormDesc('');
        setFormLang('English');
        setFormExp('');
        setActiveModal('add');
    };

    // Open edit profile modal
    const openEditModal = (tutor) => {
        setSelectedTutorId(tutor.id);
        setFormName(tutor.name);
        setFormEmail(tutor.email);
        setFormDesc(tutor.desc);
        setFormLang(tutor.lang);
        setFormExp(tutor.exp.toString());
        setActiveModal('edit');
    };

    // Open schedule modal
    const openScheduleModal = (tutor) => {
        setSelectedTutorId(tutor.id);
        setTempClasses([...tutor.classes]);
        // Set class select option matching specialization
        const defaultClass = tutor.lang === 'English' 
            ? 'English for Beginners' 
            : tutor.lang === 'Japanese' 
                ? 'Japanese for Beginners' 
                : 'Korean for Beginners';
        setNewClassName(defaultClass);
        setNewClassSchedule('');
        setActiveModal('schedule');
    };

    // Save added tutor
    function handleSaveAddTutor(e) {
        e.preventDefault();
        const flag = formLang === 'English' ? '🇬🇧' : formLang === 'Japanese' ? '🇯🇵' : '🇰🇷';
        const initials = formName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        
        const colors = [
            'bg-blue-50 text-blue-600 border-blue-100/50',
            'bg-purple-50 text-purple-600 border-purple-100/50',
            'bg-orange-50 text-orange-600 border-orange-100/50'
        ];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];

        const newTutor = {
            id: Date.now(),
            name: formName,
            desc: formDesc,
            email: formEmail,
            exp: parseInt(formExp) || 1,
            students: 0,
            lang: formLang,
            flag: flag,
            initials: initials,
            avatarColor: randomColor,
            classes: []
        };

        setTutors(prev => [newTutor, ...prev]);
        showToast(`Tutor ${formName} berhasil didaftarkan!`, 'success');
        setActiveModal(null);
    }

    // Save edited tutor profile info
    function handleSaveEditTutor(e) {
        e.preventDefault();
        const flag = formLang === 'English' ? '🇬🇧' : formLang === 'Japanese' ? '🇯🇵' : '🇰🇷';
        const initials = formName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();

        setTutors(prev => prev.map(tutor => {
            if (tutor.id === selectedTutorId) {
                return {
                    ...tutor,
                    name: formName,
                    email: formEmail,
                    desc: formDesc,
                    lang: formLang,
                    flag: flag,
                    initials: initials,
                    exp: parseInt(formExp) || tutor.exp
                };
            }
            return tutor;
        }));

        showToast(`Profil ${formName} berhasil diperbarui!`, 'success');
        setActiveModal(null);
    }

    // Add class locally inside temporary classes state
    function handleAddTempClass(e) {
        e.preventDefault();
        if (!newClassSchedule.trim()) {
            showToast('Jadwal mengajar tidak boleh kosong.', 'info');
            return;
        }

        const newClass = {
            name: newClassName,
            schedule: newClassSchedule
        };

        setTempClasses(prev => [...prev, newClass]);
        setNewClassSchedule(''); // Reset only the schedule field
    }

    // Remove class from temporary classes state
    function handleRemoveTempClass(idxToRemove) {
        setTempClasses(prev => prev.filter((_, idx) => idx !== idxToRemove));
    }

    // Save all changes in the tutor's classes and schedules
    function handleSaveSchedule() {
        setTutors(prev => prev.map(tutor => {
            if (tutor.id === selectedTutorId) {
                return {
                    ...tutor,
                    classes: tempClasses
                };
            }
            return tutor;
        }));

        const tutor = tutors.find(t => t.id === selectedTutorId);
        showToast(`Jadwal mengajar tutor ${tutor?.name || ''} berhasil disimpan!`, 'success');
        setActiveModal(null);
    }

    const filteredTutors = tutors.filter(tutor => {
        const matchesSearch = tutor.name.toLowerCase().includes(searchQuery.toLowerCase()) || 
                              tutor.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
                              tutor.desc.toLowerCase().includes(searchQuery.toLowerCase());
        
        const matchesLang = filterLang === 'All' || tutor.lang === filterLang;
        
        return matchesSearch && matchesLang;
    });

    const getLangBadgeStyle = (lang) => {
        switch (lang) {
            case 'English':
                return 'bg-blue-50 text-blue-700 border-blue-100/50';
            case 'Japanese':
                return 'bg-purple-50 text-purple-700 border-purple-100/50';
            case 'Korean':
                return 'bg-orange-50 text-orange-700 border-orange-100/50';
            default:
                return 'bg-slate-50 text-slate-700 border-slate-100';
        }
    };

    const currentTutorForModal = tutors.find(t => t.id === selectedTutorId);

    return (
        <AdminLayout
            activeTab="tutor"
            pendingPaymentsCount={pendingPaymentsCount}
            waitingListCount={waitingListCount}
            showToast={showToast}
            sidebarOpen={sidebarOpen}
            setSidebarOpen={setSidebarOpen}
        >
            {/* Header action panel */}
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div className="flex items-center gap-1.5 p-1 bg-slate-50 border border-slate-200/50 rounded-xl w-max">
                    {['All', 'English', 'Japanese', 'Korean'].map((lang) => (
                        <button
                            key={lang}
                            onClick={() => setFilterLang(lang)}
                            className={`px-4 py-1.5 rounded-lg text-xs font-bold transition-all ${
                                filterLang === lang
                                    ? 'bg-white text-blue-600 shadow-sm border border-slate-200/20'
                                    : 'text-slate-500 hover:text-slate-900'
                            }`}
                        >
                            {lang}
                        </button>
                    ))}
                </div>

                <div className="flex items-center gap-3 w-full sm:w-auto">
                    <div className="relative flex-1 sm:w-60">
                        <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <Search className="h-4 w-4" />
                        </span>
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            placeholder="Cari tutor, email, sertifikasi..."
                            className="h-9 w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500"
                        />
                    </div>
                    <button
                        onClick={openAddModal}
                        className="inline-flex h-9 items-center gap-2 rounded-xl bg-blue-600 px-4 text-xs font-bold text-white shadow-md shadow-blue-500/10 transition hover:bg-blue-700 active:scale-[0.98]"
                    >
                        <Plus className="h-4 w-4" />
                        Tambah Tutor Baru
                    </button>
                </div>
            </div>

            {/* Tutors Grid */}
            <section className="grid gap-6 md:grid-cols-2">
                {filteredTutors.length === 0 ? (
                    <div className="col-span-full rounded-2xl border border-slate-200/60 bg-white py-16 text-center text-slate-400">
                        <div className="flex justify-center mb-3">
                            <Users className="h-8 w-8 text-slate-300" />
                        </div>
                        <p className="text-xs font-semibold">Tidak ada pengajar/tutor yang sesuai filter.</p>
                    </div>
                ) : (
                    filteredTutors.map((tutor) => (
                        <article key={tutor.id} className="group relative rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md hover:border-slate-300 flex flex-col justify-between gap-6">
                            {/* Profile Info Row */}
                            <div className="flex gap-4">
                                <div className={`flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl font-bold text-xl ${tutor.avatarColor} shadow-inner`}>
                                    {tutor.initials}
                                </div>
                                <div className="min-w-0 flex-1">
                                    <div className="flex items-center gap-2">
                                        <h3 className="text-base font-bold text-slate-900 truncate group-hover:text-blue-600 transition-colors">{tutor.name}</h3>
                                        <span className="text-sm shrink-0" title={tutor.lang}>{tutor.flag}</span>
                                    </div>
                                    <p className="text-xs text-slate-500 font-medium leading-relaxed mt-1">{tutor.desc}</p>
                                    <p className="text-[10px] text-slate-400 font-medium flex items-center gap-1.5 mt-2"><Mail className="h-3.5 w-3.5 text-slate-400" />{tutor.email}</p>
                                </div>
                            </div>

                            {/* Experience and Students metrics */}
                            <div className="grid grid-cols-2 gap-3 bg-slate-50/50 border border-slate-100 rounded-xl p-3.5 shadow-inner">
                                <div className="text-center sm:text-left">
                                    <p className="text-[9px] font-bold uppercase tracking-wider text-slate-400">Pengalaman</p>
                                    <p className="text-sm font-extrabold text-slate-800 mt-1">{tutor.exp} Tahun</p>
                                </div>
                                <div className="text-center sm:text-left border-l border-slate-200/60 pl-3">
                                    <p className="text-[9px] font-bold uppercase tracking-wider text-slate-400">Total Siswa</p>
                                    <p className="text-sm font-extrabold text-blue-600 mt-1">{tutor.students} Siswa</p>
                                </div>
                            </div>

                            {/* Specialization Badge */}
                            <div>
                                <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Spesialisasi</h4>
                                <span className={`inline-block rounded-lg border px-3 py-1 text-[11px] font-bold ${getLangBadgeStyle(tutor.lang)}`}>
                                    {tutor.lang} Speaker
                                </span>
                            </div>

                            {/* Classes Taught list */}
                            <div>
                                <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2.5">
                                    Kelas yang Diajar ({tutor.classes.length})
                                </h4>
                                {tutor.classes.length === 0 ? (
                                    <div className="rounded-xl border border-dashed border-slate-200 p-4 text-center text-[10px] font-medium text-slate-400 bg-slate-50/10">
                                        Belum ditugaskan ke kelas mana pun.
                                    </div>
                                ) : (
                                    <div className="space-y-2">
                                        {tutor.classes.map((cls, idx) => (
                                            <div key={idx} className="rounded-xl border border-slate-100 bg-[#F8FAFC]/50 px-4.5 py-2.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 shadow-sm">
                                                <p className="text-xs font-bold text-slate-800">{cls.name}</p>
                                                <p className="text-[10px] text-slate-400 font-bold flex items-center gap-1.5"><Clock className="h-3.5 w-3.5 text-slate-400" />{cls.schedule}</p>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>

                            {/* Edit Profile & View Schedule Actions */}
                            <div className="grid grid-cols-2 gap-3 pt-2">
                                <button
                                    onClick={() => openEditModal(tutor)}
                                    className="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700 transition hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98]"
                                >
                                    <Edit2 className="h-3.5 w-3.5 text-slate-400" />
                                    Edit Profil
                                </button>
                                <button
                                    onClick={() => openScheduleModal(tutor)}
                                    className="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl bg-slate-900 text-xs font-bold text-white transition hover:bg-slate-800 active:scale-[0.98]"
                                >
                                    <CalendarDays className="h-3.5 w-3.5 text-slate-400" />
                                    Lihat Jadwal
                                </button>
                            </div>
                        </article>
                    ))
                )}
            </section>

            {/* Custom Premium Add / Edit Tutor Modal */}
            {(activeModal === 'add' || activeModal === 'edit') && (
                <div className="fixed inset-0 z-50 flex items-center justify-center px-4">
                    <div onClick={() => setActiveModal(null)} className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" />
                    
                    <div className="relative bg-white rounded-2xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 animate-scale-in z-10 flex flex-col gap-5">
                        <div className="flex justify-between items-start">
                            <div>
                                <h3 className="text-base font-extrabold text-slate-900">
                                    {activeModal === 'add' ? 'Tambah Tutor Baru' : 'Edit Profil Tutor'}
                                </h3>
                                <p className="text-xs text-slate-400 font-medium mt-1">
                                    {activeModal === 'add' ? 'Registrasikan data tutor baru ke dalam sistem.' : `Perbarui kualifikasi & informasi untuk tutor ${currentTutorForModal?.name}.`}
                                </p>
                            </div>
                            <button
                                onClick={() => setActiveModal(null)}
                                className="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition"
                            >
                                <X className="h-5 w-5" />
                            </button>
                        </div>

                        <form onSubmit={activeModal === 'add' ? handleSaveAddTutor : handleSaveEditTutor} className="space-y-4">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input
                                    type="text"
                                    value={formName}
                                    onChange={(e) => setFormName(e.target.value)}
                                    placeholder="Contoh: Yuki Tanaka"
                                    className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500"
                                    required
                                />
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1.5">Email Tutor</label>
                                <input
                                    type="email"
                                    value={formEmail}
                                    onChange={(e) => setFormEmail(e.target.value)}
                                    placeholder="Contoh: yuki@brainy.com"
                                    className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500"
                                    required
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1.5">Spesialisasi Bahasa</label>
                                    <select
                                        value={formLang}
                                        onChange={(e) => setFormLang(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500"
                                    >
                                        <option value="English">English</option>
                                        <option value="Japanese">Japanese</option>
                                        <option value="Korean">Korean</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1.5">Pengalaman (Tahun)</label>
                                    <input
                                        type="number"
                                        min="1"
                                        value={formExp}
                                        onChange={(e) => setFormExp(e.target.value)}
                                        placeholder="Contoh: 5"
                                        className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Sertifikasi</label>
                                <textarea
                                    value={formDesc}
                                    onChange={(e) => setFormDesc(e.target.value)}
                                    placeholder="Contoh: Native speaker dengan sertifikasi JLPT N1..."
                                    rows="3"
                                    className="w-full rounded-xl border border-slate-200 p-3.5 text-xs font-medium outline-none transition focus:border-blue-500 resize-none"
                                    required
                                />
                            </div>

                            <div className="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setActiveModal(null)}
                                    className="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-50"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    className="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white transition hover:bg-blue-700 shadow-sm shadow-blue-500/10"
                                >
                                    {activeModal === 'add' ? 'Simpan Tutor' : 'Simpan Perubahan'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Custom Premium Classes and Schedules Editing Modal */}
            {activeModal === 'schedule' && (
                <div className="fixed inset-0 z-50 flex items-center justify-center px-4">
                    <div onClick={() => setActiveModal(null)} className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" />
                    
                    <div className="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-xl w-full p-6 animate-scale-in z-10 flex flex-col gap-5">
                        <div className="flex justify-between items-start">
                            <div>
                                <h3 className="text-base font-extrabold text-slate-900">Jadwal Mengajar Tutor</h3>
                                <p className="text-xs text-slate-400 font-medium mt-1">
                                    Atur kelas aktif dan pembagian ruang waktu untuk tutor: <strong className="text-slate-700 font-bold">{currentTutorForModal?.name}</strong>
                                </p>
                            </div>
                            <button
                                onClick={() => setActiveModal(null)}
                                className="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition"
                            >
                                <X className="h-5 w-5" />
                            </button>
                        </div>

                        {/* List of current classes inside modal */}
                        <div className="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                            <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Daftar Kelas Aktif</h4>
                            
                            {tempClasses.length === 0 ? (
                                <div className="rounded-xl border border-dashed border-slate-200 py-6 text-center text-xs font-medium text-slate-400 bg-slate-50/20">
                                    Belum mengajar kelas apa pun. Silakan tambahkan jadwal kelas di bawah.
                                </div>
                            ) : (
                                tempClasses.map((cls, idx) => (
                                    <div key={idx} className="rounded-xl border border-slate-100 bg-slate-50/60 px-4 py-3 flex items-center justify-between gap-3 shadow-inner">
                                        <div className="min-w-0">
                                            <p className="text-xs font-bold text-slate-800 truncate">{cls.name}</p>
                                            <p className="text-[10px] text-slate-500 font-medium flex items-center gap-1.5 mt-1"><Clock className="h-3.5 w-3.5 text-slate-400" />{cls.schedule}</p>
                                        </div>
                                        <button
                                            type="button"
                                            onClick={() => handleRemoveTempClass(idx)}
                                            className="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition active:scale-[0.95]"
                                            title="Hapus"
                                        >
                                            <Trash2 className="h-4 w-4" />
                                        </button>
                                    </div>
                                ))
                            )}
                        </div>

                        {/* Add class inline form */}
                        <form onSubmit={handleAddTempClass} className="border-t border-slate-100 pt-4 space-y-3">
                            <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400">+ Tambah Jadwal Kelas Baru</h4>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label className="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Pilih Kelas</label>
                                    {currentTutorForModal?.lang === 'English' ? (
                                        <select
                                            value={newClassName}
                                            onChange={(e) => setNewClassName(e.target.value)}
                                            className="h-9 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                        >
                                            <option value="English for Beginners">English for Beginners</option>
                                            <option value="English Intermediate">English Intermediate</option>
                                            <option value="English Advanced">English Advanced</option>
                                        </select>
                                    ) : currentTutorForModal?.lang === 'Japanese' ? (
                                        <select
                                            value={newClassName}
                                            onChange={(e) => setNewClassName(e.target.value)}
                                            className="h-9 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                        >
                                            <option value="Japanese for Beginners">Japanese for Beginners</option>
                                            <option value="Japanese Intermediate">Japanese Intermediate</option>
                                            <option value="Japanese Advanced">Japanese Advanced</option>
                                        </select>
                                    ) : (
                                        <select
                                            value={newClassName}
                                            onChange={(e) => setNewClassName(e.target.value)}
                                            className="h-9 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                        >
                                            <option value="Korean for Beginners">Korean for Beginners</option>
                                            <option value="Korean Intermediate">Korean Intermediate</option>
                                            <option value="Korean Advanced">Korean Advanced</option>
                                        </select>
                                    )}
                                </div>
                                <div>
                                    <label className="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Hari & Jam Mengajar</label>
                                    <input
                                        type="text"
                                        value={newClassSchedule}
                                        onChange={(e) => setNewClassSchedule(e.target.value)}
                                        placeholder="Contoh: Senin & Rabu, 19:00 - 20:30"
                                        className="h-9 w-full rounded-xl border border-slate-200 px-3 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                        required
                                    />
                                </div>
                            </div>
                            <div className="flex justify-end pt-1">
                                <button
                                    type="submit"
                                    className="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs font-bold text-slate-700 transition hover:bg-slate-100 hover:border-slate-350 active:scale-[0.98]"
                                >
                                    <Plus className="h-4 w-4 text-slate-400" />
                                    Tambahkan ke List
                                </button>
                            </div>
                        </form>

                        <div className="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                            <button
                                type="button"
                                onClick={() => setActiveModal(null)}
                                className="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-50"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                onClick={handleSaveSchedule}
                                className="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white transition hover:bg-blue-700 shadow-sm shadow-blue-500/10"
                            >
                                Simpan Jadwal
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}

// Brand New Premium, Minimalist, Clean Students Page
export function StudentsPage({
    showToast,
    students,
    setStudents,
    setTotalSiswa,
    pendingPaymentsCount,
    waitingListCount
}) {
    const [sidebarOpen, setSidebarOpen] = React.useState(false);
    const [searchQuery, setSearchQuery] = React.useState('');
    const [filterLang, setFilterLang] = React.useState('All');
    const [filterStatus, setFilterStatus] = React.useState('All');
    const [selectedStudentId, setSelectedStudentId] = React.useState(null);

    // Modal states: 'add' | 'edit' | null
    const [activeModal, setActiveModal] = React.useState(null);

    // Form inputs state
    const [formName, setFormName] = React.useState('');
    const [formEmail, setFormEmail] = React.useState('');
    const [formPhone, setFormPhone] = React.useState('');
    const [formCourse, setFormCourse] = React.useState('English Intermediate');
    const [formLang, setFormLang] = React.useState('English');
    const [formLevel, setFormLevel] = React.useState('Intermediate');
    const [formStatus, setFormStatus] = React.useState('Active');
    const [formAttendance, setFormAttendance] = React.useState('90');
    const [formProgress, setFormProgress] = React.useState('50');
    const [formPaymentStatus, setFormPaymentStatus] = React.useState('Paid');

    const filteredStudents = students.filter(student => {
        const matchesSearch = student.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
                              student.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
                              student.phone.includes(searchQuery) ||
                              student.course.toLowerCase().includes(searchQuery.toLowerCase());
        
        const matchesLang = filterLang === 'All' || student.lang === filterLang;
        const matchesStatus = filterStatus === 'All' || student.status === filterStatus;
        
        return matchesSearch && matchesLang && matchesStatus;
    });

    // Auto-select first student in filtered list if current selection is not in filtered list
    React.useEffect(() => {
        if (filteredStudents.length > 0) {
            const exists = filteredStudents.some(s => s.id === selectedStudentId);
            if (!exists) {
                setSelectedStudentId(filteredStudents[0].id);
            }
        } else {
            setSelectedStudentId(null);
        }
    }, [searchQuery, filterLang, filterStatus, students]);

    const currentStudent = students.find(s => s.id === selectedStudentId) || filteredStudents[0] || null;

    // Reset Form fields
    const resetForm = () => {
        setFormName('');
        setFormEmail('');
        setFormPhone('');
        setFormCourse('English Intermediate');
        setFormLang('English');
        setFormLevel('Intermediate');
        setFormStatus('Active');
        setFormAttendance('100');
        setFormProgress('0');
        setFormPaymentStatus('Paid');
    };

    // Open add modal
    const openAddModal = () => {
        resetForm();
        setActiveModal('add');
    };

    // Open edit modal
    const openEditModal = (student) => {
        setFormName(student.name);
        setFormEmail(student.email);
        setFormPhone(student.phone);
        setFormCourse(student.course);
        setFormLang(student.lang);
        setFormLevel(student.level);
        setFormStatus(student.status);
        setFormAttendance(student.attendance.toString());
        setFormProgress(student.progress.toString());
        setFormPaymentStatus(student.paymentStatus);
        setActiveModal('edit');
    };

    // Save added student
    function handleSaveAddStudent(e) {
        e.preventDefault();
        const initials = formName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        const colors = [
            'bg-blue-50 text-blue-600 border border-blue-100/50',
            'bg-purple-50 text-purple-600 border border-purple-100/50',
            'bg-orange-50 text-orange-600 border border-orange-100/50'
        ];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];

        const newStudent = {
            id: Date.now(),
            name: formName,
            email: formEmail,
            phone: formPhone,
            course: formCourse,
            level: formLevel,
            lang: formLang,
            joinedDate: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }),
            status: formStatus,
            attendance: parseInt(formAttendance) || 100,
            progress: parseInt(formProgress) || 0,
            paymentStatus: formPaymentStatus,
            avatar: initials,
            color: randomColor
        };

        setStudents(prev => [newStudent, ...prev]);
        setTotalSiswa(prev => prev + 1);
        showToast(`Siswa ${formName} berhasil didaftarkan!`, 'success');
        setSelectedStudentId(newStudent.id);
        setActiveModal(null);
    }

    // Save edited student
    function handleSaveEditStudent(e) {
        e.preventDefault();
        const initials = formName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        
        setStudents(prev => prev.map(student => {
            if (student.id === selectedStudentId) {
                return {
                    ...student,
                    name: formName,
                    email: formEmail,
                    phone: formPhone,
                    course: formCourse,
                    level: formLevel,
                    lang: formLang,
                    status: formStatus,
                    attendance: parseInt(formAttendance) || student.attendance,
                    progress: parseInt(formProgress) || student.progress,
                    paymentStatus: formPaymentStatus,
                    avatar: initials
                };
            }
            return student;
        }));

        showToast(`Profil ${formName} berhasil diperbarui!`, 'success');
        setActiveModal(null);
    }

    // Delete student
    function handleDeleteStudent(studentId, studentName) {
        if (confirm(`Apakah Anda yakin ingin mengeluarkan/menghapus siswa ${studentName} dari lembaga?`)) {
            setStudents(prev => prev.filter(s => s.id !== studentId));
            setTotalSiswa(prev => Math.max(0, prev - 1));
            showToast(`Siswa ${studentName} telah dihapus dari direktori.`, 'info');
        }
    }

    // Toggle status quickly
    function handleToggleStatus(studentId, newStatus) {
        setStudents(prev => prev.map(student => {
            if (student.id === studentId) {
                return { ...student, status: newStatus };
            }
            return student;
        }));
        showToast(`Status akademis diperbarui menjadi ${newStatus}`, 'success');
    }

    // Stats calculations
    const activeCount = students.filter(s => s.status === 'Active').length;
    const avgAttendance = Math.round(students.reduce((acc, s) => acc + s.attendance, 0) / students.length) || 0;
    const avgProgress = Math.round(students.reduce((acc, s) => acc + s.progress, 0) / students.length) || 0;

    const getStatusBadge = (status) => {
        switch (status) {
            case 'Active':
                return 'bg-emerald-50 text-emerald-700 border-emerald-100/50';
            case 'Inactive':
                return 'bg-slate-50 text-slate-600 border-slate-100';
            case 'Suspended':
                return 'bg-rose-50 text-rose-700 border-rose-100/50';
            default:
                return 'bg-slate-50 text-slate-600 border-slate-100';
        }
    };

    return (
        <AdminLayout
            activeTab="siswa"
            pendingPaymentsCount={pendingPaymentsCount}
            waitingListCount={waitingListCount}
            showToast={showToast}
            sidebarOpen={sidebarOpen}
            setSidebarOpen={setSidebarOpen}
        >
            {/* Minimal Metrics Row */}
            <section className="grid gap-5 grid-cols-1 sm:grid-cols-3">
                <article className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
                    <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100/30">
                        <Users className="h-6 w-6" />
                    </div>
                    <div className="min-w-0">
                        <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Siswa Aktif</p>
                        <p className="text-xl font-extrabold text-slate-900 mt-0.5">{activeCount} / {students.length}</p>
                    </div>
                </article>

                <article className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
                    <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100/30">
                        <Clock className="h-6 w-6" />
                    </div>
                    <div className="min-w-0">
                        <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-rata Kehadiran</p>
                        <p className="text-xl font-extrabold text-slate-900 mt-0.5">{avgAttendance}%</p>
                    </div>
                </article>

                <article className="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
                    <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 border border-violet-100/30">
                        <TrendingUp className="h-6 w-6" />
                    </div>
                    <div className="min-w-0">
                        <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-rata Progress</p>
                        <p className="text-xl font-extrabold text-slate-900 mt-0.5">{avgProgress}%</p>
                    </div>
                </article>
            </section>

            {/* Split View Panel */}
            <section className="grid gap-6 lg:grid-cols-12 items-start">
                
                {/* Left Panel: Master list (Directory) */}
                <div className="lg:col-span-5 bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden flex flex-col h-[680px]">
                    {/* Panel Header */}
                    <div className="p-4 border-b border-slate-100 flex flex-col gap-3 shrink-0">
                        <div className="flex items-center justify-between gap-3">
                            <h2 className="text-sm font-bold text-slate-900">Daftar Siswa</h2>
                            <button
                                onClick={openAddModal}
                                className="inline-flex h-8 items-center gap-1.5 rounded-lg bg-blue-600 px-3 text-xs font-bold text-white shadow-sm hover:bg-blue-700 active:scale-[0.98] transition"
                            >
                                <Plus className="h-3.5 w-3.5" />
                                Registrasi Siswa
                            </button>
                        </div>

                        {/* Search Input */}
                        <div className="relative">
                            <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <Search className="h-4 w-4" />
                            </span>
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                placeholder="Cari nama, email, kelas..."
                                className="h-9 w-full rounded-xl border border-slate-200 pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/50 focus:bg-white"
                            />
                        </div>

                        {/* Filters Pills */}
                        <div className="space-y-1.5 pt-1">
                            {/* Language Filter */}
                            <div className="flex flex-wrap gap-1">
                                {['All', 'English', 'Japanese', 'Korean'].map((lang) => (
                                    <button
                                        key={lang}
                                        onClick={() => setFilterLang(lang)}
                                        className={`px-2.5 py-1 rounded-md text-[10px] font-bold transition-all ${
                                            filterLang === lang
                                                ? 'bg-blue-50 text-blue-600 border border-blue-100/30'
                                                : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'
                                        }`}
                                    >
                                        {lang}
                                    </button>
                                ))}
                            </div>
                            {/* Status Filter */}
                            <div className="flex flex-wrap gap-1">
                                {['All', 'Active', 'Inactive', 'Suspended'].map((status) => (
                                    <button
                                        key={status}
                                        onClick={() => setFilterStatus(status)}
                                        className={`px-2.5 py-1 rounded-md text-[10px] font-bold transition-all ${
                                            filterStatus === status
                                                ? 'bg-slate-800 text-white'
                                                : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50'
                                        }`}
                                    >
                                        {status}
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Master List Scroll Area */}
                    <div className="flex-1 overflow-y-auto divide-y divide-slate-100">
                        {filteredStudents.length === 0 ? (
                            <div className="p-12 text-center text-slate-400 space-y-2">
                                <Users className="h-8 w-8 mx-auto text-slate-300" />
                                <p className="text-xs font-semibold">Tidak ada siswa yang sesuai filter.</p>
                            </div>
                        ) : (
                            filteredStudents.map((student) => {
                                const isSelected = currentStudent && currentStudent.id === student.id;
                                return (
                                    <div
                                        key={student.id}
                                        onClick={() => setSelectedStudentId(student.id)}
                                        className={`p-3.5 flex items-center justify-between gap-3 cursor-pointer transition duration-150 ${
                                            isSelected 
                                                ? 'bg-blue-50/50 border-l-4 border-l-blue-600 pl-2.5' 
                                                : 'hover:bg-slate-50/50 border-l-4 border-l-transparent'
                                        }`}
                                    >
                                        <div className="flex items-center gap-3 min-w-0">
                                            <div className={`flex h-10 w-10 shrink-0 items-center justify-center rounded-xl font-bold text-xs ${student.color}`}>
                                                {student.avatar}
                                            </div>
                                            <div className="min-w-0">
                                                <p className="text-xs font-bold text-slate-900 truncate">{student.name}</p>
                                                <p className="text-[10px] text-slate-400 truncate mt-0.5">{student.course}</p>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-2 shrink-0">
                                            <span className={`h-2 w-2 rounded-full ${
                                                student.status === 'Active' 
                                                    ? 'bg-emerald-500' 
                                                    : student.status === 'Inactive' 
                                                        ? 'bg-slate-400' 
                                                        : 'bg-rose-500'
                                            }`} />
                                            <ChevronRight className="h-4 w-4 text-slate-300" />
                                        </div>
                                    </div>
                                );
                            })
                        )}
                    </div>
                </div>

                {/* Right Panel: Detail Inspector */}
                <div className="lg:col-span-7 bg-white border border-slate-200/60 rounded-2xl shadow-sm p-6 h-[680px] flex flex-col justify-between">
                    {!currentStudent ? (
                        <div className="my-auto text-center text-slate-400 space-y-3">
                            <div className="h-16 w-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto border border-blue-100/50 shadow-inner">
                                <Search className="h-7 w-7" />
                            </div>
                            <h3 className="text-sm font-bold text-slate-800">Detail Profil Siswa</h3>
                            <p className="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">Pilih salah satu siswa di direktori sebelah kiri untuk melihat detail informasi akademis lengkap.</p>
                        </div>
                    ) : (
                        <div className="space-y-6 overflow-y-auto pr-1">
                            {/* Profile Header Block */}
                            <div className="flex flex-col sm:flex-row items-center sm:items-start gap-4 pb-5 border-b border-slate-100 text-center sm:text-left">
                                <div className={`flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl font-bold text-xl ${currentStudent.color} shadow-inner`}>
                                    {currentStudent.avatar}
                                </div>
                                <div className="min-w-0 flex-1 space-y-1">
                                    <div className="flex flex-col sm:flex-row sm:items-center gap-2 justify-center sm:justify-start">
                                        <h3 className="text-lg font-bold text-slate-900 truncate">{currentStudent.name}</h3>
                                        <span className={`inline-block mx-auto sm:mx-0 rounded-full border px-2.5 py-0.5 text-[9px] font-bold ${getStatusBadge(currentStudent.status)}`}>
                                            {currentStudent.status}
                                        </span>
                                    </div>
                                    <p className="text-xs text-slate-500 font-medium">{currentStudent.course} &bull; Level {currentStudent.level}</p>
                                </div>
                            </div>

                            {/* Info Grid */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div className="space-y-3 bg-[#F8FAFC]/55 border border-slate-100 rounded-xl p-4.5">
                                    <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Informasi Kontak</h4>
                                    <div className="space-y-2 text-xs">
                                        <div className="flex items-center gap-2.5 text-slate-700">
                                            <Mail className="h-4 w-4 text-slate-400 shrink-0" />
                                            <span className="truncate">{currentStudent.email}</span>
                                        </div>
                                        <div className="flex items-center gap-2.5 text-slate-700">
                                            <Phone className="h-4 w-4 text-slate-400 shrink-0" />
                                            <span>{currentStudent.phone}</span>
                                        </div>
                                    </div>
                                </div>

                                <div className="space-y-3 bg-[#F8FAFC]/55 border border-slate-100 rounded-xl p-4.5">
                                    <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pendaftaran & Administrasi</h4>
                                    <div className="space-y-2 text-xs">
                                        <div className="flex items-center gap-2.5 text-slate-700">
                                            <CalendarDays className="h-4 w-4 text-slate-400 shrink-0" />
                                            <span>Terdaftar sejak {currentStudent.joinedDate}</span>
                                        </div>
                                        <div className="flex items-center gap-2.5 text-slate-700">
                                            <DollarSign className="h-4 w-4 text-slate-400 shrink-0" />
                                            <span className="font-semibold flex items-center gap-1.5">
                                                Status Biaya: 
                                                <span className={`px-2 py-0.5 rounded text-[10px] font-bold ${
                                                    currentStudent.paymentStatus === 'Paid' 
                                                        ? 'bg-emerald-100 text-emerald-800' 
                                                        : 'bg-amber-100 text-amber-800'
                                                }`}>
                                                    {currentStudent.paymentStatus === 'Paid' ? 'Lunas' : 'Menunggu Pelunasan'}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Academic Performance Section */}
                            <div className="border border-slate-200/60 rounded-xl p-5 space-y-4">
                                <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Performa Akademis</h4>
                                
                                <div className="space-y-3.5">
                                    {/* Progress */}
                                    <div className="space-y-1.5">
                                        <div className="flex items-center justify-between text-xs font-bold text-slate-700">
                                            <span>Penyelesaian Silabus (Progress)</span>
                                            <span className="text-blue-600">{currentStudent.progress}%</span>
                                        </div>
                                        <div className="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div 
                                                className="h-full bg-blue-600 rounded-full transition-all duration-500" 
                                                style={{ width: `${currentStudent.progress}%` }}
                                            />
                                        </div>
                                    </div>

                                    {/* Attendance */}
                                    <div className="space-y-1.5">
                                        <div className="flex items-center justify-between text-xs font-bold text-slate-700">
                                            <span>Rasio Kehadiran (Attendance)</span>
                                            <span className="text-indigo-600">{currentStudent.attendance}%</span>
                                        </div>
                                        <div className="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div 
                                                className="h-full bg-indigo-600 rounded-full transition-all duration-500" 
                                                style={{ width: `${currentStudent.attendance}%` }}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Actions Area */}
                            <div className="pt-4 border-t border-slate-100 space-y-4 shrink-0">
                                <h4 className="text-[10px] font-bold uppercase tracking-wider text-slate-400">Aksi Administrasi Cepat</h4>
                                <div className="flex flex-wrap gap-2">
                                    {/* Edit button */}
                                    <button
                                        onClick={() => openEditModal(currentStudent)}
                                        className="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-700 transition hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98]"
                                    >
                                        <Edit2 className="h-3.5 w-3.5 text-slate-400" />
                                        Ubah Profil
                                    </button>

                                    {/* Status updates */}
                                    {currentStudent.status !== 'Active' && (
                                        <button
                                            onClick={() => handleToggleStatus(currentStudent.id, 'Active')}
                                            className="inline-flex h-9 items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100/50 active:scale-[0.98]"
                                        >
                                            Aktifkan Siswa
                                        </button>
                                    )}

                                    {currentStudent.status !== 'Inactive' && (
                                        <button
                                            onClick={() => handleToggleStatus(currentStudent.id, 'Inactive')}
                                            className="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-100 active:scale-[0.98]"
                                        >
                                            Nonaktifkan Siswa
                                        </button>
                                    )}

                                    {currentStudent.status !== 'Suspended' && (
                                        <button
                                            onClick={() => handleToggleStatus(currentStudent.id, 'Suspended')}
                                            className="inline-flex h-9 items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-4 text-xs font-bold text-rose-700 transition hover:bg-rose-100/50 active:scale-[0.98]"
                                        >
                                            Skorsing Siswa
                                        </button>
                                    )}

                                    <button
                                        onClick={() => handleDeleteStudent(currentStudent.id, currentStudent.name)}
                                        className="inline-flex h-9 items-center gap-1.5 rounded-xl bg-rose-50 text-rose-600 border border-rose-100/50 px-4 text-xs font-bold transition hover:bg-rose-100/80 active:scale-[0.98] sm:ml-auto"
                                    >
                                        <Trash2 className="h-3.5 w-3.5 text-rose-500" />
                                        Hapus Data Siswa
                                    </button>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </section>

            {/* Custom Add / Edit Student Form Modal */}
            {(activeModal === 'add' || activeModal === 'edit') && (
                <div className="fixed inset-0 z-50 flex items-center justify-center px-4">
                    <div onClick={() => setActiveModal(null)} className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" />
                    
                    <div className="relative bg-white rounded-2xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 animate-scale-in z-10 flex flex-col gap-4">
                        <div className="flex justify-between items-start">
                            <div>
                                <h3 className="text-base font-extrabold text-slate-900">
                                    {activeModal === 'add' ? 'Registrasi Siswa Baru' : 'Ubah Data Siswa'}
                                </h3>
                                <p className="text-xs text-slate-400 font-medium mt-1">
                                    {activeModal === 'add' ? 'Isi formulir secara lengkap untuk mendaftarkan siswa baru.' : `Ubah profil dan status akademis untuk ${currentStudent?.name}.`}
                                </p>
                            </div>
                            <button
                                onClick={() => setActiveModal(null)}
                                className="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition"
                            >
                                <X className="h-5 w-5" />
                            </button>
                        </div>

                        <form onSubmit={activeModal === 'add' ? handleSaveAddStudent : handleSaveEditStudent} className="space-y-3.5">
                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                                <input
                                    type="text"
                                    value={formName}
                                    onChange={(e) => setFormName(e.target.value)}
                                    placeholder="Contoh: Ahmad Fauzi"
                                    className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                                    required
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Email</label>
                                    <input
                                        type="email"
                                        value={formEmail}
                                        onChange={(e) => setFormEmail(e.target.value)}
                                        placeholder="ahmad@email.com"
                                        className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                                        required
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">No. Handphone</label>
                                    <input
                                        type="tel"
                                        value={formPhone}
                                        onChange={(e) => setFormPhone(e.target.value)}
                                        placeholder="081234567890"
                                        className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                                        required
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-3 gap-2">
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Bahasa</label>
                                    <select
                                        value={formLang}
                                        onChange={(e) => setFormLang(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                    >
                                        <option value="English">English</option>
                                        <option value="Japanese">Japanese</option>
                                        <option value="Korean">Korean</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Tingkatan</label>
                                    <select
                                        value={formLevel}
                                        onChange={(e) => setFormLevel(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                    >
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-slate-700 mb-1">Status Keuangan</label>
                                    <select
                                        value={formPaymentStatus}
                                        onChange={(e) => setFormPaymentStatus(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                    >
                                        <option value="Paid">Lunas (Paid)</option>
                                        <option value="Unpaid">Belum Lunas</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-slate-700 mb-1">Nama Kursus / Kelas</label>
                                <input
                                    type="text"
                                    value={formCourse}
                                    onChange={(e) => setFormCourse(e.target.value)}
                                    placeholder="Contoh: English Intermediate Class"
                                    className="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                                    required
                                />
                            </div>

                            <div className="grid grid-cols-3 gap-2">
                                <div>
                                    <label className="block text-[10px] font-bold text-slate-700 mb-1">Status Rute</label>
                                    <select
                                        value={formStatus}
                                        onChange={(e) => setFormStatus(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-2 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                                    >
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Suspended">Suspended</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-[10px] font-bold text-slate-700 mb-1">Absensi (%)</label>
                                    <input
                                        type="number"
                                        min="0"
                                        max="100"
                                        value={formAttendance}
                                        onChange={(e) => setFormAttendance(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                                        required
                                    />
                                </div>
                                <div>
                                    <label className="block text-[10px] font-bold text-slate-700 mb-1">Progress (%)</label>
                                    <input
                                        type="number"
                                        min="0"
                                        max="100"
                                        value={formProgress}
                                        onChange={(e) => setFormProgress(e.target.value)}
                                        className="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                                        required
                                    />
                                </div>
                            </div>

                            <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                <button
                                    type="button"
                                    onClick={() => setActiveModal(null)}
                                    className="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 hover:bg-slate-50 transition"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    className="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white hover:bg-blue-700 shadow-sm shadow-blue-500/10 transition"
                                >
                                    {activeModal === 'add' ? 'Registrasikan Siswa' : 'Simpan Perubahan'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
