<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getMobil() {
            let tipe = document.getElementById('tipe').value;
            let tgl_ambil = document.getElementById('tgl_ambil').value;
            let tgl_pulang = document.getElementById('tgl_pulang').value;

            $.ajax({
                url: "{{ route('pemesanan.getMobil') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    tipe: tipe,
                    tgl_ambil: tgl_ambil,
                    tgl_pulang: tgl_pulang
                },
                beforeSend: function() {
                    $("#overlay").fadeIn(100);
                },
                success: function(data) {
                    $('#mobil').empty();
                    $('#mobil').append(
                        `<option value="" disabled selected>Pilih Mobil</option>`);
                    $.each(data, function(index, data) {
                        $('#mobil').append(
                            `<option value="${data.id_mobil}" 
                             data-harga="${data.harga_sewa}" 
                             data-merk = "${data.merk}"
                             data-plat = "${data.plat_nomor}"
                             data-tgl_pulang = "${data.tgl_pulang}"
                            >${data.merk} |  ${data.plat_nomor} | Tanggal Pulang: ${data.tgl_pulang} </option>`
                        );
                    })
                },
                complete: function(data) {
                    $("#overlay").fadeOut(100);
                }
            });

        }



        $('#tipe, #tgl_ambil, #tgl_pulang').on('change', function() {
            $('#harga').val('');
            $('#discount').val('');
            $('#total').val('');
            let tipe = $('#tipe').val();
            let tgl_ambil = $('#tgl_ambil').val();
            let tgl_pulang = $('#tgl_pulang').val();



            if (tipe && tgl_ambil && tgl_pulang) {
                if (tgl_ambil > tgl_pulang) {
                    alert("Tanggal pengambilan tidak boleh lebih besar dari tanggal pengembalian!");
                    return;
                }
                let date_ambil = new Date(tgl_ambil);
                let date_pulang = new Date(tgl_pulang);
                let total_hari = (date_pulang - date_ambil) / (1000 * 60 * 60 * 24);
                $('#hari_sewa').val(total_hari);
                getMobil();
            }
        });


        $('#mobil').on('change', function() {
            let id = this.value;
            $('#id_mobil').val(id);

            let harga = $(this).find(':selected').data('harga');

            let hari_sewa = document.getElementById('hari_sewa').value;
            $('#harga').val(rupiah2(harga));
            let total = hari_sewa * harga;
            $('#total').val(rupiah2(total));
        })
        let timer

        $('#discount').on('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                let hari_sewa = document.getElementById('hari_sewa').value;
                let harga = rupiah(document.getElementById('harga').value);
                let discount = angka(document.getElementById('discount').value);
                let total = (hari_sewa * harga) - discount;
                $('#total').val(rupiah2(total));
            }, 500); // 
        })






        $('#simpan').on('click', function(e) {
            let tipe = document.getElementById('tipe').value;
            let id = document.getElementById('id_mobil').value;
            let tgl_ambil = document.getElementById('tgl_ambil').value;
            let tgl_pulang = document.getElementById('tgl_pulang').value;
            let harga = rupiah(document.getElementById('harga').value);
            let discount = angka(document.getElementById('discount').value);
            let total = rupiah(document.getElementById('total').value);
            let penyewa = document.getElementById('penyewa').value;
            let anggota = document.getElementById('anggota').value;





            if (!tipe) {
                return alert('Tipe harus diisi!')
            }
            if (!tgl_ambil) {
                return alert('tanggal ambil harus diisi!')
            }
            if (!tgl_pulang) {
                return alert('tanggal pulang harus diisi!')
            }
            if (!harga) {
                return alert('harga harus diisi!')
            }
            if (!penyewa) {
                return alert('penyewa harus diisi!')
            }
            if (!anggota) {
                return alert('anggota harus diisi!')
            }





            let data = {

                tipe,
                id,
                tgl_ambil,
                tgl_pulang,
                harga,
                discount,
                total,
                penyewa,
                anggota

            };

            $.ajax({
                url: "{{ route('pemesanan.simpanEdit') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    data: data,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.message == '1') {
                        alert('Data berhasil disimpan!');
                        window.location.href = "{{ route('pemesanan.index') }}";
                    } else if (response.message == '2') {
                        alert('Mobil sudah terdaftar');

                    } else {
                        alert('Data gagal disimpan!');

                    }
                }
            });
        });
        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });
    });


    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }



    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") {
            return;
        }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    function angka(n) {
        let nilai = n.split(',').join('');
        return parseFloat(nilai) || 0;
    }

    function rupiah(n) {
        let n1 = n.split('.').join('');
        let rupiah = n1.split(',').join('.');
        return parseFloat(rupiah) || 0;
    }

    function rupiah2(angka) {
        return parseInt(angka).toLocaleString('id-ID');
    }
</script>
