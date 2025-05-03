<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>
    <style>
        #header tr>td {
            font-weight: bold;
            text-align: center;
            border: none;
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
        }


        /* #tabel_lap,
        td {
            border-collapse: collapse;
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
        } */

        #tabel_lap,
        td {
            border-collapse: collapse;
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
        }

        #tbody,
        /* td{
            /* width: 40%; */
        /* border-left: 1px solid;
            border-right: 1px solid; */
        /* border-top: none; */
        /* border-bottom: none;
            padding-bottom:10px;  */
        /* }  */
    </style>
</head>

<body>
    <table style="border-collapse:collapse;font-family: Open Sans; font-size:12px" width="100%" align="center"
        border="0" cellspacing="0" cellpadding="0" id="header">
        <tr>

            <td align="left" style="font-size:14px" width="93%">&nbsp;</td>
        </tr>
        <tr>
            <td align="left" style="font-size:14px" width="93%"><strong>Laporan Pendapatan</strong></td>
        </tr>
        <tr>
            <td align="left" style="font-size:14px" width="93%"><strong>ARTHA Royal</strong></td>
        </tr>

        <tr>
            <td align="left" style="font-size:14px"><strong>Periode {{ $tgl_awal }} s.d
                    {{ $tgl_akhir }}</strong> </td>
        </tr>

        <tr>
            <td align="left" style="font-size:14px"><strong>&nbsp;</strong></td>
        </tr>
    </table>

    <hr>
    <table style="width: 100%;font-size:12px" id="tabel_lap" border="1" class="horizontal-scroll" align='center'
        border='1' cellspacing='1' cellpadding='$spasi'>

        <thead>
            <tr>
                <th bgcolor='#CCCCCC'>No</th>
                <th bgcolor='#CCCCCC'>Penyewa</th>
                <th bgcolor='#CCCCCC'>Merk</th>
                <th bgcolor='#CCCCCC'>Plat Nomor</th>
                <th bgcolor='#CCCCCC'>Harga Sewa</th>
                <th bgcolor='#CCCCCC'>Hari</th>
                <th bgcolor='#CCCCCC'>Diskon</th>
                <th bgcolor='#CCCCCC'>Total</th>

            </tr>


        </thead>
        <tbody>


            @php
                $total2 = 0;
                $nomor = 1;
                $total_diskon = 0;

            @endphp
            @foreach ($isi as $row)
                @php
                    $no = $nomor++;
                    $total_diskon += $row->diskon;
                    $total2 += $row->total;
                    $penyewa = $row->penyewa;
                    $merk = $row->merk;
                    $plat_nomor = $row->plat_nomor;
                    $harga_sewa = $row->harga_sewa;
                    $hari = $row->hari;
                    $diskon = $row->diskon;
                    $total = $row->total;
                @endphp


                <tr>
                    <td align='center' width='5%' style="vertical-align: top">
                        {{ $no }}
                    </td>
                    <td align='center' style="vertical-align: top; width:8%">
                        {{ $penyewa }}
                    </td>
                    <td align='center' style="vertical-align: top;  width:8%">
                        {{ $merk }}
                    </td>
                    <td align='center' style="vertical-align: top; width:8%">
                        {{ $plat_nomor }}
                    </td>
                    <td align='right' style="vertical-align: top;  width:8%">
                        {{ rupiah($harga_sewa) }}
                    </td>
                    <td align='center' width='5%' style="padding-bottom:10px;padding-left:2px; padding-right:2px;">
                        {{ $hari }}
                    </td>
                    <td align='right' style="vertical-align: top; width:8%">
                        {{ rupiah($diskon) }}
                    </td>
                    <td align='right' style="vertical-align: top; width:8%">
                        {{ rupiah($total) }}
                    </td>


                </tr>
            @endforeach
            @php
                // dd($total2_brg);
            @endphp
            <tr style="font-weight: bold">
                <td colspan="6" align='center' style="vertical-align: top">
                    Total
                </td>

                <td align='right' style="vertical-align: top; width:8%">
                    {{ rupiah($total_diskon) }}
                </td>
                <td align='right' style="vertical-align: top; width:8%">
                    {{ rupiah($total2) }}
                </td>


            </tr>
        </tbody>

    </table>

    {{-- <table width='50%' style="font-size: 15px">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold; padding-left:50px;">Kas Bank : {{ rupiah($kas_bank[0]->jml) }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold; padding-left:50px;">Saldo Tunai :
                {{ rupiah($kas_tunai[0]->terimax - $kas_tunai[0]->keluarx) }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight: bold; padding-left:50px;">Pajak :
                {{ rupiah($pajak[0]->debetx - $pajak[0]->kreditx) }}</td>
        </tr>

    </table> --}}







</body>

</html>
