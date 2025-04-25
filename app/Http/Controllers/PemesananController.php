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
        return view('mobil.index');
  }

  public function loadData(Request $request)
{
    $query = DB::table('mobil')->selectRaw('*');  

    $column_search = ['plat_nomor','merk','tipe','tahun','harga_sewa'];

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
        ->setTransformer(function ($item) {

            // Tombol aksi untuk masing-masing user
            $btn = '<a href="' . route('mobil.show', ['id' => Crypt::encrypt($item->id_mobil)]) . '" class="btn btn-info btn-sm" style="margin-right:4px"><i class="uil-eye"></i></a>';
            $btn .= '<a href="' . route('mobil.edit', Crypt::encrypt($item->id_mobil)) . '" class="btn btn-warning btn-sm" style="margin-right:4px"><i class="uil-edit"></i></a>';
            $btn .= '<a href="javascript:void(0);" onclick="hapus(\'' . $item->id_mobil . '\',\'' . $item->plat_nomor . '\');" class="btn btn-danger btn-sm" style="margin-right:4px"><i class="fas fa-trash-alt"></i></a>';
            
            // Mengembalikan array dengan kolom data dan tombol aksi
            return [
                'id' => $item->id_mobil,
                'plat_nomor' => $item->plat_nomor,
                'merk' => $item->merk,
                'tipe' => $item->tipe,
                'tahun' => $item->tahun,
                'harga_sewa' => $item->harga_sewa,
                'aksi' => $btn,
            ];
        })
        ->skipPaging() // Menjaga paging tetap aktif
        ->make(true); // Mengembalikan response DataTables
}

    public function tambah() 
    {
        return view('mobil.create');
    }

    public function simpan(Request $request)
    {
        $data = $request->data;
        dd($data);
       
       

        DB::beginTransaction();
        try {
          

            DB::table('mobil')->where('id_mobil',$data['id'])
            ->update([
            
            'plat_nomor' => $data['plat'],
            'merk' => $data['merk'],
            'tipe' => $data['tipe'],
            'tahun' => $data['tahun'],
            'harga_sewa' => $data['harga'],
         

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
       
       

        DB::beginTransaction();
        try {
            $total = DB::select('SELECT COUNT(*) as total from mobil where plat_nomor = ?', [$data['plat']]);
        
            $total = $total[0]->total;
            if ($total > 0) {
                return response()->json(['message' => '2']);
            }
            $idAwal = DB::table('mobil')->max('id_mobil');
            if($idAwal == null){
                $idAwal = 0;
            }
         
            $id = $idAwal + 1;

            DB::table('mobil')->insert([
            'id_mobil' => $id,
            'plat_nomor' => $data['plat'],
            'merk' => $data['merk'],
            'tipe' => $data['tipe'],
            'tahun' => $data['tahun'],
            'harga_sewa' => $data['harga'],
         

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
    $data = DB::table('mobil')->where('id_mobil', $id)->first();
    // dd($data);
   

    
    return view('mobil.show')->with('data', $data);
}
 public function edit($id)
{
    $id = Crypt::decrypt($id); // Dekripsi ID
    $data = DB::table('mobil')->where('id_mobil', $id)->first(); // Ambil data user

    return view('mobil.edit')->with('data', $data);}

  
}
