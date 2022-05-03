<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class FilesController extends Controller
{
    public function upload(Request $request)
    {
//        dd($request);
        $validator = Validator::make($request->all(), [
            'files.*' => 'mimes:jpeg,bmp,png,pdf,docx,doc,xlsx,xls,jpg,zip'
        ]);
        if ($validator->fails()) {
            return 'error';
        }

        foreach ($request->file('files') as $file) {
            $folderName = date('d-m-Y');
            $name = rand() . '-' . $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $files[] = File::create([
                'name' => $name,
                'extension' => $extension,
                'path' => $folderName,
                'user_id' => auth()->id(),
                'size' => floor(($size ? log($size) : 0) / log(1024))
            ]);
            $file->move(public_path() . '/' . $folderName, $name);
        }
        return response()->json([
            'message' => 'Files Added',
            'data' => $files
        ], 201);
    }

    public function index()
    {
        return File::with('user')->get();
    }
}
