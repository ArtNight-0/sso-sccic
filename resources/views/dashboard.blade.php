<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-10">
                        <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Statistik Pengguna dan Client</h3>
                        <div class="flex flex-wrap justify-center items-stretch">
                            <div class="w-full md:w-1/2 p-4">
                                <div class="bg-gray-100 rounded-lg p-6 h-full shadow-md">
                                    <h4 class="text-lg font-semibold mb-4 text-center text-gray-700">Status Pengguna
                                    </h4>
                                    <canvas id="userChart"></canvas>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 p-4">
                                <div class="bg-gray-100 rounded-lg p-6 h-full shadow-md">
                                    <h4 class="text-lg font-semibold mb-4 text-center text-gray-700">Pengguna Aktif per
                                        Client</h4>
                                    <canvas id="clientChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Leaderboard dengan warna yang disesuaikan -->
                        <div class="mt-10">
                            <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Top 5 Client Leaderboard</h3>
                            <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-lg p-6 shadow-lg">
                                <div id="leaderboardBody" class="space-y-4">
                                    <!-- Data leaderboard akan diisi oleh JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery, DataTables, SweetAlert2, and FontAwesome -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            console.log('Client Chart Canvas:', document.getElementById('clientChart'));

            function createUserChart(onlineUsers, offlineUsers) {
                const ctx = document.getElementById('userChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pengguna Online', 'Pengguna Offline'],
                        datasets: [{
                            data: [onlineUsers, offlineUsers],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(255, 99, 132, 0.8)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        },
                        cutout: '50%'
                    }
                });
            }

            function createClientChart(clientStats) {
                if (!clientStats || clientStats.length === 0) {
                    console.error('Data clientStats kosong atau tidak valid');
                    return;
                }

                const ctx = document.getElementById('clientChart');
                if (!ctx) {
                    console.error('Elemen canvas clientChart tidak ditemukan');
                    return;
                }

                const clientNames = clientStats.map(client => client.name);
                const activeUserCounts = clientStats.map(client => client.active_users_count);

                console.log('Client Names:', clientNames);
                console.log('Active User Counts:', activeUserCounts);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: clientNames,
                        datasets: [{
                            label: 'Pengguna Aktif',
                            data: activeUserCounts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' pengguna aktif';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Pengguna Aktif'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Client'
                                }
                            }
                        }
                    }
                });
            }

            function updateLeaderboard(clientStats) {
                const leaderboardBody = document.getElementById('leaderboardBody');
                leaderboardBody.innerHTML = '';

                // Urutkan clientStats berdasarkan jumlah pengguna aktif
                const sortedClients = clientStats.sort((a, b) => b.active_users_count - a.active_users_count);

                // Ambil 5 client teratas
                const topClients = sortedClients.slice(0, 5);

                const pastelColors = [
                    'bg-red-100 text-red-800',
                    'bg-yellow-100 text-yellow-800',
                    'bg-green-100 text-green-800',
                    'bg-blue-100 text-blue-800',
                    'bg-pink-100 text-pink-800'
                ];

                topClients.forEach((client, index) => {
                    const row = `
                        <div class="flex items-center bg-white rounded-lg p-4 shadow-md transform transition duration-300 hover:scale-105" style="opacity: 0; animation: fadeIn 0.5s ease-out forwards ${index * 0.1}s;">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gray-200 rounded-full mr-4">
                                <span class="text-2xl font-bold text-gray-700">${index + 1}</span>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-lg font-semibold text-gray-800">${client.name}</h4>
                                <p class="text-sm text-gray-600">${client.active_users_count} pengguna aktif</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-block px-3 py-1 ${pastelColors[index]} rounded-full text-sm font-semibold">
                                    ${client.active_users_count} <i class="fas fa-user-circle ml-1"></i>
                                </span>
                            </div>
                        </div>
                    `;
                    leaderboardBody.innerHTML += row;
                });
            }

            // Gunakan data yang dikirim langsung dari controller
            try {
                createUserChart({{ $onlineUsers }}, {{ $offlineUsers }});
                createClientChart(@json($clientStats));
                updateLeaderboard(@json($clientStats));
            } catch (error) {
                console.error('Error saat membuat chart atau leaderboard:', error);
            }

            // console.log untuk debugging
            console.log('Login success:', {{ json_encode(session('login_success')) }});
            console.log('Welcome shown:', {{ json_encode(session('welcome_shown')) }});

            @if (session('login_success') && !session('welcome_shown'))
                console.log('Menampilkan SweetAlert');
                Swal.fire({
                    title: 'Selamat Datang!',
                    text: '{{ __('Anda telah berhasil masuk!') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                @php
                    session(['welcome_shown' => true]);
                @endphp
            @else
                console.log('Tidak menampilkan SweetAlert');
            @endif
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #userChart,
        #clientChart {
            height: 300px !important;
        }
    </style>

    <a href="{{ route('logout.all') }}">Logout dari Semua Aplikasi</a>
</x-app-layout>
