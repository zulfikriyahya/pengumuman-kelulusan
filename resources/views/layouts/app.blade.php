<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layanan SKL') — {{ $instansi?->nama ?? config('app.name') }}</title>

    @if ($instansi?->logo_institusi)
        <link rel="icon" href="{{ Storage::url($instansi->logo_institusi) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..500&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 font-[Inter] text-gray-800 antialiased">

    {{-- ── Navbar ─────────────────────────────────────────────── --}}
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="Logo"
                        class="h-9 w-9 object-contain transition group-hover:scale-105">
                @else
                    <div
                        class="h-9 w-9 rounded-lg bg-green-600 flex items-center justify-center text-white font-bold text-sm">
                        SKL
                    </div>
                @endif
                <div class="leading-tight">
                    <p class="font-bold text-sm text-green-700 group-hover:text-green-800 transition">
                        {{ $instansi?->nama ?? config('app.name') }}
                    </p>
                    <p class="text-xs text-gray-400">Layanan Surat Keterangan Lulus</p>
                </div>
            </a>

            <div class="flex items-center gap-1 text-sm font-medium">
                @foreach ([['route' => 'personil.index', 'label' => 'Personil'], ['route' => 'alumni.index', 'label' => 'Alumni']] as $nav)
                    <a href="{{ route($nav['route']) }}"
                        class="px-3 py-1.5 rounded-lg transition
                      {{ request()->routeIs(Str::before($nav['route'], '.') . '*')
                          ? 'bg-green-50 text-green-700 font-semibold'
                          : 'text-gray-500 hover:text-green-700 hover:bg-gray-50' }}">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- ── Flash Messages ─────────────────────────────────────── --}}
    @foreach (['error' => 'red', 'info' => 'blue', 'success' => 'green', 'warning' => 'yellow'] as $type => $color)
        @if (session($type))
            <div class="max-w-5xl mx-auto px-4 mt-4 flash-msg" data-color="{{ $color }}">
                <div
                    class="flash-inner flex items-start justify-between gap-3
                    bg-{{ $color }}-50 border border-{{ $color }}-200
                    text-{{ $color }}-700 px-4 py-3 rounded-xl text-sm shadow-sm
                    opacity-0 translate-y-1 transition-all duration-300">
                    <span>{{ session($type) }}</span>
                    <button onclick="this.closest('.flash-msg').remove()"
                        class="opacity-50 hover:opacity-100 transition text-lg leading-none mt-0.5 flex-shrink-0">
                        ×
                    </button>
                </div>
            </div>
        @endif
    @endforeach

    {{-- ── Main ───────────────────────────────────────────────── --}}
    <main class="max-w-5xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- ── Footer ─────────────────────────────────────────────── --}}
    <footer class="border-t mt-16 py-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} {{ $instansi?->nama ?? config('app.name') }} &nbsp;·&nbsp; Layanan SKL Digital
    </footer>

    <script>
        // Animate flash messages in, auto-dismiss after 4s
        document.querySelectorAll('.flash-msg .flash-inner').forEach(el => {
            requestAnimationFrame(() => {
                el.classList.remove('opacity-0', 'translate-y-1');
            });
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-4px)';
                setTimeout(() => el.closest('.flash-msg')?.remove(), 300);
            }, 4000);
        });
    </script>

    @stack('scripts')
</body>

</html>
