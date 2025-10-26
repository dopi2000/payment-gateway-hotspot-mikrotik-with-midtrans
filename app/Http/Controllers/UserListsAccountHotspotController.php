<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Http\RedirectResponse;

class UserListsAccountHotspotController extends Controller
{
    public function index() {
        $title = 'Daftar Akun Hotspot Customer - Adeeva Grosir';
        $total_price = Payment::sum('price');
        $total_order = count(Payment::all());
        $orders = Payment::latest()->paginate(10);
        return view('frontend.user-lists-hotspot-account', compact('orders', 'title', 'total_price', 'total_order'));
    }

    public function login() {
        $title = 'Login Page Admin - Adeeva Grosir';
        return view('frontend.login-page-admin', compact('title'));
        
    }

    public function validatedAdmin(Request $request) : RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('lists.order');
        }
 
        return back();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('logout');
    }

    public function viewPdf() {
        $title = 'Daftar Akun Hotspot Customer - Adeeva Grosir';
        $total_price = Payment::sum('price');
        $total_order = count(Payment::all());
        $orders = Payment::latest()->get();
        $tailwind_css = Vite::content('resources/css/app.css');

        $pdf = Pdf::loadView('frontend.pdf-view', compact('orders', 'title', 'total_price', 'total_order', 'tailwind_css'));

         return $pdf->stream('daftar-penjualan-paket-hotspot.pdf');

    }
}
