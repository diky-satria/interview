<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::orderBy('id', 'DESC')->get();

        if(request()->ajax()){
            return datatables()->of($data)
                                ->addColumn('price', function($data){
                                    return format_rupiah($data->price);
                                })
                                ->addColumn('aksi', function($data){
                                    $button = '<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="component.edit('. $data->id .')">Edit</button>';
                                    $button .= '<button class="btn btn-sm btn-danger ms-1" onclick="component.hapus('. $data->id .')">Hapus</button>';
                                    return $button;
                                })
                                ->rawColumns(['price','aksi'])
                                ->make(true);
        }

        return view('produk.produk');
    }

    public function show($id)
    {
        $data = Produk::find($id);

        return response()->json([
            'data' => $data
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ],[
            'name.required' => 'Nama harus di isi',
            'price.required' => 'Harga harus di isi',
            'price.numeric' => 'Harga harus angka'
        ]);

        Produk::create([
            'name' => ucwords(request('name')),
            'price' => request('price')
        ]);

        return response()->json([
            'message' => 'produk berhasil ditambahkan'
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ],[
            'name.required' => 'Nama harus di isi',
            'price.required' => 'Harga harus di isi',
            'price.numeric' => 'Harga harus angka'
        ]);

        $data = Produk::find($id);

        $data->update([
            'name' => ucwords(request('name')),
            'price' => request('price')
        ]);

        return response()->json([
            'message' => 'produk berhasil di edit'
        ]);
    }

    public function destroy($id)
    {
        $data = Produk::find($id);

        $data->delete();

        return response()->json([
            'message' => 'produk berhasil di hapus'
        ]);
    }
}
