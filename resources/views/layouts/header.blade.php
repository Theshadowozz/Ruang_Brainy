<header class="w-full border-b border-gray-100 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 sm:px-10 lg:px-28">
        <a
            href="https://www.flaticon.com/free-icons/open-book"
            title="Open book icons created by Icon Mela - Flaticon"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center gap-3 text-blue-600 transition hover:text-blue-700"
            aria-label="Brainy logo"
        >
            <svg
                class="h-9 w-9"
                viewBox="0 0 40 40"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <path
                    d="M7 9.75C7 8.23 8.23 7 9.75 7H17.5C18.88 7 20 8.12 20 9.5V32C19.12 30.82 17.71 30 16.1 30H9.75C8.23 30 7 28.77 7 27.25V9.75Z"
                    stroke="currentColor"
                    stroke-width="3"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path
                    d="M33 9.75C33 8.23 31.77 7 30.25 7H22.5C21.12 7 20 8.12 20 9.5V32C20.88 30.82 22.29 30 23.9 30H30.25C31.77 30 33 28.77 33 27.25V9.75Z"
                    stroke="currentColor"
                    stroke-width="3"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            <span class="text-[28px] font-bold leading-none tracking-normal">Brainy</span>
        </a>

        <nav class="flex items-center gap-5 text-base font-medium text-gray-950" aria-label="Main navigation">
            <a
                href="{{ url('/dashboard') }}"
                class="flex h-10 items-center gap-3 rounded-lg border border-gray-200 px-4 transition hover:border-gray-300 hover:bg-gray-50"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M3 10.75L12 3.75L21 10.75"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M5.5 9.5V20H10V14H14V20H18.5V9.5"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ url('/logout') }}"
                class="flex h-10 items-center gap-3 px-1 transition hover:text-blue-600"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M14 8V6.5C14 5.12 12.88 4 11.5 4H6.5C5.12 4 4 5.12 4 6.5V17.5C4 18.88 5.12 20 6.5 20H11.5C12.88 20 14 18.88 14 17.5V16"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M10 12H21"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M17 8L21 12L17 16"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
                <span>Logout</span>
            </a>
        </nav>
    </div>
</header>
