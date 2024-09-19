<?php
/**
 * This index file is a bit of mess, but its purpose is only to provide some examples for the app
 */

require __DIR__ . "/vendor/autoload.php";

use App\Factory\CampaignFactory;
use App\Entities\BlogEntity;
use App\Entities\ProductEntity;
use App\Services\CampaignService;
use App\Validation\Validation;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

$campaignFactory = new CampaignFactory(new Validation());

// Invalid, because its date range is overlap with campaign4 with the same product entity (see below)
$campaign =  $campaignFactory->createCampaign('Campaign1', Carbon::parse('2020-01-01 12:00'), Carbon::parse('2020-01-12 13:00'));

// Invalid, because it starts at weekend with a blog post entity
$campaign2 = $campaignFactory->createCampaign('Campaign2', Carbon::parse('2020-01-11 16:00'), Carbon::parse('2020-01-12 06:00'));

// Valid
$campaign3 = $campaignFactory->createCampaign('Campaign3', Carbon::parse('2020-02-03'), Carbon::parse('2020-02-05'));

// Invalid, because its date range is overlap with campaign1 with the same entity (see below)
$campaign4 = $campaignFactory->createCampaign('Campaign4', Carbon::parse('2020-01-02'), Carbon::parse('2020-01-31'));

// Valid
$campaign5 = $campaignFactory->createCampaign('Campaign5', '2020-03-05', '2020-04-5 23:59:59');

// This campaign creation will throw and exception, because the provided 'start' and 'end' are not valid date formats
//$campaign6 = $campaignFactory->createCampaign("Will Throw an exception", "qwe", "asdsa");

$product = new ProductEntity("Product 1", "This is a product entity", 500);

$campaign->addEntity($product);

$blog1 = new BlogEntity("Blog post 2", "asdf");
$blog2 = new BlogEntity("Blog post 3", "asdf");
$blog3 = new BlogEntity("Blog post 4", "asdf");
$blog4 = new BlogEntity("Blog post 5", "asdf");
$blog5 = new BlogEntity("Blog post 6", "asdf");
$blog6 = new BlogEntity("Blog post 7", "asdf");

$campaign2->addEntity($blog6);
$campaign3->addEntity($blog5);
$campaign4->addEntity($blog5);
$campaign4->addEntity($product);
$campaign5->addEntity($blog6);

$campaigns = new ArrayCollection([
    $campaign,
    $campaign2,
    $campaign3,
    $campaign4,
    $campaign5,
]);

$campaignService = new CampaignService();
$validatedCampaigns = $campaignService->validateCampaigns($campaigns);

foreach ($campaigns as $campaign) {
    echo "<p>" . $campaign . "</p>\n";
}

foreach ($validatedCampaigns as $key => $valid) {
    echo "<p>" . $key . " is " . $valid . "</p>\n";
}