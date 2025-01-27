<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PayPalSetting;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        $pageTitle = "Admin Login";
        return view('backend.auth.login',compact('pageTitle'));
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin dashboard.');
        }

        return back()->with(['error' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'Admin logged out successfully.');
    }

    public function dashboard()
    {
        $pageTitle = "Admin Dashboard";
        $users = User::all();
        return view('backend.dashboard',compact('pageTitle','users'));
    }

    public function showPayPalSettings()
    {
        // Fetch PayPal settings
        $paypalSettings = PayPalSetting::first(); // Assuming only one record exists
        return view('backend.paypal-settings', compact('paypalSettings'));
    }

    public function updatePayPalSettings(Request $request)
    {
        // Validate PayPal credentials
        $request->validate([
            'client_id' => 'required|string',
            'secret' => 'required|string',
            'mode' => 'required|in:sandbox,live',
        ]);

        // Update or create PayPal settings
        $paypalSettings = PayPalSetting::first();

        if (!$paypalSettings) {
            // If PayPal settings don't exist, create a new one
            $paypalSettings = new PayPalSetting();
        }

        $paypalSettings->client_id = $request->client_id;
        $paypalSettings->secret = $request->secret;
        $paypalSettings->mode = $request->mode;
        $paypalSettings->save();

        // Update the .env file with the new PayPal credentials
        $this->updateEnvFile([
            'PAYPAL_CLIENT_ID' => $request->client_id,
            'PAYPAL_SECRET' => $request->secret,
            'PAYPAL_MODE' => $request->mode,
        ]);

        return redirect()->route('admin.paypal-settings')
            ->with('success', 'PayPal settings updated successfully');
    }

    protected function updateEnvFile(array $data){
        // Get the path to the .env file
        $envFilePath = base_path('.env');

        // Check if the .env file exists
        if (File::exists($envFilePath)) {
            // Get the content of the .env file
            $envContent = File::get($envFilePath);

            // Loop through each item in the data array
            foreach ($data as $key => $value) {
                // Check if the key already exists in the .env file
                if (strpos($envContent, $key) !== false) {
                    // If it exists, replace the line with the new value
                    $envContent = preg_replace(
                        "/^{$key}=(.*)$/m",
                        "{$key}={$value}",
                        $envContent
                    );
                } else {
                    // If the key does not exist, add it to the .env file
                    $envContent .= "\n{$key}={$value}";
                }
            }

            // Write the updated content back to the .env file
            File::put($envFilePath, $envContent);
        }
    }
}
