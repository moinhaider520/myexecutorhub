<?php
namespace App\Traits;

trait ImageUpload
{
    public function imageUpload($request)
    {
        if ($request) {
            $file_name = $request->getClientOriginalName();
            $extension = $request->getClientOriginalExtension();
            $timestamp = time();
            $unique_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;
            $request->move('assets/upload', $unique_file_name);
            return $unique_file_name;

        }

        return null;
    }
}
