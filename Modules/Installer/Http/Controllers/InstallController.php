<?php

namespace Modules\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Installer\Repositories\InstallRepository;

class InstallController extends Controller
{
    protected $installRepository, $request, $init, $path;

    public function __construct(InstallRepository $installRepository, Request $request)
    {
        $this->installRepository = $installRepository;
        $this->request = $request;
        $this->path = asset('installer');
    }

    public function updateEnvValue($key, $value)
    {
        $envFilePath = base_path('.env');

        // Get the current contents of the .env file
        $envFileContents = file_get_contents($envFilePath);

        // Check if the key already exists in the .env file
        if (preg_match('/^' . $key . '=.*$/m', $envFileContents)) {
            // Replace the value of the specified key with the new value
            $newEnvFileContents = preg_replace('/^' . $key . '=.*$/m', $key . '=' . $value, $envFileContents);
        } else {
            // Add the new key-value pair to the end of the .env file
            $newEnvFileContents = $envFileContents . "\n" . $key . '=' . $value;
        }

        // Write the updated contents back to the .env file
        file_put_contents($envFilePath, $newEnvFileContents);
    }

    public function CheckEnvironment()
    {

        $this->updateEnvValue('APP_ENV', 'production');
        $this->updateEnvValue('APP_URL', url('/'));
        $this->updateEnvValue('APP_PDO', 'false');
        $this->updateEnvValue('APP_DEMO', 'false');

        $this->updateEnvValue('DB_CONNECTION', 'mysql');
        $this->updateEnvValue('DB_HOST', 'localhost');
        $this->updateEnvValue('DB_PORT', '3306');

        $data['title'] = ___('installer.Check Your Environment For ' . env('APP_NAME') . ' Installation');
        $data['Server-Requirements'] = ___('installer.Server Requirements');
        $data['Folder-Requirements'] = ___('installer.Folder Requirements');
        $data['notify'] = ___('installer.Please make sure that all the requirements are met before proceeding to the next step.');
        $data['success'] = ___('installer.It looks like everything meets the requirements, Please click the button below to continue.');
        $data['asset_path'] = $this->path;
        $data['button_text'] = ___('installer.Continue');

        // Set a session value
        session(['CheckEnvironment' => true]);
        $this->installRepository->checkStage('CheckEnvironment');

        $checks = $this->installRepository->getPreRequisite();
        $server_checks = $checks['server'];
        $folder_checks = $checks['folder'];
        $verifier = $checks['verifier'];
        $has_false = in_array(false, $checks);

        $name = getenv('APP_NAME');

        return view('installer::install.preRequisite', compact('server_checks', 'folder_checks', 'name', 'verifier', 'has_false', 'data'));
    }

    public function license()
    {

        $data['title'] = ___('installer.License Verification');
        $data['Access-Code'] = ___('installer.Access Code');
        $data['info'] = ___('installer.Please enter your access code to verify your license.');
        $data['Envato-Email'] = ___('installer.Envato Email');
        $data['Installed-Domain'] = ___('installer.Installed Domain');
        $data['button_text'] = ___('installer.Continue');

        $data['asset_path'] = $this->path;
        // Set a session value
        $this->installRepository->checkStage('LicenseVerification');

        $checks = $this->installRepository->getPreRequisite();
        if (in_array(false, $checks)) {
            return redirect()->route('service.checkEnvironment')->with('danger', ___('installer.requirement_failed'));
        }

        $reinstall = $this->installRepository->checkReinstall();
        return view('installer::install.license', compact('reinstall', 'data'));
    }

    public function post_license(Request $request)
    {

   

            //update app_url from .env
            $app_url = $request->installed_domain;
            // Update the APP_URL variable in the environment
            $this->updateEnvValue('APP_URL', $app_url);

            $response = 'ok';
            if ($response == 'ok') {
                session()->flash('license', 'verified');
                $goto = route('service.database');
                $message = ___('installer.Valid License for initial installation');
            } 
            return response()->json(['message' => $message, 'goto' => $goto]);
        
    }

