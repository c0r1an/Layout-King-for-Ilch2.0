<?php

/** @var $this \Ilch\Layout\Frontend */

$siteTitle = 'King';
$siteDescription = 'King Gaming Layout';
$hideSidebar = !empty($kingHideSidebar);
$siteLogo = trim((string)$this->getLayoutSetting('site_logo'));
$accentColor = trim((string)$this->getLayoutSetting('accent_color'));
$accentColor = preg_match('/^#[0-9a-fA-F]{6}$/', $accentColor) ? $accentColor : '#ef3418';
$contentWidth = (int)$this->getLayoutSetting('content_width');
$contentWidth = $contentWidth >= 800 && $contentWidth <= 2200 ? $contentWidth : 1100;
$headerBannerLeft = trim((string)$this->getLayoutSetting('header_banner_left'));
$headerBannerLeftUrl = trim((string)$this->getLayoutSetting('header_banner_left_url'));
$headerBannerLeftBlank = $this->getLayoutSetting('header_banner_left_blank') === '1';
$headerBannerRight = trim((string)$this->getLayoutSetting('header_banner_right'));
$headerBannerRightUrl = trim((string)$this->getLayoutSetting('header_banner_right_url'));
$headerBannerRightBlank = $this->getLayoutSetting('header_banner_right_blank') === '1';
$config = \Ilch\Registry::get('config');
$socialLinks = [
    'facebook' => trim((string)$this->getLayoutSetting('social_facebook')),
    'youtube' => trim((string)$this->getLayoutSetting('social_youtube')),
    'twitter' => trim((string)$this->getLayoutSetting('social_twitter')),
    'instagram' => trim((string)$this->getLayoutSetting('social_instagram')),
    'twitch' => trim((string)$this->getLayoutSetting('social_twitch')),
    'rss' => trim((string)$this->getLayoutSetting('social_rss')),
];
$footerLinksTitle = trim((string)$this->getLayoutSetting('footer_links_title')) ?: 'Wichtige Links';
$footerCopyrightText = trim((string)$this->getLayoutSetting('footer_copyright_text'))
    ?: '%YEAR% %TITLE% Inc. - All Rights Reserved.';
$footerCopyrightText = str_replace(
    ['%YEAR%', '%TITLE%'],
    [date('Y'), $siteTitle],
    $footerCopyrightText
);
$footerLinks = [];

for ($i = 1; $i <= 4; $i++) {
    $text = trim((string)$this->getLayoutSetting('footer_link_' . $i . '_text'));
    $url = trim((string)$this->getLayoutSetting('footer_link_' . $i . '_url'));

    if ($text !== '' && $url !== '') {
        $footerLinks[] = ['text' => $text, 'url' => $url];
    }
}

$sliderFallbacks = [
    1 => ['title' => 'Welcome to King', 'text' => 'Manage this slide in the layout advanced settings.'],
    2 => ['title' => 'Second Slide', 'text' => 'Add your own image, text and link for the second slide.'],
    3 => ['title' => 'Third Slide', 'text' => 'The slider width follows the content width setting.'],
];
$slides = [];

for ($i = 1; $i <= 3; $i++) {
    $slides[] = [
        'image' => trim((string)$this->getLayoutSetting('slider_' . $i . '_image')),
        'title' => trim((string)$this->getLayoutSetting('slider_' . $i . '_title')) ?: $sliderFallbacks[$i]['title'],
        'text' => trim((string)$this->getLayoutSetting('slider_' . $i . '_text')) ?: $sliderFallbacks[$i]['text'],
        'url' => trim((string)$this->getLayoutSetting('slider_' . $i . '_url')),
        'blank' => $this->getLayoutSetting('slider_' . $i . '_blank') === '1',
        'fallbackClass' => 'king-slide-bg-' . $i,
    ];
}

