@extends('layouts.app')

@section('title', 'Perpustakaan')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Perpustakaan</h5>

                        <div class="row gap-2 d-flex">
                            <div class="col-md-6">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalAdd"
                                    class="btn btn-sm btn-success "><i class="bi bi-plus"></i> Add
                                    Perpustakaan</button>
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
                                        <th scope="col">Logo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perpustakaan as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <img src="{{ $item->image }}" width="40" height="40"
                                                    class="rounded-circle" alt="">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <button data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit" type="button"
                                                    class="btn btn-info btn-sm"><i class="bi bi-pencil"></i></button>
                                                <button type="button" data-id="{{ $item->id }}" data-bs-toggle="modal"
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
                    {{ $perpustakaan->links('pagination::bootstrap-5') }}
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

                $('#formDelete').attr('action', "/perpustakaan/destroy/" + id)
            })
        })
    </script>

    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data" action="{{ route('perpustakaan.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Perpustakaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat">alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" rows="3" class="form-control"></textarea>
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
                <form method="POST" action="" id="formEdit" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Perpustakaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nameUpdate">Name</label>
                            <input type="text" class="form-control" id="nameUpdate" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="logo">Logo</label>
                            <br>
                            <img src="" width="50" id="image" height="50" alt="">
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                        <div class="mb-3">
                            <label for="alamatUpdate">alamat</label>
                            <input type="text" class="form-control" id="alamatUpdate" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="bioUpdate">Bio</label>
                            <textarea name="bio" id="bioUpdate" rows="3" class="form-control"></textarea>
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
                    url: "/api/perpustakaan/" + id,
                    success: function(data) {
                        $('#formEdit').attr('action', '/perpustakaan/update/' + id)
                        $('#nameUpdate').val(data.name)
                        $('#alamatUpdate').val(data.alamat)
                        $('#bioUpdate').val(data.bio)
                        $('#image').attr('src', data.image)

                    }
                })
            })
        })
    </script>
@endsection
