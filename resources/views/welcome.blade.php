<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SSO-SmartX</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('assets/img/Logo/icon.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white dark:bg-gray-800 shadow">
            <nav class="container mx-auto px-6 py-3">
                <div class="flex justify-between items-center">
                    <div class="text-xl font-semibold text-gray-800 dark:text-white">
                        SSO-SmartX
                    </div>
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Log
                                    in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>
        </header>

        <main class="flex-grow container mx-auto px-6 py-8">
            <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-8">
                Selamat Datang di SSO-SmartX
            </h1>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Penggunaan di Aplikasi Klien
                        Non-Laravel</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Untuk menggunakan SSO-SmartX di aplikasi klien non-Laravel, ikuti langkah-langkah berikut:
                    </p>
                    <ol class="list-decimal list-inside text-gray-600 dark:text-gray-300">
                        <li>Implementasikan protokol OAuth 2.0 di aplikasi Anda</li>
                        <li>Gunakan endpoint SSO-SmartX untuk otentikasi</li>
                        <li>Verifikasi token yang diterima dari server SSO</li>
                        <li>Kelola sesi pengguna di aplikasi Anda</li>
                    </ol>
                    <p class="text-gray-600 dark:text-gray-300 mt-4">
                        Contoh penggunaan dalam PHP murni:
                    </p>
                    <pre class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-sm text-gray-800 dark:text-gray-300 overflow-x-auto">
                        $client_id = 'your_client_id';
                        $client_secret = 'your_client_secret';
                        $redirect_uri = 'https://your-app.com/callback';

                        // Redirect pengguna ke halaman login SSO
                        $auth_url = "https://sso.smartx.com/oauth/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&response_type=code";
                        header("Location: {$auth_url}");
                        exit;

                        // Di halaman callback:
                        if (isset($_GET['code'])) {
                            $code = $_GET['code'];
                            
                            // Tukar kode dengan access token
                            $token_url = "https://sso.smartx.com/oauth/token";
                            $data = [
                                'grant_type' => 'authorization_code',
                                'client_id' => $client_id,
                                'client_secret' => $client_secret,
                                'redirect_uri' => $redirect_uri,
                                'code' => $code
                            ];
                            
                            // Kirim permintaan untuk mendapatkan token
                            // Implementasikan logika untuk mengirim permintaan POST
                            
                            // Verifikasi dan gunakan token
                            // Implementasikan logika untuk memverifikasi dan menggunakan token
                        }
                    </pre>
                </div>

                <!-- Bagian baru untuk informasi skema SSO -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Skema SSO SmartX</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        SSO-SmartX menggunakan arsitektur terpusat dengan komponen utama sebagai berikut:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4">
                        <li>Server SSO: Pusat otentikasi dan otorisasi</li>
                        <li>Client Dashboard: Kumpulan tautan ke berbagai simulator klien</li>
                        <li>Client Simulator: Berbagai aplikasi simulasi untuk menguji integrasi SSO</li>
                    </ul>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded">
                        <pre class="text-sm text-gray-800 dark:text-gray-300 overflow-x-auto">
┌─────────────┐      ┌─────────────────┐
│             │      │                 │
│  SSO Server │◄────►│ Client Dashboard│
│             │      │  (Link Hub)     │
└─────┬───────┘      └───────┬─────────┘
      │                      │
      │                      │
      │         ┌────────────┼────────────┐
      │         │            │            │
      ▼         ▼            ▼            ▼
┌─────────────┐ ┌─────────────┐ ┌─────────────┐
│  Client     │ │  Client     │ │  Client     │
│ Simulator 1 │ │ Simulator 2 │ │ Simulator 3 │
└─────────────┘ └─────────────┘ └─────────────┘
                        </pre>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mt-4">
                        Alur kerja:
                    </p>
                    <ol class="list-decimal list-inside text-gray-600 dark:text-gray-300">
                        <li>Server SSO menangani otentikasi dan otorisasi untuk semua aplikasi</li>
                        <li>Client Dashboard berfungsi sebagai hub yang menyediakan akses ke berbagai simulator klien
                        </li>
                        <li>Setiap Client Simulator merepresentasikan aplikasi berbeda yang terintegrasi dengan SSO</li>
                        <li>Pengguna dapat mengakses dan menguji berbagai skenario SSO melalui simulator-simulator ini
                        </li>
                    </ol>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow md:col-span-2">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Penggunaan SSO-SmartX sebagai
                        Server</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        SSO-SmartX berfungsi sebagai server SSO yang memungkinkan Anda mengelola otentikasi terpusat
                        untuk berbagai aplikasi. Berikut adalah langkah-langkah penggunaan SSO-SmartX sebagai server:
                    </p>
                    <ol class="list-decimal list-inside text-gray-600 dark:text-gray-300">
                        <li class="mb-2">Login ke dashboard admin SSO-SmartX</li>
                        <li class="mb-2">Navigasi ke tab "Client"</li>
                        <li class="mb-2">Klik tombol "Create Client"</li>
                        <li class="mb-2">Isi formulir dengan informasi aplikasi klien:
                            <ul class="list-disc list-inside ml-4 mt-2">
                                <li>Nama Client</li>
                                <li>Redirect Link Client (contoh: http://example_client.com/auth/callback)</li>
                            </ul>
                        </li>
                        <li class="mb-2">Klik tombol "Simpan" atau "Create"</li>
                        <li class="mb-2">Sistem akan menghasilkan Client ID dan Client Secret</li>
                        <li class="mb-2">Salin Client ID dan Client Secret yang dihasilkan</li>
                        <li>Gunakan Client ID dan Client Secret ini dalam konfigurasi aplikasi klien Anda</li>
                    </ol>
                    <div class="mt-6 p-4 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <p class="text-yellow-800 dark:text-yellow-200 font-semibold">Penting:</p>
                        <ul class="list-disc list-inside text-yellow-700 dark:text-yellow-300 mt-2">
                            <li>Jaga kerahasiaan Client Secret. Jangan pernah membagikannya kepada pihak yang tidak
                                berwenang.</li>
                            <li>Jika Client Secret terekspos, segera buat ulang di dashboard admin.</li>
                            <li>Pastikan Redirect Link Client yang didaftarkan sesuai dengan yang digunakan di aplikasi
                                klien Anda.</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow md:col-span-2">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Fitur Utama SSO-SmartX Server
                    </h2>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300">
                        <li class="mb-2">Manajemen aplikasi klien terpusat</li>
                        <li class="mb-2">Pembuatan dan pengelolaan Client ID dan Client Secret otomatis</li>
                        <li class="mb-2">Pemantauan aktivitas login dan penggunaan token</li>
                    </ul>
                </div>
            </div>
        </main>

        <footer class="bg-white dark:bg-gray-800 shadow mt-8">
            <div class="container mx-auto px-6 py-3 text-center text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} SSO-SmartX. All rights reserved.</p>
                <p class="mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
