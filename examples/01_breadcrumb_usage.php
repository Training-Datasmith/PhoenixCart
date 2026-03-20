<?php

declare(strict_types=1);

/**
 * Example: Building and rendering a breadcrumb trail in CE Phoenix.
 *
 * This example illustrates how to construct the breadcrumb trail that appears
 * at the top of category and product pages. In production, breadcrumbs are
 * built during the page bootstrap via includes/modules/content/header/ and
 * rendered in the template.
 *
 * Usage: This file is documentation-only. In a real Phoenix installation,
 * the breadcrumb object is available as $GLOBALS['breadcrumb'] after bootstrap.
 */

// Simulate the autoloaded class (in production, the class loader handles this)
require_once __DIR__ . '/../includes/classes/breadcrumb.php';

// 1. Create a new breadcrumb trail
$breadcrumb = new breadcrumb();

// 2. Add the home/root entry
$breadcrumb->add('Home', 'https://example.com/');

// 3. Add a category
$breadcrumb->add('Electronics', 'https://example.com/electronics');

// 4. Add the current product page (no link — it is the current page)
$breadcrumb->add('Wireless Headphones');

// 5. Retrieve the raw trail array and render manually
$trail = $breadcrumb->trail();
// $trail is: [
//   ['title' => 'Home',                'link' => 'https://example.com/'],
//   ['title' => 'Electronics',         'link' => 'https://example.com/electronics'],
//   ['title' => 'Wireless Headphones', 'link' => ''],
// ]

echo '<nav aria-label="breadcrumb"><ol>';
foreach ($trail as $i => $crumb) {
    $isLast = ($i === count($trail) - 1);
    if ($crumb['link'] !== '' && !$isLast) {
        echo '<li><a href="' . htmlspecialchars($crumb['link']) . '">'
            . htmlspecialchars($crumb['title']) . '</a></li>';
    } else {
        echo '<li>' . htmlspecialchars($crumb['title']) . '</li>';
    }
}
echo '</ol></nav>';

// 6. Prepend an entry (e.g. if a module needs to insert a parent)
$breadcrumb->prepend('Store', 'https://example.com/store');
// Trail is now: Store > Home > Electronics > Wireless Headphones
