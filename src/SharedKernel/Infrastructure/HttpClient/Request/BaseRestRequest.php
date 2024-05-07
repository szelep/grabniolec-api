<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Request;

use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiRequestInterface;
use App\SharedKernel\Infrastructure\HttpClient\Contract\QueryAwareRequestInterface;
use App\SharedKernel\Infrastructure\HttpClient\Contract\ReferableRequestInterface;
use App\SharedKernel\Infrastructure\HttpClient\Contract\SwitchablePayloadOptionInterface;
use App\SharedKernel\Infrastructure\HttpClient\Contract\TraceableRequestInterface;
use Webmozart\Assert\Assert;

abstract class BaseRestRequest implements ExternalApiRequestInterface, QueryAwareRequestInterface, TraceableRequestInterface, SwitchablePayloadOptionInterface, ReferableRequestInterface
{
    protected null|array|string $payload = null;

    protected null|array $query = null;

    protected array $headers = [];

    protected array $additionalOptions = [];

    protected readonly string $trace;

    public function __construct(
        protected string $endpoint,
        protected string $httpMethod,
        protected string $payloadOptionKey = SwitchablePayloadOptionInterface::JSON
    ) {
        Assert::oneOf(
            $this->payloadOptionKey,
            [SwitchablePayloadOptionInterface::JSON, SwitchablePayloadOptionInterface::BODY]
        );
        $this->trace = \uniqid('', true);
    }

    public function setPayload(null|array|string $body): self
    {
        $this->payload = $body;

        return $this;
    }

    public function addQueryParam(string $name, string $value): self
    {
        $this->query[$name] = $value;

        return $this;
    }

    public function addQueryParams(array $params): self
    {
        foreach ($params as $key => $value) {
            $this->addQueryParam($key, $value);
        }

        return $this;
    }

    public function addHeaders(array $headers): self
    {
        $this->headers = \array_merge($this->headers, $headers);

        return $this;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getTrace(): string
    {
        return $this->trace;
    }

    public function getAdditionalOptions(): array
    {
        return $this->additionalOptions;
    }

    public function setAdditionalOptions(array $additionalOptions): self
    {
        $this->additionalOptions = $additionalOptions;

        return $this;
    }

    public function addAdditionalOption(string $name, string|array $value): self
    {
        $this->additionalOptions[$name] = $value;

        return $this;
    }

    public function getPayloadOptionKey(): string
    {
        return $this->payloadOptionKey;
    }

    public function getOptions(): array
    {
        return [
            ...$this->getAdditionalOptions(),
            $this->getPayloadOptionKey() => $this->getPayload(),
            'query' => $this->getQueryParts(),
            'headers' => $this->getHeaders(),
        ];
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getPayload(): null|array|string
    {
        return $this->payload;
    }

    public function getQueryParts(): array
    {
        return $this->query ?? [];
    }

    public function getReference(): ?string
    {
        return null;
    }
}