$moduleName = (string)$this->getRequest()->getModuleName();
$controllerName = (string)$this->getRequest()->getControllerName();
$actionName = (string)$this->getRequest()->getActionName();
$requestId = (string)$this->getRequest()->getParam('id');
$currentUrl = rtrim($this->getCurrentUrl([], true), '/');
$homeUrl = rtrim($this->getUrl(), '/');
$indexUrl = rtrim($this->getUrl(['module' => 'index', 'controller' => 'index', 'action' => 'index']), '/');
$startPage = (string)$config->get('start_page');
$isHomePage = false;

if (strpos($startPage, 'module_') === 0) {
    $isHomePage = $moduleName === substr($startPage, 7)
        && ($controllerName === '' || $controllerName === 'index')
        && ($actionName === '' || $actionName === 'index');
} elseif (strpos($startPage, 'page_') === 0) {
    $isHomePage = $moduleName === 'admin'
        && $controllerName === 'page'
        && $actionName === 'show'
        && $requestId === substr($startPage, 5);
} elseif (strpos($startPage, 'layouts_') === 0) {
    $isHomePage = $moduleName === substr($startPage, 8)
        && ($controllerName === '' || $controllerName === 'index');
} else {
    $isHomePage = $currentUrl === $homeUrl
        || $currentUrl === $indexUrl
        || (($moduleName === '' || $moduleName === 'index')
        && ($controllerName === '' || $controllerName === 'index')
        && ($actionName === '' || $actionName === 'index'));
}

$menuMapper = new \Modules\Admin\Mappers\Menu();
$pageMapper = new \Modules\Admin\Mappers\Page();
$accessMapper = new \Ilch\Accesses($this->getRequest());
$locale = '';

if ((bool)$config->get('multilingual_acp') && $this->getTranslator()->getLocale() !== $config->get('content_language')) {
    $locale = $this->getTranslator()->getLocale();
}

$buildMenuTree = function (int $position) use ($menuMapper) {
    $menuId = $menuMapper->getMenuIdForPosition($position);

    if (empty($menuId)) {
        return [];
    }

    $menuItems = $menuMapper->getMenuItems((int)$menuId);
    $tree = [];

    foreach ($menuItems as $item) {
        $tree[$item->getParentId()][] = $item;
    }

    return $tree;
};

$resolveMenuRoot = function (array $tree): int {
    if (empty($tree[0])) {
        return 0;
    }

    foreach ($tree[0] as $item) {
        if ($item->getType() === \Modules\Admin\Models\MenuItem::TYPE_MENU) {
            return (int)$item->getId();
        }
    }

    return 0;
};

$resolveMenuHref = function ($item) use ($pageMapper, $locale, $accessMapper) {
    $target = '';
    $rel = '';

    if ($item->isPageLink()) {
        if (!$accessMapper->hasAccess('Module', $item->getSiteId(), $accessMapper::TYPE_PAGE)) {
            return null;
        }

        $page = $pageMapper->getPageByIdLocale($item->getSiteId(), $locale) ?: $pageMapper->getPageByIdLocale($item->getSiteId());
        if (!$page) {
            return null;
        }

        return ['href' => $this->getUrl($page->getPerma()), 'target' => $target, 'rel' => $rel];
    }

    if ($item->isModuleLink()) {
        if (!$accessMapper->hasAccess('Module', $item->getModuleKey())) {
            return null;
        }

        return [
            'href' => $this->getUrl(['module' => $item->getModuleKey(), 'controller' => 'index', 'action' => 'index']),
            'target' => $target,
            'rel' => $rel,
        ];
    }

    if ($item->isLink()) {
        $target = $item->getTarget() ? ' target="' . $this->escape($item->getTarget()) . '"' : '';
        $rel = $item->getTarget() === '_blank' ? ' rel="noopener"' : '';

        return ['href' => $item->getHref(), 'target' => $target, 'rel' => $rel];
    }

    return null;
};

