<?php

namespace Modules\Mail\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Mail\Entities\Attachment;
use Throwable;

class AttachmentController extends Controller
{

    /**
     * Upload attachment to server
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAttachment(Request $request)
    {
        try {
            if ($request->ajax() && $request->file('file')) {
                $filePath = $request->file('file');
                $filenameOrigin = $filePath->getClientOriginalName();
                $filename = time() . '_' . $filenameOrigin;
                $path = $request->file('file')
                    ->storeAs(Attachment::ATTACHMENT_PATH, $filename, 'public');

                return response()->json([
                    'filename'        => $filename,
                    'path'            => '/storage/' . $path,
                    'filename_origin' => $filenameOrigin,
                ]);
            }

            return response()->json('Invalid request', 500);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove attachment from the storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeAttachment(Request $request)
    {
        try {
            if ($request->ajax()) {
                if (file_exists(public_path($request->fileData['path'])))
                    unlink(public_path($request->fileData['path']));

                return response()->json('Success');
            }

            return response()->json('Invalid request', 500);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

}
