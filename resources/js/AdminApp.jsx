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
    ShieldAlert
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

export default function AdminApp() {
    const [toasts, setToasts] = React.useState([]);

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
                                <DashboardPage showToast={showToast} />
                            </ProtectedRoute>
                        }
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

function ProtectedRoute({ children }) {
    if (!isAdminAuthenticated()) {
        return <Navigate to="/admin/login" replace />;
    }
    return children;
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

function DashboardPage({ showToast }) {
    const navigate = useNavigate();
    const [sidebarOpen, setSidebarOpen] = React.useState(false);
    const [activeTab, setActiveTab] = React.useState('dashboard');

    // Stateful data for micro-interactions
    const [totalSiswa, setTotalSiswa] = React.useState(248);
    const [pendapatan, setPendapatan] = React.useState(45200000); // Rp 45.2M
    const [waitingListCount, setWaitingListCount] = React.useState(24);

    const [recentStudents, setRecentStudents] = React.useState([
        { id: 1, name: 'Ahmad Fauzi', course: 'English Beginner', date: '22 Mei 2026', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
        { id: 2, name: 'Siti Nurhaliza', course: 'Japanese Intermediate', date: '21 Mei 2026', avatar: 'SN', color: 'bg-indigo-50 text-indigo-600 border border-indigo-100/50' },
        { id: 3, name: 'Budi Hartono', course: 'Korean Beginner', date: '20 Mei 2026', avatar: 'BH', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
        { id: 4, name: 'Dewi Putri', course: 'English Advanced', date: '19 Mei 2026', avatar: 'DP', color: 'bg-emerald-50 text-emerald-600 border border-emerald-100/50' },
        { id: 5, name: 'Rahman Ali', course: 'Japanese Beginner', date: '18 Mei 2026', avatar: 'RA', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
    ]);

    const [pendingPayments, setPendingPayments] = React.useState([
        { id: 101, name: 'Budi Santoso', course: 'Japanese Intermediate', amount: 'Rp 2.300.000', rawAmount: 2300000 },
        { id: 102, name: 'Lisa Wijaya', course: 'English Intermediate', amount: 'Rp 1.800.000', rawAmount: 1800000 },
        { id: 103, name: 'Agus Susanto', course: 'Korean Beginner', amount: 'Rp 2.000.000', rawAmount: 2000000 },
    ]);

    function handleLogout() {
        localStorage.removeItem(AUTH_KEY);
        showToast('Anda telah keluar dari sistem admin.', 'info');
        setTimeout(() => {
            window.location.href = '/logout';
        }, 500);
    }

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

        showToast(`Pembayaran ${payment.name} (${payment.amount}) berhasil dikonfirmasi!`, 'success');
    }

    const formatCurrency = (val) => {
        return 'Rp ' + (val / 1000000).toFixed(1) + 'M';
    };

    const navItems = [
        { id: 'dashboard', label: 'Dashboard', icon: Home },
        { id: 'kursus', label: 'Kelola Kursus', icon: GraduationCap },
        { id: 'pembayaran', label: 'Pembayaran', icon: DollarSign, badge: pendingPayments.length },
        { id: 'waitinglist', label: 'Waiting List', icon: ClipboardList, badge: waitingListCount },
        { id: 'tutor', label: 'Kelola Tutor', icon: UserCheck },
        { id: 'jadwal', label: 'Jadwal Kelas', icon: CalendarDays },
        { id: 'siswa', label: 'Data Siswa', icon: Users },
    ];

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
                                onClick={() => {
                                    setActiveTab(item.id);
                                    if (item.id !== 'dashboard') {
                                        showToast(`Halaman ${item.label} terhubung. Dasbor demo aktif.`, 'info');
                                    }
                                    setSidebarOpen(false);
                                }}
                                className={`flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 ${
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
                            <h1 className="text-xl font-extrabold text-slate-900 tracking-tight">Dasbor Ringkasan</h1>
                            <p className="hidden sm:block text-xs text-slate-400 font-medium mt-0.5">Pantau parameter operasional lembaga bahasa asing Brainy.</p>
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

                {/* Dashboard Core Content */}
                <main className="flex-1 p-6 space-y-6 max-w-[1600px] w-full mx-auto">
                    
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
                                    <p className="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">{waitingListCount}</p>
                                </div>
                                <div className="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 border border-orange-100/30">
                                    <ClipboardList className="h-5 w-5" />
                                </div>
                            </div>
                            <div className="mt-4 flex items-center justify-between gap-2">
                                <span className="text-[10px] text-orange-600 font-extrabold bg-orange-50 border border-orange-100/30 rounded-lg px-2 py-0.5">
                                    Tindak lanjut
                                </span>
                                <Sparkline points={[15, 18, 22, 28, 25, waitingListCount]} color="text-orange-500" />
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
                                { title: 'Kelola Kursus', desc: 'Tambah, edit, dan hapus kurikulum bahasa.', icon: GraduationCap, color: 'text-blue-600 border-l-blue-600 bg-blue-50/20', id: 'kursus' },
                                { title: 'Pembayaran', desc: 'Verifikasi & pantau mutasi invoice pendaftaran.', icon: DollarSign, color: 'text-emerald-600 border-l-emerald-600 bg-emerald-50/20', id: 'pembayaran' },
                                { title: 'Waiting List', desc: 'Kelola alokasi kelas pendaftaran penuh.', icon: ClipboardList, color: 'text-orange-600 border-l-orange-600 bg-orange-50/20', id: 'waitinglist' },
                                { title: 'Kelola Tutor', desc: 'Atur penugasan dan ketersediaan mengajar.', icon: UserCheck, color: 'text-purple-600 border-l-purple-600 bg-purple-50/20', id: 'tutor' },
                                { title: 'Jadwal Kelas', desc: 'Atur pemetaan ruangan dan waktu belajar.', icon: CalendarDays, color: 'text-violet-600 border-l-violet-600 bg-violet-50/20', id: 'jadwal' },
                                { title: 'Data Siswa', desc: 'Direktori komprehensif profil & status siswa.', icon: Users, color: 'text-indigo-600 border-l-indigo-600 bg-indigo-50/20', id: 'siswa' },
                            ].map((item) => {
                                const Icon = item.icon;
                                return (
                                    <button
                                        key={item.title}
                                        onClick={() => {
                                            setActiveTab(item.id);
                                            showToast(`Navigasi ke menu ${item.title}`, 'info');
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
                </main>

                <footer className="border-t border-slate-200/50 bg-white py-4 text-center text-[10px] text-slate-400 mt-10">
                    &copy; 2026 Brainy Language Institute Portal Admin. Dikembangkan secara profesional.
                </footer>
            </div>
        </div>
    );
}
