<script type="text/javascript">
    $(document).ready(function() {
        // Setup CSRF Token untuk semua AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Cek dulu apakah sudah pernah diinisialisasi
        if (!$.fn.DataTable.isDataTable('#user')) {
            $('#user').DataTable({
                responsive: true,
                ordering: false,
                serverSide: true,
                processing: true,
                lengthMenu: [5, 10],
                ajax: {
                    url: "{{ route('user.load_data') }}",
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
                        data: 'nama_lengkap',
                        name: 'nama_lengkap',
                        className: "text-center",
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: "text-center",
                    },
                    {
                        data: 'role',
                        name: 'role',
                        className: "text-center",
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                        className: "text-center",
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


    function hapus(id, nama_lengkap) {
        let tanya = confirm('Apakah anda yakin untuk menghapus data user dengan nama : ' + nama_lengkap);
        if (tanya == true) {
            $.ajax({
                url: "{{ route('user.hapus') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    id: id,

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
