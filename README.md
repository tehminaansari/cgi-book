# cgi-book


Following are the details - 

Requirement #1 : 
Added a product type "books" in adin to creating a book type of product which has an additional product attribute,  "ISBN" (International Standard Book Number). Please refer to screenshots admin-product-grid.png, admin-product-view.png
The ISBN Number is assigned to a product, showing on the product detail page, the product listing page and in the corresponding order line item in the cart. Please refer shared screenshot "cart-line-items-having-ISBN.png"

Requirement #2 : 
A separate page on the frontend showing a table with all existing Products having 2 columns - product name and the ISBN number.
 To make it more flexible I used datatable here so that data populates at run time,  It provides searching, sorting and pagination too. Please refer screenshot header-customer-name-and-book-list.png.

Requirement #3 : 
The customer firstname and lastname is  displayed on every page in the header. So for that i used  httpContext to get customer data assuming cache is enabled. It will be displayed in the header even if a page cache is enabled. 

About fetching the data directly from Elasticsearch, skipping any Magento data fetching logic -
Comment : For now i just used simple magento product fetching logic here. I am doing R&D on this part, but unable to complete yet due to the time crunch. However I can share the way I am thinking to achieve this.
Using Elasticsearch\ClientBuilder , create an object for the same
Set hosts and build the object of it
Pass the necessary parameters like index = magento2_product_1_v1 , id , type  and filters.
and call upon get method on client builder object.


I might be wrong, but I just shared the way I am trying. 
