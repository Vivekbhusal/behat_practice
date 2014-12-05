Feature: Login
  When I open alexandria page
  Enter authorized username password
  I should be able to login
  
  @javascript
  Scenario: Login in as subscriber
    Given I go to "/wp-login.php"
    Given I am logged in as "subscriber" with "subscriber" as "normal" user
    Then I should not see "Dashboard"
    #When I search for "FIT"

  @javascript
  Scenario: Login in as author
    Given I go to "/wp-login.php"
    Given I am logged in as "subscriber" with "subscriber" as "normal" user
    Then I should not see "Dashboard"
    #When I search for "FIT"

 