<script type="text/javascript">
    $(document).ready(function() {
        // Setup CSRF Token untuk semua AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Cek dulu apakah sudah pernah diinisialisasi
        if (!$.fn.DataTable.isDataTable('#sewa')) {
            $('#sewa').DataTable({
                responsive: true,
                ordering: false,
                serverSide: true,
                processing: true,
                lengthMenu: [5, 10],
                ajax: {
                    url: "{{ route('pemesanan.load_data') }}",
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
                        data: 'plat_nomor',
                        name: 'plat_nomor',
                        className: "text-center",
                    },
                    {
                        data: 'penyewa',
                        name: 'penyewa',
                        className: "text-center",
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap',
                        className: "text-center",
                    },
                    {
                        data: 'tgl_ambil',
                        name: 'tgl_ambil',
                        className: "text-center",
                        render: function(data, type, row) {
                            return new Date(data).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                        }
                    },
                    {
                        data: 'tgl_pulang',
                        name: 'tgl_pulang',
                        className: "text-center",
                        render: function(data, type, row) {
                            return new Date(data).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                        }
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: "text-center",
                        render: function(data, type, row) {
                            let text = '';
                            let badgeClass = '';

                            switch (data) {
                                case 0:
                                    text = 'Boking';
                                    badgeClass = 'bg-warning text-dark';
                                    break;
                                case 1:
                                    text = 'Berlangsung';
                                    badgeClass = 'bg-primary';
                                    break;
                                case 2:
                                    text = 'Selesai';
                                    badgeClass = 'bg-success';
                                    break;
                                case 3:
                                    text = 'Batal';
                                    badgeClass = 'bg-danger';
                                    break;
                                default:
                                    text = 'Unknown';
                                    badgeClass = 'bg-secondary';
                            }

                            return `
                                            <span 
                                                class="badge ${badgeClass} status-badge" 
                                                style="cursor: pointer;" 
                                                data-status="${text}" 
                                                data-penyewa="${row.penyewa}" 
                                                data-ambil="${row.tgl_ambil}" 
                                                data-pulang="${row.tgl_pulang}">
                                                ${text}
                                            </span>
                            `;
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


    $(document).on('click', '.status-badge', function() {
        alert('muncul');
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
