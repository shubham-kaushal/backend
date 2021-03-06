Feature: Core module

  Scenario: Get languages
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/dictionary/languages"
    Then the response status code should be 200

  Scenario: Get languages (not authorized)
    When I send a GET request to "/api/v1/en_GB/dictionary/languages"
    Then the response status code should be 401

  Scenario: Get translation language (not authorized)
    When I send a GET request to "/api/v1/en_GB/languages"
    Then the response status code should be 401

  Scenario: Get translation language
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages/en_GB"
    Then the response status code should be 200

  Scenario: Get translation language (not found)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages/ZZ"
    Then the response status code should be 404

  Scenario: Get languages (order by code)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?field=code"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (order by name)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?field=name"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (order by active)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?field=active"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (order ASC)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?field=name&order=ASC"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (order DESC)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?field=name&order=DESC"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (filter by code)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?limit=25&offset=0&filter=code%3Dasd"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (filter by name)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?limit=25&offset=0&filter=name%3Dasd"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (filter by iso)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?limit=25&offset=0&filter=iso%3Den"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (filter by active)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/languages?limit=25&offset=0&filter=active%3D1"
    Then the JSON should be valid according to the schema "module/grid/features/gridSchema.json"

  Scenario: Get languages (not authorized)
    When I send a GET request to "/api/v1/en_GB/languages"
    Then the response status code should be 401

  Scenario: Update language (not authorized)
    When I send a PUT request to "/api/v1/en_GB/languages"
    Then the response status code should be 401

  Scenario: Update language
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a PUT request to "/api/v1/en_GB/languages" with body:
    """
      {
        "collection":["en_GB","pl_PL","cs_CZ","fr_FR","uk_UA","de_DE"]
      }
    """
    Then the response status code should be 204

  Scenario: Update language (wrong active - bad request)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a PUT request to "/api/v1/en_GB/languages" with body:
    """
      {
         "collection":[
            {
               "code":"en"
            }
         ]
      }
    """
    Then the response status code should be 400

  Scenario: Update language (wrong code - bad request)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a PUT request to "/api/v1/en_GB/languages" with body:
    """
      {
         "collection":[
            {
               "code":"ZZ"
            }
         ]
      }
    """
    Then the response status code should be 400

  Scenario: Update language (wrong structure)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a PUT request to "/api/v1/en_GB/languages" with body:
    """
    {
      "code": "ZZ"
    }
    """
    Then the response status code should be 400


  Scenario: Get language autocomplete
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "module/core/features/language.json"

  Scenario: Get language autocomplete (not authorized)
    When I send a GET request to "/api/v1/en_GB/language/autocomplete"
    Then the response status code should be 401

  Scenario: Get language autocomplete (order by code)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete?field=code"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "module/core/features/language.json"

  Scenario: Get language autocomplete (order by name)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete?field=name"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "module/core/features/language.json"

  Scenario: Get language autocomplete (order by active)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete?field=active"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "module/core/features/language.json"

  Scenario: Get language autocomplete (order ASC)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete?field=name&order=ASC"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "module/core/features/language.json"

  Scenario: Get language autocomplete (order DESC)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete?field=name&order=DESC"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "module/core/features/language.json"

  Scenario: Get language autocomplete (search f limit 1)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/language/autocomplete?search=f&limit=1"
    And the JSON should be valid according to the schema "module/core/features/language.json"
