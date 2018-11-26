<?php
namespace Application\Core;

class View
{
    /** @var string $templatecTemplate which will be rendered inside page layout. */
    public $template;

    /** @var string $layout Layout template path. */
    public $layout;

    /** @var string $generated Generated view for Responce. */
    private $generated;

    /**
     * View class constructor.
     */
    public function __construct()
    {
        $this->layout = __DIR__ . './../../view/layouts/pageLayout.php';
    }

    /**
     * Generates view for Responce.
     *
     * @param null $data
     */
    public function generate($data=NULL)
    {
        //include sprintf(__DIR__.'/../%s.php', $layout);
        $this->generated = include $this->layout;
    }

    /**
     * Returns generated view.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->generated;
    }
}
