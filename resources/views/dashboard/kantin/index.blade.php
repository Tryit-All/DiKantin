@extends('layout.main')
@section('title', 'Customer')
@section('content')
    <div class="container-fluid mt-3">
        <a href="/kantin/add/create" class="btn btn-dark text-white" style="padding: 7px; border-radius:10px;"> +
            Tambah Kantin Baru
        </a>

        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76%; !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-customer">
                <thead>
                    <tr>
                        @php
                            $no = 1;
                        @endphp
                    
                        <th>ID Kantin</th>
                        <th>Nama Kantin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kantin as $item)
                        <tr>
                            <th>{{ $item->id_kantin }}</th>
                            <th>{{ $item->nama }}</th>
                            <th>
                                <a href="{{url('/').'/kantin/'.$item->id_kantin}}" class="btn btn-primary">edit</a>
                                <form action="" method="post">
                                    @method('delete')
                                    @csrf
                                    <input type="text" name="id" hidden value="{{$item->id_kantin}}">
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-customer').DataTable()
        });

        // $(document).ready(function() {
        //     read();
        // });
        // read database
        // function read() {
        //     $.get("{{ url('read') }}", {}, function(data, status) {
        //         $("#read").html(data);
        //     });
        // }

        // untuk modal halaman create
        // function create() {
        //     $.get("{{ url('customer/create') }}", {}, function(data, status) {
        //         $('#exampleModalLabel').html('Add Customer');
        //         $('#page').html(data)
        //         $('#exampleModal').modal('show');
        //     });
        // }

        // untuk halaman edit show
        // function show(id) {
        //     $.get("{{ url('customer/show') }}/" + id, {}, function(data, status) {
        //         $('#exampleModalLabel').html('Edit Customer');
        //         $('#page').html(data)
        //         $('#exampleModal').modal('show');
        //     });
        // }

        // untuk proses simpan data
        // function store() {
        //     var id_customer = $('#id_customer').val();
        //     var nama = $('#nama').val();
        //     var alamat = $('#alamat').val();
        //     var no_telepon = $('#no_telepon').val();

        //     $.ajax({
        //         type: "get",
        //         url: "{{ url('/customer/store') }}",
        //         data: {
        //             id_customer: id_customer,
        //             nama: nama,
        //             alamat: alamat,
        //             no_telepon: no_telepon,
        //         },

        //         success: function(data) {
        //             $('.btn-close').click();

        //         }
        //     })
        // }
        // untuk proses update data
        function update(id) {
            var id_customer = $('#id_customer').val();
            var nama = $('#nama').val();
            var alamat = $('#alamat').val();
            var no_telepon = $('#no_telepon').val();

            $.ajax({
                type: "get",
                url: "{{ url('/customer/update') }}/" + id,
                data: {
                    id_customer: id_customer,
                    nama: nama,
                    alamat: alamat,
                    no_telepon: no_telepon,
                },

                success: function(data) {
                    $('.btn-close').click();
                }
            })
        }

        // function destroy(id) {
        //     var id_customer = $('#id_customer').val();
        //     var nama = $('#nama').val();
        //     var alamat = $('#alamat').val();
        //     var no_telepon = $('#no_telepon').val();
        //     $.ajax({
        //         type: "get",
        //         url: "{{ url('/customer/destroy') }}/" + id,
        //         data: {
        //             id_customer: id_customer,
        //             nama: nama,
        //             alamat: alamat,
        //             no_telepon: no_telepon,
        //         },

        //         success: function(data) {
        //             $('.btn-close').click();
        //         }
        //     })
        // }
    </script>
@endpush
