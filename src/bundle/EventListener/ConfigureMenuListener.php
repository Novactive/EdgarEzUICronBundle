<?php

namespace Edgar\EzUICronBundle\EventListener;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Ibexa\AdminUi\Menu\MainMenuBuilder;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use JMS\TranslationBundle\Model\Message;


/**
 * Class ConfigureMenuListener.
 */
class ConfigureMenuListener implements TranslationContainerInterface
{
    const ITEM_CRONS = 'main__crons';

    /** @var PermissionResolver */
    private $permissionResolver;

    /**
     * ConfigureMenuListener constructor.
     *
     * @param PermissionResolver $permissionResolver
     */
    public function __construct(PermissionResolver $permissionResolver)
    {
        $this->permissionResolver = $permissionResolver;
    }

    /**
     * Add cron to admin menu.
     *
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        if (!$this->permissionResolver->hasAccess('uicron', 'list')) {
            return;
        }

        $menu = $event->getMenu();

        $cronsMenu = $menu->getChild(MainMenuBuilder::ITEM_ADMIN);
        $cronsMenu->addChild(self::ITEM_CRONS, ['route' => 'edgar.ezuicron.list']);
    }

    /**
     * Menu label translation.
     *
     * @return array
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_CRONS, 'messages'))->setDesc('Cronjobs'),
        ];
    }
}
