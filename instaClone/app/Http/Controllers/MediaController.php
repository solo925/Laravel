<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    protected function s3(): S3Client
    {
        return new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'endpoint' => env('AWS_ENDPOINT', 'http://localhost:9000'),
            'use_path_style_endpoint' => (bool) env('AWS_USE_PATH_STYLE_ENDPOINT', true),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID', 'minioadmin'),
                'secret' => env('AWS_SECRET_ACCESS_KEY', 'minioadmin'),
            ],
        ]);
    }

    public function presignUpload(Request $request)
    {
        $v = Validator::make($request->all(), [
            'mime' => 'required|string',
            'filename' => 'nullable|string',
        ]);
        $v->validate();

        $bucket = env('AWS_BUCKET', 'insta-clone');
        $mime = $request->string('mime');
        $filename = $request->string('filename');
        $ext = $filename->isNotEmpty() && str_contains($filename, '.') ? '.' . pathinfo($filename, PATHINFO_EXTENSION) : '';

        $userId = optional($request->user())->id ?? 0;
        $key = trim($userId . '/' . Str::uuid() . $ext, '/');

        $cmd = $this->s3()->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $key,
            'ContentType' => $mime,
        ]);
        $req = $this->s3()->createPresignedRequest($cmd, '+15 minutes');

        return response()->json([
            'bucket' => $bucket,
            'key' => $key,
            'method' => 'PUT',
            'upload_url' => (string) $req->getUri(),
            'headers' => [
                'Content-Type' => $mime,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'bucket' => 'required|string',
            'key' => 'required|string',
            'mime' => 'required|string',
            'size' => 'required|integer|min:0',
            'etag' => 'nullable|string',
        ]);
        $data = $v->validate();

        $media = Media::create([
            'user_id' => optional($request->user())->id,
            'bucket' => $data['bucket'],
            'key' => $data['key'],
            'mime' => $data['mime'],
            'size' => $data['size'],
            'etag' => $data['etag'] ?? null,
            'status' => 'uploaded',
        ]);

        return response()->json($media, 201);
    }

    public function index(Request $request)
    {
        $items = Media::query()
            ->when($request->user(), fn($q) => $q->where('user_id', $request->user()->id))
            ->latest('id')
            ->paginate(20);
        return response()->json($items);
    }
}
