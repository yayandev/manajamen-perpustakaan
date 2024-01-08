@extends('layouts.app')

@section('title', 'Buku')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Buku</h5>

                        <div class="row gap-2 d-flex">
                            <div class="col-md-6">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalAdd"
                                    class="btn btn-sm btn-success "><i class="bi bi-plus"></i> Add
                                    Buku</button>
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bukus as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <img src="{{ $item->image }}" width="40" height="40" alt="">
                                            </td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->kategori->name }}</td>
                                            <td>
                                                <button data-id="{{ $item->slug }}" data-bs-toggle="modal"
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
                    {{ $bukus->links('pagination::bootstrap-5') }}
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

                $('#formDelete').attr('action', "/buku/destroy/" + id)
            })
        })
    </script>

    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data" action="{{ route('buku.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="author">author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher">publisher</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" required>
                        </div>
                        <div class="mb-3">
                            <label for="year">year</label>
                            <input type="number" class="form-control" id="year" name="year" required>
                        </div>
                        <div class="mb-3">
                            <label for="isbn">isbn</label>
                            <input type="number" class="form-control" id="isbn" name="isbn" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori">kategori</label>
                            <select name="kategori_id" id="kategori" class="form-select" required>
                                <option value="" disabled selected>Select kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description">description</label>
                            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
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
                        <h5 class="modal-title">Edit Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="titleUpdate" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <br>
                            <img src="" width="100" id="imageUpdate" alt="">
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="author">author</label>
                            <input type="text" class="form-control" id="authorUpdate" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher">publisher</label>
                            <input type="text" class="form-control" id="publisherUpdate" name="publisher" required>
                        </div>
                        <div class="mb-3">
                            <label for="year">year</label>
                            <input type="number" class="form-control" id="yearUpdate" name="year" required>
                        </div>
                        <div class="mb-3">
                            <label for="isbn">isbn</label>
                            <input type="number" class="form-control" id="isbnUpdate" name="isbn" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori">kategori</label>
                            <select name="kategori_id" id="kategoriUpdate" class="form-select" required>
                                <option value="" disabled selected>Select kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description">description</label>
                            <textarea name="description" id="descriptionUpdate" rows="3" class="form-control"></textarea>
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
                    url: "/api/buku/" + id,
                    success: function(response) {
                        let data = response.data;
                        $('#formEdit').attr('action', '/buku/update/' + data.id)
                        $('#titleUpdate').val(data.title)
                        $('#imageUpdate').attr('src', data.image)
                        $('#authorUpdate').val(data.author)
                        $('#publisherUpdate').val(data.publisher)
                        $('#yearUpdate').val(data.year)
                        $('#isbnUpdate').val(data.isbn)
                        $('#kategoriUpdate').val(data.kategori_id)
                        $('#descriptionUpdate').val(data.description)
                    }
                })
            })
        })
    </script>
@endsection
