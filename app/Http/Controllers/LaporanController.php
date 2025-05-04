<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use PDF;

class LaporanController extends Controller
{
  public function indexPendapatan()
  {
        return view('laporan.pendapatan.index');
  }

  
  public function cetakanPendapatan(Request $request)
  {


      
     
      $margin_atas = $request->margin_atas;
      $margin_bawah = $request->margin_bawah;
      $margin_kiri = $request->margin_kiri;
      $margin_kanan = $request->margin_kanan;
      $jenis_print = $request->jenis_print;
    $tgl_awal = $request->tgl_awal;
    $tgl_akhir = $request->tgl_akhir;

     
      $tgl_awal2 = tgl($request->tgl_awal);
      $tgl_akhir2 = tgl($request->tgl_akhir);
      
      $isi = DB::select("SELECT
		a.penyewa,
    c.merk,
    c.plat_nomor,
    c.harga_sewa,
    DATEDIFF(b.tgl_pulang, b.tgl_ambil) AS hari,
		b.diskon,b.total
FROM
    sewa a
    LEFT JOIN dsewa b ON a.id_sewa = b.id_sewa
    LEFT JOIN mobil c ON a.id_mobil = c.id_mobil
WHERE
    a.status = 2 and tgl_pulang BETWEEN '$tgl_awal' and '$tgl_akhir';
");
     


      $data = [


       
          'tgl_awal' => $tgl_awal2,
          'tgl_akhir' => $tgl_akhir2,
          'isi' => $isi
          
    


      ];
;
      $view = view('laporan.pendapatan.cetak')->with($data);
    if ($jenis_print == 'pdf') {
        $pdf = PDF::loadHtml($view)
        ->setOrientation('landscape')
        ->setPaper('a4');
     
    return $pdf->stream('laporan.pdf');
    
      } elseif ($jenis_print == 'excel') {
          header("Cache-Control:no-cache,no-store,must-revalidate");
          header("Content-Type:application/vnd.ms-excel");
          header("Content-Disposition:attachment;filename=laporan.xls");

          return $view;
      } else {
          return $view;
      }
  }


    public function getMobil(Request $request)
    {
        if($request->ajax()){
            $tipe = $request->tipe;
            $tgl_ambil = $request->tgl_ambil;
            $tgl_pulang = $request->tgl_pulang;
        }

        // $data = DB::select("SELECT
        //                     a.id_mobil,a.merk,a.tipe,a.plat_nomor,a.harga_sewa, c.tgl_ambil,c.tgl_pulang
        //                     FROM
        //                     mobil a
        //                     LEFT JOIN sewa b ON a.id_mobil = b.id_mobil
        //                     LEFT JOIN dsewa c on b.id_sewa = c.id_sewa
        //                     where a.tipe = '$tipe' and  (c.tgl_pulang > $tgl_ambil or c.tgl_pulang is null)");

                            $data = DB::select("SELECT a.*, 
    (
        SELECT MIN(c2.tgl_pulang)
        FROM sewa b2
        JOIN dsewa c2 ON b2.id_sewa = c2.id_sewa
        WHERE b2.id_mobil = a.id_mobil
          AND c2.tgl_pulang <= '$tgl_ambil' -- hanya ambil tanggal pulang ke depan
    ) AS tgl_pulang
FROM mobil a
WHERE a.id_mobil NOT IN (
    SELECT a2.id_mobil
    FROM mobil a2
    JOIN sewa b2 ON a2.id_mobil = b2.id_mobil
    JOIN dsewa c2 ON b2.id_sewa = c2.id_sewa
    WHERE
        ('$tgl_ambil' BETWEEN c2.tgl_ambil AND c2.tgl_pulang)
        OR ('$tgl_pulang' BETWEEN c2.tgl_ambil AND c2.tgl_pulang)
        OR (c2.tgl_ambil BETWEEN '$tgl_ambil' AND '$tgl_pulang')
        OR (c2.tgl_pulang BETWEEN '$tgl_ambil' AND '$tgl_pulang')
)
AND a.tipe = '$tipe';
");
                         
        return response()->json($data);
    }

    public function simpan(Request $request)
    {
        $data = $request->data;
    
       
       $id = DB::table('sewa')->max('id_sewa');
       if ($id == null) {
        $id = 1;
       } else{
        $id = $id+1;
       }

        DB::beginTransaction();
        try {
          

            DB::table('sewa')
            ->insert([
            
            'id_sewa' => $id,
            'id_mobil' => $data['id'],
            'id_user' => $data['anggota'],
            'status' => 0,
            'penyewa' => $data['penyewa'],
         
            ]);


            DB::table('dsewa')->insert([
                'id_sewa' => $id,
                'diskon' => $data['discount'],
                'harga' => $data['harga'],
                'total' => $data['total'],
                'tgl_ambil' => $data['tgl_ambil'],
                'tgl_pulang' => $data['tgl_pulang'],

            ]);



            DB::commit();
            return response()->json(['message' => '1']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => '0',
                'error'=> $th->getMessage()
            ]);
        }
    }
    public function simpanEdit(Request $request)
    {
        $data = $request->data;
    
    //  dd($data);
         DB::beginTransaction();
         try {
           
 
             DB::table('sewa')->where('id_sewa',$data['id'])
             ->update([
             
             
             'id_mobil' => $data['id'],
             'id_user' => $data['anggota'],
             'status' => 0,
             'penyewa' => $data['penyewa'],
          
             ]);
 
 
             DB::table('dsewa')->where('id_sewa',$data['id'])->
             update([
                 
                 'diskon' => $data['discount'],
                 'harga' => $data['harga'],
                 'total' => $data['total'],
                 'tgl_ambil' => $data['tgl_ambil'],
                 'tgl_pulang' => $data['tgl_pulang'],
 
             ]);
 
 
 
             DB::commit();
             return response()->json(['message' => '1']);
         } catch (\Throwable $th) {
             DB::rollBack();
             return response()->json([
                 'message' => '0',
                 'error'=> $th->getMessage()
             ]);
         }
    }

    public function show($id)
{
    // Mendekripsi ID yang diterima
    $id = Crypt::decrypt($id);
    
    // Ambil data user berdasarkan ID
    $data = DB::select("SELECT
	a.id_sewa,
	a.id_mobil,
	a.id_user,
	a.STATUS,
	a.penyewa,
	b.diskon,
	b.harga,
	b.total,
	b.tgl_ambil,
	b.tgl_pulang,
	c.tipe,
	c.merk,
	c.plat_nomor,
	d.nama_lengkap
FROM
	sewa AS a
	LEFT JOIN dsewa AS b ON a.id_sewa = b.id_sewa 
	LEFT JOIN mobil c on a.id_mobil = c.id_mobil
	LEFT JOIN users d on a.id_user = d.id
WHERE
	a.id_sewa = '$id'");
    // dd($data);
    
   

    
    return view('sewa.show')->with('data', $data);
}
 public function edit($id)
{
    $id = Crypt::decrypt($id); // Dekripsi ID
    $data = DB::select("SELECT
	a.id_sewa,
	a.id_mobil,
	a.id_user,
	a.STATUS,
	a.penyewa,
	b.diskon,
	b.harga,
	b.total,
	b.tgl_ambil,
	b.tgl_pulang,
	c.tipe,
	c.merk,
	c.plat_nomor,
	d.nama_lengkap
FROM
	sewa AS a
	LEFT JOIN dsewa AS b ON a.id_sewa = b.id_sewa 
	LEFT JOIN mobil c on a.id_mobil = c.id_mobil
	LEFT JOIN users d on a.id_user = d.id
WHERE
	a.id_sewa = '$id'");
    $nama = DB::select("SELECT nama_lengkap,id from users");
        
    return view('sewa.edit')->with([
        'data' => $data,
        'nama' => $nama
    ]);

}

  


    public function UpdateStatus(Request $request)
    {
        $id_sewa = $request->id_sewa;
        $tipe = $request->tipe;
       

        if ($tipe == 'Boking') {
            $status = 0;
        } elseif ($tipe == 'Berlangsung') {
            $status = 1;
        } elseif ($tipe == 'Selesai') {
            $status = 2;
        } else {
            $status = 3;
        }
      
    
        DB::beginTransaction();
        try {
            DB::table('sewa')->where('id_sewa', $id_sewa)->
            update(
                [
                    'status' =>$status,
                ]
            );
            DB::commit();
            return response()->json(['message' => '1']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => '0',
                'error'=> $th->getMessage()
            ]);
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->id_sewa;
    
        DB::beginTransaction();
        try {
            DB::table('sewa')->where('id_sewa', $id)->delete();
            DB::table('dsewa')->where('id_sewa', $id)->delete();
            DB::commit();
            return response()->json(['message' => '1']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => '0',
                'error'=> $th->getMessage()
            ]);
        }
    }

}