$renderMenu = function (array $tree, int $parentId = 0, bool $submenu = false) use (&$renderMenu, $resolveMenuHref, $currentUrl) {
    if (empty($tree[$parentId])) {
        return ['html' => '', 'active' => false];
    }

    $className = $submenu ? 'sub-menu' : 'menu';
    $html = '<ul class="' . $className . '">';
    $hasActiveItem = false;

    foreach ($tree[$parentId] as $item) {
        if ($item->isBox() || $item->getType() === \Modules\Admin\Models\MenuItem::TYPE_MENU) {
            continue;
        }

        $link = $resolveMenuHref($item);
        if ($link === null) {
            continue;
        }

        $childResult = $renderMenu($tree, $item->getId(), true);
        $children = $childResult['html'];
        $classes = [];
        $normalizedHref = rtrim($link['href'], '/');
        $isActive = $normalizedHref === $currentUrl
            || (!$submenu && $normalizedHref !== '' && $normalizedHref !== $currentUrl && str_starts_with($currentUrl . '/', $normalizedHref . '/'))
            || $childResult['active'];

        if ($isActive) {
            $classes[] = 'current-menu-item current_page_item';
            $hasActiveItem = true;
        }

        if ($children !== '') {
            $classes[] = 'menu-item-has-children';
        }

        $classAttr = empty($classes) ? '' : ' class="' . implode(' ', $classes) . '"';

        $html .= '<li' . $classAttr . '>';
        $html .= '<a href="' . $this->escape($link['href']) . '"' . $link['target'] . $link['rel'] . '>' . $this->escape($item->getTitle()) . '</a>';
        $html .= $children;
        $html .= '</li>';
    }

    $html .= '</ul>';

    return ['html' => $html, 'active' => $hasActiveItem];
};

$mainMenuTree = $buildMenuTree(1);
$mainMenu = $renderMenu($mainMenuTree, $resolveMenuRoot($mainMenuTree));
$sidebarBoxes = $this->getMenu(2, '<div class="widget"><h4 class="widget-title">%s</h4><div class="widget-box">%c</div></div>');
$breadcrumb = trim((string)$this->getHmenu());
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->escape($siteTitle) ?></title>
    <?=$this->getHeader() ?>
    <link rel="stylesheet" href="<?=$this->getLayoutUrl('style.css') ?>">
    <?=$this->getCustomCSS() ?>
</head>