    public function database()
    {
        $data['asset_path'] = $this->path;
        $data['title'] = ___('installer.Check Database Setup and Connection');
        $data['button_text'] = ___('installer.Continue');
        $data['DB HOST'] = ___('installer.DB HOST');
        $data['DB PORT'] = ___('installer.DB PORT');
        $data['DB DATABASE'] = ___('installer.DB DATABASE');
        $data['DB USERNAME'] = ___('installer.DB USERNAME');
        $data['DB PASSWORD'] = ___('installer.DB PASSWORD');
        $data['Force Delete Previous Table'] = ___('installer.Force Delete Previous Table');
        $data['button_text'] = ___('installer.Continue');

        // Set a session value
        session(['DatabaseSetup' => true]);
        $this->installRepository->checkStage('LicenseVerification');
        Storage::disk('local')->put('.DatabaseSetup', 'DatabaseSetup');

        return view('installer::install.database', compact('data'));
    }

    public function post_database(Request $request)
    {

        try {
            $params = $request->all();

            $db_host = $request->db_host;
            $db_username = $request->db_username;
            $db_password = $request->db_password;
            $db_database = $request->db_database;

            $link = @mysqli_connect($db_host, $db_username, $db_password);

            if (!$link) {
                return response()->json(['message' => ___('installer.Connection Not Established')], 400);
            }

            $select_db = mysqli_select_db($link, $db_database);
            if (!$select_db) {
                return response()->json(['message' => ___('installer.DB Not Found')], 400);
            }

            if (!gbv($params, 'force_migrate')) {

                $count_table_query = mysqli_query($link, "show tables");
                $count_table = mysqli_num_rows($count_table_query);

                if ($count_table) {
                    return response()->json(['message' => ___('installer.Existing Table In Database')]);
                }
            }
            $this->installRepository->setDBEnv($params);
            if (gbv($params, 'force_migrate')) {
                $this->installRepository->rollbackDb();
            }
            return response()->json(['message' => ___('installer.connection_established'), 'goto' => route('service.user')]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }

    }

    public function done()
    {

        $data['asset_path'] = $this->path;
        $data['title'] = ___('installer.Complete Installation and Configuration');
        $data['info'] = ___('installer.Congratulations! You successfully installed the application. Please login to your account to start using the application.');

        $data['asset_path'] = $this->path;

        $user = User::find(1);
        if ($user) {
            $data['email'] = $user->email;
            $data['password'] = session('password') ?? '';
        } else {

            $data['email'] = session('email') ?? '';
            $data['password'] = session('password') ?? '';
        }

        // Set a session value
        moduleUpdate('installer', false);
        session(['Complete' => true]);
        Artisan::call('optimize:clear');
        Storage::disk('local')->put('.Complete', 'Complete');
        return view('installer::install.done', compact('data'));

    }

    public function uninstall()
    {
        $response = $this->installRepository->uninstall($this->request->all());
        $message = 'Uninstall by script author successfully';
        info($message);
        return response()->json(['message' => $message, 'response' => $response]);
    }

    public function reinstall(Request $request)
    {
        if ($request->confirm == "yes") {
            $list = [
                '.AdminSetup',
                '.CheckEnvironment',
                '.Complete',
                '.DatabaseSetup',
                '.LicenseVerification',
                '.WelcomeNote',
            ];
            foreach ($list as $key => $value) {
                if (Storage::disk('local')->exists($value)) {
                    Storage::disk('local')->delete($value);
                }
            }
            return redirect('/');
        } else {
            abort(404);
        }
    }

    public function index()
    {
        try {
            $data['title'] = ___('installer.Welcome To Installation');
            $data['short_note'] = ___('installer.Welcome to ' . env('APP_NAME') . ', to complete the installation, please proceed to the next step!');
            $data['button_text'] = ___('installer.Get Started');
            $data['asset_path'] = $this->path;

            // check stage & Set a session value
            $this->installRepository->checkStage('WelcomeNote');

            // session()->forget('temp_data');
            session()->forget('CheckEnvironment');
            session()->forget('LicenseVerification');
            session()->forget('DatabaseSetup');
            session()->forget('AdminSetup');
            session()->forget('Complete');
            Artisan::call('storage:link');

            return view('installer::install.welcome', compact('data'));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function AdminSetup()
    {

        $data['title'] = ___('installer.Admin Setup');
        $data['asset_path'] = url('installer');

        $this->installRepository->checkStage('AdminSetup');

        // Set a session value

        return view('installer::install.user', compact('data'));
    }

    public function DbSeed()
    {
        try {
            $this->updateEnvValue('APP_ENV', 'production');
            $this->updateEnvValue('APP_DEBUG', 'false');
            ini_set('max_execution_time', -1);

            // Start a transaction
            DB::beginTransaction();

            Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $e) {
            // Rollback the transaction on error
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage(),
                'goto' => route('service.import_sql'),
                'error' => $e->getMessage(),
                'step' => 'AdminSetup',
            ]);
        }

    }

    public function post_user(Request $request)
    {

        if ($request->all() == null) {
            $request['email'] = 'admin@onesttech.com';
            $request['password'] = '12345678';
        }
        $request->session()->forget('temp_data');
        $request->session()->forget('email');
        $request->session()->forget('password');

        session(['email' => $request->email]);
        session(['password' => $request->password]);

        if (@$request->seed) {
            session(['temp_data' => true]);
        }

        try {

            return response()->json([
                'message' => 'Admin Setup Successfully Created',
                'goto' => route('service.import_sql'),
                'error' => '',
                'step' => 'AdminSetup',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'goto' => route('service.user'),
                'error' => $e->getMessage(),
                'step' => 'AdminSetup',
            ]);

        }

    }

    public function import_sql(Request $request)
    {

        $data['title'] = ___('installer.Admin Setup & Import SQL');
        $data['asset_path'] = url('installer');
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);
        Artisan::call('optimize:clear');
        $data['button_text'] = ___('installer.Next');

        return $this->import_sql_post();
        return view('installer::install.import_sql', compact('data'));

    }

