Feature: Login as admin and see if we can logout

  Sceneario: login and logout with user Admin
    Given I am on "/login"
    When I fill in "_username" with "admin"
    When I fill in "_password" with "test"
    When I press "_submit"
    Then I should be on "/"
    Then I should see "Profile"
    When I follow "Logout"
    Then I should be on "/login"

  Scenario: fail login
    Given I am on "/login"
    When I fill in "_username" with "admin"
    When I fill in "_password" with "admin"
    When I press "_submit"
    Then I should be on "/login"