<body class="king <?=$hideSidebar ? 'fullwidth' : 'right-sidebar' ?>" style="--king-content-width: <?=$contentWidth ?>px; --king-accent-color: <?=$this->escape($accentColor) ?>;">
    <header id="header">
        <div class="container">
            <div class="header-banner-column header-banner-left">
                <a href="<?=$this->escape($headerBannerLeftUrl !== '' ? $headerBannerLeftUrl : '#') ?>"<?=$headerBannerLeftBlank ? ' target="_blank" rel="noopener"' : '' ?>>
                    <?php if ($headerBannerLeft !== '') : ?>
                        <img class="header-banner-image" src="<?=$this->getBaseUrl($headerBannerLeft) ?>" alt="Left header banner">
                    <?php else : ?>
                        <span class="header-banner">468 x 90 Left Banner</span>
                    <?php endif; ?>
                </a>
            </div>

            <div id="logo">
                <a title="<?=$this->escape($siteDescription) ?>" href="<?=$this->getUrl() ?>">
                    <?php if ($siteLogo !== '') : ?>
                        <img class="site-logo-image" src="<?=$this->getBaseUrl($siteLogo) ?>" alt="<?=$this->escape($siteTitle) ?>">
                    <?php else : ?>
                        <span class="logo-word"><?=$this->escape($siteTitle) ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="header-banner-column header-banner-right">
                <a href="<?=$this->escape($headerBannerRightUrl !== '' ? $headerBannerRightUrl : '#') ?>"<?=$headerBannerRightBlank ? ' target="_blank" rel="noopener"' : '' ?>>
                    <?php if ($headerBannerRight !== '') : ?>
                        <img class="header-banner-image" src="<?=$this->getBaseUrl($headerBannerRight) ?>" alt="Right header banner">
                    <?php else : ?>
                        <span class="header-banner">468 x 90 Right Banner</span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </header>

    <nav id="navigation">
        <div class="container">
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="king-main-menu">
                <span class="menu-toggle-label">Menu</span>
                <span class="menu-toggle-bars"></span>
            </button>

            <div class="menu-shell" id="king-main-menu">
                <ul class="menu menu-fixed-home">
                    <li class="<?=$isHomePage ? 'current-menu-item current_page_item' : '' ?>">
                        <a href="<?=$this->getUrl() ?>">Home</a>
                    </li>
                </ul>
                <?=$mainMenu['html'] ?>
            </div>

            <div class="top-social">
                <?php if ($socialLinks['facebook'] !== '') : ?>
                <a class="social-facebook" href="<?=$this->escape($socialLinks['facebook']) ?>" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.3-1.6 1.6-1.6H17V4.8c-.4-.1-1.3-.2-2.5-.2-2.5 0-4.2 1.5-4.2 4.3V11H7.5v3h2.8v8h3.2Z"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($socialLinks['youtube'] !== '') : ?>
                <a class="social-youtube" href="<?=$this->escape($socialLinks['youtube']) ?>" aria-label="YouTube">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 12s0-3.3-.4-4.8a2.5 2.5 0 0 0-1.8-1.8C19.2 5 12 5 12 5s-7.2 0-8.8.4a2.5 2.5 0 0 0-1.8 1.8C1 8.7 1 12 1 12s0 3.3.4 4.8a2.5 2.5 0 0 0 1.8 1.8C4.8 19 12 19 12 19s7.2 0 8.8-.4a2.5 2.5 0 0 0 1.8-1.8c.4-1.5.4-4.8.4-4.8ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($socialLinks['twitter'] !== '') : ?>
                <a class="social-twitter" href="<?=$this->escape($socialLinks['twitter']) ?>" aria-label="X">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-7.3L5.6 22H2.5l7.3-8.4L1.2 2h6.5l4.4 6.7L18.9 2Zm-1.1 18h1.7L6.4 3.9H4.6L17.8 20Z"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($socialLinks['instagram'] !== '') : ?>
                <a class="social-instagram" href="<?=$this->escape($socialLinks['instagram']) ?>" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2.2A2.8 2.8 0 0 0 4.2 7v10A2.8 2.8 0 0 0 7 19.8h10a2.8 2.8 0 0 0 2.8-2.8V7A2.8 2.8 0 0 0 17 4.2H7Zm10.2 1.6a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2.2a2.8 2.8 0 1 0 0 5.6 2.8 2.8 0 0 0 0-5.6Z"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($socialLinks['twitch'] !== '') : ?>
                <a class="social-twitch" href="<?=$this->escape($socialLinks['twitch']) ?>" aria-label="Twitch">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 2 2 6v14h5v3l3-3h4l8-8V2H4Zm16 9-4 4h-4l-3 3v-3H5V4h15v7Zm-8-1h-2V6h2v4Zm5 0h-2V6h2v4Z"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($socialLinks['rss'] !== '') : ?>
                <a class="social-rss" href="<?=$this->escape($socialLinks['rss']) ?>" aria-label="RSS">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.2 17.8a2.2 2.2 0 1 1 0 4.4 2.2 2.2 0 0 1 0-4.4ZM2 9.6v3.1c5.1 0 9.3 4.2 9.3 9.3h3.1C14.4 15.2 8.8 9.6 2 9.6Zm0-6v3.1C10.5 6.7 17.3 13.5 17.3 22h3.1C20.4 11.8 12.2 3.6 2 3.6Z"/></svg>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="clearfix"></div>

    <?php if (!$isHomePage && $breadcrumb !== '') : ?>
        <div class="container">
            <div class="king-breadcrumb">
                <?=$breadcrumb ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($isHomePage) : ?>
        <div class="container">
            <section id="king-slider" class="king-slider" aria-label="Homepage Slider">
                <div class="king-slider-track">
                    <?php foreach ($slides as $index => $slide) : ?>
                        <article class="king-slide<?=$index === 0 ? ' is-active' : '' ?>">
                            <?php if ($slide['url'] !== '') : ?>
                                <a class="king-slide-link" href="<?=$this->escape($slide['url']) ?>"<?=$slide['blank'] ? ' target="_blank" rel="noopener"' : '' ?>>
                            <?php else : ?>
                                <div class="king-slide-link">
                            <?php endif; ?>

                            <?php if ($slide['image'] !== '') : ?>
                                <img class="king-slide-image" src="<?=$this->getBaseUrl($slide['image']) ?>" alt="<?=$this->escape($slide['title']) ?>">
                            <?php else : ?>
                                <span class="king-slide-image <?=$this->escape($slide['fallbackClass']) ?>"></span>
                            <?php endif; ?>

                            <span class="king-slide-overlay"></span>
                            <span class="king-slide-content">
                                <span class="king-slide-kicker">King Layout</span>
                                <strong class="king-slide-title"><?=$this->escape($slide['title']) ?></strong>
                                <span class="king-slide-text"><?=$this->escape($slide['text']) ?></span>
                            </span>

                            <?php if ($slide['url'] !== '') : ?>
                                </a>
                            <?php else : ?>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>

                <button class="king-slider-arrow king-slider-prev" type="button" aria-label="Previous slide">&lt;</button>
                <button class="king-slider-arrow king-slider-next" type="button" aria-label="Next slide">&gt;</button>

                <div class="king-slider-dots">
                    <?php foreach ($slides as $index => $slide) : ?>
                        <button class="king-slider-dot<?=$index === 0 ? ' is-active' : '' ?>" type="button" aria-label="Slide <?=$index + 1 ?>" data-slide="<?=$index ?>"></button>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    <?php endif; ?>

    <div class="container">
        <div id="content">
            <div id="main" class="<?=$hideSidebar ? 'fullwidth' : '' ?>">
                <?=$this->getContent() ?>
            </div>

            <?php if (!$hideSidebar) : ?>
                <aside id="sidebar">
                    <?=$sidebarBoxes ?>
                </aside>
            <?php endif; ?>

            <div class="clearfix"></div>
        </div>
    </div>

    <div id="footer">
        <div class="container">
            <div class="footer-layout">
                <div class="footer-links">
                    <?php if (!empty($footerLinks)) : ?>
                        <h4 class="footer-links-title"><?=$this->escape($footerLinksTitle) ?></h4>
                        <ul class="footer-links-list">
                            <?php foreach ($footerLinks as $footerLink) : ?>
                                <li><a href="<?=$this->escape($footerLink['url']) ?>"><?=$this->escape($footerLink['text']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="footer-logo">
                    <?php if ($siteLogo !== '') : ?>
                        <img class="site-logo-image footer-site-logo" src="<?=$this->getBaseUrl($siteLogo) ?>" alt="<?=$this->escape($siteTitle) ?>">
                    <?php else : ?>
                        <span class="logo-word"><?=$this->escape($siteTitle) ?></span>
                    <?php endif; ?>
                </div>

                <div class="footer-spacer"></div>
            </div>
        </div>
    </div>

    <div id="copyright">
        <div class="container">
            <p class="left"><?=$this->escape($footerCopyrightText) ?></p>
            <a href="#" class="to-top" aria-label="Back to Top"><span>Back to Top</span></a>
        </div>
    </div>

    <?=$this->getFooter() ?>
    <script src="<?=$this->getLayoutUrl('assets/js/king-menu.js') ?>"></script>
    <script src="<?=$this->getLayoutUrl('assets/js/king-slider.js') ?>"></script>
    <script src="<?=$this->getLayoutUrl('assets/js/king-totop.js') ?>"></script>
</body>
</html>
