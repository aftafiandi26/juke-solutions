<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $provinces = file_get_contents('http://dev.farizdotid.com/api/daerahindonesia/provinsi');
        $provinces = json_decode($provinces, true);
        $provinces = $provinces['provinsi'];

        $employes = Employee::latest()->get();

        return view('home', compact(['provinces', 'employes']));
    }

    public function view($id)
    {
        $emp = Employee::find($id);

        $cover = asset(Storage::url($emp->photo_ktp));

        $return = '<div class="modal-body">
        <img src="' . $cover . '" alt="ktp" class="img img-fluid">
                    </div>';

        return $return;
    }
}
