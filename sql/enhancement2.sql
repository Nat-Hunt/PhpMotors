

INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES ('Tony', 'Stark', 'tony@starknet.com', 'Iam1ronM@n', 'I am the real Ironman');

UPDATE clients
SET clientLevel = 3
WHERE clientid = 0;


UPDATE inventory
SET invDescription = REPLACE(invDescription, 'small interiors', 'spacious interiors') 
WHERE invMake LIKE 'GM' AND invModel LIKE 'Hummer';

SELECT inv.invModel, class.classificationName
FROM inventory inv INNER JOIN carclassification class
ON inv.classificationId = class.classificationId
WHERE class.classificationName LIKE 'SUV';

DELETE FROM inventory
WHERE invId = (SELECT invId
FROM inventory
WHERE invModel LIKE 'Wrangler' AND invMake LIKE 'Jeep ');

UPDATE inventory
SET invImage = CONCAT('/phpmotors', invImage);
