# Senior Backend Engineer
## Vending Machine

The goal of this program is to model a vending machine and the state it must maintain during its operation. How exactly the actions on the machine are driven is left intentionally vague and is up to the candidate

The machine works like all vending machines: it takes money then gives you items. The vending machine accepts money in the form of 0.05, 0.10, 0.25 and 1

You must have at least have 3 primary items that cost 0.65, 1.00, and 1.50. Also user may hit the button “return coin” to get back the money they’ve entered so far, If you put more money in than the item price, you get the item and change back.

## Specification

### Valid set of actions on the vending machine are:

* 0.05, 0.10, 0.25, 1 - insert money
* Return Coin - returns all inserted money
* GET Water, GET Juice, GET Soda - select item (Water = 0.65, Juice = 1.00, Soda = 1.50)
* SERVICE - a service person opens the machine and set the available change and how many items we have.

### Valid set of responses on the vending machine are:

* 0.05, 0.10, 0.25 - return coin
* Water,  Juice, Soda - vend item

### Vending machine must track the following state:

* Available items - each item has a count, a price and selector
* Available change - Number os coins available
* Currently inserted money

## Examples 
```
Example 1: Buy Soda with exact change
1, 0.25, 0.25, GET-SODA
-> SODA

Example 2: Start adding money, but user ask for return coin
0.10, 0.10, RETURN-COIN
-> 0.10, 0.10

Example 3: Buy Water without exact change
1, GET-WATER
-> WATER, 0.25, 0.10
```

# Considerations
* Programming language should be *PHP*
* Solution with `Dockerfile` or `docker-compose` is highly appreciated
*  When you finish,  why not go to an extra mille and add some tests? :) 
* Frameworks like Symphony,  Laravel are allowed

# Additional Notes
* The provided solutions needs to be uploaded into a public repository (Github, Gitlab, bitbucket) with a README.MD providing the following information.
	* Instructions on how to run your solution
	* Requirements
* Please make sure the name **Holded** are not referenced in any place in your code.
* Commit from the very beginning and commit often. We value the possibility to review your git log.

## HOW TO INSTALL

All the project is prepared to run under docker.
In order to build the the project you need to run following intructions:

* clone the repository
* docker-compose build
* docker-compose up -d
* docker exec -ti php-vendingmachine bash
* composer install

Now You have the project working!

In order to run the tests, run:

* php bin/phpunit

Note: The final implementation is not finished. All the repositories are not implemented, so you cannot persist nothing. You can only check the right functionality looking inside the tests.
Inside the tests, all the repositories are fakes, provided with Mockery. 

I've added an example of a cli command called "SetupItem" where you can see how I want to implement the final version all of the commands that are inside this repo.
Also, I've delivered an example of controller called "InsertCoinsPostController", if the application have to be called through an API. 
Neither of these two implementations works, they are just there to show the idea.


