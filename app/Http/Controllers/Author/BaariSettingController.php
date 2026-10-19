<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class BaariSettingController extends Controller
{

    public function index()
    {
        return view('author.pages.setting.index');
    }

    public function mailConfigure(Request $request)
    {
        $data = $request->validate([
            'host' => 'required|string|not_regex:/\s/',
            'port' => 'required|numeric',
            'username' => 'nullable|string',
            'password' => 'required|string',
            'encryption' => 'nullable|string|not_regex:/\s/',
            'from_address' => 'required|email',
        ]);

        //Trim whitespace from the host and encryption values
//        $data['host'] = str_replace(' ', '', $data['host']);
//        $data['encryption'] = str_replace(' ', '', $data['encryption']);

        $hashedPassword = Hash::make($data['password']);
        $data['password'] = $hashedPassword;

        // Read the current contents of the .env file
        $envFilePath = base_path('.env');
        $contents = file_get_contents($envFilePath);

        if ($contents !== false) {
            // Update specific fields in the contents
            $contents = preg_replace("/^MAIL_HOST=[^\r\n]*/m", "MAIL_HOST={$data['host']}", $contents);
            $contents = preg_replace("/^MAIL_PORT=[^\r\n]*/m", "MAIL_PORT={$data['port']}", $contents);
            $contents = preg_replace("/^MAIL_USERNAME=[^\r\n]*/m", "MAIL_USERNAME={$data['username'] }", $contents);
            $contents = preg_replace("/^MAIL_PASSWORD=[^\r\n]*/m", "MAIL_PASSWORD={$data['password']}", $contents);
            $contents = preg_replace("/^MAIL_ENCRYPTION=[^\r\n]*/m", "MAIL_ENCRYPTION={$data['encryption']}", $contents);
            $contents = preg_replace("/^MAIL_FROM_ADDRESS=[^\r\n]*/m", "MAIL_FROM_ADDRESS={$data['from_address']}", $contents);

            // Write the updated contents back to the .env file
            file_put_contents($envFilePath, $contents);
        }

        return response()->json(__('SMTP configuration saved successfully.'));

    }

}
