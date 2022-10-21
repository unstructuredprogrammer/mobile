<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function read(): string
    {
        return json_encode(
            DB::table('info')->get()->toArray()
        );
    }

    public function delById(Request $request)
    {
        $id = $request->get('id');
        try {
            DB::table('info')
                ->delete($id);
            return json_encode([
                'status' => true
            ]);
        } catch (Exception $exception) {
            return json_encode([
                'status' => false
            ]);
        }
    }
}
