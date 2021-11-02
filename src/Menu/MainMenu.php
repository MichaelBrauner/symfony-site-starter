<?php

namespace App\Menu;

use Braunstetter\MenuBundle\Factory\MenuItem;
use Braunstetter\MenuBundle\Menu;
use Symfony\Contracts\Translation\TranslatorInterface;
use Traversable;

class MainMenu extends Menu
{

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        parent::__construct();
        $this->translator = $translator;
    }

    public function define(): Traversable
    {
        yield MenuItem::linkToRoute($this->translator->trans('general.sites_names.homepage'), 'homepage');
        yield MenuItem::linkToRoute($this->translator->trans('general.sites_names.agb'), 'agbs');
        yield MenuItem::linkToRoute($this->translator->trans('general.sites_names.imprint'), 'imprint');
    }

}