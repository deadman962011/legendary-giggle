<?php

use App\Http\Controllers\cp\AizUploadController;
use Illuminate\Support\Facades\Route;

Route::post('/', 'show_uploader');
Route::post('/upload', 'upload');
Route::get('/get_uploaded_files', 'get_uploaded_files');
Route::post('/get_file_by_ids', 'get_preview_files');
Route::get('/download/{id}', 'attachment_download')->name('download_attachment');

?>
