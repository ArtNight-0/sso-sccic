<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">User List</h3>
                            <button id="openCreateUserModal"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                                <i class="fas fa-user-plus mr-2"></i> Add User
                            </button>
                        </div>
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table id="users-table"
                                class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                <thead>
                                    <tr class="text-left">
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-id-badge mr-2"></i>ID
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-user mr-2"></i>Nama
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-envelope mr-2"></i>Email
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-user-tag mr-2"></i>Role
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-calendar-alt mr-2"></i>Status
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-calendar-alt mr-2"></i>Created At
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-tools mr-2"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Rows from DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CREATE USER MODAL -->
                    <div id="createUserModal" class="fixed z-50 inset-0 hidden overflow-y-auto"
                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div
                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                aria-hidden="true">&#8203;</span>
                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Tambah User Baru
                                    </h3>
                                    <div class="mt-2">
                                        <form id="createUserForm">
                                            <div class="mb-4">
                                                <label for="name"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                                                <input type="text" id="name" name="name"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            </div>
                                            <div class="mb-4">
                                                <label for="email"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                                <input type="email" id="email" name="email"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            </div>
                                            <div class="mb-4">
                                                <label for="password"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                                                <div class="relative">
                                                    <input type="password" id="password" name="password"
                                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <span
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer toggle-password"
                                                        data-target="password">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="password_confirmation"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi
                                                    Password:</label>
                                                <div class="relative">
                                                    <input type="password" id="password_confirmation"
                                                        name="password_confirmation"
                                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <span
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer toggle-password"
                                                        data-target="password_confirmation">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="role"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                                                <select id="role" name="role"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <option value="user" selected>User</option>
                                                    <option value="admin">Admin</option>
                                                    <!-- Tambahkan opsi role lainnya sesuai kebutuhan -->
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" id="saveUser"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Simpan
                                    </button>
                                    <button type="button" id="cancelUserModal"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EDIT USER MODAL -->
                    <div id="editUserModal" class="fixed z-50 inset-0 hidden overflow-y-auto"
                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div
                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                aria-hidden="true">
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                aria-hidden="true">&#8203;</span>
                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Edit User
                                    </h3>
                                    <div class="mt-2">
                                        <form id="editUserForm">
                                            <input type="hidden" id="editUserId" name="id">
                                            <div class="mb-4">
                                                <label for="editName"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                                                <input type="text" id="editName" name="name"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            </div>
                                            <div class="mb-4">
                                                <label for="editEmail"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                                <input type="email" id="editEmail" name="email"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            </div>
                                            <div class="mb-4">
                                                <label for="editRole"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                                                <select id="editRole" name="role"
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                    <!-- Tambahkan opsi role lainnya sesuai kebutuhan -->
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" id="updateUser"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Update
                                    </button>
                                    <button type="button" id="cancelEditUserModal"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
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
            // Initialize DataTables for Users
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.list') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role',
                        render: function(data, type, row) {
                            return `<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-500 text-white">${data}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="editUser btn btn-warning" data-id="${row.id}" data-name="${row.name}" data-email="${row.email}" data-role="${row.role}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="deleteUser btn btn-danger" data-id="${row.id}">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            `;
                        }
                    }
                ]
            });

            // Create User Modal
            $('#openCreateUserModal').click(function() {
                $('#createUserModal').removeClass('hidden');
            });
            $('#cancelUserModal').click(function() {
                $('#createUserModal').addClass('hidden');
            });

            // Edit User Modal
            $(document).on('click', '.editUser', function() {
                let userId = $(this).data('id');
                let userName = $(this).data('name');
                let userEmail = $(this).data('email');
                let userRole = $(this).data('role');

                $('#editUserId').val(userId);
                $('#editName').val(userName);
                $('#editEmail').val(userEmail);
                $('#editRole').val(userRole);
                $('#editUserModal').removeClass('hidden');
            });

            // Close Edit Modal
            $('#cancelEditUserModal').click(function() {
                $('#editUserModal').addClass('hidden');
            });

            // Toggle password visibility
            $('.toggle-password').click(function() {
                let target = $(this).data('target');
                let input = $(`#${target}`);
                let icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Save New User
            $('#saveUser').click(function(e) {
                e.preventDefault();
                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let password_confirmation = $('#password_confirmation').val();
                let role = $('#role').val();

                // Tambahkan validasi di sini jika diperlukan
                if (password !== password_confirmation) {
                    Swal.fire('Error', 'Password dan konfirmasi password tidak cocok', 'error');
                    return;
                }

                $.ajax({
                    url: '{{ route('users.create') }}',
                    type: 'POST',
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        password_confirmation: password_confirmation,
                        role: role,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#createUserModal').addClass('hidden');
                        $('#users-table').DataTable().ajax.reload();
                        Swal.fire('Sukses', 'User berhasil ditambahkan', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Gagal menambahkan user', 'error');
                    }
                });
            });

            // Update User
            $('#updateUser').click(function(e) {
                e.preventDefault();
                let userId = $('#editUserId').val();
                let name = $('#editName').val();
                let email = $('#editEmail').val();
                let role = $('#editRole').val();

                $.ajax({
                    url: "{{ route('users.update', ':id') }}".replace(':id', userId),
                    type: 'PUT',
                    data: {
                        id: userId,
                        name: name,
                        email: email,
                        role: role,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#editUserModal').addClass('hidden');
                        $('#users-table').DataTable().ajax.reload();
                        Swal.fire('Sukses', 'User berhasil diperbarui', 'success');
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (let key in errors) {
                            errorMessage += errors[key][0] + '<br>';
                        }
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            // Delete User
            $(document).on('click', '.deleteUser', function() {
                let userId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/users/${userId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#users-table').DataTable().ajax.reload();
                                Swal.fire('Terhapus!', 'User telah dihapus.',
                                    'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Gagal menghapus user', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
