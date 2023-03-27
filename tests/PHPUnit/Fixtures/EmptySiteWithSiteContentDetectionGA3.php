<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
namespace Piwik\Tests\Fixtures;

use Piwik\Plugins\SitesManager\SitesManager;
use Piwik\Tests\Framework\Fixture;
use Piwik\SiteContentDetector;
use Piwik\Tests\Framework\Mock\FakeSiteContentDetector;
use Matomo\Dependencies\DI;

/**
 * Fixture that adds one site with no visits and configures site content detection test data so that GA3 will be
 * detected on the site.
 */
class EmptySiteWithSiteContentDetectionGA3 extends Fixture
{
    public $idSite = 1;

    public function provideContainerConfig()
    {
        $mockData = [
            'consentManagerId' => null,
            'consentManagerName' => null,
            'consentManagerUrl' => null,
            'isConnected' => false,
            'ga3' => true,
            'ga4' => false,
            'gtm' => false,
            'cms' => SitesManager::SITE_TYPE_UNKNOWN
        ];

        return [
            SiteContentDetector::class => DI\autowire(FakeSiteContentDetector::class)
                 ->constructorParameter('mockData', $mockData)
        ];
    }

    public function setUp(): void
    {
        Fixture::createSuperUser();
        $this->setUpWebsites();
    }

    public function tearDown(): void
    {
        // empty
    }

    private function setUpWebsites()
    {
        if (!self::siteCreated($idSite = 1)) {
            self::createWebsite('2021-01-01');
        }
    }

}
