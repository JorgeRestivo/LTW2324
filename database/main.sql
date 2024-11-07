BEGIN TRANSACTION;

DROP TABLE IF EXISTS "Users";
DROP TABLE IF EXISTS "Products";
DROP TABLE IF EXISTS "User_Products";
DROP TABLE IF EXISTS "Categories";
DROP TABLE IF EXISTS "Product_HashTags";
DROP TABLE IF EXISTS "HashTags";
DROP TABLE IF EXISTS "Product_Images";
DROP TABLE IF EXISTS "FAQ";
DROP TABLE IF EXISTS "Admins";
DROP TABLE IF EXISTS "Transactions";
DROP VIEW IF EXISTS "UsersView";
DROP VIEW IF EXISTS "ProductView"; 
DROP TABLE IF EXISTS "Chats";
DROP TABLE IF EXISTS "ChatSessions";
DROP VIEW IF EXISTS "ProductWithSellerID";

-- Table User
CREATE TABLE "Users" (
    userID INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    phoneNumber TEXT,
    location TEXT,
    profilePath TEXT,
    permission INTEGER NOT NULL DEFAULT 0
);

CREATE VIEW UsersView AS
SELECT userID, username, firstName, lastName, email, phoneNumber, location, profilePath, permission
FROM "Users";

CREATE VIEW ProductView AS
SELECT p.*, uv.*, c.categoryName, GROUP_CONCAT(h.hashtagText) as hashtags
FROM "Products" p
JOIN "User_Products" up ON p.productID = up.productID
JOIN "UsersView" uv ON up.userID = uv.userID
JOIN "Categories" c ON p.category = c.categoryID
JOIN "Product_HashTags" ph ON ph.productID = p.productID
JOIN "HashTags" h ON h.hashtagID = ph.hashtagID
GROUP BY p.productID;

-- Table Products
CREATE TABLE "Products" (
    productID INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    publishDate DATE NOT NULL,
    category INTEGER REFERENCES "Categories" (categoryID) NOT NULL,
    condition TEXT NOT NULL CHECK (condition IN ('Novo', 'Com marcas de uso', 'Usado')),
    price INTEGER NOT NULL,
    imagePath TEXT NOT NULL,
    sold BOOLEAN DEFAULT 0
);

--Table Product Images
CREATE TABLE "Product_Images" (
    imageID INTEGER PRIMARY KEY AUTOINCREMENT,
    productID INTEGER REFERENCES "Product" (productID) NOT NULL,
    imagePath TEXT NOT NULL
);

-- Table User_Product
CREATE TABLE "User_Products" (
    userID INTEGER REFERENCES "Users" (userID),
    productID INTEGER REFERENCES "Product" (productID),
    PRIMARY KEY (userID, productID)
);

-- Table Categories
CREATE TABLE "Categories" (
    categoryID INTEGER PRIMARY KEY AUTOINCREMENT,
    categoryName TEXT NOT NULL
);

-- Table FAQ
CREATE TABLE "FAQ" (
    faqID INTEGER PRIMARY KEY AUTOINCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL
);

-- Table Hashtags
CREATE TABLE "Hashtags" (
    hashtagID INTEGER PRIMARY KEY AUTOINCREMENT,
    hashtagText TEXT NOT NULL
);

-- Table Product_Hashtags
CREATE TABLE "Product_Hashtags" (
    productID INTEGER REFERENCES "Product" (productID),
    hashtagID INTEGER REFERENCES "Hashtags" (hashtagID),
    PRIMARY KEY (productID, hashtagID)
);

-- Table Admins
CREATE TABLE "Admins" (
    adminID INTEGER PRIMARY KEY AUTOINCREMENT
);

-- Table Transactions
CREATE TABLE "Transactions" (
    transactionID INTEGER PRIMARY KEY AUTOINCREMENT,
    productID INTEGER REFERENCES "Product" (productID),
    buyerID INTEGER REFERENCES "Users" (userID),
    sellerID INTEGER REFERENCES "Users" (userID),
    transactionDate TEXT NOT NULL
);
-- Table for storing chat messages
CREATE TABLE "Chats" (
    chatID INTEGER PRIMARY KEY AUTOINCREMENT,
    productID INTEGER,
    buyerID INTEGER,
    sellerID INTEGER,
    message TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (productID) REFERENCES Products(productID),
    FOREIGN KEY (buyerID) REFERENCES Users(userID),
    FOREIGN KEY (sellerID) REFERENCES Users(userID)
);

-- Table for tracking chat sessions 
CREATE TABLE "ChatSessions" (
    sessionID INTEGER PRIMARY KEY AUTOINCREMENT,
    productID INTEGER,
    buyerID INTEGER,
    sellerID INTEGER,
    FOREIGN KEY (productID) REFERENCES Products(productID),
    FOREIGN KEY (buyerID) REFERENCES Users(userID),
    FOREIGN KEY (sellerID) REFERENCES Users(userID)
);

CREATE VIEW "ProductWithSellerID" AS
SELECT p.*, up.userID AS sellerID
FROM Products p
JOIN User_Products up ON p.productID = up.productID;
COMMIT;
