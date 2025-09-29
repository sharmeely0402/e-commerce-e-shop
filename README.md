**E-Shop Project**

**E-Shop** is a simple online shopping platform built with **PHP**, **MySQL**, and **Bootstrap**. It allows users to browse products, add them to their cart, make purchases, and leave rating for products they have bought. This project demonstrates basic e-commerce functionalities with user authentication, product management, and a ratings system.

---

## **Features**

### **User Features**

* User registration and login/logout system
* View product listings with detailed pages
* Add products to cart
* Submit product ratings (only if purchased)

### **Admin Features (Optional)**

* Add, edit, and delete products
* View all orders

### **Product Details Page**

* Displays product image, name, description, and price
* Users can submit a rate only after purchasing the product

---

## **Technologies Used**

* **Backend:** PHP
* **Database:** MySQL
* **Frontend:** HTML, CSS, Bootstrap
* **Session Management:** PHP sessions
* **Client-side Libraries:** jQuery, Bootstrap JS

---

## **Database Structure**

### **Tables**

1. **customers** – Stores user information (name, email, password, address, phone)
2. **products** – Stores product information (name, description, price, image)
3. **orders** – Stores user orders
4. **order_items** – Stores items for each order
5. **ratingss** – Stores product ratings submitted by users

---

## **Installation & Setup**

1. **Clone the repository**:

   ```bash
   git clone https://github.com/yourusername/e-shop.git
   ```

2. **Import the database**:

   * Create a MySQL database (e.g., `e_shop_db`)
   * Import `database.sql` (or your exported SQL file)

3. **Configure database connection**:

   * Update `dbConfig.php` with your MySQL credentials

4. **Run the project**:

   * Place the project folder in your local server (e.g., XAMPP `htdocs`)
   * Start Apache and MySQL
   * Access the project in your browser:

     ```
     http://localhost/e-shop/
     ```

---

## **Usage**

* Register a new user or login with existing credentials
* Browse products from the homepage
* Add product to cart and proceed to checkout
* After purchase, submit reviews for purchased products

---

## **Screenshots**
<img width="812" height="980" alt="register" src="https://github.com/user-attachments/assets/a6903089-f039-42cd-9996-fc467deb5aac" />
<img width="1917" height="985" alt="home page" src="https://github.com/user-attachments/assets/4d465809-c568-4293-a708-949bab372f91" />
<img width="1917" height="998" alt="home page products" src="https://github.com/user-attachments/assets/31e15156-ded3-4a1b-8a0a-5bfcc43f451f" />
<img width="1912" height="987" alt="cart" src="https://github.com/user-attachments/assets/e585c769-cb50-40ef-9d4d-89fcf3d56473" />
<img width="1918" height="992" alt="order priview" src="https://github.com/user-attachments/assets/4ba4a136-65e0-4da9-b744-03e361083167" />
<img width="466" height="761" alt="rating" src="https://github.com/user-attachments/assets/53e44548-38de-4d1b-9fab-703fdfa5580a" />
<img width="942" height="756" alt="e-comerce" src="https://github.com/user-attachments/assets/639ce588-7194-4476-b82b-84458b221f50" />
<img width="1912" height="761" alt="admin dashboard" src="https://github.com/user-attachments/assets/a59aa175-daaa-4dbb-a11f-3b84baf34220" />
<img width="1503" height="990" alt="admin products" src="https://github.com/user-attachments/assets/8a14c3f0-08de-49b5-9415-5ea36b312ffb" />



---

## **Future Enhancements**

* Payment integration
* Customer Review
* Admin dashboard for product and order management
* Product categories and search functionality
* Rating aggregation and average rating display



