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
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Welcome</h3>
                        <p class="text-gray-600">{{ __("You're logged in!") }}</p>
                    </div>

                    <!-- CLIENT SECTION -->
                    <div class="mb-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">OAuth Clients</h3>
                            <button id="openCreateClientModal"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                                <i class="fas fa-plus-circle mr-2"></i> Create Client
                            </button>
                        </div>
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table id="clients-table"
                                class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                <thead>
                                    <tr class="text-left">
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-id-badge mr-2"></i>ID
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-user mr-2"></i>Name
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-key mr-2"></i>Secret
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-link mr-2"></i>Redirect
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-tools mr-2"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Rows from DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TOKEN SECTION -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Personal Access Tokens</h3>
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table id="tokens-table"
                                class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                <thead>
                                    <tr class="text-left">
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-id-badge mr-2"></i>ID
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-user mr-2"></i>Client
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-user mr-2"></i>User ID
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-ban mr-2"></i>Revoked
                                        </th>
                                        <th
                                            class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                            <i class="fas fa-tools mr-2"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Rows from DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CREATE CLIENT MODAL -->
                    <div id="createClientModal" class="fixed z-50 inset-0 hidden overflow-y-auto"
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
                                        <i class="fas fa-user-plus mr-2"></i> Create New Client
                                    </h3>
                                    <form id="createClientForm" class="mt-4">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="clientName"
                                                class="block text-gray-700 text-sm font-bold mb-2">Client Name</label>
                                            <input type="text" name="name" id="clientName"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="clientRedirect"
                                                class="block text-gray-700 text-sm font-bold mb-2">Redirect URL</label>
                                            <input type="text" name="redirect" id="clientRedirect"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                required>
                                        </div>
                                    </form>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button id="saveClient" type="button"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        <i class="fas fa-save mr-2"></i> Save
                                    </button>
                                    <button id="cancelClientModal" type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EDIT CLIENT MODAL -->
                    <div id="editClientModal" class="fixed z-50 inset-0 hidden overflow-y-auto"
                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <!-- [The content of this modal is similar to the Create Client Modal, adjust as needed] -->
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

    <script>
        $(document).ready(function() {
            // Initialize DataTables for Clients
            $('#clients-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('clients.list') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'secret',
                        name: 'secret'
                    },
                    {
                        data: 'redirect',
                        name: 'redirect'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="editClient btn btn-warning" data-id="${row.id}" data-name="${row.name}" data-redirect="${row.redirect}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="deleteClient btn btn-danger" data-id="${row.id}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            `;
                        }
                    }
                ]
            });

            // Initialize DataTables for Tokens
            $('#tokens-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('tokens.list') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'client',
                        name: 'client'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'revoked',
                        name: 'revoked'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="revokeToken btn btn-warning" data-id="${row.id}">
                                    <i class="fas fa-ban"></i> Revoke
                                </button>
                                <button class="deleteToken btn btn-danger" data-id="${row.id}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            `;
                        }
                    }
                ]
            });

            // Create Client Modal
            $('#openCreateClientModal').click(function() {
                $('#createClientModal').removeClass('hidden');
            });
            $('#cancelClientModal').click(function() {
                $('#createClientModal').addClass('hidden');
            });

            // Edit Client Modal
            $(document).on('click', '.editClient', function() {
                let clientId = $(this).data('id');
                let clientName = $(this).data('name');
                let clientRedirect = $(this).data('redirect');

                $('#editClientId').val(clientId);
                $('#editName').val(clientName);
                $('#editRedirect').val(clientRedirect);
                $('#editClientModal').removeClass('hidden');
            });

            // Close Edit Modal
            $('#cancelEditClientModal').click(function() {
                $('#editClientModal').addClass('hidden');
            });

            // Save New Client
            // Save New Client
            $('#saveClient').click(function(e) {
                e.preventDefault();

                let name = $('#clientName').val();
                let redirect = $('#clientRedirect').val();

                $.ajax({
                    url: '{{ route('clients.create') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: name,
                        redirect: redirect,
                    },
                    success: function(response) {
                        $('#createClientModal').addClass('hidden');
                        $('#createClientForm')[0].reset();
                        $('#clients-table').DataTable().ajax.reload();

                        // Display the client secret with copy button
                        Swal.fire({
                            title: 'Client Created Successfully!',
                            html: `
                    <p>Client ID: ${response.client_id}</p>
                    <p>
                        Client Secret: 
                        <input type="text" id="clientSecret" value="${response.client_secret}" readonly style="width: 60%; border: none; background: transparent;">
                        <button id="copySecret" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </p>
                    <p><strong>Important:</strong> Please copy and save this secret now. You won't be able to see it again!</p>
                `,
                            icon: 'success',
                            confirmButtonText: 'I have copied the secret',
                            didRender: () => {
                                document.getElementById('copySecret')
                                    .addEventListener('click', function() {
                                        const secretInput = document
                                            .getElementById('clientSecret');
                                        secretInput.select();
                                        secretInput.setSelectionRange(0,
                                            99999); // For mobile devices

                                        try {
                                            document.execCommand('copy');
                                            Swal.showValidationMessage(
                                                'Secret copied to clipboard!'
                                            );
                                            setTimeout(() => Swal
                                                .resetValidationMessage(),
                                                1500);
                                        } catch (err) {
                                            Swal.showValidationMessage(
                                                'Failed to copy: ' + err);
                                        }
                                    });
                            }
                        });
                    },
                    error: function(response) {
                        console.log(response);
                        Swal.fire('Error!', 'Failed to create client!', 'error');
                    }
                });
            });

            // Update Client via AJAX
            $('#updateClient').click(function(e) {
                e.preventDefault();

                let id = $('#editClientId').val();
                let name = $('#editName').val();
                let redirect = $('#editRedirect').val();

                $.ajax({
                    url: '{{ route('clients.update') }}',
                    type: 'PUT',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        name: name,
                        redirect: redirect,
                    },
                    success: function(response) {
                        $('#editClientModal').addClass('hidden');
                        $('#clients-table').DataTable().ajax.reload();
                        Swal.fire('Success!', 'Client updated successfully!', 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error!', 'Failed to update client!', 'error');
                    }
                });
            });

            // Delete Client via AJAX with SweetAlert
            $(document).on('click', '.deleteClient', function() {
                let clientId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/clients/' + clientId,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#clients-table').DataTable().ajax.reload();
                                Swal.fire('Deleted!', 'Client has been deleted.',
                                    'success');
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to delete client!',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Revoke Token via AJAX with SweetAlert
            $(document).on('click', '.revokeToken', function() {
                let tokenId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This token will be revoked!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, revoke it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/tokens/' + 'revoke/' + tokenId,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#tokens-table').DataTable().ajax.reload();
                                Swal.fire('Revoked!', 'Token has been revoked.',
                                    'success');
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to revoke token!', 'error');
                            }
                        });
                    }
                });
            });

            // Delete Token via AJAX with SweetAlert
            $(document).on('click', '.deleteToken', function() {
                let tokenId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/tokens/' + tokenId,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#tokens-table').DataTable().ajax.reload();
                                Swal.fire('Deleted!', 'Token has been deleted.',
                                    'success');
                            },
                            error: function() {
                                Swal.fire('Error!', 'Failed to delete token!', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
