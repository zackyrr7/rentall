<script type="text/javascript">
    $(document).ready(function() {
        // Setup CSRF Token untuk semua AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Cek dulu apakah sudah pernah diinisialisasi
        if (!$.fn.DataTable.isDataTable('#mobil')) {
            $('#mobil').DataTable({
                responsive: true,
                ordering: false,
                serverSide: true,
                processing: true,
                lengthMenu: [5, 10],
                ajax: {
                    url: "{{ route('mobil.load_data') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}"; // untuk keamanan Laravel
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center"
                    },
                    {
                        data: 'merk',
                        name: 'merk',
                        className: "text-center",
                    },
                    {
                        data: 'tipe',
                        name: 'tipe',
                        className: "text-center",
                    },
                    {
                        data: 'plat_nomor',
                        name: 'plat_nomor',
                        className: "text-center",
                    },
                    {
                        data: 'tahun',
                        name: 'tahun',
                        className: "text-center",
                    },
                    {
                        data: 'harga_sewa',
                        name: 'harga_sewa',
                        className: "text-center",
                        render: function(data, type, row) {
                            return parseInt(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '150px'
                    },
                ]
            });
        }
    });


    function hapus(id_mobil, plat_nomor) {
        let tanya = confirm('Apakah anda yakin untuk menghapus data moobil dengan plat : ' + plat_nomor);
        if (tanya == true) {
            $.ajax({
                url: "{{ route('mobil.hapus') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    id_mobil: id_mobil,

                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.message == '1') {
                        alert('Proses Hapus Berhasil');
                        window.location.reload();
                    } else {
                        alert('Proses Hapus Gagal...!!!');
                    }
                }
            })
        } else {
            return false;
        }
    }
</script>
