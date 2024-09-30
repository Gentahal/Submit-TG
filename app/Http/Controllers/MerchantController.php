<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Merchant;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan daftar merchant
        $merchants = Merchant::all();
        return view('merchant.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $merchant = Merchant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        // Log the merchant in after registration
        Auth::guard('merchant')->login($merchant);

        return redirect()->route('merchant.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $merchant = Merchant::findOrFail($id);
        return view('merchant.show', compact('merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $merchant = Merchant::findOrFail($id);
        return view('merchant.edit', compact('merchant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $merchant = Merchant::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $merchant->update($request->only(['company_name', 'address', 'phone', 'description']));

        return redirect()->route('merchant.dashboard')->with('status', 'Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merchant = Merchant::findOrFail($id);
        $merchant->delete();

        return redirect()->route('merchant.index')->with('status', 'Merchant deleted successfully');
    }

    public function showRegistrationForm()
    {
        return view('merchant.register');
    }

    public function register(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Buat merchant baru
        $merchant = Merchant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        Auth::login($merchant);

        return redirect()->route('merchant.dashboard');
    }


    public function showLoginForm()
    {
        return view('merchant.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('merchant')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('merchant.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        return view('merchant.dashboard');
    }

    public function updateProfile(Request $request)
    {
        $merchant = auth()->guard('merchant')->user();

        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $merchant->update($request->only(['company_name', 'address', 'phone', 'description']));

        return back()->with('status', 'Profile updated successfully');
    }

    public function logout(Request $request)
    {
        Auth::guard('merchant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}