    public function updateDB()
    {
        if (Schema::hasTable('users')) {
            $user = DB::table('users')->find(1);

            if ($user != "") {
                $user2 = DB::table('users')->where('email', session('email'))->first();
                if ($user2) {
                    DB::table('users')->where('email', session('email'))->delete();
                }
                DB::table('users')
                    ->where('id', 1)
                    ->update([
                        'name' => 'Admin',
                        'email' => session('email'),
                        'password' => Hash::make(session('password')),
                        'email_verified_at' => now(),
                    ]);
                return true;

            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function import_sql_post()
    {

        if (session('email') && session('password')) {
            if (!$this->updateDB()) {
                return redirect()->back()->with([
                    'danger' => 'Import SQL file properly Or Check Database Credentials !',
                    'step' => 'AdminSetup',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'message' => 'Please re-enter!',
                'goto' => route('service.user'),
                'error' => 'Re-enter your information',
                'step' => 'AdminSetup',
            ]);
        }

        $this->installRepository->checkStage('WelcomeNote');
        $this->installRepository->checkStage('CheckEnvironment');
        $this->installRepository->checkStage('LicenseVerification');
        $this->installRepository->checkStage('DatabaseSetup');
        $this->installRepository->checkStage('AdminSetup');
        $this->installRepository->checkStage('Complete');

        $data['title'] = ___('installer.Complete Installation and Configuration');
        $data['info'] = ___('installer.Congratulations! You successfully installed the application. Please login to your account to start using the application.');

        $data['asset_path'] = $this->path;
        $data['email'] = session('email') ?? '';
        $data['password'] = session('password') ?? '';
        return redirect()->route('service.done')->with('data', $data);

    }

}
