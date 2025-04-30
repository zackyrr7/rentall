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
            let table = $('#sewa').DataTable({
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
                        d.status = document.getElementById('status').value;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center"
                    },
                    {
                        data: 'id_sewa',
                        name: 'id_sewa',
                        className: "text-center",
                        visible: false,
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
            $('#status').on('change', function() {
                table.ajax.reload();
            });
        }

    });




    $(document).on('click', '.status-badge', function() {
        let status = $(this).data('status');
        let table = $('#sewa').DataTable();
        let rowData = table.row($(this).closest('tr')).data();

        let id_sewa = rowData.id_sewa;
        let merk = rowData.merk;
        let penyewa = rowData.penyewa;
        let tgl_ambil = rowData.tgl_ambil;
        let tgl_pulang = rowData.tgl_pulang;

        $('#tgl_ambil2').val(new Date(tgl_ambil).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        }));
        $('#tgl_pulang2').val(new Date(tgl_pulang).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        }));
        $('#id_sewa2').val(id_sewa);
        $('#penyewa2').val(penyewa);
        $('#merk2').val(merk);


        if (status == 'Boking') {
            $('#modal_rincian_boking').modal('show');
        } else if (status == 'Berlangsung') {
            $('#modal_rincian_berlangsung').modal('show');
        } else if (status == 'Selesai') {
            alert('Status sudah selesai.')
        } else {
            alert('Status sudah dibatalkan. Buat booking baru untuk menyewa mobil ini.')
        }


    });

    $('#simpan_boking').on('click', function() {
        updateStatus();
    });


    function updateStatus() {
        let id_sewa = $('#id_sewa2').val();
        let tipe = document.getElementById('tipe').value;
        if (tipe == '') {
            alert('Silahkan pilih status terlebih dahulu');

        }
        let tanya = confirm('Apakah anda yakin untuk mengubah status sewa menjad :' + tipe);
        if (tanya == true) {
            $.ajax({
                url: "{{ route('pemesanan.updateStatus') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    id_sewa: id_sewa,
                    tipe: tipe,

                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.message == '1') {
                        alert('Proses update Berhasil');
                        window.location.reload();
                    } else {
                        alert('Proses update Gagal...!!!');
                    }
                }
            })
        } else {
            return false;
        }
    }

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
