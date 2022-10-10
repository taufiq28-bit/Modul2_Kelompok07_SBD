<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        $datas = DB::select('select * from admin');

        return view('admin.index')
            ->with('datas', $datas);
    }

    public function create() {
        return view('admin.add');
    }

    public function store(Request $request) {
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::insert('INSERT INTO admin(id_admin, nama_admin, alamat, username, password) VALUES (:id_admin, :nama_admin, :alamat, :username, :password)',
        [
            'id_admin' => $request->id_admin,
            'nama_admin' => $request->nama_admin,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]
        );

        // Menggunakan laravel eloquent
        // Admin::create([
        //     'id_admin' => $request->id_admin,
        //     'nama_admin' => $request->nama_admin,
        //     'alamat' => $request->alamat,
        //     'username' => $request->username,
        //     'password' => Hash::make($request->password),
        // ]);

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil disimpan');
    }

    public function edit($id) {
        $data = DB::table('admin')->where('id_admin', $id)->first();

        return view('admin.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::update('UPDATE admin SET id_admin = :id_admin, nama_admin = :nama_admin, alamat = :alamat, username = :username, password = :password WHERE id_admin = :id',
        [
            'id' => $id,
            'id_admin' => $request->id_admin,
            'nama_admin' => $request->nama_admin,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]
        );

        // Menggunakan laravel eloquent
        // Admin::where('id_admin', $id)->update([
        //     'id_admin' => $request->id_admin,
        //     'nama_admin' => $request->nama_admin,
        //     'alamat' => $request->alamat,
        //     'username' => $request->username,
        //     'password' => Hash::make($request->password),
        // ]);

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diubah');
    }

    public function delete($id) {
        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::delete('DELETE FROM admin WHERE id_admin = :id_admin', ['id_admin' => $id]);

        // Menggunakan laravel eloquent
        // Admin::where('id_admin', $id)->delete();

        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus');
    }

}