<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tokens') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- TOKEN SECTION -->
                    <div>
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
                                            <i class="fas fa-calendar-alt mr-2"></i>Created At
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
                        data: 'created_at',
                        name: 'created_at',
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
