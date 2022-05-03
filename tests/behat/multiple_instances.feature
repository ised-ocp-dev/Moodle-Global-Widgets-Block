@block @block_globalwidgets
Feature: Adding and configuring multiple globalwidgets blocks
  In order to have one or multiple globalwidgets blocks on a page
  As admin
  I need to be able to create, configure and change globalwidgets blocks

  Background:
    Given I log in as "admin"
    And I am on site homepage
    When I turn editing mode on
    And I add the "globalwidgets" block

  Scenario: Other users can not see globalwidgets block that has not been configured
    Then "(new globalwidgets block)" "block" should exist
    And I log out
    And "(new globalwidgets block)" "block" should not exist
    And "block_globalwidgets" "block" should not exist

  Scenario: Other users can see globalwidgets block that has been configured even when it has no header
    And I configure the "(new globalwidgets block)" block
    And I set the field "Content" to "Static text without a header"
    And I press "Save changes"
    Then I should not see "(new globalwidgets block)"
    And I log out
    And I am on homepage
    And "block_globalwidgets" "block" should exist
    And I should see "Static text without a header" in the "block_globalwidgets" "block"
    And I should not see "(new globalwidgets block)"

  Scenario: Adding multiple instances of globalwidgets block on a page
    And I configure the "block_globalwidgets" block
    And I set the field "Block title" to "The globalwidgets block header"
    And I set the field "Content" to "Static text with a header"
    And I press "Save changes"
    And I add the "globalwidgets" block
    And I configure the "(new globalwidgets block)" block
    And I set the field "Block title" to "The second globalwidgets block header"
    And I set the field "Content" to "Second block contents"
    And I press "Save changes"
    And I log out
    Then I should see "Static text with a header" in the "The globalwidgets block header" "block"
    And I should see "Second block contents" in the "The second globalwidgets block header" "block"
