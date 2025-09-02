<?php

namespace App\Http\Controllers\v1\File;

use App\Eloquents\FileEloquent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFileRequest;
use App\Responses\BaseResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private FileEloquent $fileService;
    public function __construct(FileEloquent $fileEloquent)
    {
        $this->fileService = $fileEloquent;
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);
        $file = $request->file('file');
        $output = $this->fileService->uploadFile($file);
        return BaseResponse::success($output);
    }
    public function create(CreateFileRequest $request)
    {
        $data = $request->validated();
        $file = $this->fileService->createFile(
            auth()->guard()->user(),
            $data['path'],
            $data['usage'] ?? 'other',
            $data['fileable_type'] ?? null,
            $data['fileable_id'] ?? null,
            $data['visibility'] ?? 'private'
        );
        return BaseResponse::success($file);
    }
}
