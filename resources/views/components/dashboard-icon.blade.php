@props(['name' => 'book'])

<svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
    @switch($name)
        @case('audio')
            <path d="M5 13V11C5 7.13 8.13 4 12 4C15.87 4 19 7.13 19 11V13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M5 13H7.5C8.33 13 9 13.67 9 14.5V18.5C9 19.33 8.33 20 7.5 20H6.5C5.67 20 5 19.33 5 18.5V13Z" stroke="currentColor" stroke-width="1.8"/>
            <path d="M19 13H16.5C15.67 13 15 13.67 15 14.5V18.5C15 19.33 15.67 20 16.5 20H17.5C18.33 20 19 19.33 19 18.5V13Z" stroke="currentColor" stroke-width="1.8"/>
            @break

        @case('calendar')
            <path d="M7 3V6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M17 3V6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M4.5 9H19.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M5 5.5H19C19.83 5.5 20.5 6.17 20.5 7V19C20.5 19.83 19.83 20.5 19 20.5H5C4.17 20.5 3.5 19.83 3.5 19V7C3.5 6.17 4.17 5.5 5 5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            @break

        @case('chat')
            <path d="M4 5.5C4 4.67 4.67 4 5.5 4H18.5C19.33 4 20 4.67 20 5.5V14.5C20 15.33 19.33 16 18.5 16H9L4 20V5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            @break

        @case('clipboard')
            <path d="M9 4.5H15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M9 8H15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M8 12H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M8 16H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M6 4H18C18.83 4 19.5 4.67 19.5 5.5V19C19.5 19.83 18.83 20.5 18 20.5H6C5.17 20.5 4.5 19.83 4.5 19V5.5C4.5 4.67 5.17 4 6 4Z" stroke="currentColor" stroke-width="1.8"/>
            @break

        @case('money')
            <path d="M12 4V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M16 7.5C15.2 6.55 13.89 6 12.5 6H11C9.34 6 8 7.01 8 8.25C8 9.49 9.34 10.5 11 10.5H13C14.66 10.5 16 11.51 16 12.75C16 13.99 14.66 15 13 15H11.5C10.11 15 8.8 14.45 8 13.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            @break

        @case('mortar')
            <path d="M3 8L12 4L21 8L12 12L3 8Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7 10V15.5C7 16.6 9.24 18 12 18C14.76 18 17 16.6 17 15.5V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            @break

        @case('translate')
            <path d="M4 5H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M8.5 3V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M6 5C6.55 8.75 8.88 11.42 12 12.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M12 5C11.54 8.01 9.82 10.34 7.25 11.88" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M11 20L15.5 10L20 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12.5 16.5H18.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            @break

        @case('users')
            <path d="M8.5 11C10.43 11 12 9.43 12 7.5C12 5.57 10.43 4 8.5 4C6.57 4 5 5.57 5 7.5C5 9.43 6.57 11 8.5 11Z" stroke="currentColor" stroke-width="1.8"/>
            <path d="M2.75 20C3.28 16.85 5.53 14.75 8.5 14.75C11.47 14.75 13.72 16.85 14.25 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M16 11C17.66 11 19 9.66 19 8C19 6.34 17.66 5 16 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="M16.5 14.8C19.04 15.23 20.78 17.14 21.25 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            @break

        @default
            <path d="M7 5.5H11C12.1 5.5 13 6.4 13 7.5V19C12.42 18.39 11.61 18 10.7 18H7C5.9 18 5 17.1 5 16V7.5C5 6.4 5.9 5.5 7 5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M17 5.5H13C11.9 5.5 11 6.4 11 7.5V19C11.58 18.39 12.39 18 13.3 18H17C18.1 18 19 17.1 19 16V7.5C19 6.4 18.1 5.5 17 5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
    @endswitch
</svg>
