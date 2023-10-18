<?php

namespace Raid\Core\Controller\Traits\Response;

use ArrayKeysCaseTransform\ArrayKeys;
use Exception;
use Illuminate\Http\JsonResponse;

trait ResponseBuilder
{
    /**
     * Returned data or errors.
     */
    private array $responseData = [];

    /**
     * Response message.
     */
    private string $responseMessage = '';

    /**
     * Header code.
     */
    private int $headerCode;

    /**
     * Internal error code.
     */
    private ?int $internalCode = null;

    /**
     * Error exception.
     */
    private ?Exception $responseException = null;

    /**
     * Set internal error code.
     */
    protected function setResponseCode(int $code = null): self
    {
        $this->internalCode = $code;

        return $this;
    }

    /**
     * Set response message.
     */
    protected function setResponseMessage(string $message = ''): self
    {
        $this->responseMessage = $message;

        return $this;
    }

    /**
     * Set response data.
     */
    protected function setResponseData(array $data): self
    {
        $this->responseData = $data;

        return $this;
    }

    /**
     * Set the given exception.
     */
    public function withResponseException(Exception $exception): self
    {
        $this->responseException = $exception;

        return $this;
    }

    /**
     * Get response exception.
     */
    public function responseException(): ?Exception
    {
        return $this->responseException;
    }

    /**
     * Get internal error codes.
     */
    protected function responseCode(): ?int
    {
        return $this->internalCode;
    }

    /**
     * Get a response message.
     */
    protected function responseMessage(): ?string
    {
        return $this->responseMessage;
    }

    /**
     * Get response data.
     */
    protected function responseData(): array
    {
        return $this->formatFloatNumbers($this->responseData);
    }

    /**
     * Return success response.
     */
    public function success(string $message = 'success', array $data = [], int $headerCode = 200): JsonResponse
    {
        return $this->setResponseMessage($message)
            ->setResponseData($data)
            ->successResponse($headerCode);
    }

    /**
     * Return error response.
     */
    public function error(string $message = '', array $data = [], int $headerCode = 422): JsonResponse
    {
        $data = $this->formatErrorResponse($data);

        return $this->setResponseMessage($message)
            ->setResponseData($data)
            ->errorResponse($headerCode);
    }

    /**
     * Return bad request response.
     */
    public function badRequest(string $message = '', array $data = [], int $internalCode = null, int $headerCode = 422): JsonResponse
    {
        $data = $this->formatErrorResponse($data);

        return $this->setResponseCode($internalCode)
            ->setResponseMessage($message)
            ->setResponseData($data)
            ->errorResponse($headerCode);
    }

    /**
     * Return a not found response.
     */
    public function notFound(string $message = '', array $data = [], int $internalCode = null, int $headerCode = 404): JsonResponse
    {
        $data = $this->formatErrorResponse($data);

        return $this->setResponseCode($internalCode)
            ->setResponseMessage($message)
            ->setResponseData($data)
            ->errorResponse($headerCode);
    }

    /**
     * Build success response.
     */
    protected function successResponse(int $headerCode): JsonResponse
    {
        $response = [
            'message' => $this->responseMessage(),
            'data' => $this->responseData(),
        ];

        if (isset($this->responseData()['data'])) {
            $response['data'] = $this->responseData()['data'];
        }

        if (isset($this->responseData()['additionalData'])) {
            $response['additionalData'] = $this->responseData()['additionalData'];
        }

        if (isset($this->responseData()['meta'])) {
            $response['meta'] = $this->responseData()['meta'];
        }

        return $this->response($response, $headerCode);
    }

    /**
     * Build error response.
     */
    protected function errorResponse(int $headerCode): JsonResponse
    {
        $response = [];

        if (! empty($this->responseCode())) {
            $response['code'] = $this->responseCode();
        }

        $response['message'] = $this->responseMessage();

        $response['errors'] = $this->responseData();

        if (config('app.debug') && ! empty($this->responseException())) {
            $response['debug'] = $this->responseDebug();
        }

        return $this->response($response, $headerCode);
    }

    /**
     * Get formatted exception data.
     */
    public function responseDebug(): array
    {
        return [
            'exceptionMessage' => $this->responseException->getMessage(),
            'exceptionFile' => $this->responseException->getFile(),
            'exceptionLine' => $this->responseException->getLine(),
        ];
    }

    /**
     * Format any float number inside the array.
     */
    private function formatFloatNumbers($data): array
    {
        return collect($data)->map(function ($item) {
            if (is_float($item)) {
                return preg_replace('/\.00/', '', number_format((float) $item, 2, '.', ''));
            } elseif (is_array($item)) {
                return $this->formatFloatNumbers($item);
            }

            return $item;
        })->toArray();
    }

    /**
     * Format error response.
     */
    private function formatErrorResponse(array $data = []): array
    {
        $errorResponseData = [];

        foreach ($data as $key => $value) {
            if (is_int($key)) {
                $key = 'error';
            }

            if (! is_string($value)) {
                $value = $value[0] ?? '';
            }

            $errorResponseData[] = [
                'key' => $key,
                'value' => $value,
            ];
        }

        return $errorResponseData;
    }

    /**
     * Prepare returned response.
     */
    protected function response(array $response, int $headerCode): JsonResponse
    {
        return response()->json(ArrayKeys::toCamelCase($response), $headerCode);
    }
}
