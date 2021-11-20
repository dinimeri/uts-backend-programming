<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // menampilkan data patients dari database
        $patients = Patient::all();
        // menghitung jumlah data pada tabel patient
        $total = count($patients);
        // jika resource ada
        if ($total) {
            // maka data akan ditampilkan
            $data = [
                'message' => 'Get all patients',
                'data' => $patients
            ];
            // mengirim data (json) dan kode 200
            return response()->json($data, 200);
        // jika resource tidak ada
        }else {
            // maka akan ditampilkan pesan 'Data is empty'
            $data = [
                'message' => 'Data is empty'
            ];
            // mengirim data (json) dan kode 200
            return response()->json($data, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // membuat validasi
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|min:10|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'null|date'
        ]);

        // menggunakan model Patient untuk insert data
        $patient = Patient::create($validated);

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patient,
        ];

        // mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $patient = Patient::find($id);

        if ($patient) {
            $data = [
                'message' => 'Get detail resource',
                'data' => $patient
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        }else {
            $data = [
                'message' => 'Resource not found'
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // cari id patient yang ingin diupdate
        $patient = Patient::find($id);

        if ($patient) {
            // menangkap data request
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];

            // melakukan update data
            $patient->update($input);

            $data = [
                'message' => 'Resource is updated successfully',
                'data' => $patient
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        // jika data tidak ada
        }else{
            // maka akan ditampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];
            // mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // cari id patient yang ingin dihapus
        $patient = Patient::find($id);
        // jika data patient ada
        if ($patient) {
            // maka hapus patient tersebut
            $patient->delete();

            $data = [
                'message' => 'Resource is deleted successfully'
            ];

            // mengembalikan data (json) ke kode 200
            return response()->json($data, 200);
        // jika data patient tidak ada
        }else {
            // maka akan ditampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];

            // mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    // membuat method search
    public function search($name) {
        // mencari resource patient dari name menggunakan where, get
        $patient = Patient::where('name', 'like', '%'.$name.'%')->get();
        // menghitung total patient
        $total = count($patient);
        // jika data ada
        if ($total) {
            // maka data akan ditampilkan
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $patient
            ];
            // mengembalikan data (json) ke kode 200
            return response()->json($data, 200);
        // jika data tidak ada
        }else {
            // maka akan ditampilkan pesan 'Resource not found'
            $data = [
                'message' => 'Resource not found'
            ];
            // mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    // membuat method positive
    public function positive() {
        // mencari resource status patient yang positive
        $patient = Patient::where('status', 'positive')->get();
        // menghitung total patient
        $total = count($patient);
        // menampilkan data
        $data = [
            'message' => 'Get positive resource',
            'total' => $total,
            'data' => $patient
        ];
        // mengembalikan data (json) ke kode 200
        return response()->json($data, 200);
    }

    // membuat method recovered
    public function recovered() {
        // mencari resource status patient yang recovered
        $patient = Patient::where('status', 'recovered')->get();
        // menghitung total patient
        $total = count($patient);
        // menampilkan data
        $data = [
            'message' => 'Get recovered resource',
            'total' => $total,
            'data' => $patient
        ];
        // mengembalikan data (json) ke kode 200
        return response()->json($data, 200);
    }

    // membuat method dead
    public function dead() {
        // mencari resource status patient yang dead
        $patient = Patient::where('status', 'dead')->get();
        // menghitung total patient
        $total = count($patient);
        // menampilkan data
        $data = [
            'message' => 'Get dead resource',
            'total' => $total,
            'data' => $patient
        ];
        // mengembalikan data (json) ke kode 200
        return response()->json($data, 200);
    }
}
