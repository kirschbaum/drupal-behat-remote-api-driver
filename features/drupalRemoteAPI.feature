@d7
Feature: DrupalContext
In order to prove the Drupal Behat Remote API is working properly
As a developer
I need to use the step definitions of this context

  # These scenarios assume a "standard" install of Drupal 7.

  Scenario: Create and log in as a user
    Given I am logged in as a user with the "authenticated user" role
    When I click "My account"
    Then I should see the heading "History"

  Scenario: Target links within table rows
    Given I am logged in as a user with the "administrator" role
    When I am at "admin/structure/types"
    And I click "manage fields" in the "Article" row
    Then I should be on "admin/structure/types/manage/article/fields"
    And I should see text matching "Add new field"

  Scenario: Find a heading in a region
    Given I am not logged in
    When I am on the homepage
    Then I should see the heading "User login" in the "left sidebar" region

  Scenario: Clear cache
    Given the cache has been cleared
    When I am on the homepage
    Then I should get a "200" HTTP response

  Scenario: Create a node
    Given I am logged in as a user with the "administrator" role
    When I am viewing an "article" node with the title "My article"
    Then I should see the heading "My article"

  Scenario: Create many nodes
    Given "page" nodes:
      | title    |
      | Page one |
      | Page two |
    And "article" nodes:
      | title          |
      | First article  |
      | Second article |
    And I am logged in as a user with the "administrator" role
    When I go to "admin/content"
    Then I should see "Page one"
    And I should see "Page two"
    And I should see "First article"
    And I should see "Second article"

  Scenario: Create nodes with fields
    Given "article" nodes:
      | title                     | promote | body             |
      | First article with fields |       1 | PLACEHOLDER BODY |
    When I am on the homepage
    And follow "First article with fields"
    Then I should see the text "PLACEHOLDER BODY"

  Scenario: Create and view a node with fields
    Given I am viewing an "Article" node:
      | title | My article with fields! |
      | body  | A placeholder           |
    Then I should see the heading "My article with fields!"
    And I should see the text "A placeholder"

  Scenario: Create users
    Given users:
      | name     | mail            | status |
      | Joe User | joe@example.com | 1      |
    And I am logged in as a user with the "administrator" role
    When I visit "admin/people"
    Then I should see the link "Joe User"

  Scenario: Create users with roles
    Given users:
      | name     | mail            | roles         |
      | Joe User | joe@example.com | administrator |
    And I am logged in as a user with the "administrator" role
    When I visit "admin/people"
    Then I should see the text "administrator" in the "Joe User" row

# Currently Failing:
#  Scenario: Login as a user created during this scenario
#    Given users:
#      | name      | mail            | roles              |
#      | Test User | joe2@example.com | authenticated user |
#    When I am logged in as "Test user"
#    Then I should see the link "Log out"

#  Scenario: Create nodes with specific authorship
#    Given users:
#      | name     | mail            | status |
#      | Joe User | joe@example.com | 1      |
#    And "article" nodes:
#      | title          | author   | body             | promote |
#      | Article by Joe | Joe User | PLACEHOLDER BODY | 1       |
#    When I am logged in as a user with the "administrator" role
#    And I am on the homepage
#    And I follow "Article by Joe"
#    Then I should see the link "Joe User"
#
#  Scenario: Readable created dates
#    Given "article" nodes:
#      | title        | body             | created            | status | promote |
#      | Test article | PLACEHOLDER BODY | 07/27/2014 12:03am |      1 |       1 |
#    When I am on the homepage
#    Then I should see the text "Sun, 07/27/2014 - 00:03"
#
#  Scenario: Node hooks are functioning
#    Given "article" nodes:
#      | title        | body        | published on       | status | promote |
#      | Test article | PLACEHOLDER | 04/27/2013 11:11am |      1 |       1 |
#    When I am on the homepage
#    Then I should see the text "Sat, 04/27/2013 - 11:11"

  Scenario: Node edit access by administrator
    Given I am logged in as a user with the "administrator" role
    Then I should be able to edit an "Article" node