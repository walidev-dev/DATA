<?php

namespace Framework\Renderer;

class PHPRenderer implements RendererInterface
{
    const DEFAULT_NAMESPACE = '__MAIN';
    private $path = [];
    private $params = [];

    public function __construct(?string $path = null)
    {
        if (!is_null($path)) {
            $this->addPath($path);
        }
    }

    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->path[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->path[$namespace] = $path;
        }
    }

    public function render(string $view, ?array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            list($namespace, $viewName) = $this->getNamespaceAndViewName($view);
            $path = $this->path[$namespace] . DIRECTORY_SEPARATOR . $viewName . '.php';
        } else {
            $path = $this->path[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        if (!empty($params)) {
            extract($params);
        }
        ob_start();
        $renderer = $this;
        extract($this->params);
        require($path);
        return ob_get_clean();
    }

    public function hasNamespace(string $view): bool
    {
        if ($view[0] === '@') {
            return true;
        }
        return false;
    }

    public function getNamespaceAndViewName($view): array
    {
        $parts = explode('/', $view);
        $namespace = str_replace('@', '', $parts[0]);
        $viewName = $parts[1];
        return [$namespace, $viewName];
    }

    public function addGlobal(string $key, $value): void
    {
        $this->params[$key] = $value;
    }
}
