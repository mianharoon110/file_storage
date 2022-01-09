<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class FileController extends Controller
{
    public function upload(Request $request):RedirectResponse {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:8192'
        ]);

        $uploaded = false;

        if($request->file()) {
            try {
                $path = $request->file('file')->store('public/uploads');

                $file = new File;
                $file->user_id = session()->get('userId');
                $file->name = $request->file->getClientOriginalName();
                $file->format = $request->file->extension();
                $file->size = $request->file('file')->getSize();
                $file->path = $path;
                $file->save();

                $uploaded = true;
            }   catch (\Exception $e) {
                //log error
            }
        }
        return back()->with('isUploaded', $uploaded);
    }

    public function getFiles(Request $request) {
        try {
            $userId = $this->getCurrentUserId();
            $user = User::where('id', '=', $userId)->first();
            $files = File::where('user_id', '=', $userId)->get();
            return view('dashboard', ['files' => $files, 'user' => $user]);
        } catch (\Exception $e) {
        }
        return redirect('auth.view.login');
    }

    public function rename(Request $request):JsonResponse {
        $isRenamed = false;
        try{
            $file = File::find($request->fileId);
            if ($file) {
                $file->name = $request->fileName;
                $file->save();
                $isRenamed = true;
            }
           } catch (\Exception $e) {
           }
        return response()->json(['$isRenamed' => $isRenamed]);
    }

    public function download(Request $request) {
        try {
            $file = File::find($request->id);
            return response()->download(storage_path("app/$file->path"));
        } catch (\Exception $e) {
        }
    return redirect('dashboard');
    }

    public function delete(Request $request): JsonResponse {
        $isDeleted = false;
        try {
            $fileIds = $request->fileIds;
            $files = File::whereIn('id', $fileIds)->where('user_id', $this->getCurrentUserId())->get();

            if ($files->count() == sizeof($fileIds)) {
                foreach ($files as $file) {
                    unlink(storage_path('app/' . $file->path));
                    $file->delete();
                }
                $isDeleted = true;
            }
        } catch (\Exception $e) {
        }
        return response()->json(['isDeleted' => $isDeleted]);
    }

    private function getCurrentUserId() {
        return session('userId');
    }
}
