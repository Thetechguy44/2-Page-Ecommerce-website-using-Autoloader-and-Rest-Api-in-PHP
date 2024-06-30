## Ecommerce-Restful-Api-in-PHP
The website has a product list page, which serves as the index page where all products are displayed, and a product add page, where you can add a new product. It has a parent class file of product with the sub class file (Book, Furniture, DVD), and it uses autoloader to automatically run the need class file.
The PHP is used to construct class files and the rest API, which is the saveApi and the getApi. Javascript is also heavily used in this project. The saveApi gathers the data from the request, examines the data validation, and saves to the database if there are no errors. Otherwise, it displays an error message describing what went wrong in the network. While the getApi displays the data that was retrieved as JSON from the database on the webpage.
The frontend and the rest API are interacted with using JavaScript. It uses the api to submit and get data in JSON format and displays the results in a web page. Only three products (Book, Furniture, and DVD) can be added; any further products will result in a network error notice. 
 
#Link to webapp:
https://myscandiproject.000webhostapp.com
