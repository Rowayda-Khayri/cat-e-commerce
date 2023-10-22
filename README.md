## ERD

You can find the ERD of the e-commerce system [here](https://lucid.app/lucidchart/68464336-8fbf-43d7-bd0b-280300194c6d/edit?viewport_loc=129%2C195%2C1480%2C692%2C0_0&invitationId=inv_4f85f3ff-d02b-4d2c-8e32-2cdf1a36199c).


## Web Pages

- Run the replit here: [https://replit.com/@rowaydakhayri/CAT-E-commerce](https://replit.com/@rowaydakhayri/CAT-E-commerce)
- Visit this link to view the web pages: [https://cat-e-commerce--rowaydakhayri.repl.co](https://cat-e-commerce--rowaydakhayri.repl.co)


## API Endpoints

### Store: GET
- Endpoint: [https://cat-e-commerce--rowaydakhayri.repl.co/api](https://cat-e-commerce--rowaydakhayri.repl.co/api)

### Cart: GET
- Endpoint: [https://cat-e-commerce--rowaydakhayri.repl.co/api/cart](https://cat-e-commerce--rowaydakhayri.repl.co/api/cart)

### Add to Cart: POST
- Endpoint: [https://cat-e-commerce--rowaydakhayri.repl.co/api/cart/add-to-cart/{itemId}](https://cat-e-commerce--rowaydakhayri.repl.co/api/cart/add-to-cart/{itemId})
- Parameters:
  - quantity

### Place Order: POST
- Endpoint: [https://cat-e-commerce--rowaydakhayri.repl.co/api/checkout/process](https://cat-e-commerce--rowaydakhayri.repl.co/api/checkout/process)
- Parameters:
  - address
  - telephone

## What does this repo do?

The objective of the repo is to build the checkout pages of an E-commerce system with these requirements:

1. **All Store Items Page**
   - A page containing all of the store items indicating price, name, and description for each item. The user can select any quantity of items.

2. **The Shopping Cart Page**
   - The user is presented with a summary of the items he/she previously selected from point 1 into the cart. The user should be able to:
     - See a table listing the items selected along with the quantity desired and the total price of the purchase
     - Remove any item from the cart
     - Go back and select more items
     - Modify any of the quantities and update the cart
     - Confirm and continue to the payment page.

3. **The Payment Page**
   - The user is presented with a form that he/she should fill to complete the transaction (note: the only payment method available is payment via store credits):
     - The user should be allowed to enter an address and telephone number
     - The user should be allowed to cancel and go back to the shopping cart page
     - The user can (after filling in the form) place the transaction.
     - If the user places the transaction, his/her store credits should be updated in the database, and the transaction information should be saved in the Order table.

4. **Transaction Result Page**
   - If the user has enough credits to cover the transaction, a payment successful message should be displayed; otherwise, a payment failed message is displayed instead.

**Important Notes:**
- You can assume that the customer is already logged in, and that you also do not need to worry about authentication between your PHP pages and your API methods.
