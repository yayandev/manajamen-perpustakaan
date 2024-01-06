@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Users</h5>

                        <div class="row gap-2 d-flex">
                            <div class="col-md-6">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalAdd"
                                    class="btn btn-sm btn-success "><i class="bi bi-plus"></i> Add
                                    User</button>
                            </div>
                            <form class="col-md-6 d-flex align-items-center gap-1" method="GET" action="">
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="Search" title="Enter search keyword">
                                <button type="submit" class="btn btn-sm btn-primary" title="Search"><i
                                        class="bi bi-search"></i></button>
                            </form>
                        </div>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <img src="{{ $user->profile_picture }}" width="40" height="40"
                                                    class="rounded-circle" alt="">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <button data-id="{{ $user->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit" type="button"
                                                    class="btn btn-info btn-sm"><i class="bi bi-pencil"></i></button>
                                                <a href="{{ route('users.resetpassword', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-arrow-counterclockwise">
                                                    </i></a>
                                                <button type="button" data-id="{{ $user->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalDelete" class="btn btn-danger btn-sm"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="" id="formDelete">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#modalDelete').on('show.bs.modal', function(e) {
                let button = $(e.relatedTarget)
                let id = button.data('id')

                $('#formDelete').attr('action', "/users/destroy/" + id)
            })
        })
    </script>

    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="level">Level</label>
                            <select name="level" id="level" required class="form-select">
                                <option value="" disabled selected>Select Level</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="" id="formEdit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nameUpdate">Name</label>
                            <input type="text" class="form-control" id="nameUpdate" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailUpdate">Email</label>
                            <input type="email" class="form-control" id="emailUpdate" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="levelUpdate">Level</label>
                            <select name="level" id="levelUpdate" required class="form-select">
                                <option value="" disabled selected>Select Level</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#modalEdit').on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget)
                var id = button.data('id')

                $.ajax({
                    type: "GET",
                    url: "/api/users/" + id,
                    success: function(data) {
                        $('#formEdit').attr('action', '/users/update/' + id)
                        $('#nameUpdate').val(data.name)
                        $('#emailUpdate').val(data.email)
                        $('#levelUpdate').val(data.role)
                    }
                })
            })
        })
    </script>
@endsection
