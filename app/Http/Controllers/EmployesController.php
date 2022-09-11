<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class EmployesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'firstName'     => 'required|string|min:3',
            'lastName'      => 'required|string',
            'datepicker'    => 'required|date',
            'email'         => 'required|email',
            'provinsi'      => 'required',
            'city'          => 'required',
            'address'       => 'required',
            'ktp'           => 'required|numeric|min:4',
            'photo_ktp'     => 'required|file|mimes:jpg,png',
            'bank_position' => 'required',
            'account'       => 'required|numeric|min:4',
            'phone'         => 'required|numeric|min:4',
            'position'      => 'required'
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            toast('Sorry, something wrong !!', 'error');
            return redirect()->route('home')
                ->withErrors($validator)
                ->withInput();
        }

        $url = file_get_contents("https://dev.farizdotid.com/api/daerahindonesia/provinsi/" . $request->provinsi);
        $url = json_decode($url, true);
        $url = $url['nama'];

        if (!empty($request->photo_ktp)) {
            $path = Storage::putFile('public/employes', $request->photo_ktp);
        }

        $data = [
            'first_name'    => $request->firstName,
            'last_name'     => $request->lastName,
            'bod'           => $request->datepicker,
            'email'         => $request->email,
            'position'      => $request->position,
            'province'      => $url,
            'province_id'   => $request->provinsi,
            'city'          => $request->city,
            'ktp'           => $request->ktp,
            'photo_ktp'     => $path,
            'rek_bank_position' => $request->bank_position,
            'rek_bank'      => $request->account,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'code_pos'      => $request->code_pos
        ];

        // dd($data);

        Employee::create($data);
        Alert::success('Data berhasil ditambahkan');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $emp = Employee::find($id);

        $rule = [
            'firstName'     => 'required|string|min:3',
            'lastName'      => 'required|string',
            'datepicker'    => 'required|date',
            'email'         => 'required|email',
            'provinsi'      => 'required',
            'city'          => 'required',
            'address'       => 'required',
            'ktp'           => 'required|numeric|min:4',
            'photo_ktp'     => 'file|mimes:jpg,png',
            'bank_position' => 'required',
            'account'       => 'required|numeric|min:4',
            'phone'         => 'required|numeric|min:4',
            'position'      => 'required'
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            toast('Sorry, something wrong !!', 'error');
            return redirect()->route('home')
                ->withErrors($validator)
                ->withInput();
        }

        $url = file_get_contents("https://dev.farizdotid.com/api/daerahindonesia/provinsi/" . $request->provinsi);
        $url = json_decode($url, true);
        $url = $url['nama'];

        $path = $emp->photo_ktp;

        if (!empty($request->photo_ktp)) {
            Storage::delete($emp->photo_ktp);
            $path = Storage::putFile('public/employes', $request->photo_ktp);
        }

        $data = [
            'first_name'    => $request->firstName,
            'last_name'     => $request->lastName,
            'bod'           => $request->datepicker,
            'email'         => $request->email,
            'position'      => $request->position,
            'province'      => $url,
            'province_id'   => $request->provinsi,
            'city'          => $request->city,
            'ktp'           => $request->ktp,
            'photo_ktp'     => $path,
            'rek_bank_position' => $request->bank_position,
            'rek_bank'      => $request->account,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'code_pos'      => $request->code_pos
        ];

        // dd($data);

        Employee::where('id', $id)->update($data);
        Alert::success('Data berhasil ditambahkan');
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "Ini halaman delete";
    }
}
