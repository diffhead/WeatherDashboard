<?php namespace Lib;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigWrapper
{
    private Environment $twig;

    public function __construct(string $templatesPath, string $cachePath = _APP_BASE_DIR_ . 'Cache/twig')
    {
        $loader = new FilesystemLoader($templatesPath);
        $environment = new Environment($loader, [ 'cache' => $cachePath ]);

        $this->twig = $environment;
    }

    public function render(string $template, array $params = []): string
    {
        return $this->twig->render($template, $params);
    }
}
