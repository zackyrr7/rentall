<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class PemesananController extends Controller
{
  public function index()
  {
        return view('sewa.index');
  }

  public function loadData(Request $request)
{
    $status = $request->status;

    // Ubah status ke bentuk numerik yang sesuai
    $statusMap = [
        'Semua' => null,
        'Boking' => 0,
        'Berlangsung' => 1,
        'Selesai' => 2,
        'Batal' => 3,
        
    ];
    
    // Mulai query builder
    $query = DB::table('sewa as a')
        ->join('dsewa as b', 'a.id_sewa', '=', 'b.id_sewa')
        ->join('mobil as c', 'a.id_mobil', '=', 'c.id_mobil')
        ->join('users as d', 'a.id_user', '=', 'd.id')
        ->select(
            'a.id_sewa',
            'c.merk',
            'c.plat_nomor',
            'a.penyewa',
            'd.nama_lengkap',
            'b.tgl_ambil',
            'b.tgl_pulang',
            'a.status'
        );
    
    // Tambahkan kondisi status jika ada
    if (isset($statusMap[$status]) && $statusMap[$status] !== null) {
        $query->where('a.status', $statusMap[$status]);
    }
    
    // Eksekusi dan ambil data
    $query = $query;
  
    

    $column_search = ['c.merk','c.plat_nomor','a.penyewa','d.nama_lengkap','b.tgl_ambil','b.tgl_pulang','a.status'];

    // Filter query dengan pencarian
    $filtered = $query->where(function ($query) use ($column_search, $request) {
        foreach ($column_search as $eachElement) {
            $query->orWhere($eachElement, 'LIKE', '%' . $request->search['value'] . '%');
        }
    });

    // Menentukan jumlah total record
    if (!$request->search['value']) {
        $record_total = $query->count(); // Total record tanpa filter pencarian
        $data = $query
            ->skip($request->start)
            ->take($request->length)
            ->get();
    } else {
        $record_total = $filtered->count(); // Total record setelah filter pencarian
        $data = $filtered
            ->skip($request->start)
            ->take($request->length)
            ->get();
    }

    return DataTables::of($data)
        ->with([
            'recordsTotal' => $record_total,
            'recordsFiltered' => $record_total,
        ])
        ->rawColumns(['aksi']) // pastikan kolom 'aksi' bisa di-render dengan HTML
        ->addIndexColumn()
        ->setTransformer(function ($item) use ($status) {

            if ($item->status =='Boking') {
            $btn = '<a href="' . route('pemesanan.show', ['id' => Crypt::encrypt($item->id_sewa)]) . '" class="btn btn-info btn-sm" style="margin-right:4px"><i class="uil-eye"></i></a>';
            $btn .= '<a href="' . route('pemesanan.edit', Crypt::encrypt($item->id_sewa)) . '" class="btn btn-warning btn-sm" style="margin-right:4px"><i class="uil-edit"></i></a>';
            $btn .= '<a href="javascript:void(0);" onclick="hapus(\'' . $item->id_sewa . '\',\'' . $item->plat_nomor . '\');" class="btn btn-danger btn-sm" style="margin-right:4px"><i class="fas fa-trash-alt"></i></a>';
            
        } else{
                $btn = '<a href="' . route('pemesanan.show', ['id' => Crypt::encrypt($item->id_sewa)]) . '" class="btn btn-info btn-sm" style="margin-right:4px"><i class="uil-eye"></i></a>';

            }

            // Tombol aksi untuk masing-masing user
            
            // Mengembalikan array dengan kolom data dan tombol aksi
           
            return [
                'id_sewa' => $item->id_sewa,
                'merk' => $item->merk,
                'plat_nomor' => $item->plat_nomor,
                'penyewa' => $item->penyewa,
                'nama_lengkap' => $item->nama_lengkap,
                'tgl_ambil' => $item->tgl_ambil,
                'tgl_pulang' => $item->tgl_pulang,
                'status' => $item->status,
                'aksi' => $btn,
            ];
        })
        ->skipPaging() // Menjaga paging tetap aktif
        ->make(true); // Mengembalikan response DataTables
}

    public function tambah() 
    {
        $nama = DB::select("SELECT nama_lengkap,id from users");
        $data = [
            'nama'=>$nama
        ];
        
        return view('sewa.create')->with($data);
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
          AND c2.tgl_pulang <= '$tgl_ambil'
    ) AS tgl_pulang
FROM mobil a
WHERE a.id_mobil NOT IN (
    SELECT a2.id_mobil
    FROM mobil a2
    JOIN sewa b2 ON a2.id_mobil = b2.id_mobil
    JOIN dsewa c2 ON b2.id_sewa = c2.id_sewa
    WHERE
        ('$tgl_ambil' < c2.tgl_pulang AND '$tgl_pulang' > c2.tgl_ambil)
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



