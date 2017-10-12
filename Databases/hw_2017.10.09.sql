# 1. Получить список сотрудников (`employees`) c именами (`firstName`) `Barry`, `Larry`, `Leslie` отсортировать выборку по имени сотрудника, порядок - по возрастанию.
SELECT *
FROM employees
WHERE firstName IN ('Barry', 'Larry', 'Leslie')
ORDER BY firstName ASC;

# 2. Получить 3 товара (`products`) с самой высокой ценой (`buyPrice`) отсортировать по цене - от большей к меньшей.
SELECT *
FROM products
ORDER BY buyPrice DESC
LIMIT 3;

# 3. Получить 3 товара (`products`) с наименьшим количеством на складе (`quantityInStock`).
SELECT *
FROM products
ORDER BY quantityInStock ASC
LIMIT 3;

# 4. Получить список офисов (`offices`), в которых находится более четырех сотрудников (`employees`).
SELECT
  offices.*,
  COUNT(employeeNumber) empl_CNT
FROM offices
  LEFT JOIN employees ON offices.officeCode = employees.officeCode
GROUP BY employees.officeCode
HAVING COUNT(employeeNumber) > 4
ORDER BY offices.officeCode ASC;

# 5. Получить список заказаов (`orders`), в которых было заказано более 10 товаров.
SELECT
  COUNT(productCode) prod_CNT,
  orders.*
FROM orders
  LEFT JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber
GROUP BY orderdetails.orderNumber
HAVING prod_CNT > 10
ORDER BY orders.orderNumber ASC;

# 6. Получить полный список сотрудников (`employees`), для каждого сотрудника получить количество привязанных к нему покупателей (`customers`).
SELECT
  e.employeeNumber,
  e.firstName,
  e.lastName,
  COUNT(c.customerNumber) customers_CNT
FROM employees e LEFT JOIN customers c ON e.employeeNumber = c.salesRepEmployeeNumber
GROUP BY e.employeeNumber;

# *7. Получить список офисов (offices), для каждого из них получить количество заказов за 2005 год. Выводить толко те офисы, в которых было сделано более 5 заказов.

SELECT
  offices.*,
  COUNT(o.orderNumber) orders_CNT
FROM offices
  LEFT JOIN (employees
    LEFT JOIN (customers
      LEFT JOIN orders o ON customers.customerNumber = o.customerNumber)
      ON employees.employeeNumber = customers.salesRepEmployeeNumber) ON offices.officeCode = employees.officeCode
WHERE o.orderDate BETWEEN '2005-01-01' AND '2005-12-31'
GROUP BY offices.officeCode
HAVING orders_CNT > 5;

# *8. Получить список типов товаров (productlines), для каждого из них вывести количество заказов, в которых присутствуют товары с этим типом.

SELECT
  A.productLine,
  COUNT(A.orderNumber) orders_CNT
FROM (SELECT
        PL.productLine,
        orderdetails.orderNumber
      FROM productlines PL LEFT JOIN (products
        LEFT JOIN orderdetails ON products.productCode = orderdetails.productCode)
          ON PL.productLine = products.productLine
      WHERE orderdetails.orderNumber IS NOT NULL
      GROUP BY PL.productLine, orderdetails.orderNumber) AS A
GROUP BY A.productLine;

# or as alternative way:

SELECT
  PL.productLine,
  COUNT(DISTINCT orderdetails.orderNumber)
FROM productlines PL LEFT JOIN (products
  LEFT JOIN orderdetails ON products.productCode = orderdetails.productCode)
    ON PL.productLine = products.productLine
WHERE orderdetails.orderNumber IS NOT NULL
GROUP BY PL.productLine;