<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log("JS create dimuat");
        $('#simpan').on('click', function(e) {
            e
                .preventDefault(); // <- penting untuk mencegah submit bawaan kalau tombol ada di dalam <form>



            let nama = $('#nm_lengkap').val();
            let username = $('#username').val();
            let email = $('#email').val();
            let role = $('#role').val();
            let no_hp = $('#no_hp').val();
            let password = $('#password').val();
            let confirmation_password = $('#kon_password').val();

            // Validasi
            if (!username || !nama || !email || !role || !no_hp || !password || !
                confirmation_password) {
                alert('Semua field harus diisi!');
                $(this).prop('disabled', false);
                return;
            }

            if (password !== confirmation_password) {
                alert('Password dan konfirmasi password tidak cocok');
                $(this).prop('disabled', false);
                return;
            }

            let data = {
                nama,
                username,
                email,
                role,
                no_hp,
                password,
            };

            $.ajax({
                url: "{{ route('user.simpan') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    data: data,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.message == '1') {
                        alert('Data berhasil disimpan!');
                        window.location.href = "{{ route('user.index') }}";
                    } else if (response.message == '2') {
                        alert('Email atau username telah digunakan!');

                    } else {
                        alert('Data gagal disimpan!');

                    }
                }
            });
        });
    });
</script>
