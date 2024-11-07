
-- Populate User table
INSERT INTO "Users" (username, firstName, lastName, email, password, phoneNumber, location, profilePath, permission) 
VALUES 
('JohnDoe', 'John', 'Doe', 'john.doe@example.com', 'e4d1b9371b671c84cd8b2ba7b696a08d', '1234567890', 'New York', '1/profile.png', 1), --Qq123456
('JaneDoe', 'Jane', 'Doe', 'jane.doe@example.com', 'e4d1b9371b671c84cd8b2ba7b696a08d', '0987654321', 'Los Angeles', '2/profile.png', 0); --Qq123456

-- Populate Categories table
INSERT INTO "Categories" (categoryName) 
VALUES 
('Electronics'),
('Books'),
('Furniture'),
('Clothing'),
('Other');

INSERT INTO "Products" (title, description, publishDate, category, condition, price, imagePath, sold) 
VALUES 
('iPhone 12', 'Brand new iPhone 12', '2022-01-01', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Electronics'), 'Novo', 100000, '1/1/iphone12.png', 1);

-- Populate Product table
INSERT INTO "Products" (title, description, publishDate, category, condition, price, imagePath) 
VALUES 
('Harry Potter', 'Complete set of Harry Potter books', '2022-01-02', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Books'), 'Usado', 5000, '2/2/harrypotter.png'),
('Sofa', 'Used sofa in good condition', '2022-01-03', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Furniture'), 'Com marcas de uso', 20000, '2/3/sofa.png'),
('The Great Gatsby', 'F. Scott Fitzgerald masterpiece', '2022-02-01', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Books'), 'Novo', 2000, '1/4/thegreatgatsby.png'),
('To Kill a Mockingbird', 'Harper Lee classic novel', '2022-02-02', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Books'), 'Usado', 1500, '1/5/tokillamockingbird.png'),
('1984', 'George Orwell dystopian novel', '2022-02-03', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Books'), 'Novo', 2500, '2/6/1984.png'),
('The Catcher in the Rye', 'J.D. Salinger novel about teenage rebellion', '2022-02-04', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Books'), 'Usado', 1800, '2/7/thecatcherintherye.png'),
('Moby Dick', 'Herman Melville epic tale of a whaling voyage', '2022-02-05', (SELECT categoryID FROM "Categories" WHERE categoryName = 'Books'), 'Novo', 3000, '1/8/mobydick.png');

-- Populate FAQ table
INSERT INTO "FAQ" (question, answer) 
VALUES 
('How to reset password?', 'Click on forgot password on the login page to reset your password.'),
('How to change profile picture?', 'Go to your profile settings to change your profile picture.');

-- Populate Hashtags table
INSERT INTO "Hashtags" (hashtagText) 
VALUES 
('#electronics'),
('#books'),
('#furniture');

-- Populate Product_Hashtags table
INSERT INTO "Product_Hashtags" (productID, hashtagID) 
VALUES 
((SELECT productID FROM "Products" WHERE title = 'iPhone 12'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#electronics')),
((SELECT productID FROM "Products" WHERE title = 'Harry Potter'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#books')),
((SELECT productID FROM "Products" WHERE title = 'The Great Gatsby'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#books')),
((SELECT productID FROM "Products" WHERE title = 'To Kill a Mockingbird'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#books')),
((SELECT productID FROM "Products" WHERE title = '1984'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#books')),
((SELECT productID FROM "Products" WHERE title = 'The Catcher in the Rye'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#books')),
((SELECT productID FROM "Products" WHERE title = 'Sofa'), (SELECT hashtagID FROM "Hashtags" WHERE hashtagText = '#furniture'));

-- Populate Admins table
--Table Admin
INSERT INTO "Admins" (idAdmin)
SELECT userID
FROM Users
WHERE permission = 1;

-- Populate Transactions table
INSERT INTO "Transactions" (productID, buyerID, sellerID, transactionDate) 
VALUES 
((SELECT productID FROM "Products" WHERE title = 'iPhone 12'), (SELECT userID FROM "Users" WHERE username = 'JaneDoe'), (SELECT userID FROM "Users" WHERE username = 'JohnDoe'), date('now'));

-- Populate User_Product table
INSERT INTO "User_Products" (userID, productID) 
VALUES 
((SELECT userID FROM "Users" WHERE username = 'JohnDoe'), (SELECT productID FROM "Products" WHERE title = 'iPhone 12')),
((SELECT userID FROM "Users" WHERE username = 'JohnDoe'), (SELECT productID FROM "Products" WHERE title = 'The Great Gatsby')),
((SELECT userID FROM "Users" WHERE username = 'JohnDoe'), (SELECT productID FROM "Products" WHERE title = 'To Kill a Mockingbird')),
((SELECT userID FROM "Users" WHERE username = 'JohnDoe'), (SELECT productID FROM "Products" WHERE title = 'Moby Dick')),
((SELECT userID FROM "Users" WHERE username = 'JaneDoe'), (SELECT productID FROM "Products" WHERE title = 'Harry Potter')),
((SELECT userID FROM "Users" WHERE username = 'JaneDoe'), (SELECT productID FROM "Products" WHERE title = 'Sofa')),
((SELECT userID FROM "Users" WHERE username = 'JaneDoe'), (SELECT productID FROM "Products" WHERE title = '1984')),
((SELECT userID FROM "Users" WHERE username = 'JaneDoe'), (SELECT productID FROM "Products" WHERE title = 'The Catcher in the Rye'));

-- Populate Product_Images table
INSERT INTO "Product_Images" (productID, imagePath) 
VALUES 
((SELECT productID FROM "Products" WHERE title = 'iPhone 12'), '1/1/iphone12.png'),
((SELECT productID FROM "Products" WHERE title = 'The Great Gatsby'), '1/4/thegreatgatsby.png'),
((SELECT productID FROM "Products" WHERE title = 'To Kill a Mockingbird'), '1/5/tokillamockingbird.png'),
((SELECT productID FROM "Products" WHERE title = 'Moby Dick'), '1/8/mobydick.png'),
((SELECT productID FROM "Products" WHERE title = 'Harry Potter'), '2/2/harrypotter.png'),
((SELECT productID FROM "Products" WHERE title = '1984'), '2/6/1984.png'),
((SELECT productID FROM "Products" WHERE title = 'The Catcher in the Rye'), '2/7/thecatcherintherye.png'),
((SELECT productID FROM "Products" WHERE title = 'Sofa'), '2/3/sofa.png');
