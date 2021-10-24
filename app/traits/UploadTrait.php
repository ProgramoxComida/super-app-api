<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait UploadTrait {
    /**
     * @param Request $request
     * @param string $dir
     * @param string $fileInputName
     * @return $this|false|string
     */
    public function uploadUserPhoto(Request $request, string $dir, string $fileInputName) {

        if( $request->hasFile( $fileInputName ) ) {
            // $disk = Storage::disk('users');
            $filenameWithExt = $request->file($fileInputName)->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file($fileInputName)->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // $request->file($fileInputName)->storeAs("users/{$dir}", $fileNameToStore);
            // Get the metadata
            // $contents = Storage::get("public/videos/{$dir}/$fileNameToStore");
            // $disk->put("videos/{$dir}/$fileNameToStore", $contents);

            // Storage::delete("public/videos/{$dir}/$fileNameToStore");
            // return env('APP_URL') ."/users/{$dir}/$fileNameToStore";
            $path = $request->file($fileInputName)->store("users/{$dir}/videos/{$fileNameToStore}", "s3");
            return Storage::disk("s3")->url($path);
        }
        return env('APP_URL') ."/users/default.png";
    }
}
