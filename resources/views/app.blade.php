<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description"
    content="TopUp Diamond Mobile Legends, Free Fire, PUBG, beli pulsa, kuota data, dan token PLN termurah & terpercaya. Proses cepat & aman di {{ config('app.name', 'dpxstore') }}}.">

  <script>
    (function() {
      const appearance = '{{ $appearance ?? 'system' }}';

      if (appearance === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (prefersDark) {
          document.documentElement.classList.add('dark');
        }
      }
    })();
  </script>

  {{-- Inline style to set the HTML background color based on our theme in app.css --}}
  <style>
    html {
      background-color: oklch(1 0 0);
    }

    html.dark {
      background-color: oklch(0.145 0 0);
    }
  </style>

  <title inertia>{{ config('app.name', 'dpxstore') }}</title>

  <link rel="icon" href="/storage/logos/01JWNX7GMVA925GY0Y2N7M7EY9.png" sizes="any">
  <meta property="og:title"
    content="TopUp Diamond, Pulsa, Data & Token PLN Murah | {{ config('app.name', 'dpxstore') }}">
  <meta property="og:description"
    content="TopUp cepat & terpercaya untuk semua kebutuhan game & digital. Diamond MLBB, FF, PUBG, pulsa, data, hingga token PLN.">
  <meta property="og:image" content="https://yourwebsite.com/og-image.jpg">



  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  {{-- production --}}
  {{-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-kmr_NHHdWEK1Nrrb"></script> --}}
  {{-- development --}}
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-fmQ24Cw8snD5mR8u"></script>

  @routes
  @viteReactRefresh
  @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
  @inertiaHead
</head>

<body class="font-sans antialiased overflow-x-hidden">
  @inertia
</body>

</html>
