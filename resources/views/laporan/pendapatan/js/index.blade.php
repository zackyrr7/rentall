<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




        $('.cetak_laporan').on('click', function() {

            let tgl_awal = document.getElementById('tgl_awal').value;
            let tgl_akhir = document.getElementById('tgl_akhir').value;
            let jenis_print = $(this).data("jenis");



            let pilihan = true;
            if (!tgl_awal) {
                alert('Tanggal Awal belum di isi');
                return;
            }
            if (!tgl_akhir) {
                alert('Tanggal Akhir belum di isi');
                return;
            }



            let url = new URL("{{ route('pendapatan.preview') }}");
            let searchParams = url.searchParams;


            searchParams.append("tgl_awal", tgl_awal);
            searchParams.append("tgl_akhir", tgl_akhir);
            searchParams.append("jenis_print", jenis_print);




            searchParams.append("margin_atas", margin_atas);
            searchParams.append("margin_bawah", margin_bawah);
            searchParams.append("margin_kiri", margin_kiri);
            searchParams.append("margin_kanan", margin_kanan);
            window.open(url.toString(), "_blank");
        });
    });
</script>
