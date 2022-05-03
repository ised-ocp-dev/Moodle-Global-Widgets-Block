@block @block_globalwidgets @core_block
Feature: Adding and configuring globalwidgets blocks
  In order to have custom blocks on a page
  As admin
  I need to be able to create, configure and change globalwidgets blocks

  @javascript
  Scenario: Configuring the globalwidgets block with Javascript on
    Given I log in as "admin"
    And I am on site homepage
    When I turn editing mode on
    And I add the "globalwidgets" block
    And I configure the "(new globalwidgets block)" block
    And I set the field "Content" to "Static text without a header"
    And I press "Save changes"
    Then I should not see "(new globalwidgets block)"
    And I configure the "block_globalwidgets" block
    And I set the field "Block title" to "The globalwidgets block header"
    And I set the field "Content" to "Static text with a header"
    And I press "Save changes"
    And "block_globalwidgets" "block" should exist
    And "The globalwidgets block header" "block" should exist
    And I should see "Static text with a header" in the "The globalwidgets block header" "block"

  Scenario: Configuring the globalwidgets block with Javascript off
    Given I log in as "admin"
    And I am on site homepage
    When I turn editing mode on
    And I add the "globalwidgets" block
    And I configure the "(new globalwidgets block)" block
    And I set the field "Content" to "Static text without a header"
    And I press "Save changes"
    Then I should not see "(new globalwidgets block)"
    And I configure the "block_globalwidgets" block
    And I set the field "Block title" to "The globalwidgets block header"
    And I set the field "Content" to "Static text with a header"
    And I press "Save changes"
    And "block_globalwidgets" "block" should exist
    And "The globalwidgets block header" "block" should exist
    And I should see "Static text with a header" in the "The globalwidgets block header" "block"
