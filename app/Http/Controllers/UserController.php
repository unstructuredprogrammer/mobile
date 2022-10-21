<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if (isset($_COOKIE['key'])) {
            if ($_COOKIE['key'] === 'qwertyjm') {
                return view('table');
            }
        }
        return view('index');
    }

    public function add()
    {
        if (isset($_COOKIE['key'])) {
            if ($_COOKIE['key'] === 'qwertyjm') {
                return view('insert');
            }
        }
        return view('index');
    }

    public function validation(Request $request)
    {
        if (isset($_COOKIE['key'])) {
            if ($_COOKIE['key'] === 'qwertyjm') {
                return view('table');
            }
        }

        $username =  $request->get('username');
        $password =  md5($request->get('password'));
        $flag = (bool)
            count(
                DB::table('users')
                    ->where("username", "=", $username)
                    ->where("password", "=", $password)
                    ->get()->toArray()
            );
        if ($flag) {
            setcookie('key', 'qwertyjm', time()+60*60*24);
            return view('table');
        }
        return view('index');
    }

    public function info()
    {
        return view('table');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $original_filename = $request->file('file')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_name = $original_filename_arr[0];
            $file_ext = end($original_filename_arr);
            $destination_path = './files/';
            $file = $file_name . time() . '.' . $file_ext;

            if ($request->file('file')->move($destination_path, $file)) {
                $flag = $this->saveInfo($request, $file);
                if ($flag) {
                    return view('suc');
                } else {
                    die('there is an error with your upload!');
                }
            } else {
                die("there is an error for file uploading");
            }
        } else {
            die("you didn't uploaded a file");
        }
    }

    private function saveInfo(Request $request, string $fileName): bool
    {
        $title = $request->get('title');
        $version = $request->get('version');
        $versionTag = $request->get('version-tag');
        $description = $request->get('description');
        $oem = $request->get('oem');
        $fingerPrint = $request->get('finger-print');

        try {
            DB::table('info')
                ->insert([
                    'title' => $title,
                    'version' => $version,
                    'version_tag' => $versionTag,
                    'description' => $description,
                    'oem' => $oem,
                    'finger_print' => $fingerPrint,
                    'file_address' => $fileName
                ]);
            return true;
        } catch (Exception $exception) {
            return false;
        }

    }
}
