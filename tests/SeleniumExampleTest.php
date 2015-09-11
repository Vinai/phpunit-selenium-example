<?php


class SeleniumExampleTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    protected $screenCapturePath = __DIR__ . '/../log/screen-captures';

    private function captureScreen($fileName)
    {
        file_put_contents($this->screenCapturePath . '/' . $fileName, $this->currentScreenshot());
    }

    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('https://de.wikipedia.org');
        if (!file_exists($this->screenCapturePath)) {
            mkdir($this->screenCapturePath, 0700, true);
        }
    }

    public function testThePageContainsTheSeleniumCoreSection()
    {
        try {
            $this->url('/wiki/Selenium');
            $element = $this->byCssSelector('h2 span#Selenium_Core');
            // check the other by* methods to select methods, for example byId:
            //$element = $this->byId('Selenium_Core');
            $this->assertContains('Selenium Core', $element->text());
        } catch (\PHPUnit_Framework_Exception $e) {
            $this->captureScreen($this->getName() . '-' . time() . '.png');
            throw $e;
        }
    }

    public function testAFailingTestCapturesTheScreen()
    {
        try {
            $this->url('/wiki/Selenium');
            $element = $this->byCssSelector('h2 span#Selenium_Core');
            $this->assertContains('Raptors', $element->text());
        } catch (\PHPUnit_Framework_Exception $e) {
            $this->captureScreen($this->getName() . '-' . time() . '.png');
            throw $e;
        }
    }
}
