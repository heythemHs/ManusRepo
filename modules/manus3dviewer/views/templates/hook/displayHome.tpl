{**
 * 2007-2025 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2025 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

<section id="manus3dviewer_container" class="manus3dviewer_container">
    <h2 class="h1 products-section-title">
        {l s='Interactive 3D Product Preview' mod='manus3dviewer'}
    </h2>
    <div class="manus3dviewer_model_wrapper">
        <model-viewer
            src="{$manus3dviewer_model_url}"
            alt="{l s='A 3D model of a product' mod='manus3dviewer'}"
            ar
            shadow-intensity="1"
            camera-controls
            touch-action="pan-y"
            auto-rotate
            loading="eager"
            class="manus3dviewer_model"
        >
            <div class="progress-bar hide" slot="progress-bar">
                <div class="update-bar"></div>
            </div>
        </model-viewer>
    </div>
</section>
