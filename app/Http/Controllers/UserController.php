<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
  {
        return view('users.index');
  }

  public function loadData(Request $request)
{
    $query = DB::table('users')->selectRaw('*');  

    $column_search = ['id','nama_lengkap','email','no_hp'];

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
            $btn = '<a href="' . route('user.show', ['id' => Crypt::encrypt($item->id)]) . '" class="btn btn-info btn-sm" style="margin-right:4px"><i class="uil-eye"></i></a>';
            $btn .= '<a href="' . route('user.edit', Crypt::encrypt($item->id)) . '" class="btn btn-warning btn-sm" style="margin-right:4px"><i class="uil-edit"></i></a>';
            $btn .= '<a href="javascript:void(0);" onclick="hapus(\'' . $item->id . '\',\'' . $item->nama_lengkap    . '\');" class="btn btn-danger btn-sm" style="margin-right:4px"><i class="fas fa-trash-alt"></i></a>';
           
            // Mengembalikan array dengan kolom data dan tombol aksi
            return [
                'id' => $item->id,
                'nama_lengkap' => $item->nama_lengkap,
                'email' => $item->email,
                'role' => $item->role,
                'no_hp' => $item->no_hp,
                'aksi' => $btn,
            ];
        })
        ->skipPaging() // Menjaga paging tetap aktif
        ->make(true); // Mengembalikan response DataTables
}

    public function tambah() 
    {
        return view('users.create');
    }

    public function simpan(Request $request)
    {
        $data = $request->data;
        $tanggal = date('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            $total = DB::select('SELECT COUNT(*) as total from users where username = ? or email = ?', [$data['username'],$data['email']]);
            $total = $total[0]->total;
            if ($total > 0) {
                return response()->json(['message' => '2']);
            }
            $idAwal = DB::table('users')->max('id');
            $id = $idAwal + 1;

            DB::table('users')->insert([

            'id' => $id,
            'nama_lengkap' => $data['nama'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'no_hp' => $data['no_hp'],
            'tanggal_daftar' => $tanggal,
            'password' => Hash::make( $data['password']),
            'created_at' => $tanggal,

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
        $tanggal = date('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            $total = DB::select('SELECT id from users where nama_lengkap = ?', [$data['nama']]);
         $id = $total[0]->id;
            DB::table('users')->where('id', $id)
            ->update([

            
            'nama_lengkap' => $data['nama'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'no_hp' => $data['no_hp'],
            'tanggal_daftar' => $tanggal,
            'password' => Hash::make( $data['password']),
            'updated_at' => $tanggal,

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
    $data = DB::table('users')->where('id', $id)->first();
    // dd($data);
   

    
    return view('users.show')->with('data', $data);
}
 public function edit($id)
{
    $id = Crypt::decrypt($id); // Dekripsi ID
    $data = DB::table('users')->where('id', $id)->first(); // Ambil data user

    return view('users.edit')->with('data', $data);}


    public function destroy(Request $request)
    {
        $id = $request->id;
        DB::beginTransaction();
        try {
            DB::table('users')->where('id', $id)->delete();
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

