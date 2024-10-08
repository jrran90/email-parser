<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\SuccessfulEmail;
use App\Services\EmailParserService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class SuccessfulEmailController extends BaseController
{
    protected EmailParserService $emailParserService;

    public function __construct(EmailParserService $emailParserService)
    {
        $this->emailParserService = $emailParserService;
    }

    public function index(): JsonResponse
    {
        $emails = SuccessfulEmail::paginate();

        return $this->sendResponse($emails);
    }

    public function store(StoreEmailRequest $request): JsonResponse
    {
        $requestPayload = $request->validated();
        $requestPayload['raw_text'] = $this->emailParserService->parse($requestPayload['email']);

        $email = SuccessfulEmail::create($requestPayload);

        return $this->sendResponse($email, 'Successfully Created!', Response::HTTP_CREATED);
    }

    public function show(SuccessfulEmail $email): JsonResponse
    {
        return $this->sendResponse($email);
    }

    // Note: Since there was no specific instruction on this part, so I just assumed that the user is able to, put a raw
    // email then automatically converted to raw_text.
    public function update(UpdateEmailRequest $request, SuccessfulEmail $email): JsonResponse
    {
        $payload = $request->validated();

        $email->email = $payload['email'];
        $email->raw_text = $this->emailParserService->parse($payload['email']);
        $email->save();

        return response()->json($email);
    }

    public function destroy(SuccessfulEmail $email): JsonResponse
    {
        $email->delete();

        return $this->sendResponse($email, 'Deleted!');
    }
}
