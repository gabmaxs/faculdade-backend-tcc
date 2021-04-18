<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;

class TemporaryFileController extends Controller
{
    public function upload(Request $request) {
        $request->validate([
            "image" => "required|file|mimes:jpg,gif,png,jpeg|max:2048",
        ]);

        if($request->hasFile("image")) {
            $file = $request->file("image");
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . "-" . now()->timestamp;
            // $file->storeAs('recipes/tmp/' . $folder, $filename);

            // STORE LOCAL
            // $this->storeLocal($file, 'recipes/tmp/' . $folder, $filename);

            // STORE FIREBASE
            $this->storeFirebase($file, 'recipes/tmp/' . $folder, $filename);


            TemporaryFile::create([
                "folder" => $folder,
                "filename" => $filename
            ]);

            return $folder;
        }

        return "";
    }

    private function storeLocal($file, $folder, $filename) {
        $file->storeAs($folder, $filename);
    }

    private function storeFirebase($file, $folder, $filename) {
        $storage = app('firebase.storage');
        $storage->getBucket()->upload(fopen($file->getRealPath(), "r"), [
            "name" => $folder . "/" . $filename,
            "predefinedAcl" => "publicRead"
        ]);
    }
}
