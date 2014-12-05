# features/bootstrap/FeaturesContext.php

<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\MinkExtension\Context\MinkContext;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class FeatureContext extends MinkContext{

    /**
    * @When /^I search for "([^"]*)"$/
    */
    public function iSearchFor($arg1)
    {
        $this->fillField('s', $arg1);
        $this->pressButton('Search');
    }

    /**
     * Follow redirect instructions.
     *
     * @param   string  $page
     *
     * @return  void
     *
     * @Then /^I (?:am|should be) redirected(?: to "([^"]*)")?$/
     */
    public function iAmRedirected($page = null)
    {
        $headers = $this->getSession()->getResponseHeaders();
        if (empty($headers['Location']) && empty($headers['location'])) {
            throw new \RuntimeException('The response should contain a "Location" header');
        }
        if (null !== $page) {
            $header = empty($headers['Location']) ? $headers['location'] : $headers['Location'];
            if (is_array($header)) {
                $header = current($header);
            }
            \PHPUnit_Framework_Assert::assertEquals($header, $this->locatePath($page), 'The "Location" header points to the correct URI');
        }
        $client = $this->getClient();
        $client->followRedirects(true);
        $client->followRedirect();
    }

    /**
     * @Given /^I am logged in as "([^"]*)" with "([^"]*)" as "([^"]*)" user$/
     */
    public function iAmLoggedInAsWithAsUser($username, $password, $usertype)
    {
        $this->login($username, $password, $usertype);
    }

  /**
   * Makes sure the current user is logged out, and then logs in with
   * the given username and password.
   *
   * @param string $username
   * @param string $password
   * @author Maarten Jacobs
   **/
  public function login($username, $password = 'pass', $usertype) {
    $session = $this->session = $this->getSession();
    $current_page = $session->getPage();

    if('normal' == $usertype){
        $checkBox = $current_page->findById('use_monash_authcate');
        if($checkBox->isChecked()){
            $checkBox->uncheck();
        }
    }
    $current_page->fillField('user_login', $username);
    $current_page->fillField('user_pass', $password);
    $current_page->findButton('wp-submit')->click();
    
    // Assert that we are on the dashboard
    // assertTrue( $session->getPage()->hasContent('Dashboard') );
  }

  /**
     * @Given /^I wait for (\d+) seconds$/
     */
    public function iWaitForSeconds($arg1)
    {
        throw new PendingException();
    }

}


